FROM php:7.1-fpm

RUN apt-get update

RUN echo "Installing PHP Docker..."

# Install Postgre PDO
RUN apt-get install -y libpq-dev && \
    docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql && \
    docker-php-ext-install pdo pdo_pgsql pgsql

# COPY postgresql.conf /postgresql.conf
# COPY postgresql.conf /etc/postgresql
# COPY set-config.sh /docker-entrypoint-initdb.d/set-config.sh
# RUN sed -i -e"s/^#listen_addresses =.*$/listen_addresses = '*'/" /var/lib/postgresql/data/postgresql.conf
# RUN echo "host    all    all    0.0.0.0/0    md5" >> /var/lib/postgresql/data/pg_hba.conf

