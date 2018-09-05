<?php
	class Challenge {
		public static function getCompRacerListLadder($variables, &$response) {
			$response->setVariable('cupPrizeAmount', '500');
		}
		
		public static function getCompRacerList($variables, &$response) {
			$response->setVariable('username1', 'HotRod');
			$response->setVariable('accountID1', '2');
			$response->setVariable('prizeAmount1', '500');
			$response->setVariable('class1', '1');
			$response->setVariable('catchPhrase1', 'Catch me if you can...');
			$response->setVariable('racerLocalImage1', 'eric');
			$response->setVariable('racerRemoteImage1', 'eric');
			$response->setVariable('carColor1', '000000');
			$response->setVariable('carID1', '5');
			$response->setVariable('carLocalImage1', 'acuraRSX');
			$response->setVariable('carRemoteImage1', 'acuraRSX');
			$response->setVariable('logoLocalImage1', 'acuraRSX');
			$response->setVariable('logoRemoteImage1', 'acuraRSX');
			
			$response->setVariable('username2', 'HotRod');
			$response->setVariable('accountID2', '3');
			$response->setVariable('prizeAmount2', '500');
			$response->setVariable('class2', '1');
			$response->setVariable('catchPhrase2', 'You still wanna do this?');
			$response->setVariable('racerLocalImage2', 'jj');
			$response->setVariable('racerRemoteImage2', 'jj');
			$response->setVariable('carColor2', 'FFFFFF');
			$response->setVariable('carID2', '6');
			$response->setVariable('carLocalImage2', 'NSX');
			$response->setVariable('carRemoteImage2', 'NSX');
			$response->setVariable('logoLocalImage2', 'NSX');
			$response->setVariable('logoRemoteImage2', 'NSX');
		}
	}
?>