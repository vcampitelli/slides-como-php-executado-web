FROM php:8.5-cli-alpine

RUN apk add --no-cache bash socat
COPY server /usr/local/bin/server
COPY handle-request /usr/local/bin/handle-request
WORKDIR /app
EXPOSE 80
ENTRYPOINT ["bash", "/usr/local/bin/server"]
