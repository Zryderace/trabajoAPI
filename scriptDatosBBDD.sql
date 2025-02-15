USE futbolDB;
-- Insert Teams
INSERT INTO equipos (nombre, ciudad, estadio) VALUES 
('FC Barcelona', 'Barcelona', 'Camp Nou'),
('Real Madrid', 'Madrid', 'Santiago Bernabéu'),
('Manchester United', 'Manchester', 'Old Trafford'),
('Paris Saint-Germain', 'Paris', 'Parc des Princes'),
('Bayern Munich', 'Munich', 'Allianz Arena');

-- Insert Players
INSERT INTO jugadores (idEquipo, nombre, edad, nacionalidad) VALUES 
(1, 'Lionel Messi', 36, 'Argentina'),
(1, 'Pedri', 21, 'Espana'),
(2, 'Karim Benzema', 36, 'Francia'),
(2, 'Vinícius Jr.', 24, 'Brasil'),
(3, 'Bruno Fernandes', 29, 'Portugal'),
(3, 'Marcus Rashford', 26, 'Inglaterra'),
(3, 'Casemiro', 32, 'Brasil'),
(4, 'Kylian Mbappé', 25, 'Francia'),
(4, 'Neymar Jr.', 32, 'Brasil'),
(5, 'Harry Kane', 30, 'Inglaterra'),
(5, 'Joshua Kimmich', 29, 'Alemania');

-- Insert Positions
INSERT INTO posiciones (idJugador, posicion, descripcion) VALUES 
(1, 'Delantero', 'Atacante principal, responsable de marcar goles.'),
(2, 'Centrocampista', 'Conecta la defensa con el ataque, distribuye el balón.'),
(3, 'Delantero', 'Jugador ofensivo con capacidad de finalización.'),
(4, 'Extremo', 'Jugador veloz que ataca por las bandas.'),
(5, 'Centrocampista', 'Organizador del equipo en la mitad del campo.'),
(6, 'Delantero', 'Atacante rápido y goleador.'),
(7, 'Mediocentro Defensivo', 'Protege la defensa y recupera balones.'),
(8, 'Delantero', 'Extremadamente rápido y hábil con el balón.'),
(9, 'Extremo', 'Jugador con gran regate y desborde por las bandas.'),
(10, 'Delantero', 'Finalizador nato con gran capacidad de definición.'),
(11, 'Centrocampista', 'Jugador versátil en la media cancha.');

