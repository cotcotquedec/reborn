<?php

return [

	/*
	|--------------------------------------------------------------------------
	| Default Filesystem Disk
	|--------------------------------------------------------------------------
	|
	| Here you may specify the default filesystem disk that should be used
	| by the framework. A "local" driver, as well as a variety of cloud
	| based drivers are available for your choosing. Just store away!
	|
	| Supported: "local", "s3", "rackspace"
	|
	*/
	'default' => 'download',


	/*
	|--------------------------------------------------------------------------
	| Filesystem Disks
	|--------------------------------------------------------------------------
	|
	| Here you may configure as many filesystem "disks" as you wish, and you
	| may even configure multiple disks of the same driver. Defaults have
	| been setup for each driver as an example of the required options.
	|
	*/

	'disks' => [
        'download' => [
            'driver' => 'local',
            'root'   => env('DOWNLOAD_ROOT', storage_path().'/download'),
            'url'   => env('DOWNLOAD_URL', '/files/download'),
        ],

        'tvshow' => [
            'driver' => 'local',
            'root'   => storage_path().'/tvshow',
        ],

        'movie' => [
            'driver' => 'local',
            'root'   => storage_path().'/movie',
        ],

    ],

];
