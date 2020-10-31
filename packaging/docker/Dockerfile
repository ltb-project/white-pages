FROM php:7.4-apache
# Install PHP extensions
ENV DEBIAN_FRONTEND=noninteractive
RUN buildDeps=" \
	libbz2-dev \
	libcurl4-gnutls-dev \
	libfreetype6-dev \
	libicu-dev \
	libjpeg62-turbo-dev \
	libldap2-dev \
	libonig-dev \
	libpng-dev \
	libsasl2-dev \
	libwebp-dev \
	gnupg2 \
    " \
    runtimeDeps=" \
	curl \
	ldap-utils \
	libgd3 \
	libpng16-16 \
	libjpeg62-turbo \
	libwebp6 \
	locales \
	locales-all \
    " \
    && apt-get update \
    && DEBIAN_FRONTEND=noninteractive apt-get install -y $buildDeps $runtimeDeps \
    && docker-php-ext-configure ldap --with-libdir=lib/x86_64-linux-gnu/ \
    && docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp \
    && docker-php-ext-install intl gd ldap \
    && echo en_US.UTF-8 UTF-8 >/etc/locale.gen \
    && /usr/sbin/locale-gen \
    && apt-get purge -y --auto-remove $buildDeps \
    && rm -r /var/lib/apt/lists/* \
    && a2enmod rewrite
RUN mkdir -p /usr/share/php/smarty3/ && \
    curl -Lqs https://github.com/smarty-php/smarty/archive/v3.1.35.tar.gz | \
    tar xzf - -C /usr/share/php/smarty3/ --strip-components=2
RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"
COPY . /var/www
RUN rmdir /var/www/html && \
    mv /var/www/htdocs /var/www/html && \
    mkdir -p /var/www/templates_c && \
    chown -R www-data: /var/www/templates_c
ENV LC_CTYPE=en_US.UTF-8
EXPOSE 80
