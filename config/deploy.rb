set :application, "qrcode-rest"
set :deploy_to, "/home/deploy/public_html/#{application}"
default_run_options[:pty] = true

set :scm, :git
set :repository,  "git@github.com:tvision/qrcode-rest.git"
set :deploy_via, :remote_cache
set :branch, "master"
set :keep_releases, 3

server "1.2.3.4", :app, :web, :db, :primary => true
set :ssh_options, {:forward_agent => true, :port => 22}
set :user, "deploy"
set :use_sudo, false

namespace :deploy do

    task :start do
    end

    task :stop do
    end

    task :migrate do
    end

    task :restart do
    end

end

namespace :myproject do

    task :vendors do
        run "curl -s http://getcomposer.org/installer | php -- --install-dir=#{release_path}"
        run "cd #{release_path} && #{release_path}/composer.phar install --no-dev"
    end

end

after "deploy:update_code", "myproject:vendors"