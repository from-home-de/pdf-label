<?php /** @noinspection UnusedFunctionResultInspection */

declare(strict_types=1);

namespace Deployer;

desc( 'Show docker container status' );
task(
	'show:dc-ps',
	static function ()
	{
		cd( '{{release_path}}' );
		writeln( run( 'make -e "{{make_stage}}" dcps' ) );
	}
);