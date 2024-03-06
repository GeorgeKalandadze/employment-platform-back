<div style="display:flex; align-items: center">
  <h1 style="position:relative; top: -6px" >Employment Platform</h1>
</div>

---

In this employment platform website, you can view thousands of different vacancies and courses uploaded by user or company. Many features have been added:

-   JWT Authentication
-   Email Verification
-   Task Scheduling
-   Queues & Jobs
-   Update User Profile
-   Add Vacancy And Course To Favorite List
-   Rate Course
-   Follow Company And Get Email About Every New Vacancy Of This Company
-   Forgot Password
-   Reset Password
-   Upload User Resume

#

### Table of Contents

-   [Prerequisites](#prerequisites)
-   [Tech Stack](#tech-stack)
-   [Getting Started](#getting-started)
-   [Migrations](#migration)
-   [Development](#development)
-   [Resources](#resources)

#

### Prerequisites

-   <img src="https://raw.githubusercontent.com/RedberryInternship/example-project-laravel/7a054d64192f92566a0f48349002e0296a9d5347/readme/assets/php.svg" width="35" style="position: relative; top: 4px" /> *PHP@8.2 and up*
-   <img src="https://github.com/RedberryInternship/example-project-laravel/blob/master/readme/assets/mysql.png?raw=true" width="35" style="position: relative; top: 4px" /> _MYSQL@8 and up_
-   <img src="https://github.com/RedberryInternship/example-project-laravel/blob/master/readme/assets/npm.png?raw=true" width="35" style="position: relative; top: 4px" /> *npm@9.5 and up*
-   <img src="https://github.com/RedberryInternship/example-project-laravel/blob/master/readme/assets/composer.png?raw=true" width="35" style="position: relative; top: 6px" /> *composer@2.4 and up*

#

### Tech Stack

-   <img src="https://github.com/RedberryInternship/example-project-laravel/blob/master/readme/assets/laravel.png?raw=true" height="18" style="position: relative; top: 4px" /> [Laravel@10.x](https://laravel.com/docs/9.x) - back-end framework
-   <img src="https://jwt.io/img/pic_logo.svg" height="19" style="position: relative; top: 4px" /> [Jwt-auth](https://jwt-auth.readthedocs.io/) - package for authentication
-   [Laravel Telescope](https://jwt-auth.readthedocs.io/) - package for Debug laravel application

#

### Getting Started

1\. First of all you need to clone repository from github:

```sh
git clone https://github.com/RedberryInternship/giorgi-surmanidze-movie-quotes-back.git
```

2\. Install dependencies by running:

```sh
composer install
npm install
```

5\. Now we need to set our env file. Go to the root of your project and execute this command.

```sh
cp .env.example .env
```

6\. Next generate Laravel key:

```sh
php artisan key:generate
```

7\. link storage folder to public folder:

```sh
php artisan storage:link
```

And now you should provide **.env** file all the necessary environment variables:

#

**MYSQL:**

> DB_CONNECTION=mysql

> DB_HOST=127.0.0.1

> DB_PORT=3306

> DB_DATABASE=**\***

> DB_USERNAME=**\***

> DB_PASSWORD=**\***

#

**JWT:**

> JWT_SECRET=**\***

#

**App urls:**

> FRONT_BASE_URL=**\***

#

**Mailable:**

> MAIL_MAILER=**\***

> MAIL_HOST=**\***

> MAIL_PORT=465

> MAIL_USERNAME=**\***

> MAIL_PASSWORD=**\***

> MAIL_ENCRYPTION=**\***

> MAIL_FROM_ADDRESS=**\***

> MAIL_FROM_NAME="${APP_NAME}"

##### Now, you should be good to go!

#

### Migration

if you've completed getting started section, then migrating database if fairly simple process, just execute:

```sh
php artisan migrate
```

#

### Development

You can run Laravel's built-in development server by executing:

```sh
  php artisan serve
```

#

### Resources

Database structure in DrawSQL:
