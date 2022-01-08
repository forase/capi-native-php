<?php

use Config\Setting;

// require_once(realpath(dirname(__FILE__).'/../.config/Setting.php'));

if(!isset($_COOKIE['USERID']) || empty($_COOKIE['USERID'])){
    $externalId = Setting::sgetExternalId();
    setcookie('USERID', $externalId, time()+14*24*3600);
    $_COOKIE['USERID'] = $externalId;
}

$access_token = Setting::getAccessToken();
$pixel_id = Setting::getPixelId();

$api = Api::init(null, null, $access_token);
$api->setLogger(new CurlLogger());
$user_data = (new UserData())
// It is recommended to send Client IP and User Agent for Conversions API Events.
    ->setClientIpAddress($_SERVER['REMOTE_ADDR'])
    ->setClientUserAgent($_SERVER['HTTP_USER_AGENT'])
    ->setFbc($_COOKIE['_fbc'])
    ->setExternalId($_COOKIE['USERID'])
    ->setFbp($_COOKIE['_fbp']);

$eventSourceUrl = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

$event = (new Event())
    ->setEventName('PageView')
    ->setEventTime(time())
    ->setEventSourceUrl($eventSourceUrl)
    ->setUserData($user_data)
    ->setEventId(FacebookCapiPageView::getEventId())
    ->setActionSource(ActionSource::WEBSITE);

$events = array();
array_push($events, $event);

$request = (new EventRequest($pixel_id))
    ->setTestEventCode(Setting::getTestKey())
    ->setEvents($events);
$response = $request->execute();
?>
