<?php
//Copyright (c) 2015 Studio2b
//YouTubeWidget
//Youtube
//Studio2b(www.studio2b.kr)
//Michael Son(mson0129@gmail.com)
//09JUL2015(1.0.0.) - This widget was newly created.
class instagram extends WidgetHandler {
	public function proc($args) {
		ini_set("display_errors", 1);
		
		//xFacility - including the part of frameworks
		if(class_exists("XFCurl")===false)
			require_once($this->widget_path."XFCurl.class.php");
		require_once($this->widget_path."XFInstagram.class.php");
		
		//Interaction with Instagram Module
		if(isset($args->mid_id)) {
			$oModuleModel = getModel("module");
			$module_info = $oModuleModel->getModuleInfoByModuleSrl($args->mid_id);
			if($module_info->module=="instagram") {
				$clientId = $module_info->client_id;
				if(is_array(json_decode($module_info->username, true))) {
					$temp = json_decode($module_info->username, true);
					$username = $temp[0];
				} else {
					//NOT SET USERNAME
				}
				$listCount = $module_info->list_count;
			}
		}
		
		if(!empty($args->client_id))
			$clientId = $args->client_id;
		if(!empty($args->username))
			$username = $args->username;
		if(!is_null($args->list_count) && is_numeric($args->list_count))
			$listCount = $args->list_count;
		
		if(!empty($clientId)){
			$instagram = new XFInstagram($clientId);			
			//Convert Username to UserId
			$username = empty($username) ? "instagram" : $username; //Instagram Official Account
			$temp = $this->getUserId($username);
			if($temp->bool) {
				$userId = $temp->data;
			} else {
				$finder = $instagram->users->browse($username);
				if($finder->bool) {
					foreach($finder->data as $key=>$val) {
						if($val[username]==$username) {
							$userId = $val[id];
							break;
						}
					}
				} else {
					$error = $finder->message;
				}
			}
			unset($temp);
			$userId = is_numeric($userId) ? $userId : "25025320"; //Instagram Official Account
			
			$result = $instagram->users->mediaRecent($userId);
			Context::set("data", $result->data[data]);
		} else {
			Context::set("error", "NO_CLIENT_ID");
		}
		
		$tplPath = sprintf("%sskins/%s/", $this->widget_path, (!is_null($args->skin) &&  $args->skin!="" && is_dir(sprintf("%sskins/%s/", $this->widget_path, $args->skin))) ? $args->skin : "default");
		$tplFile = "browse";
		Context::set("colorset", $args->colorset);
		$oTemplate = &TemplateHandler::getInstance();
		return $oTemplate->compile($tplPath, $tplFile);
	}
	
	protected function getUserId($username) {
		$return = new stdClass();
		$xFCurl = new XFCurl("GET", sprintf("https://instagram.com/%s", $username), NULL, NULL);
		$xFCurl->request();
		if($xFCurl->httpCode==200) {
			$result = preg_match('/\"owner\":\{\"id\":\"(\d+)"\}/', $xFCurl->body, $arr);
			if($result) {
				$return->data = $arr[1];
				$return->message = "OK";
				$return->bool = true;
			} else {
				$return->messgae = "NOT_FOUND";
				$return->bool = false;
			}
		} else {
			$return->message = "HTTP".$xFCurl->httpCode;
			$return->bool = false;
		}
		return $return;
	}
}
?>