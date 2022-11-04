FROM php:7.4-fpm-alpine

RUN apk add --update icu-dev \ 
&& apk add libzip-dev \
libpng-dev jpeg-dev freetype-dev \
&& apk --no-cache add pcre-dev ${PHPIZE_DEPS} \ 
&& docker-php-ext-configure gd --with-jpeg --with-freetype \
&& docker-php-ext-install zip pdo pdo_mysql gd  \
&& pecl install xdebug \
&& docker-php-ext-enable zip pdo pdo_mysql xdebug gd \
&& apk del pcre-dev ${PHPIZE_DEPS}

COPY public/api api 

RUN cd api && php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
&& php composer-setup.php \
&& php -r "unlink('composer-setup.php');" \
&& php composer.phar install