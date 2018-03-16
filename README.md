# CSI 2132: Databases I

This repository contains the final project for the Databases I course. This project makes use of Docker in order to complete the initial setup and to get you setup as quickly as possible.

## Setup

1. Download Docker.
2. Pull this repository to your system.
3. Create a file titled `db-config.ini` inside of the `sites` folder. This file will look like

```
[database]
driver = pgsql
host = postgresql
port = 5432
schema = postgres
username = <YOUR USERNAME>
password = <YOUR PASSWORD>
```

4. `<YOUR USERNAME>` and `<YOUR PASSWORD>` must be the same as in the `docker-compose.yml` file.
5. Create a file named `php.ini` inside of the `sites` directory. This file will contain the following

```
; any text on a line after an unquoted semicolon (;) is ignored
[php] ; section markers (text within square brackets) are also ignored
; Boolean values can be set to either:
;    true, on, yes
; or false, off, no, none
register_globals = off
track_errors = yes

; you can enclose strings in double-quotes
include_path = "/var/www/sites/public"

; backslashes are treated the same as any other character
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
├── db-config.ini
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
