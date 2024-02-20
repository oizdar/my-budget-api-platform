#!/bin/bash

docker exec -e PHP_CS_FIXER_IGNORE_ENV=true my-budget-php-1 php /app/vendor/bin/php-cs-fixer fix $@
