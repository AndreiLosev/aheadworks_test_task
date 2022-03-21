* how run
* git clone https://github.com/AndreiLosev/aheadworks_test_task.git
* cd aheadworks_test_task
* mkdir var var/log var/db public/js && mv .env.example .env && composer install && npm i && docker-compose up -d && npm run build
* docker exec -it php bash
* *** создать базу данных с именем "test_task" из браузреа locahost:8080, ***
* php artisan migrate:fresh --seed
* php artisan queue:work
