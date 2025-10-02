FROM dunglas/frankenphp:latest

# Extensões comuns do Laravel (o image já traz o script install-php-extensions)
RUN install-php-extensions bcmath intl gd pdo_mysql zip opcache redis pcntl

COPY --from=composer:2 /usr/bin/composer /usr/local/bin/composer

WORKDIR /app
