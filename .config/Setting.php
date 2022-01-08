<?php
namespace App\Config;
/**
 * General Setting
 */
class Setting
{

  private static $ACCESS_TOKEN = '';
  private static $SHEET_ID = '';
  private static $EXTERNALID='';
  private static $GETPIXELID='';

  /**
   * The Singleton's constructor should always be private to prevent direct
   * construction calls with the `new` operator.
   */
  protected function __construct() { }

  /**
   * Singletons should not be cloneable.
   */
  protected function __clone() { }

  /**
   * Singletons should not be restorable from strings.
   */
  public function __wakeup()
  {
      throw new \Exception("Cannot unserialize a singleton.");
  }

  public function getAccessToken(){
    $cls = static::class;
    if (!isset(self::$instances[$cls])) {
        self::$instances[$cls] = new static();
    }
    return self::$ACCESS_TOKEN[$cls];
  }

  public function getSheetId(){
    $cls = static::class;
    if (!isset(self::$instances[$cls])) {
        self::$instances[$cls] = new static();
    }
    return self::$SHEET_ID[$cls];
  }

  public function sgetExternalId(){
    $cls = static::class;
    if (!isset(self::$instances[$cls])) {
        self::$instances[$cls] = new static();
    }
    return self::$EXTERNALID[$cls];
  }

  public function getPixelId(){
    $cls = static::class;
    if (!isset(self::$instances[$cls])) {
        self::$instances[$cls] = new static();
    }
    return self::$GETPIXELID[$cls];
  }

}
?>
