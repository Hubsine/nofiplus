#M3IVk3MCHI
# config valid for current version and patch releases of Capistrano
lock "~> 3.10.2"

set :application, "nofi_plus"
set :repo_url, 'git@github.com:Hubsine/nofiplus.git'

set :file_permissions_users, ["nginx"]
set :file_permissions_paths, ["var", "web/uploads"]

set :log_level, :debug

### 
# Symfony 
###

set :controllers_to_clear, ["app_*.php", "config.php"]
set :env, ->{ "--env=#{fetch(:symfony_env)}" }
#set :nginx_server_name, ->{ fetch(:app_domain) }

###
# Composer
###

SSHKit.config.command_map[:php] = "/opt/plesk/php/7.0/bin/php"

SSHKit.config.command_map[:bash] = "/bin/bash"

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
        #symfony_console("app:user:create-admin", fetch(:env))
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
after 'deploy:updated', 'deploy:migrate'
after 'deploy:migrate', 'deploy:database_validate'

namespace :assets do
  desc 'Install Ckeditor'
  task :install_ckeditor do
    on roles(:app) do
      symfony_console('ckeditor:install', fetch(:env) + ' --no-interaction')
    end
  end

  desc 'Assets dump'
  task :install do
       on roles(:app) do
            symfony_console("assets:install", fetch(:env) + ' ' + '--symlink')
       end
  end

end

after 'deploy:updated', 'assets:install_ckeditor'
after 'assets:install_ckeditor', 'assets:install'
