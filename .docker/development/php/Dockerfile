FROM php:8.0-cli-alpine
ARG XDEBUG_VERSION="3.0.4"
# Update system
RUN set -ex && apk update && apk upgrade --available \
	&& apk add --no-cache $PHPIZE_DEPS

# Install Xdebug
RUN set -ex && mkdir -p "/usr/src/php/ext/xdebug" \
	&& curl -fsSL "https://pecl.php.net/get/xdebug-${XDEBUG_VERSION}" | tar xvz -C "/usr/src/php/ext/xdebug" --strip 1 \
    && echo 'xdebug' >> "/usr/src/php-available-exts" \
	&& docker-php-ext-install xdebug \
	&& rm -rf "/usr/src/php/ext/xdebug"

# Cleanup
RUN set -ex \
	&& apk del $PHPIZE_DEPS \
	&& rm -rf /var/cache/apk/* \
    && apk add --no-cache file