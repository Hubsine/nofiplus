set :deploy_to, "/var/www/vhosts/nofiplus.com/httpdocs/PREPROD_NOFIPLUS"

set :symfony_env,  "preprod"

set :branch, 'preprod'
set :stage, :preprod
set :ssh_user, 'nofiplus'
server '94.23.206.21', user: fetch(:ssh_user), roles: %w{web app db}

set :keep_releases, 5

### 
# Composer
###

set :composer_working_dir, -> { fetch(:release_path) }
set :composer_install_flags, '--no-interaction --quiet --optimize-autoloader --ignore-platform-reqs --no-scripts'
SSHKit.config.command_map[:composer] = "/opt/plesk/php/7.0/bin/php #{shared_path.join("composer.phar")}"

namespace :deploy do
  after :starting, 'composer:install_executable'
end

###
# End Composer
###

###
# Data Fixtures
###

namespace :deploy do

  desc "Load data fixtures"
  task :load_data_fixtures do
    on roles(:db) do
      symfony_console('doctrine:fixtures:load', '--no-interaction ' + '--env=' + fetch(:symfony_env) )
    end
  end

end

after 'deploy:migrate', "deploy:load_data_fixtures"