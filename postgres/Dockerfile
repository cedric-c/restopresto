FROM postgres:latest

# COPY db-create.sql /docker-entrypoint-initdb.d/
COPY postgresql.conf /postgresql.conf
COPY postgresql.conf /tmp/postgresql.conf
COPY postgresql.conf /etc/postgresql
COPY set-config.sh /docker-entrypoint-initdb.d/set-config.sh
###RUN sed -i -e"s/^#listen_addresses =.*$/listen_addresses = '*'/" /var/lib/postgresql/data/postgresql.conf
###RUN echo "host    all    all    0.0.0.0/0    md5" >> /var/lib/postgresql/data/pg_hba.conf
