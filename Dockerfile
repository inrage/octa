# Base images
FROM inrage/docker-wordpress:8.3-redis AS base-php
FROM node:20-alpine AS base-node
FROM composer:2.8 AS php-deps

# Node dependencies
FROM base-node AS node-deps
WORKDIR /app
COPY package.json yarn.lock ./
RUN yarn install --frozen-lockfile --non-interactive

# Node build
FROM node-deps AS node-builder
WORKDIR /app
COPY . .
RUN yarn build --no-browserslist-update

# PHP dependencies
FROM php-deps AS php-deps-install
WORKDIR /app
COPY composer.json composer.lock ./
COPY app/ app/

RUN --mount=type=secret,id=COMPOSER_AUTH_JSON,target=${COMPOSER_HOME}/auth.json \
    composer install --no-dev --no-progress --no-interaction --prefer-dist --ignore-platform-reqs;

# Final image setup
FROM base-php
WORKDIR /var/www/html
COPY --chown=inr:inr . .
COPY --chown=inr --from=node-builder /app/public/dist ./public/dist
COPY --chown=inr --from=php-deps-install /app/vendor ./vendor
COPY --chown=inr --from=php-deps-install /app/public/wp ./public/wp
COPY --chown=inr --from=php-deps-install /app/public/content/plugins ./public/content/plugins
COPY --chown=inr --from=php-deps-install /app/public/content/mu-plugins ./public/content/mu-plugins

USER root

# Set up Apache catch all name
RUN echo 'ServerName localhost' >> /etc/apache2/apache2.conf;

USER inr
