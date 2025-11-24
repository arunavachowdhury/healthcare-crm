# Docker Setup for Healthcare Laravel Application

This guide explains how to build and run your Laravel application using Docker.

## Files Created

1. **Dockerfile** - Builds your custom Laravel image based on `serversideup/php:8.3-fpm-nginx`
2. **.dockerignore** - Excludes unnecessary files from the Docker build
3. **compose.yml** - Development environment configuration
4. **compose.production.yml** - Production environment configuration

## Prerequisites

- Docker installed on your system
- Docker Compose installed
- `.env` file configured for your application

## Development Usage

### Build the Image

```bash
docker compose build
```

### Run the Application

```bash
docker compose up -d
```

Your application will be available at `http://localhost`

### View Logs

```bash
docker compose logs -f php
```

### Run Artisan Commands

```bash
docker compose exec php php artisan migrate
docker compose exec php php artisan db:seed
docker compose exec php php artisan cache:clear
```

### Stop the Application

```bash
docker compose down
```

## Production Usage

### Build Production Image

```bash
docker compose -f compose.production.yml build
```

### Run in Production

```bash
docker compose -f compose.production.yml up -d
```

### Important Production Notes

1. **Environment Variables**: Make sure your `.env` file is properly configured
2. **Database Migrations**: Run migrations before starting:
   ```bash
   docker compose -f compose.production.yml run --rm php php artisan migrate --force
   ```
3. **Opcache**: Enabled in production for better performance
4. **No Volume Mounts**: Production uses fully containerized code

## Dockerfile Explanation

The Dockerfile performs these steps:

1. **Base Image**: Uses `serversideup/php:8.3-fpm-nginx` (includes PHP-FPM, NGINX, and Composer)
2. **Composer Install**: Installs PHP dependencies (production mode, no dev dependencies)
3. **Copy Application**: Copies all Laravel files into the container
4. **Set Permissions**: Configures proper file permissions for Laravel storage and cache
5. **Laravel Optimization**: Caches configuration, routes, and views for better performance
6. **Security**: Runs as `www-data` user (non-root)

## Customization

### Change PHP Settings

Edit the `environment` section in `compose.yml`:

```yaml
environment:
  PHP_UPLOAD_MAX_FILE_SIZE: "250M"
  PHP_MEMORY_LIMIT: "512M"
  PHP_MAX_EXECUTION_TIME: "120"
```

### Add Database Service

Uncomment the database section in `compose.production.yml` and update your `.env` file:

```env
DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=healthcare
DB_USERNAME=laravel
DB_PASSWORD=secret
```

### Build for Different Environments

Create custom Dockerfile variants if needed:
- `Dockerfile.dev` - Development with debugging tools
- `Dockerfile.prod` - Production optimized

## Troubleshooting

### Permission Issues

If you encounter permission issues with storage or cache:

```bash
docker compose exec php chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
docker compose exec php chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache
```

### Clear Laravel Caches

```bash
docker compose exec php php artisan config:clear
docker compose exec php php artisan route:clear
docker compose exec php php artisan view:clear
docker compose exec php php artisan cache:clear
```

### Rebuild from Scratch

```bash
docker compose down -v
docker compose build --no-cache
docker compose up -d
```

## Deployment

### Tag and Push to Registry

```bash
# Tag the image
docker tag healthcare-app:latest your-registry.com/healthcare-app:v1.0.0

# Push to registry
docker push your-registry.com/healthcare-app:v1.0.0
```

### Use in Production

Update your production server's compose file to use the registry image:

```yaml
services:
  php:
    image: your-registry.com/healthcare-app:v1.0.0
    # ... rest of configuration
```

## Additional Resources

- [ServerSideUp PHP Docker Images](https://serversideup.net/open-source/docker-php/)
- [Laravel Deployment Documentation](https://laravel.com/docs/deployment)
- [Docker Compose Documentation](https://docs.docker.com/compose/)

