FROM nginx:1.26.1-bookworm

RUN apt update --allow-insecure-repositories --allow-unauthenticated; \
    apt upgrade -y; \
    apt-get autoclean; \
    apt-get clean; \
    rm -rf /tmp/*; \
    mkdir -p /app

COPY /.docker/nginx/nginx.conf /etc/nginx/nginx.conf
COPY /.docker/nginx/default.conf /etc/nginx/templates/default.conf.template
