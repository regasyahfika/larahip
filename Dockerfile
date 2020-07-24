FROM php:7.3-fpm-alpine
ARG ENV=production
RUN apk add --no-cache libpng-dev libjpeg-turbo-dev freetype-dev
    # docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ && \
    # docker-php-ext-install pdo pdo_mysql bcmath gd zip
WORKDIR /var/www
COPY ./ /var/www

RUN apk add --update npm
RUN npm install

# Install pm2 untuk process manager node
RUN if [ "$ENV" = "production" ]; then npm install --global pm2@latest ; fi

RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
RUN php composer-setup.php --install-dir=/usr/bin --filename=composer
RUN php -r "unlink('composer-setup.php');"
RUN composer global require hirak/prestissimo
# RUN docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/
RUN docker-php-ext-install gd pdo pdo_mysql bcmath exif
RUN chmod 777 -R /var/www/storage /var/www/bootstrap/cache
