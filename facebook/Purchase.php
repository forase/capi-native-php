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
class Purchase
{
  private $api = null;
  private $events = array();

  function __construct($data)
  {
    $access_token = Setting::getAccessToken();
    $pixel_id = Setting::getPixelId();

    Api::init(null, null, $access_token,false);
    $this->api = Api::instance();
    $this->api->setLogger(new CurlLogger());

    $user_data = $this->setUserData($data);
    $content = $this->setContent();
    $custom_data = $this->setCustomData($content);
    $event = $this->setEvent($user_data,$custom_data);

    array_push($this->events, $event);

    $request = (new EventRequest($pixel_id))
                ->setTestEventCode(Setting::getTestKey())
                ->setEvents($this->events);
    $response = $request->execute();
    print_r($response);
  }

  public function setUserData($data){
    $user_data = (new UserData())
    ->setEmails(array('dev@lougha.com'))
    ->setPhones(array('12345678901', '14251234567'))
    // It is recommended to send Client IP and User Agent for Conversions API Events.
    ->setClientIpAddress($_SERVER['REMOTE_ADDR'])
    ->setClientUserAgent($_SERVER['HTTP_USER_AGENT'])
    ->setFbc('fb.1.1554763741205.AbCdEfGhIjKlMnOpQrStUvWxYz1234567890')
    ->setFbp('fb.1.1558571054389.1098115397');

    return $user_data;
  }

  public function setContent()
  {
    return (new Content())
    ->setProductId('pack kids')
    ->setQuantity(1)
    ->setDeliveryCategory(DeliveryCategory::HOME_DELIVERY);
  }

  public function setCustomData($content)
  {
    return (new CustomData())
    ->setContents(array($content))
    ->setCurrency('mad')
    ->setValue(1500);
  }

  public function setEvent($user_data,$custom_data)
  {
    return (new Event())
    ->setEventName('Purchase')
    ->setEventTime(time())
    ->setEventSourceUrl('http://loughainstitute.com/landingpage/pack/kids')
    ->setUserData($user_data)
    ->setCustomData($custom_data)
    ->setActionSource(ActionSource::WEBSITE);
  }
}

?>
