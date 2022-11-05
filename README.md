# John Virtual Card

## Story

João is tired of using business cards for his business. He liked having a picture on
his phone so that people scanning it could see all of their data on one page.

## How it work?

- Page that generates the QR Code with URL (example: domain.com/{name})
- John Mobile Image
- Page that redirects from QR Code URL to John Page (/john)

![Captura de tela de 2022-11-04 14-02-40](https://user-images.githubusercontent.com/32521472/200035524-11cd3aad-1cf7-47ed-9182-924772c93894.png)


## Get Started

- Clone repository using: `git clone https://github.com/Brunorio/john-virtual-card.git && cd john-virtual-card`
- Inside the project folder run:
     - `docker compose up -d && docker exec -it database sh /autoload.sh`

The above command is needed to upload the docker containers and populate the database

## Structure

- The project is structured on four levels:
     - `database` - Database settings
     - `frontend` - ReactJS pages
     - `php` - Backend using PHP in version 7.4
     - `nginx` - nginx server to handle reverse-proxy

After up container, access the address in your browser (Prefer to use Google Chrome without adblock):
- `http://app.localhost` - UI
- `http://api.localhost` - Restful API for data manipulation
