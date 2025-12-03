# Cart Task

Laravel додаток для управління кошиком покупок.

## Розгортання через Docker

### Передумови

- Docker (версія 20.10 або вище)
- Docker Compose (версія 2.0 або вище)

### Кроки розгортання

1. **Клонування репозиторію**

   ```bash
   git clone <repository-url>
   cd cart-task
   ```

2. **Налаштування змінних середовища**
   - Скопіюйте файл `.env.example` в `.env`:
     ```bash
     cp .env.example .env
     ```
   - Відредагуйте `.env` файл і налаштуйте наступні параметри:
     ```
     APP_NAME="Cart Task"
     APP_ENV=local
     APP_KEY=  # Залиште порожнім, буде згенеровано автоматично
     APP_DEBUG=true
     APP_URL=http://localhost:8080

     DB_CONNECTION=mysql
     DB_HOST=db
     DB_PORT=3306
     DB_DATABASE=laravel
     DB_USERNAME=laravel
     DB_PASSWORD=password

     # Інші налаштування за потребою
     ```

3. **Запуск контейнерів**

   ```bash
   docker-compose up --build -d
   ```
   - `--build` - збірка образів
   - `-d` - запуск в фоновому режимі

4. **Генерація ключа додатку**

   ```bash
   docker-compose exec app php artisan key:generate
   ```

5. **Запуск міграцій бази даних**

   ```bash
   docker-compose exec app php artisan migrate
   ```

6. **Запуск сидерів (якщо потрібно)**

   ```bash
   docker-compose exec app php artisan db:seed
   ```
   - Це додасть тестових користувачів (test@example.com / password) та товари.

7. **Збірка фронтенд ресурсів (якщо потрібно)**

   ```bash
   docker-compose exec app npm run build
   ```

### Доступ до додатку

- Веб-додаток: `http://localhost:8080`
- phpMyAdmin (адмінка БД): `http://localhost:8081`
- База даних: localhost:3306 (зовнішній доступ, якщо потрібно)

### Корисні команди

- **Перегляд логів:**

  ```bash
  docker-compose logs -f
  ```

  

- **Зупинка контейнерів:**

  ```bash
  docker-compose down
  ```

  

- **Перезапуск контейнерів:**

  ```bash
  docker-compose restart
  ```

  

- **Виконання команд в контейнері додатку:**

  ```bash
  docker-compose exec app <command>
  ```

  

- **Очищення (видалення контейнерів, мереж та volumes):**

  ```bash
  docker-compose down -v
  ```

### Структура контейнерів

- **app**: PHP-FPM контейнер з Laravel додатком
- **web**: Nginx веб-сервер
- **db**: MySQL база даних
- **phpmyadmin**: phpMyAdmin для управління базою даних

### Налаштування

- Nginx конфігурація: `docker/nginx/conf.d/default.conf`
- Docker Compose: `docker-compose.yml`
- Dockerfile: `Dockerfile`

### Troubleshooting

- Якщо порт 8080 зайнятий, змініть в `docker-compose.yml`
- Перевірте логи контейнерів при помилках
- Переконайтеся, що `.env` файл правильно налаштований
