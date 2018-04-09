# config valid for current version and patch releases of Capistrano
lock "~> 3.10.1"

set :application, "nofi_plus"
set :repo_url, "ssh://nofiplus@nofiplus.com/var/www/vhosts/nofiplus.com/git/nofiplus.com"
set :branch, 'prod'
set :stage, :prod
set :ssh_user, 'root'
server '94.23.206.21', user: fetch(:ssh_user), roles: %w{web app db}

# Default branch is :master
# ask :branch, `git rev-parse --abbrev-ref HEAD`.chomp

# Default deploy_to directory is /var/www/my_app_name
set :deploy_to, "/var/www/vhosts/nofiplus.com/httpdocs/NOFIPLUS"
