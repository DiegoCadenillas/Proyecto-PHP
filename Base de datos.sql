DROP DATABASE IF EXISTS juegosmesadb;

CREATE DATABASE IF NOT EXISTS juegosmesadb;

USE juegosmesadb;

CREATE TABLE IF NOT EXISTS Juegos(
id_juego INT AUTO_INCREMENT PRIMARY KEY,
nombre VARCHAR(50),
min_jugadores INT,
max_jugadores INT,
pegi INT, 
precio FLOAT,
idioma VARCHAR(60),
descripcion VARCHAR(255) 
);

CREATE TABLE IF NOT EXISTS Usuario(
id_usuario INT AUTO_INCREMENT PRIMARY KEY, 
nombre VARCHAR(60) NOT NULL, 
password_hash VARCHAR(100) NOT NULL, 
activation_token VARCHAR(100) NOT NULL,
email VARCHAR(100) NOT NULL,
salt VARCHAR(100),
activo TINYINT(1) NOT NULL
);

CREATE TABLE IF NOT EXISTS Reseña (
id_reseña INT AUTO_INCREMENT PRIMARY KEY,
id_usuario INT NOT NULL, 
comentario  VARCHAR(255),
fecha_Hora DATE,
puntuación FLOAT, 
FOREIGN KEY (id_usuario) REFERENCES Usuario(id_usuario) 
);

CREATE TABLE IF NOT EXISTS Pedido(
id_pedido INT AUTO_INCREMENT PRIMARY KEY,
id_usuario INT NOT NULL, 
id_producto INT NOT NULL,
importe FLOAT, 
fechaHora DATE, 
descuento FLOAT,
FOREIGN KEY (id_usuario) REFERENCES Usuario(id_usuario),
FOREIGN KEY (id_producto) REFERENCES Juegos(id_juego) 
);

CREATE TABLE IF NOT EXISTS Almacén(
id_almacen INT AUTO_INCREMENT PRIMARY KEY, 
id_pedido INT NOT NULL,
dirección VARCHAR(255) NOT NULL,
stock INT,
FOREIGN KEY (id_pedido) REFERENCES Pedido(id_pedido) 
);