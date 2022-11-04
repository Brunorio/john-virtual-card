FROM composer:2.4 as builder

WORKDIR /app

COPY public/api/ .

RUN composer install

FROM php:8-fpm-alpine

WORKDIR /public

COPY --from=builder /app/vendor/ /public/api/vendor

RUN apk add --update icu-dev \ 
&& apk add libzip-dev \
libpng-dev jpeg-dev freetype-dev \
&& apk --no-cache add pcre-dev ${PHPIZE_DEPS} \ 
&& docker-php-ext-configure gd --with-jpeg --with-freetype \
&& docker-php-ext-install zip pdo pdo_mysql gd  \
&& pecl install xdebug \
&& docker-php-ext-enable zip pdo pdo_mysql xdebug gd \
&& apk del pcre-dev ${PHPIZE_DEPS}