<?php
	class Part {
		public static function getFor($car_id) {
			return array();
		}
		public static function getWings($car_id) {
			return false;
		}
		
		public static function getWheels($car_id) {
			return false;
		}
		
		public static function getMainMenu(&$response) {
			$response->setVariable('menuName1', 'Injectors');
			$response->setVariable('menuID1', '1');
			$response->setVariable('menuSub1', '0');
			$response->setVariable('menuLocalImage1', 'injectorsGraphic');
			$response->setVariable('menuRemoteImage1', 'injectorsGraphic');
		}
		
		public static function getSubMenu($id, &$response) {
			$response->setVariable('menuName1', 'Injectors');
			$response->setVariable('menuID1', '1');
			$response->setVariable('menuSub1', '1');
			$response->setVariable('menuLocalImage1', 'injectorsGraphic');
			$response->setVariable('menuRemoteImage1', 'injectorsGraphic');	
		}
		
		public static function getList($id, &$response) {
			$response->setVariable('status', '1');
			$response->setVariable('partName1', 'Teh Indgekta');
			$response->setVariable('partID1', '1');
			$response->setVariable('partPrice1', '100');
			$response->setVariable('brandLocalImage1', 'acmeFuelInjectors');
			$response->setVariable('brandRemoteImage1', 'acmeFuelInjectors');
			$response->setVariable('partLocalImage1', 'acmeLogo');
			$response->setVariable('partRemoteImage1', 'acmeLogo');
		}
		
		public static function getDetail($variables, &$response) {
			$response->setVariable('partName', 'Teh Indgekta');
			$response->setVariable('partID', '1');
			$response->setVariable('partPrice', '100');
			$response->setVariable('partDescription', 'Makes your car go vrooom!');
			$response->setVariable('brandName', 'acme');	
			$response->setVariable('brandLocalImage', 'acmeFuelInjectors');
			$response->setVariable('brandRemoteImage', 'acmeFuelInjectors');
			$response->setVariable('partLocalImage', 'acmeLogo');
			$response->setVariable('partRemoteImage', 'acmeLogo');
		}
	}
?>