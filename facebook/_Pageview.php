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
use App\Config;

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
        $externalId = Config\Setting::setExternalId();
        setcookie('USERID', $externalId, time()+14*24*3600);
        $_COOKIE['USERID'] = $externalId;
    }

    $access_token = Config\Setting::getAccessToken();
    $pixel_id = Config\Setting::getPixelId();
    Api::init(null, null, $access_token);
    $this->api = Api::instance();
    $this->api->setLogger(new CurlLogger());
    echo "token : ".$access_token." ~ pixel id : ".$pixel_id;
    $user_data = $this->setUserData();
    $eventSourceUrl = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    $event = $this->setEvent($user_data,$eventSourceUrl);

    array_push($this->events, $event);

    $request = (new EventRequest($pixel_id))
                ->setTestEventCode(Config\Setting::getTestKey())
                ->setEvents($this->events);
    printf($request);
    $response = $request->execute();
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
    echo $eventSourceUrl;
    return (new Event())
    ->setEventName('PageView')
    ->setEventTime(time())
    ->setEventSourceUrl($eventSourceUrl)
    ->setUserData($user_data)
    ->setEventId(Config\Setting::getEventId());
    // ->setActionSource(ActionSource::WEBSITE);
  }
}

?>
