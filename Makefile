.PHONY: up down reset-db migrate test logs ps help make-test

up: ## Sobe os serviços
	@docker compose up -d

down: ## Para os serviços
	@docker compose down

reset-db: ## ⚠️ Apaga volumes e recria tudo
	@docker compose down -v
	@docker compose up -d

migrate: ## Roda migrations no ambiente de DEV
	@docker compose exec frankenphp bash -lc 'cd /app/backend && php artisan migrate'

test: ## Roda a suíte de testes (usa .env.testing)
	@docker compose exec frankenphp bash -lc 'cd /app/backend && php artisan test'

logs: ## Segue logs do frankenphp e mariadb
	@docker compose logs -f frankenphp mariadb

ps: ## Mostra status dos serviços
	@docker compose ps

help: ## Mostra esta ajuda
	@grep -E '^[a-zA-Z0-9_-]+:.*?##' Makefile | awk -F':|##' '{printf "\033[36m%-12s\033[0m %s\n", $$1, $$3}'

make-test: ## Gera um teste Laravel (feature por padrão, ou unit com TYPE=unit) NAME=NomeDoTeste
	@if [ -z "$(NAME)" ]; then \
	  echo "Uso: make make-test NAME=Cart/AddItem [TYPE=unit|feature]"; \
	  echo "Ex.:  make make-test NAME=Cart/AddItem"; \
	  echo "      make make-test NAME=PricingService TYPE=unit"; \
	  exit 2; \
	fi
	@name='$(NAME)'; \
	# garante sufixo Test
	case "$$name" in *Test) ;; *) name="$$name"Test ;; esac; \
	# decide opções do artisan
	opts=""; \
	if [ "$(TYPE)" = "unit" ]; then opts="--unit"; fi; \
	echo ">> Criando teste: $$name (TYPE=$(TYPE))"; \
	docker compose exec frankenphp bash -lc "cd /app/backend && php artisan make:test $$name $$opts"