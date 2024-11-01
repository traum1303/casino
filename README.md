### Clone the project code
```bash
git clone {{REPOSITORY}} .
``
#### Pull the Laradock code as submodule
```bash
git submodule add https://github.com/Laradock/laradock.git
git submodule update --init --recursive
```


### copy db & config files
```bash
cp -av ./laradock.config/. ./laradock
cp casino.local/.env.example casino.local/.env
```

#### Setup local hosts
```bash
sudo echo "127.0.0.1 casino.local www.casino.local" | sudo tee -a /etc/hosts
```

#### Build & run the containers in the detach mode
```bash

docker-compose --env-file laradock/.env -f laradock/docker-compose-dev.yml up -d nginx workspace php-fpm postgres rabbitmq redis

docker-compose --env-file laradock/.env -f laradock/docker-compose-dev.yml restart nginx
docker-compose --env-file laradock/.env -f laradock/docker-compose-dev.yml stop 

a2ensite casino.local.conf
service nginx reload
```

#### Login inside the 'workspace' container in order to install files
```bash
docker exec -it casino-workspace-1 bash
docker exec casino-workspace-1 bash -c "cd casino.local && composer install -n && php artisan migrate"
docker exec casino-workspace-1 bash -c "cd casino.local && chmod 777 ./storage -R && chmod 777 ./bootstrap/cache -R"
docker exec -it casino-workspace-1 bash -c "cd casino.local && npm install && npm run build"
```

#### How to stop containers
```bash
docker-compose -f laradock/docker-compose-dev.yml stop
```