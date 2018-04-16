# config valid for current version and patch releases of Capistrano
lock "~> 3.10.1"

set :file_permissions_users, ["nginx"]
set :file_permissions_paths, ["var", "web/uploads"]

set :log_level, :debug

#set :linked_files, ["app/config/parameters.yml"]
#set :linked_dirs, ["var/logs"]

### 
# Symfony 
###

set :symfony_console, "php bin/console"

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
        execute 'php bin/console cache:clear --env=prod'
        execute 'php bin/console doctrine:database:create --if-not-exists --env=prod'
        execute 'php bin/console doctrine:schema:update --force --env=prod'
        execute 'php bin/console doctrine:migrations:diff'
        execute 'php bin/console doctrine:migrations:migrate --no-interaction'
        execute 'php bin/console doctrine:migrations:status'
        execute 'php bin/console app:user:create-admin --env=prod'
    end 
  end

  desc 'Database validate'
  task :database_validate do
       on roles(:db) do
            execute 'php bin/console doctrine:schema:validate --env=prod'
       end
  end

end


###
# Events
###
after 'deploy:updated', 'deploy:migrate'
after 'deploy:migrate', 'deploy:database_validate'