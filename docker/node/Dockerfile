ARG NODE_VERSION=16.15.1
# node "stage"
FROM node:${NODE_VERSION}-alpine AS symfony_node
RUN apk add --update --no-cache \
    python3 \
    g++ \
    make \
    && ln -sf python3 /usr/bin/python
WORKDIR /srv/app
COPY package*.json ./
RUN yarn install