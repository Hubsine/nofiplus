#M3IVk3MCHI
# config valid for current version and patch releases of Capistrano
lock "~> 3.10.2"

set :application, "nofi_plus"

set :file_permissions_users, ["nginx"]
set :file_permissions_paths, ["var", "web/uploads"]

set :log_level, :debug

#set :linked_files, ["app/config/parameters.yml"]
#set :linked_dirs, ["var/logs"]

### 
# Symfony 
###

set :keep_releases, 5
set :controllers_to_clear, ["app_*.php", "config.php"]
set :env, ->{ "--env=#{fetch(:symfony_env)}" }
#set :nginx_server_name, ->{ fetch(:app_domain) }

###
# Composer
###

set :composer_install_flags, '--no-dev --no-interaction --quiet --optimize-autoloader --ignore-platform-reqs --no-scripts'

###
# Databases
###

namespace :deploy do
  task :migrate do
    on roles(:db) do
        symfony_console('cache:clear', fetch(:env))
        symfony_console('doctrine:database:create', "--if-not-exists #{fetch(:env)}")
        #symfony_console("doctrine:schema:update", "--force #{fetch(:env)}")
        symfony_console("doctrine:migrations:diff")
        symfony_console("doctrine:migrations:migrate", "--no-interaction --allow-no-migration #{fetch(:env)}")
        symfony_console("doctrine:migrations:status")
        symfony_console("app:user:create-admin", fetch(:env))
    end 
  end

  desc 'Database validate'
  task :database_validate do
    on roles(:all) do
      symfony_console('doctrine:schema:validate', fetch(:env))
    end
  end

end

###
# Events
###
#after 'composer:install', 'deploy:database_validate'
after 'deploy:updated', 'deploy:migrate'
after 'deploy:migrate', 'deploy:database_validate'
