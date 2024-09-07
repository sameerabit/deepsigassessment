# Team Hierarchy API

This API endpoint is for extracting plain data from csv file and build hierachy and provide it as a json response.

API is Secured with X-API-TOKEN stored .env file

After cloning the codebase do as follows,

    1. cd <project_dir> && composer install
    2. symfony server:start

- Make sure that symfony is started in your computer.

## Example api request

`http://127.0.0.1:8000/api/team-hierarchy?_q=Sales`

Response

`{
    "data": {
        "C Suit": {
            "teamName": "C Suit",
            "parentTeam": "",
            "managerName": "John Doe",
            "businessUnit": "",
            "teams": {
                "Business team": {
                    "teamName": "Business team",
                    "parentTeam": "C Suit",
                    "managerName": "Brad Gulter",
                    "businessUnit": "business",
                    "teams": {
                        "Sales": {
                            "teamName": "Sales",
                            "parentTeam": "Business team",
                            "managerName": "Steph Stephans",
                            "businessUnit": "business",
                            "teams": {
                                "Customer Relations": {
                                    "teamName": "Customer Relations",
                                    "parentTeam": "Sales",
                                    "managerName": "John Cutleras",
                                    "businessUnit": "business",
                                    "teams": []
                                }
                            }
                        }
                    }
                }
            }
        }
    }
}`
