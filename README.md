# AVRillo-task

## Description
> Rest API serving random Kanye West quotes

A secure API connecting to the kanye.rest APIn

Clone from Github

```sh
git clone git@github.com:Domsab/AVRillo-task.git;
cd AVRillo-task/;
```

Composer install

```sh
composer install
```

Setup Laravel .env

```sh
cp .env.example .env
php artisan key:generate
```

Run Laravel Sail in detached mode

```sh
vendor/bin/sail up -d
```

Install npm packages

```sh
npm install
```

And finally run the application

```sh
vendor/bin/sail npm run dev
```
## Usage

Create a user via http://localhost

### Tests

```sh
./vendor/bin/sail test
```

