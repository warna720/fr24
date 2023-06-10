# Init

- Setup .env: `cp .env.example .env`
  - Configure .env if you need to, for example DB connection
- Install dependencies: `composer install`
- Run migrations: `php artisan migrate:fresh`
- if you want some initial flights to play with then seed DB: `php artisan db:seed`
- Serve the application: `php artisan serve`

# API
- GET `/api/flights`
  - Returns array of FlightResources

- POST `/api/tickets`
  - Payload:
    - (Required) flight_id:uuid
    - (Required) passport_id:uuid
  - Returns TicketResource

- PUT `/api/tickets/<ticket-id>`
  - Payload:
    - (Optional) status:CANCELLED
    - (Optional) seat:1,32
  - Returns TicketResource

# API Resources
## FlightResource
- id
- departure_at
- source
- destination

## TicketResource
- ticket_id
- status 
- seat
- passport_id
- flight_id
- flight_departure_at
- flight_source
- flight_destination

# Tests
- To run tests execute `./vendor/bin/phpunit`

# Possible improvements
- Normalize DB more e.g. move source, destination and passport_id to its own table.
- API authentication, since anybody could use the API now
- Refactor the validations logic inside controllers by moving it for example to dedicated validation request file and maybe in combo with models depending on how we want to structure it.
- Increase possible seatings by changing from tinyint to a bigger datatype and refactoring the code
- More tests
- Clear up unused migrations
- Clear up unused models and factories (User)
- Implement possibility to check in ticket
- Make sure no duplicate seatings booked on same flight (maybe a feature because airlines already do this /joke)
- FlightController should not return all flights, should have some form of pagination
- Improve tests to use class variables instead of instantiate same data/variables several times
