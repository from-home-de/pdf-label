<?php /** @noinspection UnusedFunctionResultInspection */

declare(strict_types=1);

namespace Deployer;

desc( 'Docker compose pull' );
task(
	'deploy:docker-compose-pull',
	static function ()
	{
		cd( '{{release_path}}' );
		run( 'make -e "{{make_stage}}" dcpull' );
	}
);