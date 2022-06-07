**KpiDashboard for Developers.nl**

---

## build/run the project with make

1. Rename the **.env.example** file to **.env** with your own data.
2. Run **make build** in the main directory.
3. Run **make up** in the main directory.


## build the project without make
1. Run `docker-compose build` to build the containers.
2. After that install npm `docker-compose run --rm nodejs_kpi_dashboard npm install`
3. After that run dev `docker-compose run --rm nodejs_kpi_dashboard npm run dev`
4. After that run the migrations `docker-compose run --rm php_kpi_dashboard php artisan migrate`
5. After that create seeds `docker-compose run --rm php_kpi_dashboard php artisan db:seed --class=DatabaseSeeder`
     
## run the project without make
1. Startup docker containers `docker-compose up -d`
2. Run npm watch `docker-compose run --rm -d nodejs_kpi_dashboard npm run watch`
3. open the dashboard on "http://localhost:8080/dashboard"