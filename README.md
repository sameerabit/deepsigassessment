# Team Hierarchy API

This API endpoint is for extracting plain data from csv file and build hierachy and provide it as a json response.

API is Secured with X-API-TOKEN stored .env file

Remember to set X-API-TOKEN in the headers when using the API endpoint

After cloning the codebase do as follows,

    1. cd <project_dir> && composer install
    2. symfony server:start

- Make sure that symfony is started in your computer.

## Example api request

`http://127.0.0.1:8000/api/team-hierarchy?_q=Sales`

## Dev env used

PHP 8.3.3 (cli) (built: Feb 13 2024 15:41:14) (NTS)
Symfony 7.1
