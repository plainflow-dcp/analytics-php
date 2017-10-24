<?php

require_once(dirname(__FILE__) . "/../lib/Plainflow.php");

class PlainflowTest extends PHPUnit_Framework_TestCase {

  function setUp() {
    date_default_timezone_set("UTC");
    Plainflow::init("oq0vdlg7yi", array("debug" => true));
  }

  function testTrack() {
    $this->assertTrue(Plainflow::track(array(
      "userId" => "john",
      "event" => "Module PHP Event"
    )));
  }

  function testGroup(){
    $this->assertTrue(Plainflow::group(array(
      "groupId" => "group-id",
      "userId" => "user-id",
      "traits" => array(
        "plan" => "startup"
      )
    )));
  }

  function testGroupAnonymous(){
    $this->assertTrue(Plainflow::group(array(
        "groupId" => "group-id",
        "anonymousId" => "anonymous-id",
        "traits" => array(
            "plan" => "startup"
        )
    )));
  }

  /**
   * @expectedException \Exception
   * @expectedExceptionMessage Plainflow::group() requires userId or anonymousId
   */
  function testGroupNoUser() {
    Plainflow::group(array(
        "groupId" => "group-id",
        "traits" => array(
            "plan" => "startup"
        )
    ));
  }

  function testMicrotime(){
    $this->assertTrue(Plainflow::page(array(
      "anonymousId" => "anonymous-id",
      "name" => "plainflow-php-microtime",
      "category" => "docs",
      "timestamp" => microtime(true),
      "properties" => array(
        "path" => "/docs/libraries/php/",
        "url" => "https://www.plainflow.com/docs/developers/sdk/php"
      )
    )));
  }

  function testPage(){
    $this->assertTrue(Plainflow::page(array(
      "anonymousId" => "anonymous-id",
      "name" => "plainflow-php",
      "category" => "docs",
      "properties" => array(
        "path" => "/docs/libraries/php/",
        "url" => "https://www.plainflow.com/docs/developers/sdk/php"
      )
    )));
  }

  function testBasicPage(){
    $this->assertTrue(Plainflow::page(array(
      "anonymousId" => "anonymous-id"
    )));
  }

  function testScreen(){
    $this->assertTrue(Plainflow::screen(array(
      "anonymousId" => "anonymous-id",
      "name" => "2048",
      "category" => "game built with php :)",
      "properties" => array(
        "points" => 300
      )
    )));
  }

  function testBasicScreen(){
    $this->assertTrue(Plainflow::screen(array(
      "anonymousId" => "anonymous-id"
    )));
  }

  function testIdentify() {
    $this->assertTrue(Plainflow::identify(array(
      "userId" => "doe",
      "traits" => array(
        "loves_php" => false,
        "birthday" => time()
      )
    )));
  }

  function testEmptyTraits() {
    $this->assertTrue(Plainflow::identify(array(
      "userId" => "empty-traits"
    )));

    $this->assertTrue(Plainflow::group(array(
      "userId" => "empty-traits",
      "groupId" => "empty-traits"
    )));
  }

  function testEmptyArrayTraits() {
    $this->assertTrue(Plainflow::identify(array(
      "userId" => "empty-traits",
      "traits" => array()
    )));

    $this->assertTrue(Plainflow::group(array(
      "userId" => "empty-traits",
      "groupId" => "empty-traits",
      "traits" => array()
    )));
  }

  function testEmptyProperties() {
    $this->assertTrue(Plainflow::track(array(
      "userId" => "user-id",
      "event" => "empty-properties"
    )));

    $this->assertTrue(Plainflow::page(array(
      "category" => "empty-properties",
      "name" => "empty-properties",
      "userId" => "user-id"
    )));
  }

  function testEmptyArrayProperties(){
    $this->assertTrue(Plainflow::track(array(
      "userId" => "user-id",
      "event" => "empty-properties",
      "properties" => array()
    )));

    $this->assertTrue(Plainflow::page(array(
      "category" => "empty-properties",
      "name" => "empty-properties",
      "userId" => "user-id",
      "properties" => array()
    )));
  }

  function testAlias() {
    $this->assertTrue(Plainflow::alias(array(
      "previousId" => "previous-id",
      "userId" => "user-id"
    )));
  }

  function testContextEmpty() {
    $this->assertTrue(Plainflow::track(array(
      "userId" => "user-id",
      "event" => "Context Test",
      "context" => array()
    )));
  }

  function testContextCustom() {
    $this->assertTrue(Plainflow::track(array(
      "userId" => "user-id",
      "event" => "Context Test",
      "context" => array(
        "active" => false
      )
    )));
  }

  function testTimestamps() {
    $this->assertTrue(Plainflow::track(array(
      "userId" => "user-id",
      "event" => "integer-timestamp",
      "timestamp" => (int) mktime(0, 0, 0, date('n'), 1, date('Y'))
    )));

    $this->assertTrue(Plainflow::track(array(
      "userId" => "user-id",
      "event" => "string-integer-timestamp",
      "timestamp" => (string) mktime(0, 0, 0, date('n'), 1, date('Y'))
    )));

    $this->assertTrue(Plainflow::track(array(
      "userId" => "user-id",
      "event" => "iso8630-timestamp",
      "timestamp" => date(DATE_ATOM, mktime(0, 0, 0, date('n'), 1, date('Y')))
    )));

    $this->assertTrue(Plainflow::track(array(
      "userId" => "user-id",
      "event" => "iso8601-timestamp",
      "timestamp" => date(DATE_ATOM, mktime(0, 0, 0, date('n'), 1, date('Y')))
    )));

    $this->assertTrue(Plainflow::track(array(
      "userId" => "user-id",
      "event" => "strtotime-timestamp",
      "timestamp" => strtotime('1 week ago')
    )));

    $this->assertTrue(Plainflow::track(array(
      "userId" => "user-id",
      "event" => "microtime-timestamp",
      "timestamp" => microtime(true)
    )));

    $this->assertTrue(Plainflow::track(array(
      "userId" => "user-id",
      "event" => "invalid-float-timestamp",
      "timestamp" => ((string) mktime(0, 0, 0, date('n'), 1, date('Y'))) . '.'
    )));
  }
}
?>
