<?php /** @noinspection UnusedFunctionResultInspection */

declare(strict_types=1);

namespace Deployer;

desc( 'Docker compose up' );
task(
	'deploy:docker-compose-up',
	static function ()
	{
		cd( '{{release_path}}' );
		run( 'make -e "{{make_stage}}" -e "{{dc_scale_options}}" dcup' );
	}
);