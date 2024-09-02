drop database if exists bdFletes;
create database bdFletes;
use bdFletes;

create table Cliente(
    idcliente int AUTO_INCREMENT,
    apellido_paterno varchar(40),
    apellido_materno varchar(40),
    nombres varchar(40),
    dni varchar(8),
    correo varchar(55),
    estado tinyint,
    primary key(idcliente)
);
