FROM mariadb:10.5.2

EXPOSE 3307

COPY autoload.sh autoload.sh

RUN sh /autoload.sh &

CMD ["--default-authentication-plugin=mysql_native_password"]