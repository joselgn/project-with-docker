 FROM centos/httpd
 LABEL maintainer="Jose Carlos Fernandes F. Filho <joselgn@gmail.com>"
 RUN yum install -y epel-release yum-utils http://rpms.remirepo.net/enterprise/remi-release-7.rpm && yum clean all && yum -y update --skip-broken && yum-config-manager --enable remi-php73 
 RUN yum install -y yum-utils wget unzip git php php-common php-opcache php-mcrypt php-cli php-gd php-curl php-mysqlnd php-mbstring php-xml php-intl  && yum clean all
 COPY ./codigo /var/www/html
 COPY ./config-container.sh /var/www/html
 RUN chmod -R 777 /var/www/html && cd /var/www/html && php composer.phar install && php composer.phar update
 EXPOSE 80 443

