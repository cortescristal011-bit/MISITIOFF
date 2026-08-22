-- =========================================================
-- BASE DE DATOS DEL PROYECTO EDICIONES FARES
-- Crear en phpMyAdmin o ejecutar desde MySQL.
-- =========================================================

CREATE DATABASE IF NOT EXISTS sistema_fares
CHARACTER SET utf8mb4
COLLATE utf8mb4_general_ci;

USE sistema_fares;

CREATE TABLE IF NOT EXISTS clientes (
    idcli INT NOT NULL AUTO_INCREMENT,
    nomcli TEXT NOT NULL,
    direccion TEXT NULL,
    telres_cli TEXT NULL,
    telcel_cli TEXT NULL,
    email_cli TEXT NULL,
    PRIMARY KEY (idcli)
) ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS inventario (
    codigo INT NOT NULL AUTO_INCREMENT,
    nom_producto VARCHAR(150) NOT NULL,
    costo DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    porc_venta DECIMAL(5,2) NOT NULL DEFAULT 0.00,
    precio_venta DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    Imagen VARCHAR(255) NULL,
    stock INT NOT NULL DEFAULT 0,
    Fecha DATE NOT NULL,
    PRIMARY KEY (codigo)
) ENGINE = InnoDB;

-- Datos de prueba opcionales:
INSERT INTO clientes (nomcli, direccion, telres_cli, telcel_cli, email_cli)
VALUES
('Alexandra Valeriano', 'Col. Miraflores', '5569-3988', '45659685', 'alexa@edicionesfares.com');
