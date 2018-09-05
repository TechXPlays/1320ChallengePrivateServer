<?php
	class Car {
		public static function getList($variables, &$response) {
			global $nitto_db;
			// Fetch all cars
			$cars = $nitto_db->fetch_rows('nt_car_stock');
			// Parse each of the cars, skip Mopar by `local_image` (`name` may change)
			if (!isset($variables['mopar'])) $variables['mopar'] = MOPAR_DEFAULT;
			foreach($cars as $car) {
				// WARNING:
				// If the MOPAR car is not last in the car_stock table, the showroom will not show cars
				// added later to the database, with higher IDs; bear in mind, however, that MOPAR CANNOT
				// change its ID, so adding new cars afterwards will be problematic unless the
				// core Flash car counting is modified; it should have not displayed there, this MOPAR
				// business is monkey business...
				if ($variables['mopar'] == "false" AND $car['local_image'] == 'moparDragCar') continue;
				// :END WARNING
				$response->setVariable('carID'.$car['id'], $car['id']);
				$response->setVariable('carName'.$car['id'], $car['name']);
				$response->setVariable('carPrice'.$car['id'], $car['price']);
				$response->setVariable('carColor'.$car['id'], $car['color']);
				$response->setVariable('carLocalImage'.$car['id'], $car['local_image']);
				$response->setVariable('carRemoteImage'.$car['id'], $car['remote_image']);
				$response->setVariable('logoLocalImage'.$car['id'], $car['logo_local_image']);
				$response->setVariable('logoRemoteImage'.$car['id'], $car['logo_remote_image']);
				$response->setVariable('starterCar'.$car['id'], $car['starter']);
			}
		}
		public static function getDetails($id, &$response) {
			global $nitto_db, $nitto_error;
			// Get the details for a car ID
			$details = $nitto_db->fetch_row('nt_car_stock_performance', NULL, array('car_id' => intval($id)));
			if (!$details) {
				$nitto_error->report('Car', 1, 'Could not get details for carID'.$id, false);
				$details['engine'] = "unknown";
				$details['hp'] = 0;
				$details['torque'] = 0;
				$details['redline'] = 0;
				$details['width'] = 0;
				$details['length'] = 0;
				$details['height'] = 0;
				$details['weight'] = 0;
			}
			// Form response variables
			$response->setVariable('carEngine', $details['engine']);
			$response->setVariable('carHP', $details['hp']);
			$response->setVariable('carTorque', $details['torque']);
			$response->setVariable('carRedline', $details['redline']);
			$response->setVariable('carwidth', $details['width']);
			$response->setVariable('carlength', $details['length']);
			$response->setVariable('carheight', $details['height']);
			$response->setVariable('carweight', $details['weight']);
			// Acquire car variables from the database
			$car = $nitto_db->fetch_row('nt_car_stock', NULL, array('id' => intval($id)));
			if (!$car) {
				$nitto_error->report('Car', 1, 'Could not get details for carID'.$id, false);
				$car['price'] = "unknown";
				$car['local_image'] = NULL;
				$car['remote_image'] = NULL;
				$car['logo_local_image'] = NULL;
				$car['logo_remote_image'] = NULL;
			}
			$response->setVariable('carPrice', $car['price']);
			$response->setVariable('carLocalImage', $car['local_image']);
			$response->setVariable('carRemoteImage', $car['remote_image']);
			$response->setVariable('logoLocalImage', $car['logo_local_image']);
			$response->setVariable('logoRemoteImage', $car['logo_remote_image']);
			$response->setVariable('sideLocalImage', $car['logo_remote_image']);
			// Get colors (repsonse variables are formed inside)
			self::getColors($id, $response);
			return;
		}
		
		public static function getColors($id, &$response) {
			global $nitto_db, $nitto_error;
			// Get colors for a car ID
			$colors = $nitto_db->fetch_rows('nt_car_stock_color', 'color', array('car_id' => intval($id)));
			// If no colors exist for a car ID
			if (!$colors) {
				$nitto_error->report('Car', 2, 'Could not get colors for carID'.$id, false);
				$reponse->setVarialbe('colorValue1', '000000');
				return;
			}
			
			$color_number = 0;
			foreach ($colors as $color)
				$response->setVariable('colorValue'.++$color_number, $color['color']);
			
			return;
		}
		
		public static function purchase($car_id, $car_color, $account_id, $first = false) {
			global $nitto_db, $nitto_error;
			if ($first) {
				// Check if starter car
				$starter = $nitto_db->fetch_row('nt_car_stock', 'starter', array('id' => intval($car_id)));
				if ($starter['starter'] == '0') $nitto_error; // An error occured
			}
			if (!$performance = $nitto_db->fetch_row('nt_car_stock_performance', NULL, array('car_id' => intval($car_id))))
				$nitto_error; // An error occured
			
			$number_of_cars = $nitto_db->fetch_row('nt_player_car', 'car_number', array('account_id' => intval($account_id)), 'car_number', 'DESC');
			if (!isset($number_of_cars['car_number'])) $number_of_cars['car_number'] = 0;
			
			// General information
			$fieldvalues = array(
				'car_id' => intval($car_id),
				'account_id' => intval($account_id),
				'car_number' => intval($number_of_cars['car_number'] + 1)
			);
			if (!$player_car_id = $nitto_db->insert('nt_player_car', $fieldvalues))
				$nitto_error; // Error
			// Visual information
			$fieldvalues = array(
				'player_car_id' => intval($player_car_id),
				'color' => $car_color,
			);
			if ($nitto_db->insert('nt_player_car_visual', $fieldvalues))
				$nitto_error; // Error
			// Condition information
			$fieldvalues = array(
				'player_car_id' => intval($player_car_id),
				'oil_life_remaining' => 100,
				'oil_type' => 'conventional'
			);
			if ($nitto_db->insert('nt_player_car_condition', $fieldvalues))
				$nitto_error; // Error
			// Performance information
			$fieldvalues = array(
				'player_car_id' => intval($player_car_id),
				'tire_grip' => $performance['tire_grip'],
				'redline' => $performance['redline'],
				'hp' => $performance['hp'],
				'revlimiter' => $performance['revlimiter'],
				'weight' => $performance['weight'],
				'engine_damage_factor' => $performance['engine_demage_factor'],
				'clutch_wear_factor' => $performance['clutch_wear_factor'],
				'gear_ratios' => $performance['gear_ratios']
			);
			if ($nitto_db->insert('nt_player_car_performance', $fieldvalues))
				$nitto_error; // Error
		}
		
		public static function select($variables, &$response) {
			global $nitto_db, $nitto_error;
			if (!$nitto_db->update('nt_player_car', array('selected' => '0'), array('account_id' => $variables['accountID'])) OR
				!$nitto_db->update('nt_player_car', array('selected' => '1'), array('account_id' => $variables['accountID'], 'car_number' => $variables['accountCarID'])))
					$nitto_error; // Error!
		}
		
		public static function getFor($id) {
			global $nitto_db, $nitto_error;
			if (!$cars = $nitto_db->fetch_rows('nt_player_car', NULL, array('account_id' => intval($id))))
				$nitto_erro; // Report the error
			$result_cars = array();
			foreach ($cars as $car) {
				$car['stock'] = $nitto_db->fetch_row('nt_car_stock', NULL, array('id' => $car['car_id']));
				$car['stock']['performance'] = $nitto_db->fetch_row('nt_car_stock_performance', NULL, array('car_id' => $car['car_id']));
				$car['performance'] = $nitto_db->fetch_row('nt_player_car_performance', NULL, array('player_car_id' => $car['id']));
				$car['condition'] = $nitto_db->fetch_row('nt_player_car_condition', NULL, array('player_car_id' => $car['id']));
				$car['visual'] = $nitto_db->fetch_row('nt_player_car_visual', NULL, array('player_car_id' => $car['id']));
				$result_cars []= $car;
			}
			return $result_cars;
		}
		
		public static function parseGearRatios($gear_ratios) {
			$gear_ratios = explode('|', $gear_ratios);
			$gear_ratio[1] = $gear_ratios[0];
			$gear_ratio[2] = $gear_ratios[1];
			$gear_ratio[3] = $gear_ratios[2];
			$gear_ratio[4] = $gear_ratios[3];
			$gear_ratio[5] = $gear_ratios[4];
			$gear_ratio[6] = $gear_ratios[5];
			$gear_ratio['final'] = $gear_ratios[6];
			return $gear_ratio;
		}
	}
?>