
# ti-saude

Rest API using laravel with JWT authentication

## Requirements

- Docker
## Instalation

Clone the project

```bash
  git clone https://github.com/ivenspontes/ti-saude.git
```

After project clone finish, enter in project folder

```bash
  cd ti-saude
```

Now build and start docker containers (make sure ports 80 is not in use)

```bash
  make build
```
(you can change ports in docker-compose.yml, if change web ports, use http://localhost:(port)/api)


## Using

Now you can send requests to http://localhost/api, use API Documentation to test endpoints

[![Run in Insomnia}](https://insomnia.rest/images/run.svg)](https://insomnia.rest/run/?label=API%20Ti-Saude&uri=https%3A%2F%2Fraw.githubusercontent.com%2Fivenspontes%2Fti-saude%2Fdevelop%2FInsomnia.json)

If you want to connect to database, use this credentials:

- Host: localhost
- User: postgres
- Password: postgres
- Port: 54322
- Database: ti-saude
