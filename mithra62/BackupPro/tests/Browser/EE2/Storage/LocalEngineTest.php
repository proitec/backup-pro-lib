<?php
/**
 * mithra62 - Backup Pro
 *
 * @copyright	Copyright (c) 2015, mithra62, Eric Lamb.
 * @link		http://mithra62.com/
 * @version		3.0
 * @filesource 	./mithra62/BackupPro/tests/Browser/LocalEngine.php
 */
namespace mithra62\BackupPro\tests\Browser\EE2\Storage;

use mithra62\BackupPro\tests\Browser\AbstractBase\Storage\LocalEngine;
use mithra62\BackupPro\tests\Browser\EE2Trait;

/**
 * mithra62 - (Selenium) Local Storage Engine object Unit Tests
 *
 * Executes all the tests by platform using the below definitions
 *
 * @package mithra62\Tests
 * @author Eric Lamb <eric@mithra62.com>
 */
class LocalEngineTest extends LocalEngine
{
    use EE2Trait;

    /**
     * Disable this since we want full browser support
     */
    public function setUp()
    {}

    /**
     * Disable this since we want full browser support
     */
    public function teardown()
    {}
}