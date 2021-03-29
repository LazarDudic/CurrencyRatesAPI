<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

## Currency Rates API

Simple API which provides you with current rates daily.

<h3>Installation</h3>

- Clone project from Git.
```bash
git clone https://github.com/Lazar90/CurrencyRatesAPI
```

- Move terminal to project location.
```bash
cd CurrencyRatesAPI
```
- Create and Set up your .env file by copying .env.example file.
    * Fill in a database information.
        
- Install dependencies.
```bash
composer install
```

-  Generate the application key.
```bash
php artisan key:generate
``````

- Run migration.
```bash
php artisan migrate
``````

- Run api.
```bash
php artisan serve
``````
<h3>Configuration</h3> 

To scrap rates on your local development machine you need to call. 

```bash
php artisan schedule:work
``````

On your server please chek out Laravel Documentation 
<a href="https://laravel.com/docs/8.x/scheduling#running-the-scheduler" target="_blank">here</a>

Scraping currency rates will be updated daily at 07:55am UTC.
History will be updated at 08:00am UTC.

To change hours of updates visit App\Console\Kernel.php.
Make sure scrapping is always before history update.

<h3>Usage</h3> 

Using this api is only available through the Postman.

- Register
    * Provide: name, email, password
    * /api/register on POST method
    
- Login
    * Provide: email, password
    * /api/login on POST method
    * As a response you will get api token.
    
- Copy token and past to Postman Authorisation using Bearer Token type.

- Afterwards you are allowed to use api routes.
    * /api/latest
    * /api/latest?base=CAD
    * /api/latest?base=CAD&symbols=EUR,USD
    * /api/history/2021-03-28
    * /api/history/2021-03-28?base=CAD&symbols=EUR,USD
    * /api/history?start_at=2021-03-28&end_at=2021-03-30
    * /api/history?start_at=2021-03-28&end_at=2021-03-30&base=CAD&symbols=EUR,USD
    
