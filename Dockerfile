FROM php:8.2-fpm-alpine

RUN set -eux; \
    apk add --no-cache --virtual .build-deps $PHPIZE_DEPS icu-dev; \
    apk add --no-cache icu-libs curl bash; \
    docker-php-ext-install -j"$(nproc)" pdo pdo_mysql opcache intl; \
    { \
      echo "opcache.enable=1"; \
      echo "opcache.enable_cli=0"; \
      echo "opcache.memory_consumption=128"; \
      echo "opcache.interned_strings_buffer=16"; \
      echo "opcache.max_accelerated_files=20000"; \
      echo "opcache.validate_timestamps=0"; \
      echo "opcache.jit=1255"; \
      echo "opcache.jit_buffer_size=64M"; \
    } > /usr/local/etc/php/conf.d/opcache.ini; \
    apk del .build-deps

WORKDIR /var/www/html
COPY src/ /var/www/html/
RUN chown -R www-data:www-data /var/www/html

EXPOSE 9000
USER www-data

HEALTHCHECK --interval=30s --timeout=5s --start-period=10s --retries=3 \
  CMD php -v >/dev/null || exit 1
