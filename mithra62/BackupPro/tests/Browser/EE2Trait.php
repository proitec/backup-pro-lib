<?php
/**
 * mithra62 - Backup Pro
 *
 * @copyright	Copyright (c) 2015, mithra62, Eric Lamb.
 * @link		http://mithra62.com/
 * @version		3.0
 * @filesource 	./mithra62/tests/Browser/EE2Trait.php
 */
namespace mithra62\BackupPro\tests\Browser;

use JaegerApp\Files;

/**
 * Backup Pro - ExpressionEngine 2 Selenium Browser Testing Trait
 *
 * Contains all the methods for using Selenium against Backup Pro and ExpressionEngine 2
 *
 * @package mithra62\Tests
 * @author Eric Lamb <eric@mithra62.com>
 */
trait EE2Trait
{

    /**
     * The URLs to test the ExpressionEngine 2 Settings page
     *
     * Note that the ExpressionEngine 2 site MUST be configured to use cookies only for authentication
     * 
     * @var array
     */
    public $urls = array(
        // dashboards
        'dashboard' => 'http://eric.ee2.clean.mithra62.com/admin.php?/cp/addons_modules/show_module_cp&module=backup_pro',
        'db_backups' => 'http://eric.ee2.clean.mithra62.com/admin.php?/cp/addons_modules/show_module_cp&module=backup_pro&method=db_backups',
        'file_backups' => 'http://eric.ee2.clean.mithra62.com/admin.php?/cp/addons_modules/show_module_cp&module=backup_pro&method=file_backups',
        
        // backup types
        'db_backup' => 'http://eric.ee2.clean.mithra62.com/admin.php?/cp/addons_modules/show_module_cp&module=backup_pro&method=backup&type=database',
        'file_backup' => 'http://eric.ee2.clean.mithra62.com/admin.php?/cp/addons_modules/show_module_cp&module=backup_pro&method=backup&type=files',
        
        // settings
        'settings_general' => 'http://eric.ee2.clean.mithra62.com/admin.php?/cp/addons_modules/show_module_cp&module=backup_pro&method=settings&section=general',
        'settings_db' => 'http://eric.ee2.clean.mithra62.com/admin.php?/cp/addons_modules/show_module_cp&module=backup_pro&method=settings&section=db',
        'settings_files' => 'http://eric.ee2.clean.mithra62.com/admin.php?/cp/addons_modules/show_module_cp&module=backup_pro&method=settings&section=files',
        'settings_cron' => 'http://eric.ee2.clean.mithra62.com/admin.php?/cp/addons_modules/show_module_cp&module=backup_pro&method=settings&section=cron',
        'settings_ia' => 'http://eric.ee2.clean.mithra62.com/admin.php?/cp/addons_modules/show_module_cp&module=backup_pro&method=settings&section=integrity_agent',
        'settings_license' => 'http://eric.ee2.clean.mithra62.com/admin.php?/cp/addons_modules/show_module_cp&module=backup_pro&method=settings&section=license',
        'settings_api' => 'http://eric.ee2.clean.mithra62.com/admin.php?/cp/addons_modules/show_module_cp&module=backup_pro&method=settings&section=api',
        
        // storage engines
        'storage_view_storage' => 'http://eric.ee2.clean.mithra62.com/admin.php?/cp/addons_modules/show_module_cp&module=backup_pro&method=view_storage',
        'storage_add_email_storage' => 'http://eric.ee2.clean.mithra62.com/admin.php?S=0&D=cp&C=addons_modules&M=show_module_cp&module=backup_pro&method=new_storage&engine=email',
        'storage_add_ftp_storage' => 'http://eric.ee2.clean.mithra62.com/admin.php?S=0&D=cp&C=addons_modules&M=show_module_cp&module=backup_pro&method=new_storage&engine=ftp',
        'storage_add_gcs_storage' => 'http://eric.ee2.clean.mithra62.com/admin.php?S=0&D=cp&C=addons_modules&M=show_module_cp&module=backup_pro&method=new_storage&engine=gcs',
        'storage_add_local_storage' => 'http://eric.ee2.clean.mithra62.com/admin.php?S=0&D=cp&C=addons_modules&M=show_module_cp&module=backup_pro&method=new_storage&engine=local',
        'storage_add_rcf_storage' => 'http://eric.ee2.clean.mithra62.com/admin.php?S=0&D=cp&C=addons_modules&M=show_module_cp&module=backup_pro&method=new_storage&engine=rcf',
        'storage_add_s3storage' => 'http://eric.ee2.clean.mithra62.com/admin.php?S=0&D=cp&C=addons_modules&M=show_module_cp&module=backup_pro&method=new_storage&engine=s3',
        'storage_add_dropbox_storage' => 'http://eric.ee2.clean.mithra62.com/admin.php?S=0&D=cp&C=addons_modules&M=show_module_cp&module=backup_pro&method=new_storage&engine=dropbox',
        'storage_add_sftp_storage' => 'http://eric.ee2.clean.mithra62.com/admin.php?S=0&D=cp&C=addons_modules&M=show_module_cp&module=backup_pro&method=new_storage&engine=sftp'
    );

    /**
     * The various setting values we'll use for the tests
     * 
     * @var array
     */
    public $test_settings = array(
        'allowed_access_levels' => '',
        'auto_threshold' => '0',
        'auto_threshold_custom' => '',
        'exclude_paths' => array(),
        'allow_duplicates' => '0',
        
        'db_backup_on_cms_update' => '0',
        'file_backup_on_cms_update' => '0',
        'db_backup_on_plugin_update' => '0',
        'file_backup_on_plugin_update' => '0',
        'db_backup_on_plugin_install' => '0',
        'file_backup_on_plugin_install' => '0',
        'db_backup_on_theme_update' => '0',
        'file_backup_on_theme_update' => '0',
        'db_backup_on_theme_install' => '0',
        'file_backup_on_theme_install' => '0',
        
        'enable_cron_db_backup' => '1',
        'enable_cron_file_backup' => '1',
        'enable_cron_integrity_check' => '1',
        
        'cron_notify_emails' => array(),
        'cron_notify_email_subject' => '',
        'cron_notify_email_message' => '',
        'cron_notify_email_mailtype' => 'html',
        'cron_query_key' => 'yup', // the value the backup_pro query query key must have
        
        'storage_details' => array(),
        
        'working_directory' => 'D:\ProjectFiles\mithra62\clean_cms\ee2\backup_meta',
        'local_backup_store_location' => 'D:\ProjectFiles\mithra62\clean_cms\ee2\backups',
        'backup_file_location' => array(
            'D:\ProjectFiles\mithra62\clean_cms\ee2\html'
        ),
        
        'max_file_backups' => '3',
        'max_db_backups' => '3',
        'db_backup_method' => 'php', // mysqldump
        'db_restore_method' => 'php', // mysql
        'db_backup_execute_pre_sql' => array(), // these get executed against MySQL before a backup starts
        'db_backup_execute_post_sql' => array(), // these get executed against MySQL after a backup finishes
        'db_backup_archive_pre_sql' => array(), // these get written in the backup SQL dump at the top
        'db_backup_archive_post_sql' => array(), // these get written in the backup SQL dump at the bottom
        'db_backup_ignore_tables' => array(), // what MySQL tables to ignore from the backup?
        'db_backup_ignore_table_data' => array(), // which tables should we not bother grabbing the data for?
        'mysqldump_command' => 'mysqldump',
        'mysqlcli_command' => 'mysql',
        'php_backup_method_select_chunk_limit' => '50',
        'system_command_function' => 'proc_open', // exec
        'dashboard_recent_total' => '5',
        'db_backup_alert_threshold' => '1',
        'file_backup_alert_threshold' => '7',
        
        'backup_missed_schedule_notify_emails' => array(),
        'backup_state_notify_email_subject' => '',
        'backup_state_notify_email_message' => '',
        'backup_state_notify_email_mailtype' => 'html',
        
        'backup_missed_schedule_notify_member_ids' => array(),
        'backup_missed_schedule_notify_email_mailtype' => 'html',
        'backup_missed_schedule_notify_email_subject' => '',
        'backup_missed_schedule_notify_email_message' => '',
        'backup_missed_schedule_notify_email_last_sent' => '0', // unix timestamp for determining whether to send an email
        'backup_missed_schedule_notify_email_interval' => 8, // hours between when backup state emails should be sent
        
        'db_verification_db_name' => '',
        'last_verification_type' => 'database', // either "database" or "files" to alternate between which backup to verify at any given time
        'last_verification_time' => '0', // timestamp last time a verification happened
        'total_verifications_per_execution' => '2', // the number of backups to check in a given run
        'check_backup_state_cp_login' => '1'
    );

    /**
     * Logs the user into the ExpressionEngine 2 site
     */
    public function login()
    {
        // This is Mink's Session.
        $this->session = $this->getSession();
        
        // Go to a page.
        $this->session->visit('http://eric.ee2.clean.mithra62.com/admin.php?/cp/login&return=');
        $this->session->maximizeWindow();
        
        // log in
        $page = $this->session->getPage();
        $page->findById('username')->setValue('mithra62');
        $page->findById('password')->setValue('dimens35');
        $page->findButton('submit')->submit();
    }

    /**
     * Helper method to handle logging in and installing the add-on
     */
    protected function setUp()
    {
        $this->login();
        $this->install_addon();
    }

    /**
     * Helper method to handle uinstalling the add-on
     */
    public function teardown()
    {
        $this->uninstall_addon();
    }

    /**
     * Installs the add-on
     */
    public function install_addon()
    {
        $this->session->visit('http://eric.ee2.clean.mithra62.com/admin.php?/cp/addons/package_settings&package=backup_pro&return=addons_modules');
        $page = $this->session->getPage();
        $form = $page->findById('install_module')->setValue('install');
        $page->findButton('submit')->submit();
    }

    /**
     * Uninstalls the add-on
     */
    public function uninstall_addon()
    {
        $this->session->visit('http://eric.ee2.clean.mithra62.com/admin.php?/cp/addons/package_settings&package=backup_pro&return=addons_modules');
        $page = $this->session->getPage();
        $form = $page->findById('install_module')->setValue('uninstall');
        $page->findButton('submit')->submit();
        
        $files = new Files;
        $files->deleteDir($this->test_settings['working_directory'], true, 0);
        mkdir($this->test_settings['working_directory']);        
    }
}
