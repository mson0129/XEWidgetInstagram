<?php
//Copyright (c) 2015 Studio2b
//xFacility2015
//xFInstagram
//Studio2b(www.studio2b.kr)
//Michael Son(mson0129@gmail.com)
//09JUL2015(1.0.0.) - Newly added.

//https://instagram.com/developer/endpoints/users/

class XFInstagramUsers {
	var $clientId;
	
	function XFInstagramUsers($clientId) {
		$this->clientId = $clientId;
	}
	
	function browse($q, $count=2000) {
		$return = new stdClass();
		if(!is_null($q)) {
			$data[client_id] = $this->clientId;
			$data[q] = $q;
			if(!is_null($count))
				$data[count] = $count;
			
			$curlClass = new XFCurl("GET", "https://api.instagram.com/v1/users/search", NULL, $data);
			$return->data = json_decode($curlClass->body, true);
			if($curlClass->httpCode==200 && is_array($return->data)) {
				$return->message = "OK";
				$return->bool = true;
			} else {
				$temp = json_decode($curlClass->body);
				$return->message = $temp->meta->error_type;
				$return->bool = false;
			}
		} else {
			$return->message = "NOT_VALID_KEYWORD";
			$return->bool = false;
		}
		return $return;
	}
	
	function peruse($userId) {
		$return = new stdClass();
		if(!is_null($userId)) {
			$data[client_id] = $this->clientId;
			
			$curlClass = new XFCurl("GET", sprintf("https://api.instagram.com/v1/users/%s", $userId), NULL, $data);
			$return->data = json_decode($curlClass->body, true);
			if($curlClass->httpCode==200 && is_array($return->data)) {
				$return->message = "OK";
				$return->bool = true;
			} else {
				$temp = json_decode($curlClass->body);
				$return->message = $temp->meta->error_type;
				$return->bool = false;
			}
		} else {
			$return->message = "NOT_VALID_USER_ID";
			$return->bool = false;
		}
		return $return;
	}
	
	function mediaRecent($userId, $max_id=NULL, $min_id=NULL, $count=33, $min_timestamp=NULL, $max_timestamp=NULL) {
		$return = new stdClass();
		if(!is_null($userId) && is_numeric($userId)) {
			$data[client_id] = $this->clientId;
			if(!is_null($min_id))
				$data[min_id] = $min_id;
			if(!is_null($max_id))
				$data[max_id] = $max_id;
			if(!is_null($count))
				$data[count] = $count;
			if(!is_null($min_timestamp))
				$data[min_timestamp] = $min_timestamp;
			if(!is_null($max_timestamp))
				$data[max_timestamp] = $max_timestamp;
			
			$curlClass = new XFCurl("GET", sprintf("https://api.instagram.com/v1/users/%s/media/recent", $userId), NULL, $data);
			$return->data = json_decode($curlClass->body, true);
			if($curlClass->httpCode==200 && is_array($return->data)) {
				$return->message = "OK";
				$return->bool = true;
			} else {
				$temp = json_decode($curlClass->body);
				$return->message = $temp->meta->error_type;
				$return->bool = false;
			}
		} else {
			$return->message = "NOT_VALID_USER_ID";
			$return->bool = false;
		}
		return $return;
	}
	
	function selfMediaLiked() {}
	function selfFeed() {}
}
?>