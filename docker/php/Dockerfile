ARG WITH_XDEBUG=false

FROM php:7.4-fpm

RUN apt-get update && apt-get install -y \
    openssl \
    git \
    vim \
    unzip locales openssh-client \
    zlib1g-dev libonig-dev libpng-dev \
    && locale-gen es_ES.UTF-8 \
    && echo "LC_ALL=es_ES.UTF-8" >> /etc/environment \
    && echo "LANG=es_ES.UTF-8" >> /etc/environment \
    && echo "LC_ALL=es_ES.UTF-8" >> /etc/default/locale \
    && echo "LANG=es_ES.UTF-8" >> /etc/default/locale

RUN docker-php-ext-install pdo pdo_mysql

RUN ln -snf /usr/share/zoneinfo/${DOCKER_TIMEZONE} /etc/localtime && echo ${DOCKER_TIMEZONE} > /etc/timezone \
&& printf '[PHP]\ndate.timezone = "%s"\n', ${DOCKER_TIMEZONE} > /usr/local/etc/php/conf.d/tzone.ini \
&& "date"

#LDAP
RUN set -x \
    && apt-get update \
    && apt-get install -y libldap2-dev \
    && rm -rf /var/lib/apt/lists/* \
    && docker-php-ext-configure ldap --with-libdir=lib/x86_64-linux-gnu/ \
    && docker-php-ext-install ldap \
    && apt-get purge -y --auto-remove libldap2-dev


# REDIS
RUN pecl install -o -f redis \
    &&  rm -rf /tmp/pear \
    &&  docker-php-ext-enable redis

#PHP ZIP
RUN apt-get update && apt-get install -y \
    zlib1g-dev \
    libzip-dev
RUN docker-php-ext-install zip

RUN docker-php-ext-install mbstring
RUN docker-php-ext-install gd
RUN docker-php-ext-install opcache

# APCU
RUN pecl install apcu \
	&& docker-php-ext-enable apcu \
	&& (rm -rf /usr/local/lib/php/test/apcu || true) \
	&& (rm -rf /usr/local/lib/php/doc/apcu || true)

# install xdebug
RUN pecl install xdebug \
    && docker-php-ext-enable xdebug \
    && echo "zend_extension=$(find /usr/local/lib/php/extensions/ -name xdebug.so)" >> /usr/local/etc/php/php.ini  \
    && echo "error_reporting = E_ALL" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "display_startup_errors = On" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "display_errors = On" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.remote_enable=1" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.remote_connect_back=1" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
&& composer --version

# Add Yarn repository
RUN apt-get update && apt-get install -y gnupg2
RUN curl -sS https://dl.yarnpkg.com/debian/pubkey.gpg | apt-key add -
RUN echo "deb https://dl.yarnpkg.com/debian/ stable main" | tee /etc/apt/sources.list.d/yarn.list

# Update
RUN apt-get update -y

# Install Yarn
RUN apt-get install yarn -y

# alias

RUN echo 'alias sf="php bin/console"' >> ~/.bashrc
RUN echo 'alias cc="php bin/console cache:clear"' >> ~/.bashrc
RUN echo 'alias f="ls -lah"' >> ~/.bashrc


WORKDIR /usr/src/app

COPY . /usr/src/app

RUN PATH=$PATH:/usr/src/apps/vendor/bin:bin
