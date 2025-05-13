FROM ghcr.io/roadrunner-server/roadrunner:2025.1.1 AS roadrunner

FROM php:8.4-cli-alpine

COPY --from=roadrunner /usr/bin/rr /usr/local/bin/rr
COPY --from=composer /usr/bin/composer /usr/local/bin/composer

RUN apk add --no-cache linux-headers && \
    docker-php-ext-install sockets

EXPOSE 8006
CMD /usr/local/bin/rr serve -w /app
