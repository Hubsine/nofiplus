# config valid for current version and patch releases of Capistrano
lock "~> 3.10.1"

set :deploy_to, "/var/www/vhosts/nofiplus.com/httpdocs/NOFIPLUS"

set :application, "nofi_plus"
set :repo_url, 'git@github.com:Hubsine/nofiplus.git'

set :file_permissions_users, ["nginx"]
set :file_permissions_paths, ["var", "web/uploads"]

set :log_level, :debug

#set :linked_files, ["app/config/parameters.yml"]
#set :linked_dirs, ["var/logs"]

### 
# Symfony 
###

###
# Composer
###

set :composer_install_flags, '--no-dev --no-interaction --quiet --optimize-autoloader --ignore-platform-reqs --no-scripts'

###
# Events
###