<?php
	class Account {
		public static function create($variables, &$response) {
			global $nitto_db;
			global $nitto_error;

			// Check username
			if ($nitto_db->fetch_row('nt_account', 'username', array('username' => $variables['username']))) {
				$response->setVariable('status', '2'); // Username error
				return;
			}
			// Check email
			if ($nitto_db->fetch_row('nt_account', 'username', array('email' => $variables['email']))) {
				$response->setVariable('status', '3'); // Email error
				return;
			}
			// Check birthyear
			if ($variables['birthYear'] > BIRTHYEAR_MAX OR $variables['birthYear'] < BIRTHYEAR_MIN) {
				$response->setVariable('status', '4'); // Birthyear error
				return;
			}
			// Non keyboard characters...
			if (!ctype_alnum($variables['username'])) {
				$response->setVariable('status', '5'); // Badword encountered
				return;
			}
			
			// Passed the error barbed wires, have we?
			$fieldvalues = array(
				'username' => $variables['username'],
				'password' => Helper::hashPassword($variables['password']),
				'email' => $variables['email'],
				'location' => $variables['region'],
				'ethnicity' => $variables['ethnicity'],
				'birthyear' => $variables['birthYear'],
				'gender' => $variables['sex'],
				'activation_code' => Helper::randomActivationCode($variables['username']),
				'active' => '0',
				'level' => 'unknown',
				'type' => 'unknown',
				'class' => 'unknown',
				'balance' => STARTING_BALANCE,
				'points' => '0',
				'email_notification' => '1'
			);

			$id = $nitto_db->insert('nt_account', $fieldvalues);
			// $id = 1;
			// Send the activation key
			if ($id) {
				$response->setVariable('status', '1');
				$response->setVariable('accountID', $id);
				if (!Car::purchase($variables['carID'], $variables['color'], $id, true))
					$nitto_error; // Throw error
				if (!self::sendActivation($fieldvalues['activation_code'], $fieldvalues['email']))
					$nitto_error; // Throw error
				// Purchase the vehicle
			} else $nittor_error; // Throw error
		}
		
		private static function sendActivation($code, $email) {
			$template_variables = array(
					'code' => $code
				);
			return Mail::send('Activation', $email, 'activation', $template_variables);
		}
		
		public static function resendActivation($variables, &$response) {
			global $nitto_db;
			
			$row = $nitto_db->fetch_row('nt_account', array('activation_code', 'email'),
				array('username' => $variables['username'], 'password' => Helper::hashPassword($variables['password'])));
			if ($row) {
				if (!self::sendActivation($row['activation_code'], $row['email']))
					$nitto_error; // Throw error
				$response->setVariable('email', $row['email']);
			}
			else {
				$response->setVariable('email', 'error');
				// Throw error
			}
		}
		
		public static function activate($variables, &$response) {
			global $nitto_db;
			
			$activation_code = $nitto_db->fetch_row('nt_account', 'activation_code', array('id' => $variables['accountID']));			
			if ($activation_code) $activation_code = $activation_code['activation_code'];
			else $activation_code = "unknown";
			
			// Let's see if we match?
			$status = '0'; // Fallback, default override
			if (trim($variables['activationCode']) == $activation_code	OR trim($variables['activationCode']) == '0000000') {
				if ($nitto_db->update('nt_account', array('active' => '1', 'terms_accepted' => '1'), array('id' => $variables['accountID'])))
					$status = "1";
			} else $status = "0"; // Activation failed
			$response->setVariable('status', $status);
			return;
		}
		
		public static function resetPassword($variables, &$response) {
			global $nitto_db;
			
			$row = $nitto_db->fetch_row('nt_account', 'id', array('email' => $variables['email']));
			if ($row) {
				$password = Helper::randomPassword();
				$nitto_db->update('nt_account', array('password' => Helper::hashPassword($password)), array('email' => $variables['email']));
				
				$template_variables = array(
					'password' => $password
				);
				
				if (!Mail::send('Password Reset', $variables['email'], 'forgotpassword', $template_variables)); // Throw error
				$response->setVariable('status', '1');
			}
			else $response->setVariable('status', '0'); // Failed...
		}
		
		public static function login($variables, &$response) {
			global $nitto_db;
			
			if (Version::versionRequired($variables['version'])) {
				$response->setVariable('status', '6'); // Minimum version is higher
				return;
			}
			$server_status = Server::status();
			if ($server_status['traffic']) {
				$response->setVariable('status', '5'); // Server traffic is too high, try again later
				return;
			}
			$account = $nitto_db->fetch_row('nt_account', NULL, array('username' => $variables['username'], 'password' => Helper::hashPassword($variables['password'])));
			if (!$account) {
				$response->setVariable('status', '2'); // Authorization failed
				return;
			}
			if (!intval($account['active'])) {
				$response->setVariable('email', $account['email']);
				$response->setVariable('accountID', $account['id']);
				$response->setVariable('status', '3'); // Account inactive...
				return;
			}
			$ban = Ban::get($account['id']);
			if ($ban) {
				$response->setVariable('status', '4'); // You're banned!
				$response->setVariable('banReason', $ban['reason']);
				$response->setVariable('unlockTime', $ban['unlock_time']);
				return;
			}
			
			$response->setVariable('chatClickable', "1"); // Chat active?
			$response->setVariable('allowModTool', "1"); // Allow MOD tool
			$response->setVariable('memberLevel', $account['level']); // Member level
			$response->setVariable('terms', intval($account['terms_accepted']) ? "0" : "1"); // Are the terms not accepted?
			$response->setVariable('accountID', $account['id']); // Account ID
			$response->setVariable('username', $account['username']); // Username
			$response->setVariable('status', '1'); // Success
			
			return;
		}
		
		public static function acceptTerms($variables, &$response) {
			global $nitto_db;
			$nitto_db->update('nt_account', array('terms_accepted' => '1'), array('id' => $variables['accountID']));
			$response->setVariable('status', '1'); // Success
		}
		
		public static function initialize($variables, &$response) {
			global $nitto_db, $nitto_error;
			// Acount data
			// var_dump($variables);
			if (!$account = $nitto_db->fetch_row('nt_account', NULL, array('id' => $variables['accountID'])))
				$nitto_error; // Fatal Error
			$response->setVariable('emailNotification', $account['email_notification']);
			$response->setVariable('newUsername', '0');
			$response->setVariable('level', $account['level']);
			$response->setVariable('teamName', Team::getName($account['team_id']));
			$response->setVariable('teamID', $account['team_id']);
			$response->setVariable('memberType', $account['type']);
			$response->setVariable('accountbalance', $account['balance']);
			$response->setVariable('points', $account['points']);
			$response->setVariable('class', $account['class']);
			$response->setVariable('age', date("Y") - $account['birthyear']);
			$response->setVariable('gender', $account['gender']);
			$response->setVariable('bracketET', $account['bracketET']);
			// Messages
			$message = Message::getNewest($variables['accountID']);
			if ($message){
				$response->setVariable('messageID1', $message['id']);
				$response->setVariable('messageFrom1', Account::getUsername($message['from_id']));
				$response->setVariable('messageDate1', $message['date']);
				$response->setVariable('messageHeader1', $message['subject']);
				$response->setVariable('message1', $message['content']);
			}
			// Cars
			$cars = Car::getFor($variables['accountID']);
			foreach ($cars as $car) {
				$n = $car['car_number'];
				// Car Stock
				$response->setVariable('carName'.$n, $car['stock']['name']);
				$response->setVariable('carID'.$n, $car['stock']['id']);
				$response->setVariable('carLocalImage'.$n, $car['stock']['local_image']);
				$response->setVariable('carRemoteImage'.$n, $car['stock']['remote_image']);
				$response->setVariable('logoLocalImage'.$n, $car['stock']['logo_local_image']);
				$response->setVariable('logoRemoteImage'.$n, $car['stock']['logo_remote_image']);
				$response->setVariable('carStockHp'.$n, $car['stock']['performance']['hp']);
				$response->setVariable('carStockWeight'.$n, $car['stock']['performance']['weight']);
				$response->setVariable('carStockBoost'.$n, $car['stock']['performance']['boost']);
				$response->setVariable('carStockRedline'.$n, $car['stock']['performance']['redline']);
				$response->setVariable('carStockRevLimiter'.$n, $car['stock']['performance']['revlimiter']);
				// Car General
				$response->setVariable('carLocked'.$n, $car['locked']);
				$response->setVariable('carTeam'.$n, $car['team_id']);
				$response->setVariable('carSelected'.$n, $car['selected']);
				$response->setVariable('accountCarID'.$n, $car['id']);
				// Car Visual
				$response->setVariable('carColor'.$n, $car['visual']['color']);
				$response->setVariable('carHood'.$n, $car['visual']['hood']);
				$response->setVariable('carGraphic'.$n, $car['visual']['graphic']);
				$response->setVariable('carGraphicColor'.$n, $car['visual']['graphic_color']);
				$response->setVariable('carNumeral'.$n, $car['visual']['numeral']);
				$response->setVariable('carNumeralColor'.$n, $car['visual']['numeral_color']);
				$response->setVariable('carNumeralShadow'.$n, $car['visual']['numeral_shadow']);
				$response->setVariable('carRideHeight'.$n, $car['visual']['ride_height']);
				$response->setVariable('accountCarID'.$n.'guages',  $car['visual']['guages']);
				// Wings and wheels
				$wings = Part::getWings($car['id']);
				for ($i = 0; $i < sizeof($wings); $i++)
					$response->setVariable('accountCarID'.$n.'wing'.$i, $wings[$i]['id']);
				$wheels = Part::getWheels($car['id']);
				for ($i = 0; $i < sizeof($wheels); $i++)
					$response->setVariable('accountCarID'.$n.'wheels'.$i, $wheels[$i]['id']);
				// Car Conditions
				$response->setVariable('carNitrousRemaining'.$n, $car['condition']['nitrous_remaining']);
				$response->setVariable('carOilType'.$n, $car['condition']['oil_type']);
				$response->setVariable('carOilLifeRemaining'.$n, $car['condition']['oil_life_remaining']);
				$response->setVariable('carEngineDamage'.$n, $car['condition']['engine_damage']);
				$response->setVariable('carClutchWear'.$n, $car['condition']['clutch_wear']);
				// Car Performance 
				$response->setVariable('carHP'.$n, $car['performance']['hp']);
				$response->setVariable('carTireGrip'.$n, $car['performance']['tire_grip']);
				$response->setVariable('carRedline'.$n, $car['performance']['redline']);
				$response->setVariable('carRevLimiter'.$n, $car['performance']['revlimiter']);
				$response->setVariable('carWeight'.$n, $car['performance']['weight']);
				$response->setVariable('carEngineDamageFactor'.$n, $car['performance']['engine_damage_factor']);
				$response->setVariable('carClutchWearFactor'.$n, $car['performance']['clutch_wear_factor']);
				$response->setVariable('carHpIncrease'.$n, $car['performance']['hp_increase']);
				$response->setVariable('carBoostSetting'.$n, $car['performance']['boost_setting']);
				$response->setVariable('carBoostIncrease'.$n, $car['performance']['boost_increase']);
				$response->setVariable('carShiftLight'.$n, $car['performance']['shift_light']);
				$response->setVariable('carBracketET'.$n, $car['performance']['bracket_et']);
				$response->setVariable('carAverageET'.$n, $car['performance']['average_et']);
				$response->setVariable('car'.$n.'TireRadius', $car['performance']['tire_radius']);
				// Gear ratios
				$gear_ratios = Car::parseGearRatios($car['performance']['gear_ratios']);
				$response->setVariable('car'.$n.'GearRatio1', $gear_ratios[1]);
				$response->setVariable('car'.$n.'GearRatio2', $gear_ratios[2]);
				$response->setVariable('car'.$n.'GearRatio3', $gear_ratios[3]);
				$response->setVariable('car'.$n.'GearRatio4', $gear_ratios[4]);
				$response->setVariable('car'.$n.'GearRatio5', $gear_ratios[5]);
				$response->setVariable('car'.$n.'GearRatio6', $gear_ratios[6]);
				$response->setVariable('car'.$n.'FinalDriveRatio', $gear_ratios['final']);
				// Car Tuning
				$response->setVariable('carNitrousShotSize1', '1');
				$response->setVariable('accountCarID'.$n.'boostController', $car['performance']['boost_controller']);
				$response->setVariable('accountCarID'.$n.'suspensionController', $car['performance']['suspension_controller']);
				$response->setVariable('accountCarID'.$n.'magicGearBox', $car['performance']['magic_gearbox']);
				$response->setVariable('accountCarID'.$n.'supercharger', $car['performance']['supercharger']);
				$response->setVariable('accountCarID'.$n.'blowOffValve', $car['performance']['blowoffvalve']);
				// Car Parts
				$parts = Part::getFor($car['id']);
				foreach ($parts as $part) {
					$response->setVariable('1partName1', 'unknown');
					$response->setVariable('1partID1', '1');
					$response->setVariable('1partHPIncrease1', '0');
					$response->setVariable('1partCategory1', 'Spark Plugs');
					$response->setVariable('1partSubCategory1', 'NGK');
					$response->setVariable('1partInstalled1', '0');
					$response->setVariable('1brandLocalImage1', '');
					$response->setVariable('1brandRemoteImage1', '');
					$response->setVariable('1partLocalImage1', '');
					$response->setVariable('1brandRemoteImage1', '');
				}
				// Settings
				$response->setVariable('crowd', '1');
				$response->setVariable('asphalt', '1');
				$response->setVariable('centerLine', '1');
				$response->setVariable('backDrop', '1');
				$response->setVariable('vehicleAnimation', '1');
				$response->setVariable('soundEffects', '0');
			}
		}
		
		public static function getUsername($id) {
			global $nitto_db, $nitto_error;
			if (!$id OR !$account = $nitto_db->fetch_row('nt_account', 'username', array('id' => intval($id)))) {
				$nitto_error;
				$account['username'] = 'unknown';
			}
			return $account['username'];
		}
	}
?>