<?php declare(strict_types=1);

if ( function_exists( 'xdebug_set_filter' ) )
{
	xdebug_set_filter(
		XDEBUG_FILTER_CODE_COVERAGE,
		XDEBUG_PATH_EXCLUDE,
		['/repo/tests', '/repo/vendor']
	);
}
