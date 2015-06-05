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
