<?php /** @noinspection UnusedFunctionResultInspection */

declare(strict_types=1);

namespace Deployer;

desc( 'Docker compose down previous release' );
task(
	'deploy:docker-compose-down-previous',
	static function ()
	{
		if ( has( 'previous_release' ) )
		{
			cd( '{{previous_release}}' );
			run( 'make -e "{{make_stage}}" dcdown' );
		}
	}
);