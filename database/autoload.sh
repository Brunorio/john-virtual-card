while :; do
    echo "$(mysqladmin ping -uroot -p"$MYSQL_ROOT_PASSWORD" 2> /dev/null)" >> resource.txt;
    validator=$(grep -c "is alive" resource.txt);
    
    if [ $validator -gt 0 ]
    then
        mysql -uroot -p"$MYSQL_ROOT_PASSWORD" -e "$(cat /database/resources/data.sql)";
        rm resource.txt;
        echo "autoload executed with success";
        break;
    fi
    echo "Loading database resources...";
    sleep 5;
done
