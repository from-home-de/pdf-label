<?php /** @noinspection UnusedFunctionResultInspection */

declare(strict_types=1);

namespace Deployer;

desc( 'Show docker images' );
task(
	'show:dc-images',
	static function ()
	{
		cd( '{{release_path}}' );
		writeln( run( 'make -e "{{make_stage}}" dcimages' ) );
	}
);
