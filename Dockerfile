FROM php:8.3-apache
RUN docker-php-ext-install mysqli
RUN docker-php-ext-install pdo_mysql
RUN echo "upload_max_filesize = 20M" | tee -a /usr/local/etc/php/conf.d/upload.ini
RUN echo "post_max_size = 20M" | tee -a /usr/local/etc/php/conf.d/upload.ini
EXPOSE 80
