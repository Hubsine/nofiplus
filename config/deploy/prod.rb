set :deploy_to, "/var/www/vhosts/nofiplus.com/httpdocs/NOFIPLUS"

set :repo_url, 'git@github.com:Hubsine/nofiplus.git'

set :branch, 'prod'
set :stage, :prod
set :deploy_to, "/var/www/vhosts/nofiplus.com/httpdocs/NOFIPLUS"
set :controllers_to_clear, ["app_*.php"]
set :ssh_user, 'nofiplus'
server '94.23.206.21', user: fetch(:ssh_user), roles: %w{web app db}

# Configuration
# http://capistranorb.com/documentation/getting-started/configuration/
#server "94.23.206.21",
   #user: "user_name",
   #roles: %w{web app},
   #ssh_options: {
     #user: "nofiplus",  #overrides user setting above
     #keys: %w(/home/user_name/.ssh/id_rsa),
     #forward_agent: false,
     #auth_methods: %w(publickey password)
     #password: "please use keys"
   #}

SSHKit.config.command_map[:php] = "/opt/plesk/php/7.0/bin/php"

### 
# Composer
###

set :composer_install_flags, '--no-dev --no-interaction --quiet --optimize-autoloader --ignore-platform-reqs --no-scripts'
set :composer_working_dir, -> { fetch(:release_path) }

SSHKit.config.command_map[:bash] = "/bin/bash"
SSHKit.config.command_map[:composer] = "/opt/plesk/php/7.0/bin/php #{shared_path.join("composer.phar")}"
namespace :deploy do
  after :starting, 'composer:install_executable'
end

###
# End Composer
###