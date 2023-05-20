## Embedditor

### Installation

1. Install docker
2. Install docker-compose
3. Run the following commands:
  - `docker-compose build`
  - `docker-compose up -d`

4. Copy .env.example into .env

5. Set the following settings in the .env


    `OPENAI_API_KEY=`


6. Setup the project
- `docker-compose exec app bash`
- `php artisan migrate`
- `php artisan db:seed`
