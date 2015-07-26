<?php  
/**
 * mithra62 - Backup Pro
 *
 * @author		Eric Lamb <eric@mithra62.com>
 * @copyright	Copyright (c) 2015, mithra62, Eric Lamb.
 * @link		http://mithra62.com/
 * @version		2.0
 * @filesource 	./mithra62/BackupPro/Platforms/Eecms.php
 */
 
namespace mithra62\BackupPro\Platforms;

use mithra62\Platforms\Eecms AS m62Eecms;
use mithra62\BackupPro\Platforms\PlatformInterface;

/**
 * Backup Pro - Eecms Bridge
 *
 * Contains the Eecms specific 
 *
 * @package 	mithra62\BackupPro
 * @author		Eric Lamb <eric@mithra62.com>
 */
class Eecms extends m62Eecms implements PlatformInterface
{
    /**
     * (non-PHPdoc)
     * @see \mithra62\BackupPro\Platforms\PlatformInterface::getCronCommands()
     */
    public function getBackupCronCommands()
    {
		ee()->load->library('backup_pro_lib', null, 'backup_pro');
        return ee()->backup_pro->get_cron_commands();
    }
    
    /**
     * (non-PHPdoc)
     * @ignore
     * @see \mithra62\BackupPro\Platforms\PlatformInterface::getEmailDetails()
     */
    public function getIaCronCommands()
    {
        return array();
    }
}