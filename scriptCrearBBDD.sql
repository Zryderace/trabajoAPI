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

-- Tabla jugadores (Players)
CREATE TABLE IF NOT EXISTS jugadores (
    id INT AUTO_INCREMENT PRIMARY KEY,
    idEquipo INT NOT NULL,
    nombre VARCHAR(100) NOT NULL,
    edad INT NOT NULL,
    nacionalidad VARCHAR(100) NOT NULL,
    FOREIGN KEY (idEquipo) REFERENCES equipos(id) ON DELETE CASCADE
);

-- Tabla posiciones (Positions)
CREATE TABLE IF NOT EXISTS posiciones (
    id INT AUTO_INCREMENT PRIMARY KEY,
    idJugador INT NOT NULL,
    posicion VARCHAR(50) NOT NULL,
    descripcion TEXT,
    FOREIGN KEY (idJugador) REFERENCES jugadores(id) ON DELETE CASCADE
);
