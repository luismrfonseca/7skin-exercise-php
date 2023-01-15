# Installation Guide

## Setup Database

Create a database and execute the script db/init-db.sql

## Configuration of database connection

Create a .env file to configure the DBHOST, DBNAME, DBUSERNAME, DBPASSWORD

## Instalation on Server
```bash
composer install

composer dump-autoload
```

# Endpoint

## GET - /persons/

Get all persons of database

## GET - /persons/:id

Get a person by Id

## POST - /persons/

Create a person with name, gender (MALE, FEMALE) and age.

## DELETE - /persons/:id

Delete a person by Id


# License

[MIT](https://choosealicense.com/licenses/mit/)