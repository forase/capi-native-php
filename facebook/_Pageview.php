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
use Config\Setting;
/**
 *
 */
class Pageview
{
  private $api = null;
  private $events = array();

  function __construct($data)
  {
    if(!isset($_COOKIE['USERID']) || empty($_COOKIE['USERID'])){
        $externalId = Setting::sgetExternalId();
        setcookie('USERID', $externalId, time()+14*24*3600);
        $_COOKIE['USERID'] = $externalId;
    }

    $access_token = Setting::getAccessToken();
    $pixel_id = Setting::getPixelId();
    echo "token : ".$access_token." ~ pixel id : ".$pixel_id;
    $this->api = new Api::init(null, null, $access_token);
    $this->api->setLogger(new CurlLogger());

    $user_data = $this->setUserData($data);
    $eventSourceUrl = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    $event = $this->setEvent($user_data,$eventSourceUrl);

    array_push($this->events, $event);

    $request = (new EventRequest($pixel_id))
                // ->setTestEventCode(Setting::getTestKey())
                ->setEvents($events);
    $response = $request->execute();
  }

  public function setUserData($data){
    return (new UserData())
    // It is recommended to send Client IP and User Agent for Conversions API Events.
    ->setClientIpAddress($_SERVER['REMOTE_ADDR'])
    ->setClientUserAgent($_SERVER['HTTP_USER_AGENT'])
    ->setFbc($_COOKIE['_fbc'])
    ->setExternalId($_COOKIE['USERID'])
    ->setFbp($_COOKIE['_fbp']);
  }

  public function setEvent($user_data,$eventSourceUrl)
  {
    return (new Event())
    ->setEventName('PageView')
    ->setEventTime(time())
    ->setEventSourceUrl($eventSourceUrl)
    ->setUserData($user_data)
    // ->setEventId(FacebookCapiPageView::getEventId())
    ->setActionSource(ActionSource::WEBSITE);
  }
}

?>
