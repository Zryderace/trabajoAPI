DROP DATABASE IF EXISTS futbolDB;
CREATE DATABASE IF NOT EXISTS futbolDB;
USE futbolDB;

-- Tabla equipos (Teams)
CREATE TABLE IF NOT EXISTS equipos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    ciudad VARCHAR(100) NOT NULL,
    estadio VARCHAR(100) NOT NULL
);

-- Tabla posiciones (Positions)
CREATE TABLE IF NOT EXISTS posiciones (
    posicion VARCHAR(50) PRIMARY KEY,
    descripcion VARCHAR(70) NOT NULL
);

-- Tabla jugadores (Players)
CREATE TABLE IF NOT EXISTS jugadores (
    id INT AUTO_INCREMENT PRIMARY KEY,
    idEquipo INT NOT NULL,
    nombre VARCHAR(100) NOT NULL,
    posicion VARCHAR(50) NOT NULL,
    nacionalidad VARCHAR(100) NOT NULL,
    edad INT NOT NULL,
    FOREIGN KEY (idEquipo) REFERENCES equipos(id) ON DELETE CASCADE,
    FOREIGN KEY (posicion) REFERENCES posiciones(posicion) ON DELETE CASCADE
);


