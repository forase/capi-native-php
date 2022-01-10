<?php
namespace App\Config;
/**
 * General Setting
 */
class Setting
{

  private static $ACCESS_TOKEN = 'EAAMe6ZCZBypBABANoWDTSct8v8ompuKnUc8Ainizj7nq4CAg4bXBcfwUce6ykxEjb1AxQ5YGAyNDljvGpOYBQLhLEFFC4EcNf9ZBo9GUIPcIRmJUc22JPLSuKgwBZCGBIdGWbgJvCpvLB1pWptD6ssuOzekgUDc1PoT74zcquLd7DY8Tp1ik';
  private static $SHEET_ID = '';
  private static $EXTERNAL_ID= '';
  private static $PIXEL_ID= 409961910674232;
  private static $EVENT_ID= '';
  private static $TEST_KEY= 'TEST72964';

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

  public static function getAccessToken(){
    // $cls = static::class;
    // if (!isset(self::$ACCESS_TOKEN[$cls])) {
    //     self::$ACCESS_TOKEN[$cls] = new static();
    // }
    // return self::$ACCESS_TOKEN[$cls];
    return self::$ACCESS_TOKEN;
  }

  public static function setExternalId(){
    // $cls = static::class;
    // if (!isset(self::$EXTERNAL_ID[$cls])) {
    //     self::$EXTERNAL_ID[$cls] = new static();
    // }
    // return self::$EXTERNAL_ID[$cls];
    return self::$EXTERNAL_ID;
  }

  public static function getPixelId(){
    // $cls = static::class;
    // if (!isset(self::$PIXEL_ID[$cls])) {
    //     self::$PIXEL_ID[$cls] = new static();
    // }
    // return self::$PIXEL_ID[$cls];
    return self::$PIXEL_ID;
  }

  public static function getEventId(){
    // $cls = static::class;
    // if (!isset(self::$PIXEL_ID[$cls])) {
    //     self::$PIXEL_ID[$cls] = new static();
    // }
    // return self::$PIXEL_ID[$cls];
    return self::$EVENT_ID;
  }

  public static function getTestKey(){
    // $cls = static::class;
    // if (!isset(self::$TEST_KEY[$cls])) {
    //     self::$TEST_KEY[$cls] = new static();
    // }
    // return self::$TEST_KEY[$cls];
    return self::$TEST_KEY;
  }

}
?>
