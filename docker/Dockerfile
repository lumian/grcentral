FROM php:7.4.33-apache-bullseye

RUN apt-get update && \
    apt-get install -y --no-install-recommends libonig-dev libcurl4-openssl-dev ca-certificates supervisor cron && \
    rm -rf /var/lib/apt/lists/*

RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini" && \
    sed -i 's/short_open_tag = Off/short_open_tag = On/g' "$PHP_INI_DIR/php.ini" && \
    docker-php-ext-install mysqli curl pdo_mysql mbstring && \
    docker-php-ext-enable mysqli curl pdo_mysql mbstring

COPY docker/supervisor.conf /etc/supervisor/conf.d/supervisor.conf

COPY docker/crontab /etc/cron.d/grcentral
RUN crontab /etc/cron.d/grcentral

RUN ln -s /etc/apache2/mods-available/rewrite.load /etc/apache2/mods-enabled/rewrite.load

COPY webui/ /var/www/html

# Задаем права доступа и владельца
# Файлы - 644
# Директории - 755
RUN find -type f -exec chmod -R 644 {} \; \
    && find -type d -exec chmod -R 755 {} \; \
    && chown -R www-data:www-data . .*

CMD ["/usr/bin/supervisord"]
