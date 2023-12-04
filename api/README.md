# API

The API will be here.

Refer to the [Getting Started Guide](https://api-platform.com/docs/distribution) for more information.


# DDD

## Infrastructure
- Controllers
- Databases
- Caches
- Vendors

## Application
- Use cases
- Application services
- DTOs
- Commands
- Queries

## Domain
- Models
- Value Objects
- Events
- Repositiories

# You can depend only to the same layer or the lower lvl layer
- Domain can depend on Domain
- Application can depend on Aplication and on Domain
- Infrastructure can depend on Infrastructure and on Application and on Domain
