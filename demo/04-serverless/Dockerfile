FROM php:8.4-cli-alpine AS builder

WORKDIR /app

COPY --from=composer:2 /usr/bin/composer /usr/local/bin/composer
COPY ["04-serverless/composer.json", "04-serverless/composer.lock", "./"]

RUN composer require "bref/bref:^2.4"

FROM node:24-alpine

WORKDIR /app

COPY ["04-serverless/package.json", "04-serverless/package-lock.json", "04-serverless/serverless.yml", "./"]
COPY --from=builder /app/vendor/ ./vendor

RUN npm install --include=dev
