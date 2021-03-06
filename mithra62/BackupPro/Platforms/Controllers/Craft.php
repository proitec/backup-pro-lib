<?php
/**
 * mithra62 - Backup Pro
 *
 * @copyright	Copyright (c) 2015, mithra62, Eric Lamb.
 * @link		http://mithra62.com/
 * @version		3.0
 * @filesource 	./mithra62/BackupPro/Controllers/Craft.php
 */
namespace mithra62\BackupPro\Platforms\Controllers;

use mithra62\BackupPro\Platforms\Craft as Platform;
use mithra62\BackupPro\Traits\Controller;
use Craft\BaseController;

/**
 * Backup Pro - Craft Base Controller
 *
 * Starts the Controllers up
 *
 * @package BackupPro\Controllers
 * @author Eric Lamb <eric@mithra62.com>
 */
class Craft extends BaseController
{
    use Controller;

    /**
     * The abstracted platform object
     * 
     * @var \mithra62\Platforms\Craft
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
     * Set it up
     * 
     * @param unknown $id            
     * @param string $module            
     */
    public function __construct($id, $module = null)
    {
        parent::__construct($id, $module);
        $this->initController();
        $this->platform = new Platform();
        $this->m62->setService('platform', function ($c) {
            return $this->platform;
        });
        
        $this->m62->setDbConfig($this->platform->getDbCredentials());
        $this->settings = $this->services['settings']->get();
        $errors = $this->services['errors']->checkWorkingDirectory($this->settings['working_directory'])
            ->checkStorageLocations($this->settings['storage_details'])
            ->licenseCheck($this->settings['license_number'], $this->services['license']);
        
        if ($errors->totalErrors() == '0') {
            $errors = $errors->checkBackupState($this->services['backups'], $this->settings);
        }
        
        $this->errors = $errors->getErrors();
    }

    /**
     * (non-PHPdoc)
     * @ignore
     * @see \Craft\BaseController::renderTemplate()
     */
    public function renderTemplate($template, $variables = array(), $return = false, $processOutput = false)
    {
        // grab the backup details
        $backup = $this->services['backups'];
        $backups = $backup->setBackupPath($this->settings['working_directory'])->getAllBackups($this->settings['storage_details']);
        $backup_meta = $backup->getBackupMeta($backups);
        
        $variables['backup_meta'] = $backup_meta;
        $variables['backup_details'] = $backups;
        $variables['selectedSubnavItem'] = (empty($variables['selectedSubnavItem']) ? 'dashboard' : $variables['selectedSubnavItem']);
        $variables['tab_set'] = (empty($variables['tab_set']) ? '' : $variables['tab_set']);
        parent::renderTemplate($template, $variables, $return, $processOutput);
    }
}