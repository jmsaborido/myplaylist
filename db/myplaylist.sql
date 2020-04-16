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
    pasado boolean,
    imagen_id varchar(255)
);

DROP TABLE IF EXISTS seguidores CASCADE;

CREATE TABLE seguidores (
    id BIGSERIAL PRIMARY KEY,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    ended_at TIMESTAMP,
    blocked_at TIMESTAMP,
    seguidor_id BIGINT NOT NULL REFERENCES usuarios (id) ON DELETE CASCADE ON UPDATE CASCADE,
    seguido_id BIGINT NOT NULL REFERENCES usuarios (id) ON DELETE CASCADE ON UPDATE CASCADE
);

DROP TABLE IF EXISTS comentarios CASCADE;

CREATE TABLE comentarios (
    id BIGSERIAL PRIMARY KEY,
    cuerpo TEXT,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    edited_at TIMESTAMP,
    padre_id BIGINT,
    completado_id BIGINT NOT NULL REFERENCES completados (id) ON DELETE CASCADE ON UPDATE CASCADE,
    usuario_id BIGINT NOT NULL REFERENCES usuarios (id) ON DELETE CASCADE ON UPDATE CASCADE
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
        'pepe@iesdoñana.org',
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
    generos (id, denom)
VALUES
    (2, 'Point-and-click'),
    (4, 'Peleas'),
    (5, 'Shooter'),
    (7, 'Musical'),
    (8, 'Plataformas'),
    (9, 'Puzzles'),
    (10, 'Carreras'),
    (11, 'Estrategia en tiempo real'),
    (12, 'RPG'),
    (13, 'Simulador'),
    (14, 'Deportes'),
    (15, 'Estrategia'),
    (16, 'Estrategia por turnos'),
    (24, 'Tactico'),
    (25, 'Hack and slash / Beat  ''em up'),
    (26, 'Concursos / Trivia'),
    (30, 'Pinball'),
    (31, 'Aventuras'),
    (32, 'Indie'),
    (33, 'Arcade'),
    (34, 'Novela Grafica');

INSERT INTO
    juegos (id, nombre, genero_id, year_debut)
VALUES
    (1802, 'Chrono Trigger', 12, 1995),
    (481, 'Silent Hill 2', 9, 2001),
    (480, 'Silent Hill', 9, 1999),
    (482, 'Silent Hill 3', 9, 2003),
    (
        8222,
        'Dark Souls II: Scholar of the First Sin',
        12,
        2015
    ),
    (7334, 'Bloodborne', 12, 2015),
    (374, 'Metal Gear', 5, 1987),
    (377, 'Metal Gear 2: Solid Snake', 31, 1990),
    (375, 'Metal Gear Solid', 15, 1998),
    (
        376,
        'Metal Gear Solid 2: Sons of Liberty',
        31,
        2001
    ),
    (379, 'Metal Gear Solid 3: Snake Eater', 5, 2004),
    (
        380,
        'Metal Gear Solid 4: Guns of the Patriots',
        5,
        2008
    ),
    (2585, 'Skate', 13, 2007),
    (2350, 'Mario Kart 8', 10, 2014),
    (2586, 'Skate 2', 10, 2009),
    (
        7346,
        'The Legend of Zelda: Breath of the Wild',
        12,
        2017
    ),
    (2587, 'Skate 3', 14, 2010),
    (2180, 'Super Mario 3D World', 8, 2013),
    (7091, 'MX vs. ATV Reflex', 10, 2009),
    (733, 'Grand Theft Auto: Vice City', 5, 2003),
    (
        3262,
        'Grand Theft Auto: Vice City Stories',
        10,
        2006
    ),
    (
        3263,
        'Grand Theft Auto: Liberty City Stories',
        10,
        2005
    ),
    (2484, 'Pro Evolution Soccer 6', 14, 2005),
    (96, 'Need for Speed: Underground', 10, 2003),
    (20456, 'Resident Evil: Deadly Silence', 5, 2006),
    (97, 'Need for Speed: Underground 2', 10, 2004),
    (913, 'Tony Hawk''s Pro Skater 2', 14, 2000),
    (6692, 'Tony Hawk''s Pro Skater', 14, 1999),
    (24869, 'Resident Evil', 9, 2002),
    (98, 'Need for Speed: Most Wanted', 10, 2005),
    (7498, 'Tekken 7', 4, 2015),
    (
        3619,
        'Toy Story 2: Buzz Lightyear to the Rescue',
        8,
        1999
    ),
    (1289, 'Ratchet & Clank', 5, 2002),
    (1770, 'Ratchet & Clank: Going Commando', 5, 2003),
    (47381, 'Dirt 3: Complete Edition', 10, 2015),
    (
        5328,
        'Metal Gear Solid V: Ground Zeroes',
        5,
        2014
    ),
    (9806, 'Hyper Light Drifter', 8, 2016),
    (14593, 'Hollow Knight', 8, 2017),
    (
        1985,
        'Metal Gear Solid V: The Phantom Pain',
        5,
        2015
    ),
    (8774, 'Grow Home', 8, 2015),
    (
        25532,
        'Fallout: New Vegas - Ultimate Edition',
        5,
        2010
    ),
    (1051, 'Mirror''s Edge', 4, 2008),
    (37, 'Dead Space', 5, 2008),
    (121, 'Minecraft', 13, 2011),
    (78153, 'Burnout Paradise Remastered', 10, 2018),
    (4006, 'Metal Gear Solid: Twin Snakes', 31, 2004),
    (25580, 'Forager', 13, 2019),
    (914, 'Tony Hawk''s Pro Skater 3', 14, 2001),
    (47325, 'Tony Hawk''s Pro Skater 2X', 14, 2001),
    (1577, 'Spyro 2: Ripto''s Rage!', 8, 1999),
    (
        1026,
        'The Legend of Zelda: A Link to the Past',
        12,
        1991
    ),
    (
        1027,
        'The Legend of Zelda: Link''s Awakening DX',
        31,
        1998
    ),
    (
        1032,
        'The Legend of Zelda: Oracle of Seasons',
        12,
        2001
    ),
    (
        1041,
        'The Legend of Zelda: Oracle of Ages',
        12,
        2001
    ),
    (
        1035,
        'The Legend of Zelda: The Minish Cap',
        12,
        2004
    ),
    (52200, 'Descenders', 10, 2018),
    (11065, 'Ratchet & Clank', 5, 2016),
    (25076, 'Red Dead Redemption 2', 5, 2018),
    (75449, 'Resident Evil 7: Biohazard', 5, 2017),
    (19686, 'Resident Evil 2', 5, 2019),
    (11233, 'What Remains of Edith Finch', 9, 2017),
    (9727, 'SOMA', 31, 2015),
    (7621, 'Rime', 8, 2017),
    (11156, 'Horizon Zero Dawn', 5, 2017),
    (19560, 'God Of War', 12, 2018),
    (19565, 'Marvel''s Spider-Man', 25, 2018),
    (87683, 'Spyro Reignited Trilogy', 8, 2019),
    (1075, 'Super Mario Sunshine', 8, 2002),
    (1103, 'Super Metroid', 5, 1994),
    (1107, 'Metroid: Zero Mission', 5, 2004),
    (1104, 'Metroid Fusion', 5, 2002),
    (1077, 'Super Mario Galaxy', 8, 2007),
    (1102, 'Metroid II: Return of Samus', 5, 2016),
    (26820, 'Blasphemous', 8, 2019),
    (96476, 'Horizon Chase Turbo', 10, 2018),
    (71, 'Portal', 5, 2007),
    (
        19456,
        'Ori and the Blind Forest: Definitive Edition',
        8,
        2015
    ),
    (26226, 'Celeste', 8, 2018),
    (
        1128,
        'Castlevania: Symphony of the Night',
        8,
        1997
    ),
    (20150, 'Katana ZERO', 8, 2019),
    (
        27832,
        'The Witcher: Enhanced Edition Director''s Cut',
        12,
        2008
    ),
    (943, 'Colin McRae: Dirt', 10, 2007),
    (424, 'Resident Evil', 31, 1996),
    (9730, 'Firewatch', 31, 2016),
    (6643, 'Tony Hawk ''s American Sk8land', 14, 2005);

INSERT INTO
    completados(usuario_id, juego_id, consola_id, fecha, pasado)
VALUES
    (1, 1802, 1, '2017/1/6', FALSE),
    (1, 481, 8, '2017/1/23', FALSE),
    (1, 480, 8, '2017/2/8', FALSE),
    (1, 482, 5, '2017/2/14', FALSE),
    (1, 8222, 8, '2017/3/6', FALSE),
    (1, 7334, 7, '2017/4/1', FALSE),
    (1, 374, 6, '2017/4/29', FALSE),
    (1, 377, 6, '2017/5/1', FALSE),
    (1, 375, 6, '2017/5/4', TRUE),
    (1, 376, 6, '2017/5/5', TRUE),
    (1, 379, 6, '2017/5/9', TRUE),
    (1, 380, 6, '2017/5/23', TRUE),
    (1, 2585, 6, '2018/1/5', FALSE),
    (1, 2350, 10, '2018/1/27', FALSE),
    (1, 2586, 6, '2018/2/14', FALSE),
    (1, 7346, 10, '2018/3/8', FALSE),
    (1, 2587, 6, '2018/3/13', FALSE),
    (1, 2180, 10, '2018/3/15', FALSE),
    (1, 7091, 8, '2018/6/28', FALSE),
    (1, 733, 8, '2018/7/4', TRUE),
    (1, 3262, 8, '2018/7/7', TRUE),
    (1, 3263, 8, '2018/7/10', TRUE),
    (1, 2484, 8, '2018/7/28', TRUE),
    (1, 96, 8, '2018/8/8', TRUE),
    (1, 20456, 3, '2018/8/27', FALSE),
    (1, 97, 8, '2018/8/28', FALSE),
    (1, 913, 9, '2018/9/9', FALSE),
    (1, 6692, 9, '2018/9/10', FALSE),
    (1, 24869, 11, '2018/9/17', FALSE),
    (1, 98, 11, '2018/9/26', TRUE),
    (1, 7498, 8, '2018/9/30', FALSE),
    (1, 3619, 9, '2018/10/6', FALSE),
    (1, 1289, 5, '2018/10/31', TRUE),
    (1, 1770, 5, '2018/11/4', TRUE),
    (1, 47381, 8, '2018/11/9', FALSE),
    (1, 5328, 8, '2018/11/12', TRUE),
    (1, 9806, 8, '2018/11/16', FALSE),
    (1, 14593, 8, '2018/11/23', FALSE),
    (1, 1985, 8, '2018/11/30', TRUE),
    (1, 8774, 8, '2018/11/30', FALSE),
    (1, 25532, 8, '2018/12/27', FALSE),
    (1, 1051, 8, '2019/1/24', TRUE),
    (1, 37, 8, '2019/1/28', TRUE),
    (1, 121, 8, '2019/2/28', TRUE),
    (1, 78153, 8, '2019/4/18', FALSE),
    (1, 4006, 8, '2019/5/2', FALSE),
    (1, 25580, 8, '2019/5/8', FALSE),
    (1, 375, 6, '2019/5/9', TRUE),
    (1, 914, 9, '2019/5/11', FALSE),
    (1, 47325, 8, '2019/5/13', FALSE),
    (1, 1577, 8, '2019/5/29', TRUE),
    (1, 1026, 10, '2019/6/7', FALSE),
    (1, 1027, 10, '2019/6/16', FALSE),
    (1, 1032, 10, '2019/6/19', FALSE),
    (1, 1041, 10, '2019/6/26', FALSE),
    (1, 1035, 10, '2019/6/29', FALSE),
    (1, 52200, 8, '2019/7/5', FALSE),
    (1, 11065, 7, '2019/7/16', FALSE),
    (1, 25076, 7, '2019/7/25', FALSE),
    (1, 75449, 7, '2019/7/27', FALSE),
    (1, 19686, 7, '2019/7/30', FALSE),
    (1, 11233, 7, '2019/8/1', FALSE),
    (1, 9727, 7, '2019/8/2', FALSE),
    (1, 7621, 7, '2019/8/4', FALSE),
    (1, 376, 6, '2019/8/6', TRUE),
    (1, 11156, 7, '2019/8/15', FALSE),
    (1, 19560, 7, '2019/9/16', FALSE),
    (1, 19565, 7, '2019/10/5', FALSE),
    (1, 87683, 8, '2019/10/12', FALSE),
    (1, 379, 6, '2019/10/30', TRUE),
    (1, 1075, 2, '2019/11/5', FALSE),
    (1, 1103, 10, '2019/11/17', FALSE),
    (1, 1107, 10, '2019/11/19', FALSE),
    (1, 1104, 10, '2019/11/23', FALSE),
    (1, 1077, 10, '2019/11/23', FALSE),
    (1, 1102, 8, '2019/11/24', FALSE),
    (1, 26820, 8, '2019/12/11', FALSE),
    (1, 96476, 8, '2019/12/12', FALSE),
    (1, 71, 8, '2019/12/14', TRUE),
    (1, 19456, 8, '2019/12/15', FALSE),
    (1, 26226, 8, '2019/12/15', FALSE),
    (1, 1128, 9, '2019/12/21', FALSE),
    (1, 20150, 8, '2019/12/21', FALSE),
    (1, 27832, 8, '2020/1/3', FALSE),
    (1, 943, 8, '2020/1/23', FALSE),
    (1, 424, 8, '2020/3/5', TRUE),
    (1, 9730, 8, '2020/3/10', FALSE),
    (1, 6643, 3, '2020/4/8', FALSE),
    (2, 9730, 4, '2020/3/27', FALSE);