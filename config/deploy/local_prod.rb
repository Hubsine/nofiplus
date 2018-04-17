#/usr/local/var/www/nofiplus/.git
set :repo_url, '/usr/local/var/www/nofiplus/.git'
#set :branch, ENV.fetch("BRANCH", "local_prod")
set :branch, 'local_prod'
set :stage, :staging
set :deploy_to, "/usr/local/var/www/NOFIPLUS_PROD"

server 'localhost', roles: %w{app web db} # no need to set SSH configs.