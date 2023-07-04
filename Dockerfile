FROM httpd:bullseye
COPY . /usr/local/apache2/htdocs/
# WORKDIR /usr/local/apache2/htdocs/

COPY --from=composer /usr/bin/composer /usr/bin/composer
VOLUME . /usr/local/apache2/htdocs/
EXPOSE 8080 443
# CMD [ "php", "./your-script.php" ]
CMD ["apachectl", "-D", "FOREGROUND"]

