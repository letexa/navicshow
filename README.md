# Системные требования

php: >= 7.1

# Установка

 1. Скопировать содержимое файла .env.example в .env, указав свои настройки.
    Параметр ENV  может быть в следующих режимах: production,
    development и test.
 2. Установить зависимые пакеты `composer install`
 3. Добавить классы в автозагрузку composer dump-autoload -o
 4. Выполнить миграции `vendor/bin/phinx-migrations migrate`
 5. После установки сделать дамп БД для тестов и сохранить в файл `/tests/_data/dump.sql`

# Тестирование

Запускается из консоли `vendor/bin/codecept run api`

# Nginx конфиг

server {
        listen 80;
        listen [::]:80;


        root /var/www/navicshow.loc/public_html/api/src/public;

        index index.php index.html index.htm index.nginx-debian.html;

        access_log /var/www/navicshow.loc/cgi-bin/access.log;
        error_log /var/www/navicshow.loc/cgi-bin/error.log;

        server_name api.navicshow.loc www.api.navicshow.loc;

        location ~ \.php$ {
            include snippets/fastcgi-php.conf;
            fastcgi_pass unix:/run/php/php7.2-fpm.sock;
        }
       location / {
            try_files $uri $uri/ /index.php$is_args$args;

            if ($request_method = 'OPTIONS') {
                add_header 'Access-Control-Allow-Origin' '*';
                add_header 'Access-Control-Allow-Methods' 'GET, POST, OPTIONS, PUT, PATCH, DELETE';
                add_header 'Access-Control-Allow-Headers' 'DNT,User-Agent,X-Requested-With,If-Modified-Since,Cache-Control,Content-Type,Range';
                add_header 'Access-Control-Max-Age' 1728000;
                add_header 'Content-Type' 'text/plain; charset=utf-8';
                add_header 'Content-Length' 0;
                return 204;
            }
        }
        location ~* ^.+.(jpg|jpeg|gif|css|png|js|ico|html|xml|txt)$ {
            access_log off;
        }
                location ~ /\.ht {
            deny all;
        }

        sendfile off;

        dav_methods PUT DELETE MKCOL COPY MOVE;
}


