# 🐳 Docker + PHP 8 + MySQL + Nginx + Symfony 5 

## Description

This is a complete stack for running Symfony 5 into Docker containers using docker-compose tool.

It is composed by 3 containers:

- `nginx`, acting as the webserver.
- `php`, the PHP-FPM container with the 8 PHPversion.
- `db` which is the MySQL database container with a **MySQL 8.0** image.

## Installation

1. 😀 Clone this rep.

2. Run `docker-compose up -d`

3. The 3 containers are deployed: 

```
Creating symfony-docker_db_1    ... done
Creating symfony-docker_php_1   ... done
Creating symfony-docker_nginx_1 ... done
```

4. Use this value for the DATABASE_URL environment variable of Symfony:

```
DATABASE_URL=mysql://app_user:helloworld@db:3306/app_db?serverVersion=5.7
```

You could change the name, user and password of the database in the `env` file at the root of the project.

#FIRST EXCUTE
Enter in the container php and execute
```
composer install
```
And enter in folder /var/www/symfony
```
npm install
```

Execute Scheme Create
```
php bin/console doctrine:schema:create
```

Create in /var/www/symfony/public/ folder uploads and inside movie

# Command for create User

In folder symfony
```
app:user:create <username> <email> <password> <role>
```

Roles availables: 
ROLE_ADMIN
ROLE_USER

# TO COMPILE SCSS AND JS
Execute in /var/www/symfony/

```
npm run watch 
```
for listen change in directory /var/www/symfony/assets

# ROADMAP - NEXT STEPS
- Pagination List Movies
- Flashbag sistem to show application message
- Finish events when change status rent
- Change ORM mapping with YAML (Deprecate in doctrine 3.0)
- Register validate with Token
- Testing
- Workflow for change status rent
- Front 
- Read api for import movies

