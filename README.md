Thanks to Blacking7 for his help

https://github.com/blacking7/free-text-property-search

I haven't written any phpdoc. This is bad... But I am actually working on a very old mac
without my beloved phpstorm to help me. For that reason, I gave up... But I could write them.

### php configuration
1. >=5.4

2. short_open_tag = On

### dependencies
composer

### folders and permission
mkdir log cache

chmod -R 777 log/ cache/

### install composer dependencies
composer install

### run tests
ant phpunit

### check coding synthax
ant phpcs

### start app with php webserver embed
cd public

php -S localhost:7777
