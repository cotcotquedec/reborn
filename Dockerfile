FROM debian
MAINTAINER  Julien Houvion "jhouvion@gmail.com"

# UPGRADE
RUN DEBIAN_FRONTEND=noninteractive apt-get update && \
	DEBIAN_FRONTEND=noninteractive apt-get upgrade -y && \
	DEBIAN_FRONTEND=noninteractive apt-get install -y wget curl locales git apt-transport-https lsb-release ca-certificates && \
	wget -O /etc/apt/trusted.gpg.d/php.gpg https://packages.sury.org/php/apt.gpg && \
    echo "deb https://packages.sury.org/php/ $(lsb_release -sc) main" >> /etc/apt/sources.list && \
    apt-get -q autoremove  && \
    apt-get -q clean -y  && \
    rm -rf /var/lib/apt/lists/*  && \
    rm -f /var/cache/apt/*.bin

# TIMEZONE
RUN echo "Europe/Paris" > /etc/timezone && \
	dpkg-reconfigure -f noninteractive tzdata
RUN export LANGUAGE=fr_FR.UTF-8 && \
	export LANG=fr_FR.UTF-8 && \
	export LC_ALL=fr_FR.UTF-8 && \
	locale-gen fr_FR.UTF-8 && \
	DEBIAN_FRONTEND=noninteractive dpkg-reconfigure locales

# INSTALL PHP
RUN apt-get update; apt-get install -y sudo php7.1 php7.1-cli php7.1-gd php7.1-imap php7.1-mbstring php7.1-xml php7.1-curl \
    php7.1-mcrypt php7.1-zip php7.1-mysqlnd mysql-client libapache2-mod-php7.1 cron libapache2-mod-xsendfile && \
    apt-get -q autoremove  && \
    apt-get -q clean -y  && \
    rm -rf /var/lib/apt/lists/*  && \
    rm -f /var/cache/apt/*.bin

# Let's set the default timezone in both cli and apache configs
RUN sed -i 's/\;date\.timezone\ \=/date\.timezone\ \=\ Europe\/Paris/g' /etc/php/7.1/cli/php.ini
RUN sed -i 's/\;date\.timezone\ \=/date\.timezone\ \=\ Europe\/Paris/g' /etc/php/7.1/apache2/php.ini

# CONFIG
ADD docker/apache.conf /etc/apache2/sites-available/000-default.conf
ADD docker/entrypoint.sh /sbin/entrypoint.sh
RUN chmod +x /sbin/entrypoint.sh

#APACHE
RUN a2enmod rewrite expires headers

#CRON
#ADD docker/crontab /etc/cron.d/schedule
#RUN chmod 0644 /etc/cron.d/schedule && \
#  crontab /etc/cron.d/schedule && \
#  touch /var/log/schedule.log

#COMMAND
ADD docker/artisan /usr/local/bin/artisan
RUN chmod 770 /usr/local/bin/artisan


#APACHE ENV
ENV APACHE_RUN_USER www-data
ENV APACHE_RUN_GROUP www-data
ENV APACHE_LOG_DIR /var/log/apache2
ENV APACHE_PID_FILE /var/run/apache2.pid
ENV APACHE_RUN_DIR /var/run/apache2
ENV APACHE_LOCK_DIR /var/lock/apache2
ENV APACHE_SERVERADMIN jhouvion@gmail.com
ENV APACHE_SERVERNAME localhost
ENV APACHE_SERVERALIAS docker.localhost
ENV APACHE_DOCUMENTROOT /var/www

#USER
RUN useradd -m -u 9001 -G www-data -N -s /bin/bash alliwant
RUN mkdir /var/www/app && chown alliwant:www-data /var/www/app
WORKDIR /var/www/app

#APP CODE
COPY --chown=9001:33 . .

RUN chmod -R 770 storage bootstrap/cache public/build

EXPOSE 80
ENTRYPOINT ["/sbin/entrypoint.sh"]