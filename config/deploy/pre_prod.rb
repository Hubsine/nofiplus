set :deploy_to, "/var/www/vhosts/nofiplus.com/httpdocs/PREPROD_NOFIPLUS"
set :repo_url, 'git@github.com:Hubsine/nofiplus.git'

set :symfony_env,  "preprod"

set :branch, 'preprod'
set :ssh_user, 'nofiplus'
server '94.23.206.21', user: fetch(:ssh_user), roles: %w{web app db}

SSHKit.config.command_map[:php] = "/opt/plesk/php/7.0/bin/php"

### 
# Composer
###

set :composer_working_dir, -> { fetch(:release_path) }

SSHKit.config.command_map[:bash] = "/bin/bash"
SSHKit.config.command_map[:composer] = "/opt/plesk/php/7.0/bin/php #{shared_path.join("composer.phar")}"

namespace :deploy do
  after :starting, 'composer:install_executable'
end

###
# End Composer
###