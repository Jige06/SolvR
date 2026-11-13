# Image officielle : PHP 8.3 + Apache
FROM php:8.5-apache

# Modules Apache présents chez la plupart des hébergeurs mutualisés
# rewrite : URLs propres et redirections via .htaccess
# headers : en-têtes de sécurité via .htaccess
RUN a2enmod rewrite headers

# Autorise les .htaccess et interdit le listage des dossiers
RUN printf '<Directory /var/www/html>\n    Options -Indexes\n    AllowOverride All\n</Directory>\n' \
      > /etc/apache2/conf-available/solvr.conf \
    && a2enconf solvr

# Supprime l'avertissement "Could not reliably determine the server's name"
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

# Configuration PHP de développement : erreurs affichées
RUN cp "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini"

# Composer (gestionnaire de dépendances PHP) + unzip pour décompresser les paquets
RUN apt-get update \
    && apt-get install -y --no-install-recommends unzip \
    && rm -rf /var/lib/apt/lists/*
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
ENV COMPOSER_ALLOW_SUPERUSER=1