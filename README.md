## Инструкция

Для того, чтобы проверить работу импорта, нужно

1. Скопировать `.env.example` в свой `.env` 
2. Поменять переменные  `AMOCRM_*` в `.env` файле  на свои данные доступа
3. Скопировать `amocrm_token.json.example` в свой json файл и ввести необходимые данные доступа
4. `docker-compose up -d`
5. `docker-compose exec app php artisan amocrm:import:leads`

После запуска команды, в таблицах leads и companies должны появиться записи.
