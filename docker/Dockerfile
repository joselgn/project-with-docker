 FROM centos/httpd
 LABEL maintainer="Jose Carlos Fernandes F. Filho <joselgn@gmail.com>"
 RUN yum install -y epel-release yum-utils http://rpms.remirepo.net/enterprise/remi-release-7.rpm
 RUN yum clean all && yum -y update --skip-broken && yum-config-manager --enable remi-php73 
 RUN yum install -y yum-utils wget unzip git php php-common php-opcache php-mcrypt php-cli php-gd php-curl php-mysqlnd php-mbstring php-xml php-intl  && yum clean all
#COPY ./codigo /var/www/html 
#RUN chmod -R 777 /var/www/html/storage 
 EXPOSE 80 443

