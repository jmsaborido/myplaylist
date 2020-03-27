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
    consola_id bigint NOT NULL REFERENCES consolas (id),
    fecha date NOT NULL DEFAULT CURRENT_DATE,
    pasado boolean
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
    ('Metal Gear Solid', 4, 1998),
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
    ('Resident Evil: Deadly Silence', 13, 2006),
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
    ('Ratchet & Clank', 8, 2016),
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

INSERT INTO
    completados(usuario_id, juego_id, consola_id, fecha, pasado)
VALUES
    (1, 1, 1, '2017/1/6', FALSE),
    (1, 2, 8, '2017/1/23', FALSE),
    (1, 3, 8, '2017/2/8', FALSE),
    (1, 4, 8, '2017/2/14', FALSE),
    (1, 5, 8, '2017/3/6', FALSE),
    (1, 6, 11, '2017/4/1', FALSE),
    (1, 7, 6, '2017/4/29', FALSE),
    (1, 8, 6, '2017/5/1', FALSE),
    (1, 9, 6, '2017/5/4', TRUE),
    (1, 10, 6, '2017/5/5', TRUE),
    (1, 11, 6, '2017/5/9', TRUE),
    (1, 12, 6, '2017/5/23', TRUE),
    (1, 13, 6, '2018/1/5', FALSE),
    (1, 14, 10, '2018/1/27', FALSE),
    (1, 15, 6, '2018/2/14', FALSE),
    (1, 16, 10, '2018/3/8', FALSE),
    (1, 17, 6, '2018/3/13', FALSE),
    (1, 18, 10, '2018/3/15', FALSE),
    (1, 19, 8, '2018/6/28', FALSE),
    (1, 20, 8, '2018/7/4', TRUE),
    (1, 21, 8, '2018/7/7', TRUE),
    (1, 22, 8, '2018/7/10', TRUE),
    (1, 23, 8, '2018/7/28', TRUE),
    (1, 24, 8, '2018/8/8', TRUE),
    (1, 25, 3, '2018/8/27', FALSE),
    (1, 26, 8, '2018/8/28', FALSE),
    (1, 27, 9, '2018/9/9', FALSE),
    (1, 28, 9, '2018/9/10', FALSE),
    (1, 28, 11, '2018/9/17', FALSE),
    (1, 29, 11, '2018/9/17', FALSE),
    (1, 30, 11, '2018/9/26', TRUE),
    (1, 31, 8, '2018/9/30', FALSE),
    (1, 32, 9, '2018/10/6', FALSE),
    (1, 33, 5, '2018/10/31', TRUE),
    (1, 34, 5, '2018/11/4', TRUE),
    (1, 35, 8, '2018/11/9', FALSE),
    (1, 36, 8, '2018/11/12', TRUE),
    (1, 37, 8, '2018/11/16', FALSE),
    (1, 38, 8, '2018/11/23', FALSE),
    (1, 39, 8, '2018/11/30', TRUE),
    (1, 40, 8, '2018/11/30', FALSE),
    (1, 41, 8, '2018/12/27', FALSE),
    (1, 42, 8, '2019/1/24', TRUE),
    (1, 43, 8, '2019/1/28', TRUE),
    (1, 44, 8, '2019/2/28', TRUE),
    (1, 45, 8, '2019/4/18', FALSE),
    (1, 46, 8, '2019/5/2', FALSE),
    (1, 47, 8, '2019/5/8', FALSE),
    (1, 9, 6, '2019/5/9', TRUE),
    (1, 48, 9, '2019/5/11', FALSE),
    (1, 49, 8, '2019/5/13', FALSE),
    (1, 50, 8, '2019/5/29', TRUE),
    (1, 51, 10, '2019/6/7', FALSE),
    (1, 52, 10, '2019/6/16', FALSE),
    (1, 53, 10, '2019/6/19', FALSE),
    (1, 54, 10, '2019/6/26', FALSE),
    (1, 55, 10, '2019/6/29', FALSE),
    (1, 56, 8, '2019/7/5', FALSE),
    (1, 57, 7, '2019/7/16', FALSE),
    (1, 58, 7, '2019/7/25', FALSE),
    (1, 59, 7, '2019/7/27', FALSE),
    (1, 60, 7, '2019/7/30', FALSE),
    (1, 61, 7, '2019/8/1', FALSE),
    (1, 62, 7, '2019/8/2', FALSE),
    (1, 63, 7, '2019/8/4', FALSE),
    (1, 10, 6, '2019/8/6', TRUE),
    (1, 64, 7, '2019/8/15', FALSE),
    (1, 65, 7, '2019/8/16', FALSE),
    (1, 66, 7, '2019/10/5', FALSE),
    (1, 67, 8, '2019/10/12', FALSE),
    (1, 11, 6, '2019/10/30', TRUE),
    (1, 68, 2, '2019/11/5', FALSE),
    (1, 69, 10, '2019/11/17', FALSE),
    (1, 70, 10, '2019/11/19', FALSE),
    (1, 71, 10, '2019/11/23', FALSE),
    (1, 72, 10, '2019/11/23', FALSE),
    (1, 73, 8, '2019/11/24', FALSE),
    (1, 74, 8, '2019/12/21', FALSE),
    (1, 75, 8, '2019/12/12', FALSE),
    (1, 76, 8, '2019/12/14', TRUE),
    (1, 77, 8, '2019/12/15', FALSE),
    (1, 78, 8, '2019/12/15', FALSE),
    (1, 79, 8, '2019/12/21', FALSE),
    (1, 80, 8, '2019/12/21', FALSE),
    (1, 81, 8, '2020/1/3', FALSE),
    (1, 82, 8, '2020/1/23', FALSE),
    (1, 83, 8, '2020/3/5', FALSE),
    (2, 3, 8, '2020/3/27', FALSE);