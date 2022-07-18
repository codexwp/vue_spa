# SPA with Vue Cli and Lumen
## Requirements
- Lumen 8.3.4
- Laravel Components ^8.0
- nodejs 12.14
- PHP >= 8.0
- MySQL >= 5.7
- OpenSSL PHP Extension
- PDO PHP Extension
- Mbstring PHP Extension

## Installation
Open Terminal and Clone the repository
```
$ git clone https://github.com/codexwp/vue_spa.git
```
### Backend Configuration
```
$ cd vue_spa/backend
$ composer install
$ cp .env.example .env
```
Set value on the following environment variable
- APP_KEY
- DB_DATABASE
- DB_USERNAME
- DB_PASSWORD
- JWT_SECRET
- JWT_TTL
- AUTH_COOKIE_NAME
```
$ php artisan migrate --seed
$ php -S localhost:8000 -t public
```
Now your API host is running on http://localhost:8000/

### Frontend Configuration
```
$ cd ..
$ cd frontend
$ npm install
$ npm run serve
```
Now your frontend is running on http://localhost:8080/

## Default Credentials
- Username : api@lumen.com
- Password : 123456

