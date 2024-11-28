drop database if exists bdFletes;
create database bdFletes;
use bdFletes;

create table Empleado(
    idempleado int AUTO_INCREMENT,
    apellidos VARCHAR(40) NOT NULL,
    nombres VARCHAR(40) NOT NULL,
    celular varchar(9),
    dni VARCHAR(8) UNIQUE,
    estado tinyint,
    PRIMARY KEY (idempleado)
);
create table Flete(
    idflete int AUTO_INCREMENT,
    nombre_flete VARCHAR(40) NOT NULL,
    descripcion varchar(200),
    estado tinyint,
    PRIMARY KEY (idflete)
);
create table Viatico(
    idviatico int AUTO_INCREMENT,
    nombre_viatico VARCHAR(40) NOT NULL,
    descripcion varchar(200),
    estado tinyint,
    PRIMARY KEY (idviatico)
);
create table DetalleFV(
    iddetallefv int AUTO_INCREMENT,
    idempleado int,
    idflete int,
    idviatico int,
    fecha DATE,
    descripcion varchar(200),
    tipoIG int,  
    importe DECIMAL(10, 2) DEFAULT 0.00,
    estado tinyint,
    PRIMARY KEY (iddetallefv),
    FOREIGN KEY (idempleado) REFERENCES Empleado(idempleado),
    FOREIGN KEY (idflete) REFERENCES Flete(idflete),
    FOREIGN KEY (idviatico) REFERENCES Viatico(idviatico)
);
create table Vehiculo(
    idvehiculo int AUTO_INCREMENT,
    placa VARCHAR(50) NOT NULL UNIQUE,
    marca VARCHAR(50) NOT NULL,
    descripcion VARCHAR(200) NOT NULL,
    fecha_registro DATE ,
    estado tinyint,
    PRIMARY KEY (idvehiculo)
);

create table DetalleVehiculo(
    iddetalleveh int AUTO_INCREMENT,
    idvehiculo int,
    idempleado int,
    fecha DATE,
    observacion varchar(200),
    monto DECIMAL(10, 2) DEFAULT 0.00,
    estado tinyint,
    PRIMARY KEY (iddetalleveh),
    FOREIGN KEY (idvehiculo) REFERENCES Vehiculo(idvehiculo),
    FOREIGN KEY (idempleado) REFERENCES Empleado(idempleado)
);



