DROP DATABASE IF EXISTS equipoDesarrollo;
CREATE DATABASE IF NOT EXISTS equipoDesarrollo;
USE equipoDesarrollo;

-- tabla empleados
CREATE TABLE IF NOT EXISTS empleados (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL
);

-- tabla proyectos
CREATE TABLE IF NOT EXISTS proyectos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    idEmpleado INT NOT NULL,
    nombre VARCHAR(100) NOT NULL,
    descripcion TEXT,
    FOREIGN KEY (idEmpleado) REFERENCES empleados(id) ON DELETE CASCADE
);

-- tabla tareas
CREATE TABLE IF NOT EXISTS tareas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    idProyecto INT NOT NULL,
    titulo VARCHAR(255) NOT NULL,
    estado ENUM('pendiente', 'enProgreso', 'completado') DEFAULT 'pendiente',
    FOREIGN KEY (idProyecto) REFERENCES proyectos(id) ON DELETE CASCADE
);
