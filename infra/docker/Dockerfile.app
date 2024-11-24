FROM php:8.2-fpm

# Definindo argumentos de usuário
ARG user=creis
ARG uid=1000

# Definir diretório de trabalho
WORKDIR /var/www

# Defina a variável de ambiente TZ
ENV TZ=America/Sao_Paulo

# Instalar pacotes necessários
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    tzdata \
    vim \
    zip \
    unzip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd sockets \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Configure o fuso horário no contêiner
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

# Instala o Xdebug via PECL
RUN pecl install xdebug \
    && docker-php-ext-enable xdebug

# Adiciona a configuração do Xdebug diretamente no arquivo .ini e configura logs de erro
RUN echo "display_errors=On" >> /usr/local/etc/php/conf.d/custom.ini \
    && echo "log_errors=On" >> /usr/local/etc/php/conf.d/custom.ini \
    && echo "error_log=/var/log/php_errors.log" >> /usr/local/etc/php/conf.d/custom.ini \
    && mkdir -p /var/log \
    && touch /var/log/php_errors.log \
    && chmod 777 /var/log/php_errors.log

COPY ./xdebug.ini /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
COPY ./php.ini-development /usr/local/etc/php/php.ini-development
COPY ./php.ini-development /usr/local/etc/php/php.ini-production

# Copiar o Composer da imagem oficial
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Instalar a extensão Redis
RUN pecl install -o -f redis \
    && rm -rf /tmp/pear \
    && docker-php-ext-enable redis

# Instalar o Node.js e npm
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get install -y nodejs

# Criar o usuário e diretório home
RUN useradd -G www-data,root -u $uid -d /home/$user $user \
    && mkdir -p /home/$user/.composer \
    && chown -R $user:$user /home/$user

# Ajustar permissões do diretório /var
RUN chown -R $user:www-data /var \
    && chmod -R 775 /var

# Copiar o arquivo de configuração do Opcache para o diretório de configuração do PHP
COPY opcache.ini /usr/local/etc/php/conf.d/opcache.ini

# Mudar para o usuário não-root
USER $user

# Expor a porta do PHP-FPM
EXPOSE 9000

# Comando para rodar o PHP-FPM
CMD ["php-fpm"]
