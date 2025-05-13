FROM php:8.4-cli-alpine AS builder

WORKDIR /app

COPY --from=composer:2 /usr/bin/composer /usr/local/bin/composer
COPY ["composer.json", "composer.lock", "./"]

RUN composer install

FROM node:24-alpine

WORKDIR /app

COPY ["package.json", "package-lock.json", "serverless.yml", "./"]
COPY --from=builder /app/vendor/ ./vendor

RUN npm install --include=dev
