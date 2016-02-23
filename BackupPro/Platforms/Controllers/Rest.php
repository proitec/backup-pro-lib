<?php
/**
 * mithra62 - Backup Pro
 *
 * @copyright	Copyright (c) 2015, mithra62, Eric Lamb.
 * @link		http://mithra62.com/
 * @version		3.0
 * @filesource 	./mithra62/BackupPro/Platforms/Controllers/Eecms.php
 */
namespace mithra62\BackupPro\Platforms\Controllers;

use mithra62\BackupPro\Traits\Controller;
use mithra62\Platforms\View\Rest as RestView;

/**
 * Backup Pro - Eecms Base Controller
 *
 * Starts the Controllers up
 *
 * @package BackupPro\Controllers
 * @author Eric Lamb <eric@mithra62.com>
 */
class Rest
{
    use Controller;

    /**
     * The abstracted platform object
     * 
     * @var \mithra62\Platforms\Eecms
     */
    protected $platform = null;

    /**
     * The Backup Pro Settings
     * 
     * @var array
     */
    protected $settings = array();

    /**
     * A container of system messages and errors
     * 
     * @var array
     */
    protected $errors = array();

    /**
     * The View Helper
     * 
     * @var \mithra62\Platforms\View\Rest
     */
    protected $view_helper = null;

    /**
     * Set it up
     * 
     * @param \mithra62\Platforms\AbstractPlatform $platform
     */
    public function __construct(\mithra62\Platforms\AbstractPlatform $platform, \mithra62\BackupPro\Rest $rest)
    {
        $this->initController();
        $this->platform = $platform;
        $this->rest = $rest;
        $this->m62->setService('platform', function ($c) {
            return $this->platform;
        });
        
        $this->m62->setDbConfig($this->platform->getDbCredentials());
        $this->settings = $this->services['settings']->get();
        
        //is the API even on?!?
        if($this->settings['enable_rest_api'] !== '1')
        {
            http_response_code(404);
            exit;
        }
        
        $errors = $this->services['errors']->checkWorkingDirectory($this->settings['working_directory'])
            ->checkStorageLocations($this->settings['storage_details'])
            ->licenseCheck($this->settings['license_number'], $this->services['license']);
        
        if ($errors->totalErrors() == '0') {
            $errors = $errors->checkBackupState($this->services['backups'], $this->settings);
        }
        
        $this->errors = $errors->getErrors();
        $this->view_helper = new RestView($this->services['lang'], $this->services['files'], $this->services['settings'], $this->services['encrypt'], $this->platform);
        $this->m62->setService('view_helpers', function ($c) {
            return $this->view_helper;
        });
        
        //verify request auth
    }
}