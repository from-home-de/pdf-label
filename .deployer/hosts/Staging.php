<?php /** @noinspection UnusedFunctionResultInspection */

declare(strict_types=1);

namespace Deployer;

host( ...['stage.from-home.de'] )
	->stage( 'staging' )
	->user( 'deploy' )
	->multiplexing( true )
	->forwardAgent( false )
	->addSshOption( 'UserKnownHostsFile', '/dev/null' )
	->addSshOption( 'StrictHostKeyChecking', 'no' )
	->set( 'deploy_path', '/var/docker/{{application}}' );