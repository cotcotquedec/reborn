FROM        debian
MAINTAINER  Julien Houvion "julien@jobmaker.fr"

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

# DOTDEB
RUN echo "deb http://packages.dotdeb.org jessie all" >> /etc/apt/sources.list.d/dotdeb.org.list && \
	wget -O- http://www.dotdeb.org/dotdeb.gpg | apt-key add -

# INSTALL PHP
RUN apt-get update; apt-get install -y php5-cli php5 php5-mcrypt php5-curl php5-mysql

# Let's set the default timezone in both cli and apache configs
RUN sed -i 's/\;date\.timezone\ \=/date\.timezone\ \=\ Europe\/Paris/g' /etc/php5/cli/php.ini
RUN sed -i 's/\;date\.timezone\ \=/date\.timezone\ \=\ Europe\/Paris/g' /etc/php5/apache2/php.ini

#APACHE
ADD docker/jobmaker.conf /etc/apache2/sites-available/000-default.conf
RUN a2enmod rewrite

#APACHE ENV
ENV APACHE_RUN_USER www-data
ENV APACHE_RUN_GROUP www-data
ENV APACHE_LOG_DIR /var/log/apache2
ENV APACHE_PID_FILE /var/run/apache2.pid
ENV APACHE_RUN_DIR /var/run/apache2
ENV APACHE_LOCK_DIR /var/lock/apache2
ENV APACHE_SERVERADMIN julien@jomaker.fr
ENV APACHE_SERVERNAME localhost
ENV APACHE_SERVERALIAS docker.localhost
ENV APACHE_DOCUMENTROOT /var/www


EXPOSE 80
VOLUME ["/var/log/apache2"]
ENTRYPOINT ["/usr/sbin/apache2", "-D", "FOREGROUND"]

#docker build -t jobmaker .
#docker run -d -P -v /var/www/jobmaker:/var/www/jobmaker jobmaker