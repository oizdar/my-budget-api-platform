#!/bin/bash

# Pobierz nazwę folderu nadrzędnego
PROJECT_FOLDER=$(basename $(dirname $(dirname $(dirname $(realpath $0)))))

# Ustaw nazwę kontenera Docker, używając nazwy folderu projektu
CONTAINER_NAME="${PROJECT_FOLDER}-php-1"

# Uruchom polecenie w kontenerze Docker
docker exec "$CONTAINER_NAME" php /app/bin/console "$@"
