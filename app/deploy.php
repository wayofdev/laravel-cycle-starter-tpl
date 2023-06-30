<?php

declare(strict_types=1);

namespace Deployer;

require 'recipe/laravel.php';
require 'contrib/slack.php';

set('application', 'laravel-cycle-starter-tpl');
set('repository', 'git@github.com:wayofdev/laravel-cycle-starter-tpl.git');
set('base_deploy_path', '/home/ploi');

set('composer_options', '--verbose --no-progress --no-interaction --optimize-autoloader');
set('branch', function () {
    $stage = input()->getArgument('stage');

    return host($stage)->get('branch');
});

function getDefaultEnv(mixed $variable, mixed $default = null)
{
    $value = getenv($variable);
    return $value !== false ? $value : $default;
}

host('staging')
    ->set('branch', getDefaultEnv('DEPLOYER_STAGING_BRANCH', 'develop'))
    ->set('remote_user', getDefaultEnv('DEPLOYER_STAGING_REMOTE_USER', 'staging-pbb2p'))
    ->set('base_deploy_path', '/home/{{ remote_user }}')
    ->set('hostname', getDefaultEnv('DEPLOYER_STAGING_HOST', 'staging.laravel-cycle-starter-tpl.wayof.dev'))
    ->set('deploy_path', '{{ base_deploy_path }}/{{ hostname}}')
    ->set('slack_webhook', getDefaultEnv('DEPLOYER_STAGING_SLACK_WEBHOOK'))
    ->set('sub_directory', 'app');

host('prod')
    ->set('branch', getDefaultEnv('DEPLOYER_PROD_BRANCH', 'master'))
    ->set('remote_user', getDefaultEnv('DEPLOYER_PROD_REMOTE_USER', 'prod-btkvj'))
    ->set('base_deploy_path', '/home/{{ remote_user }}')
    ->set('hostname', getDefaultEnv('DEPLOYER_PROD_HOST', 'prod.laravel-cycle-starter-tpl.wayof.dev'))
    ->set('deploy_path', '{{ base_deploy_path }}/{{ hostname }}')
    ->set('slack_webhook', getDefaultEnv('DEPLOYER_PROD_SLACK_WEBHOOK'))
    ->set('sub_directory', 'app');

before('deploy', 'slack:notify');

task('artisan:db:wipe', function () {
    cd('{{release_or_current_path}}');
    run('php artisan db:wipe --force');
});

task('artisan:cycle:migrate', function () {
    cd('{{release_or_current_path}}');
    run('php artisan cycle:migrate --force');
});

/*
 * This task is needed because of the following issue:
 * When adding new entity to the project, the repository injector
 * will not be able to find the entity role for the repository,
 * because of existing cache.
 */
task('cache:clear', function () {
    cd('{{current_path}}');
    run('php artisan cache:clear');
});

before('deploy', 'cache:clear');

task('deploy', [
    'deploy:prepare',
    'deploy:vendors',
    'artisan:storage:link',
    'artisan:cache:clear',
    'artisan:config:cache',
    'artisan:route:cache',
    'artisan:view:cache',
    'artisan:event:cache',
    'artisan:db:wipe',
    'artisan:cycle:migrate',
    'artisan:db:seed',
    'deploy:publish',
]);

after('deploy:failed', 'deploy:unlock');
after('deploy:failed', 'slack:notify:failure');

after('deploy:success', 'slack:notify:success');
