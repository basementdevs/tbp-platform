# Default target
.DEFAULT_GOAL := help

# Commands
test: ## Run tests
	@php artisan test

coverage: ## Run tests with coverage
	@php artisan test --coverage --min=90

pint: ## Run Pint code style fixer
	@$(CURDIR)/vendor/bin/pint --no-interaction --test --preset=laravel

help: ## Show this help
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-20s\033[0m %s\n", $$1, $$2}'
