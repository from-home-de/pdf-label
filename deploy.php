<?php /** @noinspection UnusedFunctionResultInspection */

namespace Deployer;

/** @noinspection PhpIncludeInspection */
require 'recipe/common.php';

# Settings
set( 'application', 'template-repo' );
set( 'default_stage', 'staging' );
set( 'repository', 'git@github.com:from-home-de/template-repo.git' );
set( 'git_tty', false );
set( 'default_timeout', 86400 );
set( 'shared_files', [] );
set( 'shared_dirs', [] );
set( 'writable_dirs', [] );
set( 'allow_anonymous_stats', false );

# Environment variable overrides for make command
set( 'make_stage', 'STAGE={{stage}}' );
set( 'dc_scale_options', 'DOCKER_COMPOSE_UP_SCALE_OPTIONS=--scale nginx=2' );

# Hosts
include __DIR__ . '/.deployer/hosts/Staging.php';
include __DIR__ . '/.deployer/hosts/Production.php';

# Deploy tasks
desc( 'Deploy your project' );
task(
	'deploy',
	[
		'deploy:info',
		'deploy:prepare',
		'deploy:lock',
		'deploy:release',
		'deploy:update_code',
		'deploy:writable',
		'deploy:clear_paths',
		'deploy:docker-compose-pull',
		'deploy:copy-shared',
		'deploy:docker-compose-down-previous',
		'deploy:docker-compose-up',
		'deploy:symlink',
		'deploy:unlock',
		'cleanup',
		'success',
	]
);

# DEPLOY TASKS

include __DIR__ . '/.deployer/tasks/deploy/DockerComposePull.php';
include __DIR__ . '/.deployer/tasks/deploy/CopyShared.php';
include __DIR__ . '/.deployer/tasks/deploy/DockerComposeDownPrevious.php';
include __DIR__ . '/.deployer/tasks/deploy/DockerComposeUp.php';

# MANUAL TASKS

## SHOW INFORMATION

include __DIR__ . '/.deployer/tasks/show/DockerImages.php';
include __DIR__ . '/.deployer/tasks/show/DockerContainerStatus.php';

after( 'deploy:failed', 'deploy:unlock' );
