#!/bin/bash

docker exec my-budget-php-1 php /app/vendor/bin/deptrac --report-uncovered --fail-on-uncovered $@
