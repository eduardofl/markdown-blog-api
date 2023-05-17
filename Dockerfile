FROM ubuntu:20.04

ARG DEBIAN_FRONTEND=noninteractive

RUN apt-get update && apt-get install -y \
    software-properties-common \
    build-essential \
    nginx \
    curl \
    unzip

RUN LC_ALL=C.UTF-8 add-apt-repository ppa:ondrej/php && \
    apt-get update && \
    apt-get install -y \
    php8.2 \
    php8.2-fpm \
    php8.2-mbstring \
    php8.2-xml \
    php8.2-mysql \
    php8.2-curl \
    php8.2-zip

RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" && \
    php composer-setup.php --version=2.4.1 --install-dir=/usr/local/bin --filename=composer

COPY ./ /opt/source/markdown-blog-api

WORKDIR /opt/source/markdown-blog-api

COPY ./docker/nginx/default.conf /etc/nginx/sites-available/default

RUN touch /var/log/laravel.log && \
    chmod 666 /var/log/laravel.log && \
    sed -i "s/^;clear_env =.*/clear_env = no/g" /etc/php/8.2/fpm/pool.d/www.conf && \
    rm -f .env && \
    rm -rf storage/app/* && \
    rm -rf vendor && \
    composer install --no-scripts

CMD /etc/init.d/php8.2-fpm start && \
    chmod -R 777 storage && \
    tail -fq /var/log/laravel.log > /dev/stdout & \
    nginx -g 'daemon off;'

EXPOSE 80
EXPOSE 443