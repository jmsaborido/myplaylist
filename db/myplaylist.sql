------------------------------
-- Archivo de base de datos --
------------------------------
CREATE EXTENSION pgcrypto;

DROP TABLE IF EXISTS usuarios CASCADE;

CREATE TABLE usuarios (
    id bigserial PRIMARY KEY,
    login varchar(11) NOT NULL UNIQUE CONSTRAINT ck_login_sin_espacios CHECK (LOGIN NOT LIKE '% %'),
    nombre varchar(255) NOT NULL,
    apellidos varchar(255) NOT NULL,
    password varchar(255) NOT NULL,
    email varchar(255) NOT NULL UNIQUE,
    created_at timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP,
    token varchar(32),
    auth_key varchar(255),
    rol varchar(255)
);

DROP TABLE IF EXISTS generos CASCADE;

CREATE TABLE generos (
    id bigserial PRIMARY KEY,
    denom varchar(255) NOT NULL UNIQUE,
    created_at timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP
);

DROP TABLE IF EXISTS consolas CASCADE;

CREATE TABLE consolas (
    id bigserial PRIMARY KEY,
    denom varchar(255) NOT NULL UNIQUE,
    created_at timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP
);

DROP TABLE IF EXISTS juegos CASCADE;

CREATE TABLE juegos (
    id bigserial PRIMARY KEY,
    nombre varchar(100) NOT NULL,
    genero_id bigint NOT NULL REFERENCES generos (id),
    year_debut smallint CONSTRAINT ck_primer_videojuego CHECK (year_debut >= 1950)
);

DROP TABLE IF EXISTS completados CASCADE;

CREATE TABLE completados (
    id bigserial PRIMARY KEY,
    usuario_id bigint NOT NULL REFERENCES usuarios (id),
    juego_id bigint NOT NULL REFERENCES juegos (id),
    fecha date NOT NULL DEFAULT CURRENT_DATE,
    pasado boolean,
    consola_id bigint NOT NULL REFERENCES consolas (id)
);

INSERT INTO
    usuarios (LOGIN, nombre, apellidos, PASSWORD, email, rol)
VALUES
    (
        'josesabor',
        'José María',
        'Saborido Monge',
        '$2y$13$IT4m7G6xRaN6M6AXWTfiZ.1m3/sV5ljpD64VWCPjX0vaOfGOaZvhG',
        'josemaria.saborido@iesdonana.org',
        'ADMIN'
    );

INSERT INTO
    usuarios (LOGIN, nombre, apellidos, PASSWORD, email, rol)
VALUES
    (
        'pepe',
        'pepe',
        'pepe',
        '$2a$10$Tr9k2vCnBdxsqOSQqjClEeFat22FdTWAZyJc4U9a5U/ERmmSF74ru',
        'pepe@iesdonana.org',
        'USER'
    );

INSERT INTO
    consolas (denom)
VALUES
    ('Android'),
    ('Gamecube'),
    ('NDS'),
    ('PS1'),
    ('PS2'),
    ('PS3'),
    ('PS4'),
    ('PC'),
    ('Raspberry'),
    ('Wii U'),
    ('XBOX 360');

INSERT INTO
    generos (denom)
VALUES
    ('ARPG'),
    ('Conduccion'),
    ('Deportes Extremos'),
    ('Espionaje'),
    ('Futbol'),
    ('Metroidvania'),
    ('Peleas'),
    ('Plataformas'),
    ('RPG'),
    ('Sandbox'),
    ('Soulsborne'),
    ('Supervivencia'),
    ('Terror'),
    ('Walking Simulator');

INSERT INTO
    juegos (nombre, genero_id, year_debut)
VALUES
    ('Chrono Trigger', 9, 1995),
    ('Silent Hill 2', 13, 2001),
    ('Silent Hill', 13, 1999),
    ('Silent Hill 3', 13, 2003),
    (
        'Dark Souls II: Scholar of the First Sin',
        11,
        2015
    ),
    ('Bloodborne', 11, 2015),
    ('Metal Gear', 4, 1987),
    ('Metal Gear 2: Solid Snake', 4, 1990),
    ('Metal Gear Solid ', 4, 1998),
    ('Metal Gear Solid 2: Sons of Liberty', 4, 2001),
    ('Metal Gear Solid 3: Snake Eater', 4, 2004),
    (
        'Metal Gear Solid 4: Guns of the Patriots',
        4,
        2008
    ),
    ('Skate', 3, 2007),
    ('Mario Kart 8', 2, 2014),
    ('Skate 2', 3, 2009),
    (
        'The Legend of Zelda: Breath of the Wild',
        1,
        2017
    ),
    ('Skate 3', 3, 2010),
    ('Super Mario 3D World', 8, 2013),
    ('MX vs.ATV Reflex', 2, 2009),
    ('Grand Theft Auto: Vice City', 10, 2003),
    ('Grand Theft Auto: Vice City Stories', 10, 2006),
    (
        'Grand Theft Auto: Liberty City Stories',
        10,
        2005
    ),
    ('Pro Evolution Soccer 6', 5, 2005),
    ('Need for Speed: Underground', 2, 2003),
    ('Resident Evil DS', 13, 2006),
    ('Need for Speed: Underground 2', 2, 2004),
    ('Tony Hawk''s Pro Skater 2', 3, 2000),
    ('Tony Hawk''s Pro Skater', 9, 1999),
    ('Resident Evil', 13, 2002),
    ('Need for Speed: Most Wanted', 2, 2005),
    ('Tekken 7', 7, 2015),
    (
        'Toy Story 2: Buzz Lightyear to the Rescue',
        8,
        1999
    ),
    ('Ratchet & Clank', 8, 2002),
    ('Ratchet & Clank: Going Commando', 8, 2003),
    ('DiRT 3', 2, 2015),
    ('Metal Gear Solid V: Ground Zeroes', 4, 2014),
    ('Hyper Light Drifter', 6, 2016),
    ('Hollow Knight', 6, 2017),
    ('Metal Gear Solid V: The Phantom Pain', 4, 2015),
    ('Grow Home', 8, 2015),
    ('Fallout: New Vegas', 9, 2010),
    ('Mirror''s Edge', 8, 2008),
    ('Dead Space', 13, 2008),
    ('Minecraft', 12, 2011),
    ('Burnout Paradise Remastered', 2, 2018),
    ('Metal Gear Solid: Twin Snakes', 4, 2004),
    ('Forager', 12, 2019),
    ('Tony Hawk''s Pro Skater 3', 3, 2001),
    ('Tony Hawk''s Pro Skater 2X', 3, 2001),
    ('Spyro 2', 8, 1999),
    (
        'The Legend of Zelda: A Link to the Past',
        1,
        1991
    ),
    (
        'The Legend of Zelda: Link''s Awakening DX',
        1,
        1993
    ),
    (
        'The Legend of Zelda: Oracle of Seasons',
        1,
        2001
    ),
    ('The Legend of Zelda: Oracle of Ages', 1, 2001),
    ('The Legend of Zelda: The Minish Cap', 1, 2004),
    ('Descenders', 3, 2018),
    ('Ratchet & Clank ', 8, 2016),
    ('Red Dead Redemption 2', 10, 2018),
    ('Resident Evil 7: Biohazard', 13, 2017),
    ('Resident Evil 2', 13, 2019),
    ('What Remains of Edith Finch', 14, 2017),
    ('SOMA', 14, 2015),
    ('Rime', 8, 2017),
    ('Horizon Zero Dawn', 1, 2017),
    ('God Of War', 1, 2018),
    ('Marvel''s Spider-Man', 1, 2018),
    ('Spyro Reignited Trilogy', 8, 2019),
    ('Super Mario Sunshine', 8, 2002),
    ('Super Metroid', 6, 1994),
    ('Metroid: Zero Mission', 6, 2004),
    ('Metroid Fusion', 6, 2002),
    ('Super Mario Galaxy', 8, 2007),
    ('Metroid II: Return of Samus', 6, 2016),
    ('Blasphemous', 6, 2019),
    ('Horizon Chase Turbo', 2, 2018),
    ('Portal', 8, 2007),
    ('Ori and the Blind Forest', 6, 2015),
    ('Celeste', 8, 2018),
    ('Castlevania: Symphony of the Night', 6, 1997),
    ('Katana ZERO', 8, 2019),
    ('The Witcher', 1, 2007),
    ('Colin McRae: Dirt', 2, 2007),
    ('Resident Evil', 2, 1996),
    ('Firewatch', 14, 2016);