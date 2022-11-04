FROM node:18.7-alpine

WORKDIR /application

COPY package.json /application

RUN yarn install --network-timeout 1000000

EXPOSE 3000

CMD yarn start