FROM        debian
MAINTAINER  Julien Houvion "cotcotquedec@gmail.com"

# UPGRADE
RUN DEBIAN_FRONTEND=noninteractive apt-get update && \
	DEBIAN_FRONTEND=noninteractive apt-get upgrade -y && \
	DEBIAN_FRONTEND=noninteractive apt-get install -y wget curl locales

# TIMEZONE
RUN echo "Europe/Paris" > /etc/timezone && \
	dpkg-reconfigure -f noninteractive tzdata
RUN export LANGUAGE=fr_FR.UTF-8 && \
	export LANG=fr_FR.UTF-8 && \
	export LC_ALL=fr_FR.UTF-8 && \
	locale-gen fr_FR.UTF-8 && \
	DEBIAN_FRONTEND=noninteractive dpkg-reconfigure locales

# INSTALL PHP
RUN apt-get update; apt-get install -y sudo php7.0 php7.0-cli php7.0-gd php7.0-imap php7.0-mbstring php7.0-xml php7.0-curl \
    php7.0-mcrypt php7.0-zip php7.0-mysqlnd mysql-client libapache2-mod-php7.0 git libapache2-mod-xsendfile

# Let's set the default timezone in both cli and apache configs
RUN sed -i 's/\;date\.timezone\ \=/date\.timezone\ \=\ Europe\/Paris/g' /etc/php/7.0/cli/php.ini
RUN sed -i 's/\;date\.timezone\ \=/date\.timezone\ \=\ Europe\/Paris/g' /etc/php/7.0/apache2/php.ini
#APACHE
ADD docker/apache.conf /etc/apache2/sites-available/000-default.conf
RUN echo "umask 077" > /etc/apache2/envvars

RUN a2enmod rewrite expires headers xsendfile

#APACHE ENV
ENV APACHE_RUN_USER www-data
ENV APACHE_RUN_GROUP www-data
ENV APACHE_LOG_DIR /var/log/apache2
ENV APACHE_PID_FILE /var/run/apache2.pid
ENV APACHE_RUN_DIR /var/run/apache2
ENV APACHE_LOCK_DIR /var/lock/apache2
ENV APACHE_SERVERADMIN cotcotquedec@gmail.com
ENV APACHE_SERVERNAME localhost
ENV APACHE_SERVERALIAS docker.localhost
ENV APACHE_DOCUMENTROOT /var/www


EXPOSE 80
VOLUME ["/var/log/apache2"]
ENTRYPOINT ["/usr/sbin/apache2", "-D", "FOREGROUND"]


#docker build -t jobmaker .
#docker run -d -P -v /var/www/jobmaker:/var/www/jobmaker jobmaker