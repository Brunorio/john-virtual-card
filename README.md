# John Virtual Card

- Inside the project folder run:
     - `docker compose up -d && docker exec -it database sh /autoload.sh`

The above command is needed to upload the docker containers and populate the database

## Structure

- The project is structured on four levels:
     - `database` - Database settings
     - `frontend` - ReactJS pages
     - `php` - Backend using PHP in version 7.4
     - `nginx` - nginx server to handle reverse-proxy

After up container, access the address in your browser:
- `http://app.localhost` - UI
- `http://api.localhost` - Restful API for data manipulation