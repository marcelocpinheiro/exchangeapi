# Currency Exchange API 


This example api was created to a coding challenge. 

# Setup

- Install de composer packages.
```sh
composer install
```
- Make sure that the .env file is present. If its not, just create one on the application root and put this line inside it. You can put any currency you want, just remember that it must exist (duh) and separate them with a comma, just like the above line
```sh
CURRENCIES=GBP,USD,BRL
BASEURL=https://api.exchangeratesapi.io
```
- Then serve the application (you can use any server. Here, we are using the built-in php development server)
```sh
php -S localhost:8000
```
- There are two URLS on this app: /exchange and /recomendation. Just access `http://localhost:8000/exchange` or `http://localhost:8000/recomendation` to see it working 


Hope you like it, guys :)
