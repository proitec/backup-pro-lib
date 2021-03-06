<?php
/**
 * mithra62
 *
 * @copyright	Copyright (c) 2015, mithra62, Eric Lamb.
 * @link		http://mithra62.com/
 * @version		3.0
 * @filesource 	./mithra62/BackupPro/tests/Browser/AbstractBase/Storage/RcfEngine.php
 */
namespace mithra62\BackupPro\tests\Browser\AbstractBase\Storage;

use mithra62\BackupPro\tests\Browser\TestFixture;

/**
 * mithra62 - (Selenium) Rackspace Cloud Files Storage Engine object Unit Tests
 *
 * Executes all the tests by platform using the below definitions
 *
 * @package mithra62\Tests
 * @author Eric Lamb <eric@mithra62.com>
 */
abstract class RcfEngine extends TestFixture
{

    /**
     * An instance of the mink selenium object
     * 
     * @var unknown
     */
    public $session = null;

    public function testAddRcfStorageNoName()
    {
        $this->login();
        sleep(2);
        $this->install_addon();
        
        $this->session = $this->getSession();
        $this->session->visit($this->url('storage_add_rcf_storage'));
        $page = $this->session->getPage();
        $page->findById('storage_location_name')->setValue('');
        $page->findButton('m62_settings_submit')->submit();
        
        $this->assertTrue($this->session->getPage()
            ->hasContent('Storage Location Name is required'));
    }

    /**
     * @depends testAddRcfStorageNoName
     */
    public function testAddRcfStorageGoodName()
    {
        $this->session = $this->getSession();
        $this->session->visit($this->url('storage_add_rcf_storage'));
        $page = $this->session->getPage();
        $page->findById('storage_location_name')->setValue('My Rackspace Storage');
        $page->findButton('m62_settings_submit')->submit();
        
        $this->assertNotTrue($this->session->getPage()
            ->hasContent('Storage Location Name is required'));
    }

    /**
     * @depends testAddRcfStorageGoodName
     */
    public function testAddRcfUsernameNoValue()
    {
        $this->session = $this->getSession();
        $this->session->visit($this->url('storage_add_rcf_storage'));
        $page = $this->session->getPage();
        $page->findById('rcf_username')->setValue('');
        $page->findButton('m62_settings_submit')->submit();
        
        $this->assertTrue($this->session->getPage()
            ->hasContent('Rcf Username is required'));
    }

    /**
     * @depends testAddRcfUsernameNoValue
     */
    public function testAddRcfUsernameGoodValue()
    {
        $rcf_creds = $this->getRcfCreds();
        $this->session = $this->getSession();
        $this->session->visit($this->url('storage_add_rcf_storage'));
        $page = $this->session->getPage();
        $page->findById('rcf_username')->setValue($rcf_creds['rcf_username']);
        $page->findButton('m62_settings_submit')->submit();
        
        $this->assertNotTrue($this->session->getPage()
            ->hasContent('Rcf Username is required'));
    }

    /**
     * @depends testAddRcfUsernameGoodValue
     */
    public function testAddRcfApiKeyNoValue()
    {
        $rcf_creds = $this->getRcfCreds();
        $this->session = $this->getSession();
        $this->session->visit($this->url('storage_add_rcf_storage'));
        $page = $this->session->getPage();
        $page->findById('rcf_api')->setValue('');
        $page->findButton('m62_settings_submit')->submit();
        
        $this->assertTrue($this->session->getPage()
            ->hasContent('Rcf Api is required'));
    }

    /**
     * @depends testAddRcfApiKeyNoValue
     */
    public function testAddRcfApiKeyGoodValue()
    {
        $rcf_creds = $this->getRcfCreds();
        $this->session = $this->getSession();
        $this->session->visit($this->url('storage_add_rcf_storage'));
        $page = $this->session->getPage();
        $page->findById('rcf_api')->setValue($rcf_creds['rcf_api']);
        $page->findButton('m62_settings_submit')->submit();
        
        $this->assertNotTrue($this->session->getPage()
            ->hasContent('Rcf Api is required'));
    }

    /**
     * @depends testAddRcfApiKeyGoodValue
     */
    public function testAddRcfContainerNoValue()
    {
        $rcf_creds = $this->getRcfCreds();
        $this->session = $this->getSession();
        $this->session->visit($this->url('storage_add_rcf_storage'));
        $page = $this->session->getPage();
        $page->findById('rcf_container')->setValue('');
        $page->findButton('m62_settings_submit')->submit();
        
        $this->assertTrue($this->session->getPage()
            ->hasContent('Rcf Container is required'));
    }

    /**
     * @depends testAddRcfContainerNoValue
     */
    public function testAddRcfContainerGoodValue()
    {
        $rcf_creds = $this->getRcfCreds();
        $this->session = $this->getSession();
        $this->session->visit($this->url('storage_add_rcf_storage'));
        $page = $this->session->getPage();
        $page->findById('rcf_container')->setValue($rcf_creds['rcf_container']);
        $page->findButton('m62_settings_submit')->submit();
        
        $this->assertNotTrue($this->session->getPage()
            ->hasContent('Rcf Container is required'));
    }

    /**
     * @depends testAddRcfContainerGoodValue
     */
    public function testAddRcfStorageLocationStatusChecked()
    {
        $this->session = $this->getSession();
        $this->session->visit($this->url('storage_add_rcf_storage'));
        
        $page = $this->session->getPage();
        $page->findById('storage_location_status')->check();
        $page->findButton('m62_settings_submit')->submit();
        
        $this->assertTrue($this->session->getPage()
            ->findById('storage_location_status')
            ->isChecked());
    }

    /**
     * @depends testAddRcfStorageLocationStatusChecked
     */
    public function testAddRcfStorageLocationStatusUnChecked()
    {
        $this->session = $this->getSession();
        $this->session->visit($this->url('storage_add_rcf_storage'));
        
        $page = $this->session->getPage();
        $page->findById('storage_location_status')->uncheck();
        $page->findButton('m62_settings_submit')->submit();
        
        $this->assertNotTrue($this->session->getPage()
            ->findById('storage_location_status')
            ->isChecked());
        $this->assertTrue($this->session->getPage()
            ->hasContent('Storage Location Status is required unless you have more than 1 Storage Location'));
    }

    /**
     * @depends testAddRcfStorageLocationStatusUnChecked
     */
    public function testAddRcfStorageLocationFileUseChecked()
    {
        $this->session = $this->getSession();
        $this->session->visit($this->url('storage_add_rcf_storage'));
        
        $page = $this->session->getPage();
        $page->findById('storage_location_file_use')->check();
        $page->findButton('m62_settings_submit')->submit();
        
        $this->assertTrue($this->session->getPage()
            ->findById('storage_location_file_use')
            ->isChecked());
    }

    /**
     * @depends testAddRcfStorageLocationFileUseChecked
     */
    public function testAddRcfStorageLocationFileUseUnChecked()
    {
        $this->session = $this->getSession();
        $this->session->visit($this->url('storage_add_rcf_storage'));
        
        $page = $this->session->getPage();
        $page->findById('storage_location_file_use')->uncheck();
        $page->findButton('m62_settings_submit')->submit();
        
        $this->assertNotTrue($this->session->getPage()
            ->findById('storage_location_file_use')
            ->isChecked());
        $this->assertTrue($this->session->getPage()
            ->hasContent('Storage Location File Use is required unless you have more than 1 Storage Location'));
    }

    /**
     * @depends testAddRcfStorageLocationFileUseUnChecked
     */
    public function testAddRcfStorageLocationDbUseChecked()
    {
        $this->session = $this->getSession();
        $this->session->visit($this->url('storage_add_rcf_storage'));
        
        $page = $this->session->getPage();
        $page->findById('storage_location_db_use')->check();
        $page->findButton('m62_settings_submit')->submit();
        
        $this->assertTrue($this->session->getPage()
            ->findById('storage_location_db_use')
            ->isChecked());
    }

    /**
     * @depends testAddRcfStorageLocationDbUseChecked
     */
    public function testAddRcfStorageLocationDbUseUnChecked()
    {
        $this->session = $this->getSession();
        $this->session->visit($this->url('storage_add_rcf_storage'));
        
        $page = $this->session->getPage();
        $page->findById('storage_location_db_use')->uncheck();
        $page->findButton('m62_settings_submit')->submit();
        
        $this->assertNotTrue($this->session->getPage()
            ->findById('storage_location_db_use')
            ->isChecked());
        $this->assertTrue($this->session->getPage()
            ->hasContent('Storage Location Db Use is required unless you have more than 1 Storage Location'));
    }

    /**
     * @depends testAddRcfStorageLocationDbUseUnChecked
     */
    public function testAddRcfStorageLocationIncludePruneChecked()
    {
        $this->session = $this->getSession();
        $this->session->visit($this->url('storage_add_rcf_storage'));
        
        $page = $this->session->getPage();
        $page->findById('storage_location_include_prune')->check();
        $page->findButton('m62_settings_submit')->submit();
        
        $this->assertTrue($this->session->getPage()
            ->findById('storage_location_include_prune')
            ->isChecked());
    }

    /**
     * @depends testAddRcfStorageLocationIncludePruneChecked
     */
    public function testAddRcfStorageLocationIncludePruneUnChecked()
    {
        $this->session = $this->getSession();
        $this->session->visit($this->url('storage_add_rcf_storage'));
        
        $page = $this->session->getPage();
        $page->findById('storage_location_include_prune')->uncheck();
        $page->findButton('m62_settings_submit')->submit();
        
        $this->assertNotTrue($this->session->getPage()
            ->findById('storage_location_include_prune')
            ->isChecked());
    }

    /**
     * @depends testAddRcfStorageLocationIncludePruneUnChecked
     */
    public function testAddCompleteRcfStorage()
    {
        $page = $this->setupRcfStorageLocation();
        $this->assertTrue($this->session->getPage()
            ->hasContent('Created Date'));
        $this->assertNotTrue($this->session->getPage()
            ->hasContent('No Storage Locations have been setup yet!'));
    }

    /**
     * @depends testAddCompleteRcfStorage
     */
    public function testBackupDatabaseRcfStorage()
    {
        $page = $this->takeDatabaseBackup();
        $this->removeDatabaseBackup();
        $this->uninstall_addon();
    }
}