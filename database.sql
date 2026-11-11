CREATE DATABASE IF NOT EXISTS tienda_moto;
USE tienda_moto;
CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre_completo VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


/*La contraseña plana de prueba para estos registros es "123456"*/
INSERT INTO usuarios (nombre_completo, email, password) VALUES
('Juan Pérez', 'juan@example.com', '$2y$10$e0MYzXyjpJS7Pd0RVvHwHeFXd1xZp/2Hh.y/T9VjZgZ.WbNq3WJ4m'),
('María Gómez', 'maria@example.com', '$2y$10$e0MYzXyjpJS7Pd0RVvHwHeFXd1xZp/2Hh.y/T9VjZgZ.WbNq3WJ4m'),
('Carlos López', 'carlos@example.com', '$2y$10$e0MYzXyjpJS7Pd0RVvHwHeFXd1xZp/2Hh.y/T9VjZgZ.WbNq3WJ4m'),
('Ana Martínez', 'ana@example.com', '$2y$10$e0MYzXyjpJS7Pd0RVvHwHeFXd1xZp/2Hh.y/T9VjZgZ.WbNq3WJ4m'),
('Luis Rodríguez', 'luis@example.com', '$2y$10$e0MYzXyjpJS7Pd0RVvHwHeFXd1xZp/2Hh.y/T9VjZgZ.WbNq3WJ4m'),
('Laura Sánchez', 'laura@example.com', '$2y$10$e0MYzXyjpJS7Pd0RVvHwHeFXd1xZp/2Hh.y/T9VjZgZ.WbNq3WJ4m');