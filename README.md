# Системные требования

php: >= 7.1

# Установка

 1. Скопировать содержимое файла .env.example в .env, указав свои настройки.
    Параметр ENV  может быть в следующих режимах: production,
    development и test.
 2. Установить зависимые пакеты `composer install`
 3. Выполнить миграции `vendor/bin/phinx-migrations migrate`
 4. После установки сделать дамп БД для тестов и сохранить в файл `/tests/_data/dump.sql`

# Тестирование

Запускается из консоли `vendor/bin/codecept run api`
