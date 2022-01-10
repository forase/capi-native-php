<?php
namespace App\Facebook;

use FacebookAds\Api;
use FacebookAds\Logger\CurlLogger;
use FacebookAds\Object\ServerSide\ActionSource;
use FacebookAds\Object\ServerSide\Content;
use FacebookAds\Object\ServerSide\CustomData;
use FacebookAds\Object\ServerSide\DeliveryCategory;
use FacebookAds\Object\ServerSide\Event;
use FacebookAds\Object\ServerSide\EventRequest;
use FacebookAds\Object\ServerSide\UserData;
use App\Config\Setting;
/**
 *
 */
class Pageview
{
  private $api = null;
  private $events = array();

  function __construct()
  {
    if(!isset($_COOKIE['USERID']) || empty($_COOKIE['USERID'])){
        $externalId = Setting::setExternalId();
        setcookie('USERID', $externalId, time()+14*24*3600);
        $_COOKIE['USERID'] = $externalId;
    }

    $access_token = Setting::getAccessToken();
    $pixel_id = Setting::getPixelId();
    Api::init(null, null, $access_token,false);
    $this->api = Api::instance();
    $this->api->setLogger(new CurlLogger());
    $user_data = $this->setUserData();
    $eventSourceUrl = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    $event = $this->setEvent($user_data,$eventSourceUrl);

    array_push($this->events, $event);

    try {
      $request = (new EventRequest($pixel_id))
                  ->setTestEventCode(Setting::getTestKey())
                  ->setEvents($this->events);
      $response = $request->execute();
    } catch(Facebook\Exceptions\FacebookResponseException $e) {
      echo 'Graph returned an error: ' . $e->getMessage();
      exit;
    } catch(Facebook\Exceptions\FacebookSDKException $e) {
      echo 'Facebook SDK returned an error: ' . $e->getMessage();
      exit;
    }


  }

  public function setUserData(){
    return (new UserData())
    // It is recommended to send Client IP and User Agent for Conversions API Events.
    ->setClientIpAddress($_SERVER['REMOTE_ADDR'])
    ->setClientUserAgent($_SERVER['HTTP_USER_AGENT'])
    ->setExternalId($_COOKIE['USERID'])
    ->setFbc('fb.1.1554763741205.AbCdEfGhIjKlMnOpQrStUvWxYz1234567890')
    ->setFbp('fb.1.1558571054389.1098115397');
    // ->setFbc($_COOKIE['_fbc'])
    // ->setExternalId($_COOKIE['USERID'])
    // ->setFbp($_COOKIE['_fbp']);
  }

  public function setEvent($user_data,$eventSourceUrl)
  {
    return (new Event())
    ->setEventName('PageView')
    ->setEventTime(time())
    ->setEventSourceUrl($eventSourceUrl)
    ->setUserData($user_data)
    ->setEventId(Setting::getEventId())
    ->setActionSource(ActionSource::WEBSITE);
  }
}

?>
