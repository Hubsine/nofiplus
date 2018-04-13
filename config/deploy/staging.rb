#/usr/local/var/www/nofiplus/.git
set :repo_url, '/usr/local/var/www/nofiplus/.git'
#set :repository, '.'
#set :local_repository, "."
set :branch, 'master'
set :stage, :staging
set :deploy_to, "/usr/local/var/www/NOFIPLUS_PROD"

server 'localhost', roles: %w{app web db} # no need to set SSH configs.