## Setup

This is a containerized solution developed and tested with docker container. In order to setup this application is necessary to execute the following commands on the order that they are presented:

- Run **docker-compose build app** inside this folder
- Run **docker-compose up -d** following the above command
- Optionally, you can run **docker-compose ps**, to verify if all needed containers started correctly
- Run **docker-compose exec app composer install** to install the necessary dependencies
- Run **docker-compose exec app php artisan migrate --seed** to run the migrations and the users seeder, preparing the database for the API to use
- After that, the application will be available to use. One can post call: **http://127.0.0.1:8000/api/funds/index** to test the api and see it working
- To access PhpMyAdmin mysql db one need to use the DB_HOST, DB_USERNAME and DB_PASSWORD on the login screen.

# Containers
As this is a containerized solution, was necessary to setup some specific containers in order to make the application work and to make easier for one that is currently running it. Below I'll explain each one of the containers and why it was necessary:

- db and testing-db containers: two mysql containers, one for the application database and the other to run the feature tests.
- app container: containers that host the application files
- nginx container: container for nginx web server service
- phpmyadmin container: this one could be excluded, is not necessary for the application to work, but it's an easier way to access the container database

## Tests

This solutions has it's own database container for testing, so after setting up the above, you can run the tests directly. Steps needed to run the integration tests:
- Run **docker-compose exec app php artisan migrate --database=mysql_testing** to create the tables on the testing db
- Run **docker-compose exec app php artisan test** will execute all the main test cases.

I didn't wrote tests for all scenarios, it's just an example of how it could be tested in a real scenario.

## Rest Api

The rest api has 5 main routes, that you might find under 'routes/api.php'. Below are the explanation to each endpoint, in the order that one'll find at the routes file:

- **GET /fund/duplicates/{fund_manager_id}: ** returns the possibly duplicated funds for a fund manager id.

- **POST /fund/index: ** Returns a paginated list of fund from given parameters (One can check more about the possible parameters under: **app\Http\Requests\FundIndexRequest.php**)

- **POST /fund/create: ** Create a fund from given parameters (One can check more about the possible parameters under: **app\Http\Requests\FundCreateRequest.php**)

- **PATCH /fund/update: ** Update a fund with given parameters (One can check more about the possible parameters under: **app\Http\Requests\FundUpdateRequest.php**)

- **DELETE /fund/delete/{fund_id}: ** Delete the fund with the passed id.

## Solution
This Rest API is developed using the PHP framework Laravel and leverage several of its best traits. Besides that and outside Laravel scope, the Repository Pattern was used to perform reading operations and Actions were created to perform the writing operations to the database. Thus separating the the logic/business layer from the Controller layer and moving closer to SOLID principles.

All the controllers methods are wrapped around a try catch that will ultimately, return any exceptions in a treated manner with the message and the trace being returned. Obviously if in production, the exceptions wouldn't be just returned through the api, it would possibly be spitted in some other place that would make easier to debug possible bugs. Transactions were also used in cases were inserts involved more than one entity.

### Scalability Considerations
The application is prepared with indexes in several main fields to help improving data handling and queries response time. Besides that, when looking at the user growth ratio behaviour, the solution is robust and prepared to handle it, would have to think about infrastructure to better answer this question and infrastructure is not really my best trait.