<?php
/**
 * mithra62 - Backup Pro
 *
 * @copyright	Copyright (c) 2015, mithra62, Eric Lamb.
 * @link		http://mithra62.com/
 * @version		3.0
 * @filesource 	./mithra62/BackupPro/tests/Browser/WP/Storage/S3EngineTest.php
 */
namespace mithra62\BackupPro\tests\Browser\WP\Storage;

use mithra62\BackupPro\tests\Browser\AbstractBase\Storage\S3Engine;
use mithra62\BackupPro\tests\Browser\WPTrait;

/**
 * mithra62 - (Selenium) Amazon S3 Storage object Unit Tests
 *
 * Executes all the tests by platform using the below definitions
 *
 * @package mithra62\Tests
 * @author Eric Lamb <eric@mithra62.com>
 */
class S3EngineTest extends S3Engine
{
    use WPTrait;

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