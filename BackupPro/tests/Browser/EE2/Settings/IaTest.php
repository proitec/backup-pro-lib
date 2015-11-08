<?php
/**
 * mithra62
 *
 * @copyright	Copyright (c) 2015, mithra62, Eric Lamb.
 * @link		http://mithra62.com/
 * @version		2.0
 * @filesource 	./mithra62/BackupPro/tests/Browser/EE2/Settings/IaTest.php
 */

namespace mithra62\BackupPro\tests\Browser;

use mithra62\BackupPro\tests\Browser\AbstractBase\Settings\Ia;
use mithra62\BackupPro\tests\Browser\EE2Trait;

/**
 * mithra62 - (Selenium) Integrity Agent Settings object Unit Tests
 *
 * Executes all teh tests by platform using the below definitions
 *
 * @package 	mithra62\Tests
 * @author		Eric Lamb <eric@mithra62.com>
 */
class IaTest extends Ia
{
    use EE2Trait;

    /**
     * Disable this since we want full browser support
     */
    public function setUp()
    {
    
    }
    
    /**
     * Disable this since we want full browser support
     */
    public function teardown()
    {
    
    }
}