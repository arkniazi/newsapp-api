#!/bin/bash

sleep 5

# Run Laravel migrations
php artisan migrate --force 

# Run Laravel seeders
php artisan db:seed --force &
php artisan schedule:run &

# Will add a cron job to the container
service cron start &
echo "0 0 * * * cd /var/www && php artisan schedule:run >> /var/www/storage/logs/cron.log 2>&1" > /etc/cron.d/my-cron-job &
chmod 0644 /etc/cron.d/my-cron-job &

# Start the server
php artisan serve --host=0.0.0.0 --port=8181