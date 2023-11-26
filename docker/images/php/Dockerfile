FROM php:8.1-rc-fpm

# INSTALL Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN apt-get update \
    && apt-get install -y \
    supervisor \
    iputils-ping \
    cron \
    zlib1g-dev \
    libzip-dev \
    procps \
    cron \
    supervisor \
    iputils-ping \
    libfreetype6-dev libjpeg62-turbo-dev libpng-dev \
    libc-client-dev libkrb5-dev \
    libmagickwand-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd \
    && docker-php-ext-install \
    zip \
    pdo \
    pdo_mysql \
    mysqli \
    calendar \
    bcmath \
    exif \
    opcache \
    sockets \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

RUN apt-get update \
    && apt-get install -y \
    libpq-dev \
    && docker-php-ext-install pdo_pgsql

RUN docker-php-ext-configure pgsql \
    && docker-php-ext-install pdo pdo_pgsql pgsql

# SETTINGS supervisor
RUN mkdir -p /var/log/supervisor
RUN mkdir -p /var/log/php-fpm
COPY supervisor/* /etc/supervisor/conf.d/


RUN printf '* * * * * www-data cd /var/www/html && /usr/local/bin/php artisan schedule:run >> /var/www/html/storage/logs/cron.log 2>&1\n#' >> /etc/cron.d/hello-cron
RUN crontab /etc/cron.d/hello-cron

# Create the log file to be able to run tail
RUN touch /var/log/cron.log

# Add script
ADD script.sh /usr/local/bin/script.sh
RUN chmod 0755 /usr/local/bin/script.sh

WORKDIR /var/www/html

RUN echo "memory_limit = 3G" >> /usr/local/etc/php/conf.d/settings.ini

RUN echo "post_max_size = 500M" >> /usr/local/etc/php/conf.d/settings.ini
RUN echo "upload_max_filesize = 500M" >> /usr/local/etc/php/conf.d/settings.ini
RUN echo "output_buffering = 4096" >> /usr/local/etc/php/conf.d/settings.ini
RUN echo "session.sid_length = 26" >> /usr/local/etc/php/conf.d/settings.ini
RUN echo "session.sid_bits_per_character = 5" >> /usr/local/etc/php/conf.d/settings.ini

RUN echo "* soft  nofile  200000" >> /etc/security/limits.conf
RUN echo "* hard  nofile  200000" >> /etc/security/limits.conf
RUN echo "www-data  soft  nofile 200000" >> /etc/security/limits.conf
RUN echo "www-data  hard  nofile 200000" >> /etc/security/limits.conf
RUN echo "root soft nofile 200000" >> /etc/security/limits.conf
RUN echo "root hard nofile 200000" >> /etc/security/limits.conf
RUN echo "nginx soft nofile 200000" >> /etc/security/limits.conf
RUN echo "nginx hard nofile 200000" >> /etc/security/limits.conf

RUN echo "fs.file-max = 200000" >> /etc/sysctl.conf

CMD /bin/sh -c "/usr/local/bin/script.sh"
