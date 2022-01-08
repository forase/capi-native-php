<?php
namespace Config;
/**
 * General Setting
 */
class Setting
{

  private $ACCESS_TOKEN = '';
  private $SHEET_ID = '';
  private $EXTERNALID='';
  private $GETPIXELID='';

  public static function __construct()
  {
    // code...
  }

  public function getAccessToken(){
    return $this->ACCESS_TOKEN;
  }

  public function getSheetId(){
    return $this->SHEET_ID;
  }

  public function sgetExternalId(){
    return $this->EXTERNALID;
  }

  public function getPixelId(){
    return $this->GETPIXELID;
  }

}
?>
