## Description
> Rest API serving random Kanye West quotes

A secure API connecting to the kanye.rest API
## Getting Started

### Prerequisites

The things you need before installing the software.

- PHP 8.2
- Composer
- Node
- Docker
### Installation

Clone from Github

```sh
git clone git@github.com:Domsab/AVRillo-task.git
cd AVRillo-task/
```

Composer install

```sh
composer install
```

Setup Laravel .env & database

```sh
cp .env.example .env
php artisan key:generate
vendor/bin/sail artisan migrate
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

Create a user via http://localhost or by running the following command

```sh
./vendor/bin/sail artisan api:manage-users
```
### Tests

```sh
./vendor/bin/sail test
```
