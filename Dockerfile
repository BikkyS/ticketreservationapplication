# Use an official PHP image with version 7.4
FROM php:7.4-apache

# Update the package list
RUN apt-get update

# Install necessary packages
RUN apt-get install -y mariadb-server libmariadb-dev

# Install PHP MySQL extension
RUN docker-php-ext-install mysqli

# Create the sessions directory and set permissions
RUN mkdir -p /var/www/html/sessions && chmod -R 777 /var/www/html/sessions

# Copy the custom php.ini file
COPY custom-php.ini /usr/local/etc/php/conf.d/custom-php.ini

# Copy the custom Apache config file
COPY apache-config.conf /etc/apache2/conf-available/

# Enable the custom Apache config
RUN a2enconf apache-config

# Copy your project files to the container
COPY . /var/www/html

# Set up permissions
RUN chown -R www-data:www-data /var/www/html
RUN chmod -R 755 /var/www/html

# Copy SQL scripts to initialize databases and tables
COPY create_databases.sql /docker-entrypoint-initdb.d/
COPY create_tables.sql /docker-entrypoint-initdb.d/

# Ensure config.inc.php has correct permissions
RUN chmod 644 /etc/phpmyadmin/config.inc.php

# Expose port 80
EXPOSE 80

# Start Apache
CMD ["apache2-foreground"]
