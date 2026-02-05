#!/bin/bash

# Deployment Script for Production

# 1. Pull latest changes (uncomment if you use git on server)
# git pull origin main

# 2. Install Dependencies
composer install --no-dev --optimize-autoloader
npm install

# 3. Build Assets
npm run build

# 4. Run Migrations
php artisan migrate --force

# 5. Link Storage
php artisan storage:link

# 5. Optimize Configuration
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache

# 6. Restart Queue (if using Supervisor)
# php artisan queue:restart

echo "Deployment completed successfully!"
