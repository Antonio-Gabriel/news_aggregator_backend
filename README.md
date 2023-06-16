<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## News aggregator App

The application consists in pulls articles from various sources:

For this demo I've used only two providers because another has error to load the articles.

## Get started

First install docker in your device or copy the project in your local server and create a database with the name `newsaggregatordb`.

Rename the `.env.example` file to `.env` and add the key for external apis

After run the commands bellow.

With docker:
```bash
# ubuntu
sudo docker-compose up

# or
docker-compose up
```

Without docker:

After copy the project for your local server:
Follow the instructions

```bash
composer install

# ubuntu
sudo bash.sh

# or
bash.sh
```

When the app is running to access the docummentations:

[http://0.0.0.0:8080/api/documentation](http://0.0.0.0:8080/api/documentation)

The default user credentials to auth is:

```json
{
    "email": "antoniogabriel@gmail.com",
    "password": "antoniogabriel"
}
```

## License

The news aggregator app is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
