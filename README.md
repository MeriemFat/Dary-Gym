<p align="center"><img src="https://symfony.com/images/logos/header-logo.svg"></p>
# **DaryGYm**
- salle de sport back_office and front_office


# **Requirements**
- PHP >=7.1
- Symfony 4.4.*
- MySQL



# **SETUP**
1 - Install all dependencies :

~~~
    composer update
~~~


2 - Create database using the next command:
~~~
    php bin/console doctrine:schema:create
~~~

3 - Create scheme using migration command:
~~~
    php bin/console doctrine:migrations:migrate
~~~

4 - You will need to populate your database using fixtures for login.

Run:

~~~
    php bin/console doctrine:fixtures:load
~~~
5- install web server 
~~~
   composer require --dev symfony/web-server-bundle
~~~

6- run 
~~~
   php bin/console server:run
~~~


**ENJOY**
