<?php /** @noinspection UnusedFunctionResultInspection */

declare(strict_types=1);

namespace Deployer;

host( ...['prod.from-home.de'] )
	->stage( 'production' )
	->user( 'deploy' )
	->multiplexing( true )
	->forwardAgent( false )
	->addSshOption( 'UserKnownHostsFile', '/dev/null' )
	->addSshOption( 'StrictHostKeyChecking', 'no' )
	->set( 'deploy_path', '/var/docker/{{application}}' );