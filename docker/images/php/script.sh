#!/bin/bash
mkdir -pv /var/www/html/public/storage;
chown www-data:www-data -R /var/www/html/public/storage;
chmod 0755 -R /var/www/html/public/storage;

mkdir -pv /var/www/html/public/img;
chown www-data:www-data -R /var/www/html/public/img;
chmod 0755 -R /var/www/html/public/img;

mkdir -pv /var/www/html/public/openapi;
chown www-data:www-data -R /var/www/html/public/openapi;

mkdir -pv /var/www/html/storage/logs/supervisor
chown www-data:www-data -R /var/www/html/storage/logs;
chmod 0755 -R /var/www/html/storage/logs;
chown www-data:www-data -R /var/www/html/storage/framework;

/usr/bin/supervisord -c /etc/supervisor/supervisord.conf;
