INSERT INTO empleados (nombre, email) VALUES 
('Carlos Pérez', 'carlos.perez@gmail.com'),
('Ana López', 'ana.lopez@gmail.com'),
('Luis Fernández', 'luis.fernandez@gmail.com'),
('María Gómez', 'maria.gomez@gmail.com'),
('Javier Torres', 'javier.torres@gmail.com');

INSERT INTO proyectos (idEmpleado, nombre, descripcion) VALUES 
(1, 'Desarrollo Web', 'Creación de un sitio web moderno'),   -- Carlos
(2, 'Aplicación Móvil', 'App para Android e iOS'),           -- Ana
(3, 'Sistema de Gestión', 'Software interno para la empresa'), -- Luis
(1, 'Rediseño UX', 'Mejoras en la experiencia de usuario'),  -- Carlos
(4, 'E-commerce', 'Tienda en línea para ventas');            -- María


INSERT INTO tareas (idProyecto, titulo, estado) VALUES 
(1, 'Diseñar interfaz', 'pendiente'),          -- Proyecto: Desarrollo Web
(2, 'Integrar pasarela de pago', 'enProgreso'), -- Proyecto: Aplicación Móvil
(3, 'Configurar base de datos', 'completado'),  -- Proyecto: Sistema de Gestión
(1, 'Optimizar SEO', 'pendiente'),             -- Proyecto: Desarrollo Web
(5, 'Agregar sistema de facturación', 'pendiente'); -- Proyecto: E-commerce
