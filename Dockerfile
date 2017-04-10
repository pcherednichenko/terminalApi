FROM jcherqui/docker-silex

COPY /composer.json /var/www/composer.json

RUN cd /var/www/ && composer update

RUN chown -R www-data /var/www/web/
RUN su - www-data && npm install && npm run typings install && npm run tsc
