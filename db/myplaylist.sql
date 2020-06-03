------------------------------
-- Archivo de base de datos --
------------------------------
CREATE EXTENSION pgcrypto;

DROP TABLE IF EXISTS usuarios CASCADE;

CREATE TABLE usuarios (
    id bigserial PRIMARY KEY,
    username varchar(11) NOT NULL UNIQUE CONSTRAINT ck_username_sin_espacios CHECK (username NOT LIKE '% %'),
    nombre varchar(255) NOT NULL,
    apellidos varchar(255) NOT NULL,
    password varchar(255) NOT NULL,
    email varchar(255) NOT NULL UNIQUE,
    created_at timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP,
    image TEXT DEFAULT 'user.png',
    token varchar(32),
    auth_key varchar(255),
    rol varchar(255) DEFAULT 'USER'
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
    created_at timestamp(0) DEFAULT CURRENT_TIMESTAMP
);

DROP TABLE IF EXISTS juegos CASCADE;

CREATE TABLE juegos (
    id bigserial PRIMARY KEY,
    api bigint NOT NULL UNIQUE,
    img_api varchar(255),
    nombre varchar(100) NOT NULL,
    genero_id bigint NOT NULL REFERENCES generos (id),
    year_debut smallint
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

DROP TABLE IF EXISTS pendientes CASCADE;

CREATE TABLE pendientes (
    id bigserial PRIMARY KEY,
    usuario_id bigint NOT NULL REFERENCES usuarios (id),
    juego_id bigint NOT NULL REFERENCES juegos (id),
    consola_id bigint NOT NULL REFERENCES consolas (id),
    pasado boolean,
    tengo boolean
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

DROP TABLE IF EXISTS comentarios_usuarios CASCADE;

CREATE TABLE comentarios_usuarios (
    id BIGSERIAL PRIMARY KEY,
    usuario_id BIGINT NOT NULL REFERENCES usuarios (id) ON DELETE CASCADE ON UPDATE CASCADE,
    perfil_id BIGINT NOT NULL REFERENCES usuarios (id) ON DELETE CASCADE ON UPDATE CASCADE,
    cuerpo TEXT NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    edited_at TIMESTAMP
);

DROP TABLE IF EXISTS comentarios_completados CASCADE;

CREATE TABLE comentarios_completados (
    id BIGSERIAL PRIMARY KEY,
    usuario_id BIGINT NOT NULL REFERENCES usuarios (id) ON DELETE CASCADE ON UPDATE CASCADE,
    completado_id BIGINT NOT NULL REFERENCES completados (id) ON DELETE CASCADE ON UPDATE CASCADE,
    cuerpo TEXT NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    edited_at TIMESTAMP
);

DROP TABLE IF EXISTS conversaciones CASCADE;

CREATE TABLE conversaciones (
    id BIGSERIAL PRIMARY KEY,
    id_user1 BIGINT NOT NULL REFERENCES usuarios (id) ON DELETE CASCADE ON UPDATE CASCADE,
    id_user2 BIGINT NOT NULL REFERENCES usuarios (id) ON DELETE CASCADE ON UPDATE CASCADE
);

DROP TABLE IF EXISTS mensajes CASCADE;

CREATE TABLE mensajes (
    id BIGSERIAL PRIMARY KEY,
    id_sender BIGINT NOT NULL REFERENCES usuarios (id) ON DELETE CASCADE ON UPDATE CASCADE,
    cuerpo TEXT,
    leido BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    id_conversacion BIGINT NOT NULL REFERENCES conversaciones(id) ON DELETE CASCADE ON UPDATE CASCADE
);

DROP TABLE IF EXISTS seleccion CASCADE;

CREATE TABLE seleccion (
    usuario_id BIGINT PRIMARY KEY REFERENCES usuarios (id) ON DELETE CASCADE ON UPDATE CASCADE,
    fechas boolean DEFAULT TRUE,
    anterior boolean DEFAULT TRUE,
    debut boolean DEFAULT TRUE
);

INSERT INTO
    usuarios (
        username,
        nombre,
        apellidos,
        PASSWORD,
        email,
        rol
    )
VALUES
    (
        'josesabor',
        'José María',
        'Saborido Monge',
        '$2y$13$IT4m7G6xRaN6M6AXWTfiZ.1m3/sV5ljpD64VWCPjX0vaOfGOaZvhG',
        'josemaria.saborido@iesdonana.org',
        'ADMIN'
    ),
    (
        'pepe',
        'pepe',
        'pepe',
        '$2a$10$Tr9k2vCnBdxsqOSQqjClEeFat22FdTWAZyJc4U9a5U/ERmmSF74ru',
        'pepe@iesdoñana.pepe',
        'USER'
    );

INSERT INTO
    seguidores(seguidor_id, seguido_id)
VALUES
    (1, 2);

INSERT INTO
    conversaciones(id_user1, id_user2)
VALUES
    (1, 2);

INSERT INTO
    mensajes(id_sender, id_conversacion, cuerpo)
VALUES
    (1, 1, 'Hola');

INSERT INTO
    seleccion (usuario_id)
VALUES
    (1);

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
    (34, 'Novela Grafica'),
    (35, 'Juegos de mesa'),
    (36, 'MOBA');

INSERT INTO
    juegos (api, nombre, genero_id, year_debut, img_api)
VALUES
    (1802, 'Chrono Trigger', 12, 1995, 'co1r7m'),
    (481, 'Silent Hill 2', 9, 2001, 'co1p0a'),
    (480, 'Silent Hill', 9, 1999, 'co1uti'),
    (482, 'Silent Hill 3', 9, 2003, 'co1p0b'),
    (
        8222,
        'Dark Souls II: Scholar of the First Sin',
        12,
        2015,
        'co20um'
    ),
    (7334, 'Bloodborne', 12, 2015, 'co1rba'),
    (
        374,
        'Metal Gear',
        5,
        1987,
        'pd9u2f5zmlzh6jvfrhha'
    ),
    (
        377,
        'Metal Gear 2: Solid Snake',
        31,
        1990,
        'co1v8d'
    ),
    (375, 'Metal Gear Solid', 15, 1998, 'co1v82'),
    (
        376,
        'Metal Gear Solid 2: Sons of Liberty',
        31,
        2001,
        'co1ox2'
    ),
    (
        379,
        'Metal Gear Solid 3: Snake Eater',
        5,
        2004,
        'co1ox4'
    ),
    (
        380,
        'Metal Gear Solid 4: Guns of the Patriots',
        5,
        2008,
        'co1v84'
    ),
    (2585, 'Skate', 13, 2007, 't1xdmprs3jpiu7plohch'),
    (2350, 'Mario Kart 8', 10, 2014, 'co213q'),
    (
        2586,
        'Skate 2',
        10,
        2009,
        'wkwd1ga1qr9xrudotbsw'
    ),
    (
        7346,
        'The Legend of Zelda: Breath of the Wild',
        12,
        2017,
        'co1vcp'
    ),
    (2587, 'Skate 3', 14, 2010, 'co1o4l'),
    (2180, 'Super Mario 3D World', 8, 2013, 'co21vd'),
    (7091, 'MX vs. ATV Reflex', 10, 2009, 'co1the'),
    (
        733,
        'Grand Theft Auto: Vice City',
        5,
        2003,
        'co1tgv'
    ),
    (
        3262,
        'Grand Theft Auto: Vice City Stories',
        10,
        2006,
        'co1ng2'
    ),
    (
        3263,
        'Grand Theft Auto: Liberty City Stories',
        10,
        2005,
        'co1th1'
    ),
    (
        2484,
        'Pro Evolution Soccer 6',
        14,
        2005,
        'co1ug9'
    ),
    (
        96,
        'Need for Speed: Underground',
        10,
        2003,
        'co209g'
    ),
    (
        20456,
        'Resident Evil: Deadly Silence',
        5,
        2006,
        'co20cb'
    ),
    (
        97,
        'Need for Speed: Underground 2',
        10,
        2004,
        'co209h'
    ),
    (
        913,
        'Tony Hawk''s Pro Skater 2',
        14,
        2000,
        'co1y77'
    ),
    (
        6692,
        'Tony Hawk''s Pro Skater',
        14,
        1999,
        'co1y79'
    ),
    (24869, 'Resident Evil', 9, 2002, 'co1pe8'),
    (
        98,
        'Need for Speed: Most Wanted',
        10,
        2005,
        'co209j'
    ),
    (7498, 'Tekken 7', 4, 2015, 'co1w4f'),
    (
        3619,
        'Toy Story 2: Buzz Lightyear to the Rescue',
        8,
        1999,
        'jpg5xmq4fcyvrzp3tq9o'
    ),
    (1289, 'Ratchet & Clank', 5, 2002, 'co1oym'),
    (
        1770,
        'Ratchet & Clank: Going Commando',
        5,
        2003,
        'co230n'
    ),
    (
        47381,
        'Dirt 3: Complete Edition',
        10,
        2015,
        'co1nsn'
    ),
    (
        5328,
        'Metal Gear Solid V: Ground Zeroes',
        5,
        2014,
        'co1v88'
    ),
    (9806, 'Hyper Light Drifter', 8, 2016, 'co1rh3'),
    (14593, 'Hollow Knight', 8, 2017, 'co1rgi'),
    (
        1985,
        'Metal Gear Solid V: The Phantom Pain',
        5,
        2015,
        'co1v85'
    ),
    (8774, 'Grow Home', 8, 2015, 'co217x'),
    (
        25532,
        'Fallout: New Vegas - Ultimate Edition',
        5,
        2010,
        'co1ybz'
    ),
    (1051, 'Mirror''s Edge', 4, 2008, 'co1n5g'),
    (
        37,
        'Dead Space',
        5,
        2008,
        'exlxirelwzpoqftj8phf'
    ),
    (121, 'Minecraft', 13, 2011, 'co1x7j'),
    (
        78153,
        'Burnout Paradise Remastered',
        10,
        2018,
        'lviuichzlt8bhquwtqu6'
    ),
    (
        4006,
        'Metal Gear Solid: Twin Snakes',
        31,
        2004,
        'co1v8c'
    ),
    (25580, 'Forager', 13, 2019, 'co1hdc'),
    (
        914,
        'Tony Hawk''s Pro Skater 3',
        14,
        2001,
        'co1o73'
    ),
    (
        47325,
        'Tony Hawk''s Pro Skater 2X',
        14,
        2001,
        'ovv7t3mh8jhhglxwgc4j'
    ),
    (
        1577,
        'Spyro 2: Ripto''s Rage!',
        8,
        1999,
        'co1u2f'
    ),
    (
        1026,
        'The Legend of Zelda: A Link to the Past',
        12,
        1991,
        'co1nqk'
    ),
    (
        1027,
        'The Legend of Zelda: Link''s Awakening DX',
        31,
        1998,
        'co1o4a'
    ),
    (
        1032,
        'The Legend of Zelda: Oracle of Seasons',
        12,
        2001,
        'co1nrd'
    ),
    (
        1041,
        'The Legend of Zelda: Oracle of Ages',
        12,
        2001,
        'co1nre'
    ),
    (
        1035,
        'The Legend of Zelda: The Minish Cap',
        12,
        2004,
        'co1uja'
    ),
    (
        52200,
        'Descenders',
        10,
        2018,
        'ouo8qsui9yq0jjgg9gsy'
    ),
    (11065, 'Ratchet & Clank', 5, 2016, 'co230k'),
    (
        25076,
        'Red Dead Redemption 2',
        5,
        2018,
        'co1q1f'
    ),
    (
        75449,
        'Resident Evil 7: Biohazard',
        5,
        2017,
        'co1l49'
    ),
    (19686, 'Resident Evil 2', 5, 2019, 'co1ir3'),
    (
        11233,
        'What Remains of Edith Finch',
        9,
        2017,
        'co1rbj'
    ),
    (9727, 'SOMA', 31, 2015, 'm6bll6ci6sy7ollxttj1'),
    (7621, 'Rime', 8, 2017, 'co1rcl'),
    (11156, 'Horizon Zero Dawn', 5, 2017, 'co1izx'),
    (19560, 'God Of War', 12, 2018, 'co1tmu'),
    (
        19565,
        'Marvel''s Spider-Man',
        25,
        2018,
        'co1r77'
    ),
    (
        87683,
        'Spyro Reignited Trilogy',
        8,
        2019,
        'co1tjo'
    ),
    (1075, 'Super Mario Sunshine', 8, 2002, 'co21rh'),
    (1103, 'Super Metroid', 5, 1994, 'co1o11'),
    (
        1107,
        'Metroid: Zero Mission',
        5,
        2004,
        'co1vci'
    ),
    (1104, 'Metroid Fusion', 5, 2002, 'co1vb9'),
    (1077, 'Super Mario Galaxy', 8, 2007, 'co21ro'),
    (
        1102,
        'Metroid II: Return of Samus',
        5,
        2016,
        'co1wwx'
    ),
    (
        26820,
        'Blasphemous',
        8,
        2019,
        'esby831i9tkzlbr9lth6'
    ),
    (96476, 'Horizon Chase Turbo', 10, 2018, 'co1iyy'),
    (71, 'Portal', 5, 2007, 'co1x7d'),
    (
        19456,
        'Ori and the Blind Forest: Definitive Edition',
        8,
        2015,
        'co1y40'
    ),
    (26226, 'Celeste', 8, 2018, 'co1vcd'),
    (
        1128,
        'Castlevania: Symphony of the Night',
        8,
        1997,
        'co1nh3'
    ),
    (20150, 'Katana ZERO', 8, 2019, 'co1isp'),
    (
        27832,
        'The Witcher: Enhanced Edition Director''s Cut',
        12,
        2008,
        'gxalrv8blq7k4lkzzvc6'
    ),
    (943, 'Colin McRae: Dirt', 10, 2007, 'co1si7'),
    (424, 'Resident Evil', 31, 1996, 'co20bp'),
    (9730, 'Firewatch', 31, 2016, 'co1m35'),
    (
        6643,
        'Tony Hawk ''s American Sk8land',
        14,
        2005,
        'eeq4sjbaildexl0kshh8'
    ),
    (22917, 'GRIS', 8, 2018, 'co1qv5'),
    (131705, 'SLUDGE LIFE', 31, 2020, 'co205p');

INSERT INTO
    completados(usuario_id, juego_id, consola_id, fecha, pasado)
VALUES
    (1, 1, 1, '2017/1/6', FALSE),
    (1, 2, 8, '2017/1/23', FALSE),
    (1, 3, 8, '2017/2/8', FALSE),
    (1, 4, 5, '2017/2/14', FALSE),
    (1, 5, 8, '2017/3/6', FALSE),
    (1, 6, 7, '2017/4/1', FALSE),
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
    (1, 29, 8, '2018/6/28', FALSE),
    (1, 20, 8, '2018/7/4', TRUE),
    (1, 21, 8, '2018/7/7', TRUE),
    (1, 22, 8, '2018/7/10', TRUE),
    (1, 23, 8, '2018/7/28', TRUE),
    (1, 24, 8, '2018/8/8', TRUE),
    (1, 25, 3, '2018/8/27', FALSE),
    (1, 26, 8, '2018/8/28', FALSE),
    (1, 27, 9, '2018/9/9', FALSE),
    (1, 28, 9, '2018/9/10', FALSE),
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
    (1, 65, 7, '2019/9/16', FALSE),
    (1, 66, 7, '2019/10/5', FALSE),
    (1, 67, 8, '2019/10/12', FALSE),
    (1, 11, 6, '2019/10/30', TRUE),
    (1, 68, 2, '2019/11/5', FALSE),
    (1, 69, 10, '2019/11/17', FALSE),
    (1, 70, 10, '2019/11/19', FALSE),
    (1, 71, 10, '2019/11/23', FALSE),
    (1, 72, 10, '2019/11/23', FALSE),
    (1, 73, 8, '2019/11/24', FALSE),
    (1, 74, 8, '2019/12/11', FALSE),
    (1, 75, 8, '2019/12/12', FALSE),
    (1, 76, 8, '2019/12/14', TRUE),
    (1, 77, 8, '2019/12/15', FALSE),
    (1, 78, 8, '2019/12/15', FALSE),
    (1, 79, 9, '2019/12/21', FALSE),
    (1, 80, 8, '2019/12/21', FALSE),
    (1, 81, 8, '2020/1/3', FALSE),
    (1, 82, 8, '2020/1/23', FALSE),
    (1, 83, 8, '2020/3/5', TRUE),
    (1, 84, 8, '2020/3/10', FALSE),
    (1, 85, 3, '2020/4/8', FALSE),
    (1, 86, 8, '2020/4/25', FALSE),
    (1, 87, 8, '2020/5/31', FALSE),
    (2, 85, 4, '2020/3/27', FALSE);

INSERT INTO
    comentarios_completados (usuario_id, completado_id, cuerpo)
VALUES
    (1, 1, 'hola');

INSERT INTO
    pendientes (usuario_id, juego_id, consola_id, pasado, tengo)
VALUES
    (2, 69, 4, false, true);