USE futbolDB;
-- Insert Teams
INSERT INTO equipos (nombre, ciudad, estadio) VALUES 
('Real Madrid', 'Madrid', 'Santiago Bernabéu'),
('FC Barcelona', 'Barcelona', 'Camp Nou'),
('Manchester United', 'Manchester', 'Old Trafford'),
('Paris Saint-Germain', 'Paris', 'Parc des Princes'),
('Bayern Munich', 'Munich', 'Allianz Arena');

-- Insert Positions
INSERT INTO posiciones (posicion, descripcion) VALUES 
('Portero', 'Jugador encargado de evitar goles y proteger la portería.'),
('Defensa Central', 'Clave en la defensa, intercepta ataques y despeja el balón.'),
('Lateral', 'Defensa de banda que marca extremos y apoya en ataque.'),
('Mediocentro Defensivo', 'Protege la defensa y recupera balones.'),
('Pivote', 'Centrocampista que equilibra el equipo y distribuye el juego.'),
('Mediocentro Ofensivo', 'Creador de juego, asiste a delanteros y genera oportunidades.'),
('Extremo', 'Jugador veloz con regate que ataca por las bandas.'),
('Delantero', 'Jugador ofensivo con capacidad de finalización.');

-- Insert Players
INSERT INTO jugadores (idEquipo, nombre, posicion, nacionalidad, edad) VALUES 
(1, 'Kylian Mbappé','Delantero' ,'Francia', 26),
(1, 'Vinícius Jr.','Extremo' ,'Brasil', 24),
(2, 'Lamine Yamal','Delantero' ,'Espana', 36),
(2, 'Pedri','Pivote' ,'Espana', 21),
(3, 'Alejandro Garnacho','Extremo' ,'Argentina', 26),
(3, 'Harry Maguire','Defensa Central' ,'Portugal', 31),
(4, 'Gianluigi Donnarumma','Portero' ,'Italia', 30),
(4, 'Achraf Hakimi','Lateral' ,'Marruecos', 28),
(5, 'Harry Kane','Delantero' ,'Inglaterra', 30),
(5, 'Joshua Kimmich','Mediocentro Defensivo' ,'Alemania', 29);



