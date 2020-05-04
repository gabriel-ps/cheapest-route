

## Installation

Development environment requirements :
- [Docker](https://www.docker.com)
- [Docker Compose](https://docs.docker.com/compose/install/)
- [PHP Composer](https://getcomposer.org/)

Setting up your development environment on your local machine :
```bash
$ git clone https://github.com/gabriel-ps/cheapest-route.git
$ cd cheapest-route
$ cp .env.example .env
$ docker-compose build && docker-compose up -d
$ composer install
```

Now the API will be avaible on [http://localhost:8080](http://localhost:8080) or [http://192.168.99.100:8080](http://192.168.99.100:8080) on Windows.

### Alternatively

You can also use PHP development server:

```bash
$ git clone https://github.com/gabriel-ps/cheapest-route.git
$ cd cheapest-route
$ cp .env.example .env
$ composer install
$ php -S localhost:8000 -t ./public
```

## Just two routes

### GET /quote/{origin}/{destination}

Returns the cheapest route from origin to destination

### POST /route

Stores a new route

## Run tests with PHPUnit
```bash
# Global phpunit installation
phpunit

# Local installation - Linux/Mac
./vendor/bin/phpunit

# Local installation - Windows
.\vendor\bin\phpunit
```
