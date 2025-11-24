FROM serversideup/php:8.3-fpm-nginx

# Set working directory
WORKDIR /var/www/html

# Switch to root to install dependencies and set permissions
USER root

# Copy composer files first for better layer caching
# COPY composer.json composer.lock ./

# Install composer dependencies (with dev dependencies for local development)
# Use --no-scripts to avoid errors before the full app is copied
# For production: add --no-dev flag
RUN composer install \
    --no-scripts \
    --no-interaction \
    --prefer-dist \
    --optimize-autoloader

# Copy the rest of the application
# COPY . .

# Run composer scripts now that all files are present
RUN composer dump-autoload --optimize

# Create necessary directories and set permissions
RUN mkdir -p storage/framework/{sessions,views,cache} \
    && mkdir -p storage/logs \
    && mkdir -p bootstrap/cache \
    && chown -R www-data:www-data /var/www/html \
    && chmod -R 775 storage bootstrap/cache

# DON'T cache config/routes/views during build for development
# The .env file is mounted at runtime, so caching during build would use wrong values
# For production: uncomment these and copy .env during build instead of mounting
# RUN php artisan config:cache \
#     && php artisan route:cache \
#     && php artisan view:cache

# Switch back to www-data user for security
USER www-data

# Expose port 8080 (NGINX port in this image)
EXPOSE 8080

# The base image already has the proper CMD to start PHP-FPM and NGINX

