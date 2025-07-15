# Use the official PHP image as the base image
FROM php:8.1-apache

# Install necessary PHP extensions and dependencies
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libcurl4-openssl-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd mysqli pdo pdo_mysql curl

# Configure PHP settings for better error handling
RUN echo "output_buffering = 4096" >> /usr/local/etc/php/conf.d/custom.ini && \
    echo "session.auto_start = 0" >> /usr/local/etc/php/conf.d/custom.ini && \
    echo "display_errors = On" >> /usr/local/etc/php/conf.d/custom.ini && \
    echo "log_errors = On" >> /usr/local/etc/php/conf.d/custom.ini

# Set the working directory
WORKDIR /var/www/html

# Copy the application files to the container
COPY . /var/www/html

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Set permissions for the application files
RUN chown -R www-data:www-data /var/www/html && \
    chmod -R 755 /var/www/html

# Expose port 80
EXPOSE 80