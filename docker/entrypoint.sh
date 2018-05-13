#!/bin/bash


#php artisan config:cache
#php artisan route:cache

if [ "$ENABLE_SCHEDULER" = "1" ]; then
  exec cron -f
elif [ "$ENABLE_QUEUE" = "1" ]; then
  sudo -u alliwant -g www-data php /var/www/app/artisan queue:work --daemon --sleep=3 --tries=3
else
  cd /var/www/app
  php artisan minify
  exec apache2 -D FOREGROUND
fi