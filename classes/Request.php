<?php
	class Request {
		public $variables;
		public $response;
		
		function __construct($request_variables) {
			$this->variables = $request_variables;
			$this->response = new Response();
			
			// Version checking must not be encrypted, since encryption keys can change from version to version
			if (isset($this->variables['action']) AND $this->variables['action'] == 'checkVersion') {
				$this->dispatchAction($this->variables['action']);
				return;
			}
			// If the request contains a data payload, we have to decode it first
			if (isset($this->variables['data'])) $this->decode($this->variables['data']);
			else die('malformed request');
			
			// var_dump($this->variables);

			// If the request contains an action to be performed, dispatch it to the relevant class
			if (isset($this->variables['action'])) $this->dispatchAction($this->variables['action']);
			else die('malformed request');
		}

		function getResponse() {
			return $this->response;
		}
		
		function dispatchAction($action) {
			// echo '<pre>'; var_dump($this->variables); die();
			switch ($action) {
				// General Core
				case 'checkVersion': Server::HELO($this->variables['version'], $this->response); break;
				// Vehicles
				case 'getCarSearchList': // Probably same stuff...
				case 'getCarList': Car::getList($this->variables, $this->response); break;
				case 'getCarDetail': Car::getDetails($this->variables['carID'], $this->response); break;
				case 'selectCar': Car::select($this->variables, $this->response);
				// Accounts
				case 'createAccount': Account::create($this->variables, $this->response); break;
				case 'activateAccount': Account::activate($this->variables, $this->response); break;
				case 'getActivationCode': Account::resendActivation($this->variables, $this->response); break;
				case 'forgotPassword': Account::resetPassword($this->variables, $this->response); break;
				case 'login': Account::login($this->variables, $this->response); break;
				case 'acceptTerms': Account::acceptTerms($this->variables, $this->response); break;
				// Game
				case 'initialize': Account::initialize($this->variables, $this->response); break;
				// Parts
				case 'getpartmainmenu': Part::getMainMenu($this->response); break;
				case 'getpartsubmenu': Part::getSubMenu($this->variables['ID'], $this->response); break;
				case 'getPartList': Part::getList($this->variables['ID'], $this->response); break;
				case 'getpartdetail': Part::getDetail($this->variables, $this->response); break;
				// Challenge
				case 'getCompRacerListLadder': Challenge::getCompRacerListLadder($this->variables, $this->response); break;
				case 'getCompRacerList': Challenge::getCompRacerList($this->variables, $this->response); break;
				case 'runComputerRace': Race::runComputer($this->variables, $this->response); break;
				default: die('malformed request');
			}
		}
		
		public function decode($request_string) {			
			$key = ENCRYPTION_KEY;
			$request_string = strtr($request_string, array("~x00~"=>"\0"));
			$_decoded = "";
			// Simple XOR encryption to counteract the casual spoofer
			for ($i = 0; $i < strlen($request_string); $i++) {
				$_decoded .= chr(ord($request_string[$i]) ^ ord($key[$i%strlen($key)]));
				// echo "[".ord($request_string[$i])."] ".$request_string[$i]." ^ ".ord($key[$i%strlen($key)])."\n";
				// echo "   > ".chr(ord($request_string[$i]) ^ ord($key[$i%strlen($key)]))." [".(ord($request_string[$i]) ^ ord($key[$i%strlen($key)]))."]\n";
			}
			// Load the decoded request data into the request variables
			parse_str($_decoded, $this->variables);
			// var_dump($_decoded);
		}
	}
?>
