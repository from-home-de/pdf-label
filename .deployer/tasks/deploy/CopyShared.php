<?php /** @noinspection UnusedFunctionResultInspection */

declare(strict_types=1);

namespace Deployer;

desc( 'Copy shared files' );
task(
	'deploy:copy-shared',
	static function ()
	{
		cd( '{{release_path}}' );
		foreach ( get( 'shared_files' ) as $sharedFile )
		{
			run( "cp {{deploy_path}}/shared/{$sharedFile} {{release_path}}/{$sharedFile}" );
		}

		foreach ( get( 'shared_dirs' ) as $sharedDir )
		{
			run( "rm -rf {{release_path}}/{$sharedDir}" );
			run( "cp -Rf {{deploy_path}}/shared/{$sharedDir} {{release_path}}/{$sharedDir}" );
		}
	}
);