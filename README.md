<br>

<div align="center">
<img width="456" src="https://raw.githubusercontent.com/wayofdev/laravel-cycle-starter-tpl/master/assets/logo.gh-light-mode-only.png#gh-light-mode-only">
<img width="456" src="https://raw.githubusercontent.com/wayofdev/laravel-cycle-starter-tpl/master/assets/logo.gh-dark-mode-only.png#gh-dark-mode-only">
</div>

<br>

<br>

<div align="center">
<a href="https://actions-badge.atrox.dev/wayofdev/laravel-cycle-starter-tpl/goto"><img alt="Build Status" src="https://img.shields.io/endpoint.svg?url=https%3A%2F%2Factions-badge.atrox.dev%2Fwayofdev%2Flaravel-cycle-starter-tpl%2Fbadge&style=flat-square"/></a>
<a href="https://github.com/wayofdev/laravel-cycle-starter-tpl/tags"><img alt="GitHub package.json version" src="https://img.shields.io/github/package-json/v/wayofdev/laravel-cycle-starter-tpl?style=flat-square"></a>
<a href="LICENSE.md"><img src="https://img.shields.io/github/license/wayofdev/laravel-cycle-starter-tpl.svg?style=flat-square&color=blue" alt="Software License"/></a>
<a href="#"><img alt="Commits since latest release" src="https://img.shields.io/github/commits-since/wayofdev/laravel-cycle-starter-tpl/latest?style=flat-square"></a>
<a href="https://app.codecov.io/gh/wayofdev/laravel-cycle-starter-tpl">
<img alt="Codecov" src="https://img.shields.io/codecov/c/gh/wayofdev/laravel-cycle-starter-tpl?style=flat-square"></a>
</div>

<br>

# Laravel Starter Template

This is an **opinionated** modified version of the Laravel framework which aims at providing a Domain-Driven Design (DDD) structure and using [CycleORM](https://cycle-orm.dev) instead of Eloquent.

## 📄 About

Laravel is a popular PHP web framework known for its simplicity, elegance and the Active Record ORM - Eloquent. Despite its popularity and convenience, Eloquent often comes in the way of projects that require a Domain-Driven Design (DDD) structure. This is due to Eloquent's active record pattern, which in practice can cause the violation of DDD principles, most notably the separation of the business logic from infrastructure code.

Understanding this challenge, we've introduced CycleORM in place of Eloquent in this starter template. CycleORM offers a DataMapper pattern which is a better fit for DDD as it helps to maintain a clear boundary between your business logic and database. This approach ensures that your domain rules and business logic can be modelled according to your needs, and not around the constraints of the active record pattern.

This repository provides a modified file structure for Laravel that follows DDD principles and tries to adhere to best practices, such as those outlined in Spatie's Laravel Beyond CRUD.

Our goal is to provide a starting point for building Laravel applications using a DDD approach with CycleORM, while still leveraging the power and convenience of the Laravel framework.

<br>

🙏 If you find this repository useful, consider giving it a ⭐️. Thank you!

<br>

## 🚀 Features

This starter template inherits the following features from its upstream template [wayofdev/laravel-starter-tpl](https://github.com/wayofdev/laravel-starter-tpl):

* **Added:**
  * Strict types declaration in all PHP files
  * Style checker package for custom rule-sets to php-cs-fixer — [wayofdev/php-cs-fixer-config](https://github.com/wayofdev/php-cs-fixer-config)
  * Static analysis tool — [PHPStan](https://phpstan.org) and it's extensions:
    * [phpstan/extension-installer](https://github.com/phpstan/extension-installer) — automatic installation of PHPStan extensions
    * [phpstan/phpstan-deprecation-rules](https://github.com/phpstan/phpstan-deprecation-rules) — rules for detecting usage of deprecated classes, methods, properties, constants and traits.
    * [nunomaduro/larastan](https://github.com/nunomaduro/larastan) — PHPStan integration with Laravel
  * [Pest](https://pestphp.com) testing framework
  * Github action workflows for:
    * Continuous integration which includes coding standards checks, unit testing and static analysis
    * Automatic pull-request labeling
    * [Deployer](https://deployer.org) for automatic deployments to staging and production servers with support of [Github Environments](https://docs.github.com/en/actions/deployment/targeting-different-environments/using-environments-for-deployment)
  * [ergebnis/composer-normalize](https://github.com/ergebnis/composer-normalize) composer plugin for normalizing composer.json file
  * [roave/securityadvisories](https://github.com/Roave/SecurityAdvisories) package to ensure that application doesn't have installed dependencies with known security vulnerabilities.
  * Application dockerization using docker-compose and Makefile — use `make help` to view available commands
  * Git pre-commit hooks using [pre-commit](https://pre-commit.com) package
* **Changed:**
  * Marked default Laravel classes as `final`
  * Modified file structure to meet DDD principles
  * Changed config folder files to use default PHP multi-line comment style
* **Removed:**
  * Dependencies like Laravel Sanctum, Laravel Pint, and Laravel Sail.
  * Broadcasting service provider and it's routes. It can be added back, if it will be required for project
  * Console routes in favor of Command classes.
  * Sanctum migration files

Following the inherited features, this starter template also introduces a set of additional modifications from the upstream template, [wayofdev/laravel-starter-tpl](https://github.com/wayofdev/laravel-starter-tpl):

* **Added:**
  * CycleORM support via [wayofdev/laravel-cycle-orm-adapter](https://github.com/wayofdev/laravel-cycle-orm-adapter) - This introduces the DataMapper pattern, which is more compatible with DDD principles, replacing Laravel's default Eloquent ORM which uses the Active Record pattern.
* **Changed:**
  * Deployer script uses custom task to run Cycle ORM migrations instead of Eloquent migrations
* **Removed:**
  * Default Laravel Eloquent migrations - As we're using CycleORM, the default Eloquent migrations are no longer necessary and have been removed to prevent conflicts.

<br>

## 🚩 Requirements

To use this repository, you need to meet the following requirements:

- **macOS** Monterey+ or **Linux**
- Docker 20.10 or newer
  - [How To Install and Use Docker on Ubuntu 22.04](https://www.digitalocean.com/community/tutorials/how-to-install-and-use-docker-on-ubuntu-22-04)
- Installed **dnsmasq** service, running in the system. You can use [ansible-role-dnsmasq](https://github.com/wayofdev/ansible-role-dnsmasq) to install and configure this service.
- **Cloned, configured and running** [docker-shared-services](https://github.com/wayofdev/docker-shared-services) to support system-wide DNS, routing, and TLS support via Traefik.

<br>

## 💿 Installation

> Warning: You should configure, set up, and run the [docker-shared-services](https://github.com/wayofdev/docker-shared-services) repository to ensure system-wide TLS and DNS support.

1. **Clone** repository:

   After forking or creating generating repository from template, you can clone it to your local machine. In this example we will use `laravel-cycle-starter-tpl` repository as starting point.

   ```bash
   $ git clone git@github.com:wayofdev/laravel-cycle-starter-tpl.git
   ```

2. **Generate** `.env` file

   Generate .env file from .env.example file using Makefile command:

   ```bash
   $ make env \
       APP_NAME=laravel \
       SHARED_SERVICES_NAMESPACE=ss \
       PROJECT_SERVICES_NAMESPACE=wod \
       COMPOSE_PROJECT_NAME=laravel-cycle-starter-tpl
   ```

   **Change** generated `.env` file to match your needs, if needed.

   (Optional): to re-generate `.env` file, add `FORCE=true` to the end of command:

   ```bash
   $ make env \
       APP_NAME=laravel \
       SHARED_SERVICES_NAMESPACE=ss \
       PROJECT_SERVICES_NAMESPACE=wod \
       COMPOSE_PROJECT_NAME=laravel-cycle-starter-tpl \
       FORCE=true
   ```

3. **Build**, install and run. This will also generate Laravel app key:

   ```bash
   $ make

   # or run commands separately
   $ make hooks
   $ make install
   $ make key
   $ make prepare
   $ make up
   ```

<br>

## 🤝 License

[![Licence](https://img.shields.io/github/license/wayofdev/laravel-cycle-starter-tpl?style=for-the-badge&color=blue)](./LICENSE)

<br>

## 🧱 Credits and Useful Resources

Useful resources about Laravel and DDD approach:

* [Laravel Beyond CRUD](https://spatie.be/products/laravel-beyond-crud)
* [Laravel Skeleton](https://romanzipp.github.io/Laravel-Skeleton/) by [romanzipp](https://github.com/romanzipp)

<br>

## 🙆🏼‍♂️ Author Information

This repository was created in **2022** by [lotyp / wayofdev](https://github.com/wayofdev).

<br>

## 🙌 Want to Contribute?

Thank you for considering contributing to the wayofdev community!
We are open to all kinds of contributions. If you want to:

- 🤔 Suggest a feature
- 🐛 Report an issue
- 📖 Improve documentation
- 👨‍💻 Contribute to the code

<br>
