#!/bin/sh

php bin/console ckeditor:install --tag=4.22.1
php bin/console c:c --env=prod --no-debug
php bin/console assets:install web --symlink