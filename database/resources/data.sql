create database if not exists buzzvel;

use buzzvel;

create table if not exists user (
    code int primary key auto_increment,
    name varchar(200) not null,
    linkedin varchar(200) default null,
    github varchar(200) default null,
    uri varchar(200) default null
);