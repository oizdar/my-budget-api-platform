#!/bin/bash
# Pobierz nazwę folderu nadrzędnego
PROJECT_FOLDER=$(basename $(dirname $(dirname $(dirname $(realpath $0)))))

# Ustaw nazwę kontenera Docker, używając nazwy folderu projektu
CONTAINER_NAME="${PROJECT_FOLDER}-php-1"

docker exec -e PHP_CS_FIXER_IGNORE_ENV=true  "$CONTAINER_NAME" php /app/vendor/bin/php-cs-fixer fix $@
