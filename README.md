# CSI 2132: Databases I

> Dilanga says hello!

This repository contains the final project for the Databases I course. This project makes use of Docker in order to complete the initial setup and to get you setup as quickly as possible.

## Setup

1. Download Docker.
2. Pull this repository to your system.
3. Create a file named `php.ini` inside of the `sites` directory. `<YOUR USERNAME>` and `<YOUR PASSWORD>` must be the same as in the `docker-compose.yml` file. The `php.ini` file will contain the following

```
[php]
register_globals = true
track_errors = true
include_path = "/var/www/sites/public"

[database]
driver = pgsql
host = postgresql
port = 5432
schema = test
db_name = postgres
username = <YOUR USERNAME>
password = <YOUR PASSWORD>
```

## Running the Webserver

Once you have completed the steps above, your directory structure should look like this

```
sites
.
├── build
│   └── nginx.conf
├── data
│   └── postgres
│       └── postgresql.conf
├── public
│   ├── res
│   │   ├── bootstrap-native.min.js
│   │   └── vue.js
│   ├── index.php
│   ├── Model.php
│   ├── PDOLoader.php
│   └── Person.php
├── scripts
│   └── init.sql
├── docker-compose.yml
├── Dockerfile
├── php.ini
├── postgre.docker
├── postgresql.conf
├── pq-setup.docker
├── psql.docker
├── set-config.sh
├── test.sh
└── README.md
```
