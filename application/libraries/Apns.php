<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
#error_reporting(E_ALL); ini_set('display_errors', '1');

class Apns
{
	public function send_push_message_user($deviceId,$messages){
		date_default_timezone_set('Asia/Kolkata');
		error_reporting(-1);
		require_once(APPPATH.'/third_party/ApnsPHP/Autoload.php');
		$push = new ApnsPHP_Push(
			ApnsPHP_Abstract::ENVIRONMENT_PRODUCTION,
			'certificates/Service-Certificates.pem'
			#ApnsPHP_Abstract::ENVIRONMENT_SANDBOX,
			#'certificates/server_certificates_bundle_sandbox.pem'
		);
		$push->connect();

		$message = new ApnsPHP_Message($deviceId);

		$message->setCustomIdentifier("Message-Badge-3");

		$message->setBadge(3);

		$message->setText($messages['message']);

		$message->setSound();

		$message->setCustomProperty('acme2', array('bang', 'whiz'));

		$message->setCustomProperty('acme3', array('bing', 'bong'));
		
		$message->setCustomProperty('message', $messages);

		$message->setExpiry(30);

		$push->add($message);

		$push->send();

		$push->disconnect();#echo '<pre>';print_r($push->getErrors());
		return $push->getErrors();
	}
   public function send_push_message_user_new($deviceId,$messages,$action_key){
		date_default_timezone_set('Asia/Kolkata');
		error_reporting(-1);
		require_once(APPPATH.'/third_party/ApnsPHP/Autoload.php');
		$push = new ApnsPHP_Push(
			ApnsPHP_Abstract::ENVIRONMENT_PRODUCTION,
			'certificates/Service-Certificates.pem'
			#ApnsPHP_Abstract::ENVIRONMENT_SANDBOX,
			#'certificates/server_certificates_bundle_sandbox.pem'
		);
		#echo $messages['message'];
		$push->connect();

		$message = new ApnsPHP_Message($deviceId);

		$message->setCustomIdentifier("Message-Badge-3");

		$message->setBadge(3);

		$message->setText($messages);

		$message->setSound();

		$message->setCustomProperty('acme2', array('bang', 'whiz'));

		$message->setCustomProperty('acme3', array('bing', 'bong'));
		
		$message->setCustomProperty('action_key', $action_key);
		
		$message->setCustomProperty('message', $messages);

		$message->setExpiry(30);

		$push->add($message);

		$push->send();

		$push->disconnect();#echo '<pre>';print_r($push->getErrors());
		return $push->getErrors();
	}
   
   public function send_push_message_tasker_new($deviceId,$messages,$action_key){
		date_default_timezone_set('Asia/Kolkata');
		error_reporting(-1);
		require_once(APPPATH.'/third_party/ApnsPHP/Autoload.php');
		$push = new ApnsPHP_Push(
			ApnsPHP_Abstract::ENVIRONMENT_PRODUCTION,			
			'certificates/Tasker-Certificates.pem'
			#ApnsPHP_Abstract::ENVIRONMENT_SANDBOX,
			#ApnsPHP_Abstract::ENVIRONMENT_PRODUCTION,
			#'certificates/server_certificates_bundle_sandbox.pem'
		); 
		$push->connect();

		$message = new ApnsPHP_Message($deviceId);

		$message->setCustomIdentifier("Message-Badge-3");

		$message->setBadge(3);

		$message->setText($messages['message']);

		$message->setSound();

		$message->setCustomProperty('acme2', array('bang', 'whiz'));

		$message->setCustomProperty('acme3', array('bing', 'bong'));
		
		$message->setCustomProperty('action_key', $action_key);
		
		$message->setCustomProperty('message', $messages);

		$message->setExpiry(30);

		$push->add($message);

		$push->send();

		$push->disconnect(); #echo '<pre>';print_r($push->getErrors());
		return $push->getErrors(); 
	} 
	
	public function send_push_message_tasker($deviceId,$messages){
		date_default_timezone_set('Asia/Kolkata');
		error_reporting(-1);
		require_once(APPPATH.'/third_party/ApnsPHP/Autoload.php');
		$push = new ApnsPHP_Push(
			ApnsPHP_Abstract::ENVIRONMENT_PRODUCTION,			
			'certificates/Tasker-Certificates.pem'
			#ApnsPHP_Abstract::ENVIRONMENT_SANDBOX,
			#ApnsPHP_Abstract::ENVIRONMENT_PRODUCTION,
			#'certificates/server_certificates_bundle_sandbox.pem'
		); 
		$push->connect();

		$message = new ApnsPHP_Message($deviceId);

		$message->setCustomIdentifier("Message-Badge-3");

		$message->setBadge(3);

		$message->setText($messages['message']);

		$message->setSound();

		$message->setCustomProperty('acme2', array('bang', 'whiz'));

		$message->setCustomProperty('acme3', array('bing', 'bong'));
		
		$message->setCustomProperty('message', $messages);

		$message->setExpiry(30);

		$push->add($message);

		$push->send();

		$push->disconnect(); #echo '<pre>';print_r($push->getErrors());
		return $push->getErrors(); 
	}
}