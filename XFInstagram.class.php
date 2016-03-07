<?php
//Copyright (c) 2015 Studio2b
//xFacility2015
//xFInstagram
//Studio2b(www.studio2b.kr)
//Michael Son(mson0129@gmail.com)
//09JUL2015(1.0.0.) - Newly added.

//https://instagram.com/developer/endpoints/users/

require_once(__DIR__."/XFInstagramUsers.class.php");
//require_once(__DIR__."/XFInstagramRelationships.class.php");
//require_once(__DIR__."/XFInstagramMedia.class.php");
//require_once(__DIR__."/XFInstagramComments.class.php");
//require_once(__DIR__."/XFInstagramLikes.class.php");
//require_once(__DIR__."/XFInstagramTags.class.php");
//require_once(__DIR__."/XFInstagramLocations.class.php");
//require_once(__DIR__."/XFInstagramSubscriptions.class.php");
class XFInstagram {
	var $clientId;
	var $users, $relationships, $media, $comments, $likes, $tags, $locations, $subscriptions;
	
	function XFInstagram($clientId) {
		$this->clientId = $clientId;
		$this->users = new XFInstagramUsers($clientId);
		//$this->relationships = new XFInstagramRelationships($client_id);
		//$this->media = new XFInstagramMedia($client_id);
		//$this->comments = new XFInstagramComments($client_id);
		//$this->likes = new XFInstagramLikes($client_id);
		//$this->tags = new XFInstagramTags($client_id);
		//$this->locations = new XFInstagramLocations($client_id);
		//$this->subscriptions = new XFInstagramSubscriptions($client_id);
	}
}
?>