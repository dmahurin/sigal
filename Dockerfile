FROM ubuntu:18.04

MAINTAINER Don Mahurin <dm@openright.org>

# Install apache and PHP
RUN apt-get update && apt-get -y upgrade && DEBIAN_FRONTEND=noninteractive apt-get -y install \
	apache2 php7.2 libapache2-mod-php7.2 \
	php7.2-gd php7.2-json php7.2-opcache \
	ffmpeg \
	node-uglify

# Enable apache mods.
RUN a2enmod php7.2
RUN a2enmod rewrite

# Update the PHP.ini file, enable <? ?> tags and quieten logging.
RUN sed -i "s/short_open_tag = Off/short_open_tag = On/" /etc/php/7.2/apache2/php.ini
RUN sed -i "s/error_reporting = .*$/error_reporting = E_ERROR | E_WARNING | E_PARSE/" /etc/php/7.2/apache2/php.ini

# Manually set up the apache environment variables
ENV APACHE_RUN_USER www-data
ENV APACHE_RUN_GROUP www-data
ENV APACHE_LOG_DIR /var/log/apache2
ENV APACHE_LOCK_DIR /var/lock/apache2
ENV APACHE_PID_FILE /var/run/apache2.pid

# Expose apache.
EXPOSE 80

ADD . /app/
RUN cd /app && uglifyjs -c -m < ./js/lazy.js > ./js/lazy.min.js && uglifyjs -c -m < ./js/sigal.js > ./js/sigal.min.js && php build.php
RUN mkdir -p /var/www/html/pics/cache
RUN cp -a /app/index.min.php /var/www/html/pics/index.php
RUN cp -a /app/demo/range_download.php /var/www/html/pics/range_download.php

ADD config.example.php /var/www/html/pics/config.php
# override sigal config with -v /srv/sigal/config.php:/var/www/html/pics/config.php

RUN printf "DocumentRoot /var/www/html\n<Directory \"/var/www/html\">\n\tOptions Indexes FollowSymLinks MultiViews\n\tAllowOverride All\n</Directory>\n" > /etc/apache2/sites-enabled/000-default.conf

VOLUME /var/www/site/html/cache
VOLUME /var/www/site/html/pictures

CMD /usr/sbin/apache2ctl -D FOREGROUND
