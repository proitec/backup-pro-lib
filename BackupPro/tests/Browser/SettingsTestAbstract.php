<?php
/**
 * mithra62
 *
 * @copyright	Copyright (c) 2015, mithra62, Eric Lamb.
 * @link		http://mithra62.com/
 * @version		2.0
 * @filesource 	./mithra62/BackupPro/tests/Browser/SettingsTestAbstract.php
 */

namespace mithra62\BackupPro\tests\Browser;

use mithra62\BackupPro\tests\Browser\TestFixture;

/**
 * mithra62 - (Selenium) Settings object Unit Tests
 *
 * Executes all teh tests by platform using the below definitions
 *
 * @package 	mithra62\Tests
 * @author		Eric Lamb <eric@mithra62.com>
 */
abstract class SettingsTestAbstract extends TestFixture  
{   
    /**
     * An instance of the mink selenium object
     * @var unknown
     */
    public $session = null;
    
    /**
     * The browser config
     * @var array
     */
    public static $browsers = array(
        array(
            'driver' => 'selenium2',
            'host' => 'localhost',
            'port' => 4444,
            'browserName' => 'firefox',
            'baseUrl' => 'http://eric.ee2.clean.mithra62.com',
            'sessionStrategy' => 'shared',
        ),
    );
    
    public function testGeneralViewWorkingDirectoryFieldEmpty()
    {
        $this->login();
        sleep(2);
        $this->install_addon();
        
        $this->session->visit( $this->url('settings_general') );
        
        $page = $this->session->getPage();
        $page->findById('working_directory' )->setValue('');
        $page->findButton('m62_settings_submit')->submit();
        
        $page = $this->session->getPage();
        $this->assertTrue($this->session->getPage()->hasContent('Working Directory is required'));
        $this->assertTrue($this->session->getPage()->hasContent('Working Directory has to be writable'));
        $this->assertTrue($this->session->getPage()->hasContent('Working Directory has to be a directory'));
        $this->assertTrue($this->session->getPage()->hasContent('Working Directory has to be readable'));
    }
    
    /**
     * @depends testGeneralViewWorkingDirectoryFieldEmpty
     */
    public function testGeneralViewWorkingdirecotryFieldBadPath()
    {
        $this->session = $this->getSession();
        $this->session->visit( $this->url('settings_general') );
        $page = $this->session->getPage();
        $page->findById('working_directory' )->setValue('fdsafdsafdsa');
        $page->findButton('m62_settings_submit')->submit();
        
        $this->assertNotTrue($this->session->getPage()->hasContent('Working Directory is required'));
        $this->assertTrue($this->session->getPage()->hasContent('Working Directory has to be writable'));
        $this->assertTrue($this->session->getPage()->hasContent('Working Directory has to be a directory'));
        $this->assertTrue($this->session->getPage()->hasContent('Working Directory has to be readable'));
    }
    
    /**
     * @depends testGeneralViewWorkingdirecotryFieldBadPath
     */
    public function testGeneralViewWorkingdirecotryGoodValue()
    {
        $this->session = $this->getSession();
        $this->session->visit( $this->url('settings_general') );
        $page = $this->session->getPage();
        $page->findById('working_directory' )->setValue( $this->ts('working_directory') );
        $page->findButton('m62_settings_submit')->submit();
        
        $this->assertNotTrue($this->session->getPage()->hasContent('Working Directory is required'));
        $this->assertNotTrue($this->session->getPage()->hasContent('Working Directory has to be writable'));
        $this->assertNotTrue($this->session->getPage()->hasContent('Working Directory has to be a directory'));
        $this->assertNotTrue($this->session->getPage()->hasContent('Working Directory has to be readable'));
    }
    
    /**
     * @depends testGeneralViewWorkingdirecotryGoodValue
     */
    public function testGeneralCronQueryKeyEmptyField()
    {
        $this->session = $this->getSession();
        $this->session->visit( $this->url('settings_general') );
        $page = $this->session->getPage();
        $page->findById('cron_query_key' )->setValue('');
        $page->findButton('m62_settings_submit')->submit();
        
        $this->assertTrue($this->session->getPage()->hasContent('Cron Query Key is required'));
        $this->assertTrue($this->session->getPage()->hasContent('Cron Query Key must be alpha-numeric only'));
    }
    
    /**
     * @depends testGeneralCronQueryKeyEmptyField
     */
    public function testGeneralCronQueryBadValueField()
    {
        $this->session = $this->getSession();
        $this->session->visit( $this->url('settings_general') );
        $page = $this->session->getPage();
        $page->findById('cron_query_key' )->setValue('my=bad&key=test');
        $page->findButton('m62_settings_submit')->submit();

        $this->assertNotTrue($this->session->getPage()->hasContent('Cron Query Key is required'));
        $this->assertTrue($this->session->getPage()->hasContent('Cron Query Key must be alpha-numeric only'));
    }
    
    /**
     * @depends testGeneralCronQueryBadValueField
     */
    public function testGeneralCronQueryGoodValue()
    {
        $this->session = $this->getSession();
        $this->session->visit( $this->url('settings_general') );
        $page = $this->session->getPage();
        $page->findById('cron_query_key' )->setValue( $this->ts('cron_query_key') );
        $page->findButton('m62_settings_submit')->submit();

        $this->assertNotTrue($this->session->getPage()->hasContent('Cron Query Key is required'));
        $this->assertNotTrue($this->session->getPage()->hasContent('Cron Query Key must be alpha-numeric only'));
    }

    /**
     * @depends testGeneralCronQueryGoodValue
     */
    public function testGeneralDashboardRecentTotalEmptyField()
    {
        $this->session = $this->getSession();
        $this->session->visit( $this->url('settings_general') );
        $page = $this->session->getPage();
        $page->findById('dashboard_recent_total' )->setValue('');
        $page->findButton('m62_settings_submit')->submit();
    
        $this->assertTrue($this->session->getPage()->hasContent('Dashboard Recent Total is required'));
        $this->assertTrue($this->session->getPage()->hasContent('Dashboard Recent Total must be a number greater than 1'));
    }

    /**
     * @depends testGeneralDashboardRecentTotalEmptyField
     */
    public function testGeneralDashboardRecentTotalBadValue()
    {
        $this->session = $this->getSession();
        $this->session->visit( $this->url('settings_general') );
        $page = $this->session->getPage();
        $page->findById('dashboard_recent_total' )->setValue('fdsafdsa');
        $page->findButton('m62_settings_submit')->submit();
    
        $this->assertNotTrue($this->session->getPage()->hasContent('Dashboard Recent Total is required'));
        $this->assertTrue($this->session->getPage()->hasContent('Dashboard Recent Total must be a number greater than 1'));
    }

    /**
     * @depends testGeneralDashboardRecentTotalBadValue
     */
    public function testGeneralDashboardRecentTotalGoodValue()
    {
        $this->session = $this->getSession();
        $this->session->visit( $this->url('settings_general') );
        $page = $this->session->getPage();
        $page->findById('dashboard_recent_total' )->setValue( $this->ts('dashboard_recent_total') );
        $page->findButton('m62_settings_submit')->submit();
    
        $this->assertNotTrue($this->session->getPage()->hasContent('Dashboard Recent Total is required'));
        $this->assertNotTrue($this->session->getPage()->hasContent('Dashboard Recent Total must be a number greater than 1'));
    }

    /**
     * @depends testGeneralDashboardRecentTotalGoodValue
     */
    public function testGeneralAutoThresholdGoodValue()
    {
        $this->session = $this->getSession();
        $this->session->visit( $this->url('settings_general') );
        $page = $this->session->getPage();
        $page->findById('auto_threshold' )->setValue( 104857600 );
        $page->findButton('m62_settings_submit')->submit();

        $this->assertNotTrue($this->session->getPage()->hasContent('Auto Threshold is required'));
        $this->assertNotTrue($this->session->getPage()->hasContent('Auto Threshold must be a number'));
    }

    /**
     * @depends testGeneralAutoThresholdGoodValue
     */
    public function testGeneralAutoThresholdCustomEmptyValue()
    {
        $this->session = $this->getSession();
        $this->session->visit( $this->url('settings_general') );
        $page = $this->session->getPage();
        $page->findById('auto_threshold' )->selectOption('custom');
        $page->findById('auto_threshold_custom' )->setValue('');
        $page->findButton('m62_settings_submit')->submit();

        $this->assertTrue($this->session->getPage()->hasContent('Auto Threshold Custom is required'));
        $this->assertTrue($this->session->getPage()->hasContent('Auto Threshold Custom must be a number'));
        $this->assertTrue($this->session->getPage()->hasContent('Auto Threshold Custom must be at least 100MB (100000000)'));
    }

    /**
     * @depends testGeneralAutoThresholdCustomEmptyValue
     */
    public function testGeneralAutoThresholdCustomStringBadValue()
    {
        $this->session = $this->getSession();
        $this->session->visit( $this->url('settings_general') );
        $page = $this->session->getPage();
        $page->findById('auto_threshold' )->selectOption('custom');
        $page->findById('auto_threshold_custom' )->setValue('fdsafdsa');
        $page->findButton('m62_settings_submit')->submit();

        $this->assertNotTrue($this->session->getPage()->hasContent('Auto Threshold Custom is required'));
        $this->assertTrue($this->session->getPage()->hasContent('Auto Threshold Custom must be a number'));
        $this->assertTrue($this->session->getPage()->hasContent('Auto Threshold Custom must be at least 100MB (100000000)'));
    }

    /**
     * @depends testGeneralAutoThresholdCustomStringBadValue
     */
    public function testGeneralAutoThresholdCustomNumberBadValue()
    {
        $this->session = $this->getSession();
        $this->session->visit( $this->url('settings_general') );
        $page = $this->session->getPage();
        $page->findById('auto_threshold' )->selectOption('custom');
        $page->findById('auto_threshold_custom' )->setValue(99);
        $page->findButton('m62_settings_submit')->submit();

        $this->assertNotTrue($this->session->getPage()->hasContent('Auto Threshold Custom is required'));
        $this->assertNotTrue($this->session->getPage()->hasContent('Auto Threshold Custom must be a number'));
        $this->assertTrue($this->session->getPage()->hasContent('Auto Threshold Custom must be at least 100MB (100000000)'));
    }

    /**
     * @depends testGeneralAutoThresholdCustomStringBadValue
     */
    public function testGeneralAutoThresholdCustomGoodValue()
    {
        $this->session = $this->getSession();
        $this->session->visit( $this->url('settings_general') );
        $page = $this->session->getPage();
        $page->findById('auto_threshold' )->selectOption('custom');
        $page->findById('auto_threshold_custom' )->setValue(100000000);
        $page->findButton('m62_settings_submit')->submit();

        $this->assertNotTrue($this->session->getPage()->hasContent('Auto Threshold Custom is required'));
        $this->assertNotTrue($this->session->getPage()->hasContent('Auto Threshold Custom must be a number'));
        $this->assertNotTrue($this->session->getPage()->hasContent('Auto Threshold Custom must be at least 100MB (100000000)'));
    }

    /**
     * @depends testGeneralAutoThresholdCustomGoodValue
     */
    public function testGeneralDateFormatEmptyValue()
    {
        $this->session = $this->getSession();
        $this->session->visit( $this->url('settings_general') );
        $page = $this->session->getPage();
        $page->findById('date_format' )->setValue('');
        $page->findButton('m62_settings_submit')->submit();

        $this->assertTrue($this->session->getPage()->hasContent('Date Format is required'));
    }

    /**
     * @depends testGeneralDateFormatEmptyValue
     */
    public function testGeneralDateFormatGoodValue()
    {
        $this->session = $this->getSession();
        $this->session->visit( $this->url('settings_general') );
        $page = $this->session->getPage();
        $page->findById('date_format' )->setValue('M d, Y, h:i:sA');
        $page->findButton('m62_settings_submit')->submit();

        $this->assertNotTrue($this->session->getPage()->hasContent('Date Format is required'));
    }
    
    /**
     * @depends testGeneralDateFormatGoodValue
     */
    public function testDbBackupMaxDbBackupEmptyValue()
    {
        $this->session = $this->getSession();
        $this->session->visit( $this->url('settings_db') );
        $page = $this->session->getPage();
        $page->findById('max_db_backups' )->setValue('');
        $page->findButton('m62_settings_submit')->submit();

        $this->assertTrue($this->session->getPage()->hasContent('Max Db Backups is required'));
        $this->assertTrue($this->session->getPage()->hasContent('Max Db Backups must be a number'));
    }

    /**
     * @depends testDbBackupMaxDbBackupEmptyValue
     */
    public function testDbBackupMaxDbBackupStringValue()
    {
        $this->session = $this->getSession();
        $this->session->visit( $this->url('settings_db') );
        $page = $this->session->getPage();
        $page->findById('max_db_backups' )->setValue('fdsafdsa');
        $page->findButton('m62_settings_submit')->submit();
    
        $this->assertNotTrue($this->session->getPage()->hasContent('Max Db Backups is required'));
        $this->assertTrue($this->session->getPage()->hasContent('Max Db Backups must be a number'));
    }

    /**
     * @depends testDbBackupMaxDbBackupStringValue
     */
    public function testDbBackupMaxDbBackupGoodValue()
    {
        $this->session = $this->getSession();
        $this->session->visit( $this->url('settings_db') );
        $page = $this->session->getPage();
        $page->findById('max_db_backups' )->setValue(4);
        $page->findButton('m62_settings_submit')->submit();
    
        $this->assertNotTrue($this->session->getPage()->hasContent('Max Db Backups is required'));
        $this->assertNotTrue($this->session->getPage()->hasContent('Max Db Backups must be a number'));
    }

    /**
     * @depends testDbBackupMaxDbBackupGoodValue
     */
    public function testDbBackupDbBackupAlertFreqEmptyValue()
    {
        $this->session = $this->getSession();
        $this->session->visit( $this->url('settings_db') );
        $page = $this->session->getPage();
        $page->findById('db_backup_alert_threshold' )->setValue('');
        $page->findButton('m62_settings_submit')->submit();
    
        $this->assertTrue($this->session->getPage()->hasContent('Db Backup Alert Threshold is required'));
        $this->assertTrue($this->session->getPage()->hasContent('Db Backup Alert Threshold must be a number'));
    }

    /**
     * @depends testDbBackupDbBackupAlertFreqEmptyValue
     */
    public function testDbBackupDbBackupAlertFreqStringValue()
    {
        $this->session = $this->getSession();
        $this->session->visit( $this->url('settings_db') );
        $page = $this->session->getPage();
        $page->findById('db_backup_alert_threshold' )->setValue('fdsafdsa');
        $page->findButton('m62_settings_submit')->submit();
    
        $this->assertNotTrue($this->session->getPage()->hasContent('Db Backup Alert Threshold is required'));
        $this->assertTrue($this->session->getPage()->hasContent('Db Backup Alert Threshold must be a number'));
    }

    /**
     * @depends testDbBackupDbBackupAlertFreqStringValue
     */
    public function testDbBackupDbBackupAlertFreqGoodValue()
    {
        $this->session = $this->getSession();
        $this->session->visit( $this->url('settings_db') );
        $page = $this->session->getPage();
        $page->findById('db_backup_alert_threshold' )->setValue(3);
        $page->findButton('m62_settings_submit')->submit();
    
        $this->assertNotTrue($this->session->getPage()->hasContent('Db Backup Alert Threshold is required'));
        $this->assertNotTrue($this->session->getPage()->hasContent('Db Backup Alert Threshold must be a number'));
    }

    /**
     * @depends testDbBackupDbBackupAlertFreqGoodValue
     */
    public function testDbBackupDbMysqldumpNoValue()
    {
        $this->session = $this->getSession();
        $this->session->visit( $this->url('settings_db') );
        $page = $this->session->getPage();
        $page->findById('db_backup_method' )->selectOption('mysqldump');
        $page->findById('mysqldump_command' )->setValue('');
        $page->findButton('m62_settings_submit')->submit();
    
        $this->assertTrue($this->session->getPage()->hasContent('Mysqldump Command is required'));
    }

    /**
     * @depends testDbBackupDbMysqldumpNoValue
     */
    public function testDbBackupDbMysqldumpGoodValue()
    {
        $this->session = $this->getSession();
        $this->session->visit( $this->url('settings_db') );
        $page = $this->session->getPage();
        $page->findById('db_backup_method' )->selectOption('mysqldump');
        $page->findById('mysqldump_command' )->setValue('mysqldump');
        $page->findButton('m62_settings_submit')->submit();
    
        $this->assertNotTrue($this->session->getPage()->hasContent('Mysqldump Command is required'));
    }

    /**
     * @depends testDbBackupDbMysqldumpNoValue
     */
    public function testDbBackupDbMysqlcliNoValue()
    {
        $this->session = $this->getSession();
        $this->session->visit( $this->url('settings_db') );
        $page = $this->session->getPage();
        $page->findById('db_restore_method' )->selectOption('mysql');
        $page->findById('mysqlcli_command' )->setValue('');
        $page->findButton('m62_settings_submit')->submit();
    
        $this->assertTrue($this->session->getPage()->hasContent('Mysqlcli Command is required'));
    }

    /**
     * @depends testDbBackupDbMysqlcliNoValue
     */
    public function testDbBackupDbMysqlcliGoodValue()
    {
        $this->session = $this->getSession();
        $this->session->visit( $this->url('settings_db') );
        $page = $this->session->getPage();
        $page->findById('db_restore_method' )->selectOption('mysql');
        $page->findById('mysqlcli_command' )->setValue('mysql');
        $page->findButton('m62_settings_submit')->submit();
    
        $this->assertNotTrue($this->session->getPage()->hasContent('Mysqlcli Command is required'));
    }

    /**
     * @depends testDbBackupDbMysqlcliGoodValue
     */
    public function testFileBackupMaxFileBackupsNoValue()
    {
        $this->session = $this->getSession();
        $this->session->visit( $this->url('settings_files') );
        $page = $this->session->getPage();
        $page->findById('max_file_backups' )->setValue('');
        $page->findButton('m62_settings_submit')->submit();
    
        $this->assertTrue($this->session->getPage()->hasContent('Max File Backups is required'));
        $this->assertTrue($this->session->getPage()->hasContent('Max File Backups must be a number'));
    }

    /**
     * @depends testFileBackupMaxFileBackupsNoValue
     */
    public function testFileBackupMaxFileBackupsBadValue()
    {
        $this->session = $this->getSession();
        $this->session->visit( $this->url('settings_files') );
        $page = $this->session->getPage();
        $page->findById('max_file_backups' )->setValue('fdsafdsa');
        $page->findButton('m62_settings_submit')->submit();
    
        $this->assertNotTrue($this->session->getPage()->hasContent('Max File Backups is required'));
        $this->assertTrue($this->session->getPage()->hasContent('Max File Backups must be a number'));
    }

    /**
     * @depends testFileBackupMaxFileBackupsBadValue
     */
    public function testFileBackupMaxFileBackupsGoodValue()
    {
        $this->session = $this->getSession();
        $this->session->visit( $this->url('settings_files') );
        $page = $this->session->getPage();
        $page->findById('max_file_backups' )->setValue(4);
        $page->findButton('m62_settings_submit')->submit();
    
        $this->assertNotTrue($this->session->getPage()->hasContent('Max File Backups is required'));
        $this->assertNotTrue($this->session->getPage()->hasContent('Max File Backups must be a number'));
    }

    /**
     * @depends testFileBackupMaxFileBackupsGoodValue
     */
    public function testFileBackupBackupAlertThresholdNoValue()
    {
        $this->session = $this->getSession();
        $this->session->visit( $this->url('settings_files') );
        $page = $this->session->getPage();
        $page->findById('file_backup_alert_threshold' )->setValue('');
        $page->findButton('m62_settings_submit')->submit();
    
        $this->assertTrue($this->session->getPage()->hasContent('File Backup Alert Threshold is required'));
        $this->assertTrue($this->session->getPage()->hasContent('File Backup Alert Threshold must be a number'));
    }

    /**
     * @depends testFileBackupBackupAlertThresholdNoValue
     */
    public function testFileBackupBackupAlertThresholdBadValue()
    {
        $this->session = $this->getSession();
        $this->session->visit( $this->url('settings_files') );
        $page = $this->session->getPage();
        $page->findById('file_backup_alert_threshold' )->setValue('fdsafdsa');
        $page->findButton('m62_settings_submit')->submit();

        $this->assertNotTrue($this->session->getPage()->hasContent('File Backup Alert Threshold is required'));
        $this->assertTrue($this->session->getPage()->hasContent('File Backup Alert Threshold must be a number'));
    }

    /**
     * @depends testFileBackupBackupAlertThresholdBadValue
     */
    public function testFileBackupBackupAlertThresholdGoodValue()
    {
        $this->session = $this->getSession();
        $this->session->visit( $this->url('settings_files') );
        $page = $this->session->getPage();
        $page->findById('file_backup_alert_threshold' )->setValue(4);
        $page->findButton('m62_settings_submit')->submit();

        $this->assertNotTrue($this->session->getPage()->hasContent('File Backup Alert Threshold is required'));
        $this->assertNotTrue($this->session->getPage()->hasContent('File Backup Alert Threshold must be a number'));
    }

    /**
     * @depends testFileBackupBackupAlertThresholdGoodValue
     */
    public function testFileBackupFileBackupLocationsNoValue()
    {
        $this->session = $this->getSession();
        $this->session->visit( $this->url('settings_files') );
        $page = $this->session->getPage();
        $page->findById('backup_file_location' )->setValue('');
        $page->findButton('m62_settings_submit')->submit();

        $this->assertTrue($this->session->getPage()->hasContent('Backup File Location is required'));
    }

    /**
     * @depends testFileBackupFileBackupLocationsNoValue
     */
    public function testFileBackupFileBackupLocationsBadValue()
    {
        $this->session = $this->getSession();
        $this->session->visit( $this->url('settings_files') );
        $page = $this->session->getPage();
        $page->findById('backup_file_location' )->setValue('fdsafdsa');
        $page->findButton('m62_settings_submit')->submit();

        $this->assertNotTrue($this->session->getPage()->hasContent('Backup File Location is required'));
        $this->assertTrue($this->session->getPage()->hasContent('"fdsafdsa" isn\'t a valid regular expression or path on the system.'));
    }

    /**
     * @depends testFileBackupFileBackupLocationsBadValue
     */
    public function testFileBackupFileBackupLocationsGoodValue()
    {
        $this->session = $this->getSession();
        $this->session->visit( $this->url('settings_files') );
        $page = $this->session->getPage();
        $page->findById('backup_file_location' )->setValue(dirname(__FILE__));
        $page->findButton('m62_settings_submit')->submit();

        $this->assertNotTrue($this->session->getPage()->hasContent('Backup File Location is required'));
        $this->assertNotTrue($this->session->getPage()->hasContent('"fdsafdsa" isn\'t a valid regular expression or path on the system.'));
    }

    /**
     * @depends testFileBackupFileBackupLocationsGoodValue
     */
    public function testFileBackupExcludePathsBadValue()
    {
        $this->session = $this->getSession();
        $this->session->visit( $this->url('settings_files') );
        $page = $this->session->getPage();
        $page->findById('exclude_paths' )->setValue('fdsafdsa');
        $page->findButton('m62_settings_submit')->submit();

        $this->assertTrue($this->session->getPage()->hasContent('"fdsafdsa" isn\'t a valid regular expression or path on the system.'));
    }

    /**
     * @depends testFileBackupExcludePathsBadValue
     */
    public function testFileBackupExcludePathsGoodPathValue()
    {
        $this->session = $this->getSession();
        $this->session->visit( $this->url('settings_files') );
        $page = $this->session->getPage();
        $page->findById('exclude_paths' )->setValue(dirname(__FILE__));
        $page->findButton('m62_settings_submit')->submit();

        $this->assertNotTrue($this->session->getPage()->hasContent('"fdsafdsa" isn\'t a valid regular expression or path on the system.'));
    }

    /**
     * @depends testFileBackupExcludePathsGoodPathValue
     */
    public function testCronBackupNotifyEmailBadValue()
    {
        $this->session = $this->getSession();
        $this->session->visit( $this->url('settings_cron') );
        $page = $this->session->getPage();
        $page->findById('cron_notify_emails' )->setValue("fdsafdsa\neric@mithra62.com\nuuuuuuuu");
        $page->findButton('m62_settings_submit')->submit();
        
        $this->assertTrue($this->session->getPage()->hasContent('"fdsafdsa" isn\'t a valid email'));
        $this->assertTrue($this->session->getPage()->hasContent('"uuuuuuuu" isn\'t a valid email'));
        $this->assertNotTrue($this->session->getPage()->hasContent('"eric@mithra62.com" isn\'t a valid email'));
    }

    /**
     * @depends testFileBackupExcludePathsBadValue
     */
    public function testCronBackupNotifyEmailSubjectNoValue()
    {
        $this->session = $this->getSession();
        $this->session->visit( $this->url('settings_cron') );
        $page = $this->session->getPage();
        $page->findById('cron_notify_email_subject' )->setValue('');
        $page->findButton('m62_settings_submit')->submit();

        $this->assertTrue($this->session->getPage()->hasContent('Cron Notify Email Subject is required'));
    }

    /**
     * @depends testCronBackupNotifyEmailSubjectNoValue
     */
    public function testCronBackupNotifyEmailSubjectGoodValue()
    {
        $this->session = $this->getSession();
        $this->session->visit( $this->url('settings_cron') );
        $page = $this->session->getPage();
        $page->findById('cron_notify_email_subject' )->setValue('fdsafdsa');
        $page->findButton('m62_settings_submit')->submit();

        $this->assertNotTrue($this->session->getPage()->hasContent('Cron Notify Email Subject is required'));
    }

    /**
     * @depends testCronBackupNotifyEmailSubjectGoodValue
     */
    public function testCronBackupNotifyEmailMessageNoValue()
    {
        $this->session = $this->getSession();
        $this->session->visit( $this->url('settings_cron') );
        $page = $this->session->getPage();
        $page->findById('cron_notify_email_message' )->setValue('');
        $page->findButton('m62_settings_submit')->submit();

        $this->assertTrue($this->session->getPage()->hasContent('Cron Notify Email Message is required'));
    }

    /**
     * @depends testCronBackupNotifyEmailMessageNoValue
     */
    public function testIaVerificationTempDatabaseBadValue()
    {
        $this->session = $this->getSession();
        $this->session->visit( $this->url('settings_ia') );
        $page = $this->session->getPage();
        $page->findById('db_verification_db_name' )->setValue('fdsafdsa');
        $page->findButton('m62_settings_submit')->submit();

        $this->assertTrue($this->session->getPage()->hasContent('"fdsafdsa" isn\'t available to your configured database connection'));
    }

    /**
     * @depends testCronBackupNotifyEmailMessageNoValue
     */
    public function testIaVerificationTempDatabaseGoodValue()
    {
        $this->session = $this->getSession();
        $this->session->visit( $this->url('settings_ia') );
        $page = $this->session->getPage();
        $page->findById('db_verification_db_name' )->setValue('test_backup_pro_verification');
        $page->findButton('m62_settings_submit')->submit();

        $this->assertNotTrue($this->session->getPage()->hasContent('"test_backup_pro_verification" isn\'t available to your configured database connection'));
    }

    /**
     * @depends testIaVerificationTempDatabaseGoodValue
     */
    public function testIaTotalExecutionsPerExecutionNoValue()
    {
        $this->session = $this->getSession();
        $this->session->visit( $this->url('settings_ia') );
        $page = $this->session->getPage();
        $page->findById('total_verifications_per_execution' )->setValue('');
        $page->findButton('m62_settings_submit')->submit();

        $this->assertTrue($this->session->getPage()->hasContent('Total Verifications Per Execution is required'));
        $this->assertTrue($this->session->getPage()->hasContent('Total Verifications Per Execution must be a whole number'));
    }

    /**
     * @depends testIaTotalExecutionsPerExecutionNoValue
     */
    public function testIaTotalExecutionsPerExecutionStringValue()
    {
        $this->session = $this->getSession();
        $this->session->visit( $this->url('settings_ia') );
        $page = $this->session->getPage();
        $page->findById('total_verifications_per_execution' )->setValue('fdsafdsa');
        $page->findButton('m62_settings_submit')->submit();

        $this->assertNotTrue($this->session->getPage()->hasContent('Total Verifications Per Execution is required'));
        $this->assertTrue($this->session->getPage()->hasContent('Total Verifications Per Execution must be a whole number'));
    }

    /**
     * @depends testIaTotalExecutionsPerExecutionStringValue
     */
    public function testIaTotalExecutionsPerExecutionGoodValue()
    {
        $this->session = $this->getSession();
        $this->session->visit( $this->url('settings_ia') );
        $page = $this->session->getPage();
        $page->findById('total_verifications_per_execution' )->setValue(4);
        $page->findButton('m62_settings_submit')->submit();

        $this->assertNotTrue($this->session->getPage()->hasContent('Total Verifications Per Execution is required'));
        $this->assertNotTrue($this->session->getPage()->hasContent('Total Verifications Per Execution must be a whole number'));
    }

    /**
     * @depends testIaTotalExecutionsPerExecutionStringValue
     */
    public function testIaBackupMissingScheduleEmailIntervalEmptyValue()
    {
        $this->session = $this->getSession();
        $this->session->visit( $this->url('settings_ia') );
        $page = $this->session->getPage();
        $page->findById('backup_missed_schedule_notify_email_interval' )->setValue('');
        $page->findButton('m62_settings_submit')->submit();
    
        $this->assertTrue($this->session->getPage()->hasContent('Backup Missed Schedule Notify Email Interval is required'));
        $this->assertTrue($this->session->getPage()->hasContent('Backup Missed Schedule Notify Email Interval must be a whole number'));
    }

    /**
     * @depends testIaBackupMissingScheduleEmailIntervalEmptyValue
     */
    public function testIaBackupMissingScheduleEmailIntervalStringValue() 
    {
        $this->session = $this->getSession();
        $this->session->visit( $this->url('settings_ia') );
        $page = $this->session->getPage();
        $page->findById('backup_missed_schedule_notify_email_interval' )->setValue('fdsafdsa');
        $page->findButton('m62_settings_submit')->submit();
    
        $this->assertNotTrue($this->session->getPage()->hasContent('Backup Missed Schedule Notify Email Interval is required'));
        $this->assertTrue($this->session->getPage()->hasContent('Backup Missed Schedule Notify Email Interval must be a whole number'));
    }

    /**
     * @depends testIaBackupMissingScheduleEmailIntervalStringValue
     */
    public function testIaBackupMissedScheduleNotifyEmailsBadValue() 
    {
        $this->session = $this->getSession();
        $this->session->visit( $this->url('settings_ia') );
        $page = $this->session->getPage();
        $page->findById('backup_missed_schedule_notify_emails')->setValue("fdsafdsa\neric@mithra62.com\nuuuuuuuu");
        $page->findButton('m62_settings_submit')->submit();
        
        $this->assertTrue($this->session->getPage()->hasContent('"fdsafdsa" isn\'t a valid email'));
        $this->assertTrue($this->session->getPage()->hasContent('"uuuuuuuu" isn\'t a valid email'));
        $this->assertNotTrue($this->session->getPage()->hasContent('"eric@mithra62.com" isn\'t a valid email'));
    }

    /**
     * @depends testIaBackupMissedScheduleNotifyEmailsBadValue
     */
    public function testIaBackupMissedScheduleEmailSubjectNoValue() 
    {
        $this->session = $this->getSession();
        $this->session->visit( $this->url('settings_ia') );
        $page = $this->session->getPage();
        $page->findById('backup_missed_schedule_notify_email_subject')->setValue('');
        $page->findButton('m62_settings_submit')->submit();

        $this->assertTrue($this->session->getPage()->hasContent('Backup Missed Schedule Notify Email Subject is required'));
    }

    /**
     * @depends testIaBackupMissedScheduleEmailSubjectNoValue
     */
    public function testIaBackupMissedScheduleEmailSubjectGoodValue() 
    {
        $this->session = $this->getSession();
        $this->session->visit( $this->url('settings_ia') );
        $page = $this->session->getPage();
        $page->findById('backup_missed_schedule_notify_email_subject')->setValue('My Test Subject');
        $page->findButton('m62_settings_submit')->submit();

        $this->assertNotTrue($this->session->getPage()->hasContent('Backup Missed Schedule Notify Email Subject is required'));
    }

    /**
     * @depends testIaBackupMissedScheduleEmailSubjectGoodValue
     */
    public function testIaBackupMissedScheduleEmailMessageNoValue() 
    {
        $this->session = $this->getSession();
        $this->session->visit( $this->url('settings_ia') );
        $page = $this->session->getPage();
        $page->findById('backup_missed_schedule_notify_email_message')->setValue('');
        $page->findButton('m62_settings_submit')->submit();

        $this->assertTrue($this->session->getPage()->hasContent('Backup Missed Schedule Notify Email Message is required'));
    }

    /**
     * @depends testIaBackupMissedScheduleEmailMessageNoValue
     */
    public function testIaBackupMissedScheduleEmailMessageGoodValue() 
    {
        $this->session = $this->getSession();
        $this->session->visit( $this->url('settings_ia') );
        $page = $this->session->getPage();
        $page->findById('backup_missed_schedule_notify_email_message')->setValue('My Test Message');
        $page->findButton('m62_settings_submit')->submit();

        $this->assertNotTrue($this->session->getPage()->hasContent('Backup Missed Schedule Notify Email Message is required'));
    }

    /**
     * @depends testIaBackupMissedScheduleEmailMessageGoodValue
     */
    public function testLicenseKeyNoValue() 
    {
        $this->session = $this->getSession();
        $this->session->visit( $this->url('settings_license') );
        $page = $this->session->getPage();
        $page->findById('license_number')->setValue('');
        $page->findButton('m62_settings_submit')->submit();

        $this->assertTrue($this->session->getPage()->hasContent('License Number is required'));
        $this->assertTrue($this->session->getPage()->hasContent('License Number isn\'t a valid license key'));
    }

    /**
     * @depends testLicenseKeyNoValue
     */
    public function testLicenseKeyBadValue() 
    {
        $this->session = $this->getSession();
        $this->session->visit( $this->url('settings_license') );
        $page = $this->session->getPage();
        $page->findById('license_number')->setValue('fdsafdsa');
        $page->findButton('m62_settings_submit')->submit();

        $this->assertNotTrue($this->session->getPage()->hasContent('License Number is required'));
        $this->assertTrue($this->session->getPage()->hasContent('License Number isn\'t a valid license key'));
    }

    /**
     * @depends testLicenseKeyBadValue
     */
    public function testLicenseKeyGoodValue() 
    {
        $this->session = $this->getSession();
        $this->session->visit( $this->url('settings_license') );
        $page = $this->session->getPage();
        $page->findById('license_number')->setValue('5214af45-9bc9-4019-8af9-bc98c38802c1');
        $page->findButton('m62_settings_submit')->submit();

        $this->assertNotTrue($this->session->getPage()->hasContent('License Number is required'));
        $this->assertNotTrue($this->session->getPage()->hasContent('License Number isn\'t a valid license key'));
        $this->uninstall_addon();
    }
}