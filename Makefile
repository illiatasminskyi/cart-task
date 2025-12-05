# Laravel Project Makefile

.PHONY: help install dev build serve clean d-build d-up d-down d-restart d-logs d-exec d-art d-artisan d-clean d-migrate d-migrate-fresh d-migrate-seed d-seed d-optimize d-storage-link d-key d-init

# Змінні
PHP := php
COMPOSER := composer
NPM := npm
ARTISAN := $(PHP) artisan
DOCKER_COMPOSE := docker-compose
DOCKER_APP := app

# Допомога
help:
	@echo "Laravel Project Commands:"
	@echo ""
	@echo "Local Development:"
	@echo "  make install    - Встановити залежності"
	@echo "  make dev        - Запустити розробку"
	@echo "  make serve      - Запустити сервер"
	@echo "  make build      - Зібрати фронтенд"
	@echo "  make clean      - Очистити кеш"
	@echo ""
	@echo "Docker Commands (d-*):"
	@echo "  make d-build         - Зібрати Docker образи"
	@echo "  make d-up            - Запустити Docker контейнери"
	@echo "  make d-down          - Зупинити Docker контейнери"
	@echo "  make d-restart       - Перезапустити Docker контейнери"
	@echo "  make d-logs          - Показати логи контейнерів"
	@echo "  make d-exec          - Зайти в контейнер app"
	@echo "  make d-art cmd='...' - Виконати artisan команду (спосіб 1)"
	@echo "  make d-artisan ...   - Виконати artisan команду (спосіб 2)"
	@echo "  make d-clean         - Очистити кеш в Docker"
	@echo "  make d-migrate       - Запустити міграції"
	@echo "  make d-migrate-fresh - Міграції з очисткою БД"
	@echo "  make d-migrate-seed  - Міграції + seeders"
	@echo "  make d-seed          - Запустити seeders"
	@echo "  make d-optimize      - Оптимізувати додаток"
	@echo "  make d-storage-link  - Створити симлінк storage"
	@echo "  make d-key           - Згенерувати ключ додатку"
	@echo "  make d-init          - Повне налаштування (збірка+запуск+міграції)"

# Встановлення залежностей
install:
	$(COMPOSER) install
	$(NPM) install

# Запуск середовища розробки
dev:
	$(COMPOSER) run dev

# Запуск Laravel серверу
serve:
	$(ARTISAN) serve

# Збірка фронтенду
build:
	$(NPM) run build

# Очистка кешу
clean:
	$(ARTISAN) config:clear
	$(ARTISAN) cache:clear
	$(ARTISAN) route:clear
	$(ARTISAN) view:clear
	$(ARTISAN) optimize
	$(NPM) run build

# ============================================
# Docker Commands (короткі алиаси: d-*)
# ============================================

# Зібрати Docker образи
d-build:
	$(DOCKER_COMPOSE) build --no-cache

# Запустити Docker контейнери
d-up:
	$(DOCKER_COMPOSE) up -d

# Зупинити Docker контейнери
d-down:
	$(DOCKER_COMPOSE) down

# Перезапустити Docker контейнери
d-restart:
	$(DOCKER_COMPOSE) restart
	@echo "🧹 Очищення кешу..."
	@$(MAKE) d-clean

# Показати логи контейнерів
d-logs:
	$(DOCKER_COMPOSE) logs -f

# Зайти в контейнер app
d-exec:
	$(DOCKER_COMPOSE) exec $(DOCKER_APP) bash

# Виконати artisan команду в Docker (використання: make d-art cmd="migrate")
d-art:
	$(DOCKER_COMPOSE) exec $(DOCKER_APP) php artisan $(cmd)

# Варіант з передачею аргументів після команди (використання: make d-artisan migrate)
d-artisan:
	$(DOCKER_COMPOSE) exec $(DOCKER_APP) php artisan $(filter-out $@,$(MAKECMDGOALS))

# Очистити кеш в Docker
d-clean:
	$(DOCKER_COMPOSE) exec $(DOCKER_APP) php artisan config:clear
	$(DOCKER_COMPOSE) exec $(DOCKER_APP) php artisan cache:clear
	$(DOCKER_COMPOSE) exec $(DOCKER_APP) php artisan route:clear
	$(DOCKER_COMPOSE) exec $(DOCKER_APP) php artisan view:clear
	$(DOCKER_COMPOSE) exec $(DOCKER_APP) php artisan optimize
	$(DOCKER_COMPOSE) exec $(DOCKER_APP) $(NPM) run build

# Запустити міграції в Docker
d-migrate:
	$(DOCKER_COMPOSE) exec $(DOCKER_APP) php artisan migrate

# Запустити міграції з rollback
d-migrate-fresh:
	$(DOCKER_COMPOSE) exec $(DOCKER_APP) php artisan migrate:fresh

# Запустити міграції з seed
d-migrate-seed:
	$(DOCKER_COMPOSE) exec $(DOCKER_APP) php artisan migrate --seed

# Запустити seeders
d-seed:
	$(DOCKER_COMPOSE) exec $(DOCKER_APP) php artisan db:seed

# Оптимізувати додаток
d-optimize:
	$(DOCKER_COMPOSE) exec $(DOCKER_APP) php artisan optimize

# Створити симлінк для storage
d-storage-link:
	$(DOCKER_COMPOSE) exec $(DOCKER_APP) php artisan storage:link

# Генерація ключа додатку в Docker
d-key:
	$(DOCKER_COMPOSE) exec $(DOCKER_APP) php artisan key:generate

# Повний запуск Docker (збірка + запуск + міграції)
d-init:
	@echo "🐳 Початкове налаштування Docker..."
	$(DOCKER_COMPOSE) up -d --build
	@echo "⏳ Очікування запуску контейнерів..."
	sleep 5
	@echo "🔑 Генерація ключа додатку..."
	$(DOCKER_COMPOSE) exec $(DOCKER_APP) php artisan key:generate
	@echo "🗄️  Запуск міграцій..."
	$(DOCKER_COMPOSE) exec $(DOCKER_APP) php artisan migrate
	@echo "✅ Docker середовище готове!"

# Ігноруємо аргументи як цілі для d-artisan
%:
	@:

# За замовчуванням показуємо допомогу
default: help
