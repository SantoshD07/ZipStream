FROM httpd:latest

COPY index.html /usr/local/apache2/htdocs/
COPY zip.php /usr/local/apache2/htdocs/
COPY conf/httpd.conf /usr/local/apache2/conf/