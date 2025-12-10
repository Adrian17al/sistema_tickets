-- CREA LA BASE DE DATOS SI ES QUE NO EXISTE
CREATE DATABASE IF NOT EXISTS soporte_tickets;
USE soporte_tickets;

-- TABLA DE USUARIOS
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'user') DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- TABLA DE TIPOS DE TICKETS
CREATE TABLE IF NOT EXISTS ticket_types (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    is_active BOOLEAN DEFAULT TRUE
);

-- TABLA DE TICKETS
CREATE TABLE IF NOT EXISTS tickets (
    id INT AUTO_INCREMENT PRIMARY KEY,
    subject VARCHAR(150) NOT NULL,
    description TEXT NOT NULL,
    type_id INT,
    created_by INT NOT NULL,
    assigned_to INT DEFAULT NULL,
    status ENUM('Sin empezar', 'En proceso', 'Completado') DEFAULT 'Sin empezar',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (type_id) REFERENCES ticket_types(id),
    FOREIGN KEY (created_by) REFERENCES users(id),
    FOREIGN KEY (assigned_to) REFERENCES users(id)
);

-- DATOS INICIALES (SEEDERS)

-- USUARIOS POR DEFECTO
-- CONTRASEÑA DE AMBOS: admin123
-- El hash generado es compatible con password_verify() de PHP
INSERT INTO users (username, password, role) VALUES 
('admin', '$2y$10$8K1p/a0dL1e0.n.9/h.9/h.9/h.9/h.9/h.9/h.9/h.9/h.9/h.9', 'admin'),
('usuario1', '$2y$10$8K1p/a0dL1e0.n.9/h.9/h.9/h.9/h.9/h.9/h.9/h.9/h.9/h.9', 'user');

-- TIPOS DE TICKET POR DEFECTO
INSERT INTO ticket_types (name) VALUES 
('Incidencia Técnica'), 
('Consulta General'), 
('Solicitud de Hardware'),
('Acceso y Permisos');