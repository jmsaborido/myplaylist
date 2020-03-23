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
    fecha date NOT NULL DEFAULT CURRENT_DATE,
    nombre varchar(100) NOT NULL,
    consola_id bigint NOT NULL REFERENCES consolas (id),
    pasado boolean,
    genero_id bigint NOT NULL REFERENCES generos (id),
    year_debut smallint CONSTRAINT ck_primer_videojuego CHECK (year_debut >= 1950),
    usuario_id bigint NOT NULL REFERENCES usuarios (id)
);

INSERT INTO usuarios (LOGIN, nombre, apellidos, PASSWORD, email, rol)
    VALUES ('josesabor', 'José María', 'Saborido Monge', '$2y$13$IT4m7G6xRaN6M6AXWTfiZ.1m3/sV5ljpD64VWCPjX0vaOfGOaZvhG', 'josemaria.saborido@iesdonana.org', 'ADMIN');

INSERT INTO usuarios (LOGIN, nombre, apellidos, PASSWORD, email, rol)
    VALUES ('pepe', 'pepe', 'pepe', '$2a$10$Tr9k2vCnBdxsqOSQqjClEeFat22FdTWAZyJc4U9a5U/ERmmSF74ru', 'pepe@iesdonana.org', 'USER');

INSERT INTO consolas (denom)
    VALUES ('Android'), ('Gamecube'), ('NDS'), ('PS1'), ('PS2'), ('PS3'), ('PS4'), ('PC'), ('Raspberry'), ('Wii U'), ('XBOX 360');

INSERT INTO generos (denom)
    VALUES ('ARPG'), ('Conduccion'), ('Deportes Extremos'), ('Espionaje'), ('Futbol'), ('Metroidvania'), ('Peleas'), ('Plataformas'), ('RPG'), ('Sandbox'), ('Soulsborne'), ('Supervivencia'), ('Terror'), ('Walking Simulator');


/* INSERT QUERY NO: 1 */
INSERT INTO juegos (fecha, nombre, consola_id, pasado, genero_id, year_debut, usuario_id)
    VALUES ('2017/1/6', 'Chrono Trigger', 1, FALSE, 9, 1995, 1);


/* INSERT QUERY NO: 2 */
INSERT INTO juegos (fecha, nombre, consola_id, pasado, genero_id, year_debut, usuario_id)
    VALUES ('2017/1/23', 'Silent Hill 2', 8, FALSE, 13, 2001, 1);


/* INSERT QUERY NO: 3 */
INSERT INTO juegos (fecha, nombre, consola_id, pasado, genero_id, year_debut, usuario_id)
    VALUES ('2017/2/8', 'Silent Hill', 8, FALSE, 13, 1999, 1);


/* INSERT QUERY NO: 4 */
INSERT INTO juegos (fecha, nombre, consola_id, pasado, genero_id, year_debut, usuario_id)
    VALUES ('2017/2/14', 'Silent Hill 3', 5, FALSE, 13, 2003, 1);


/* INSERT QUERY NO: 5 */
INSERT INTO juegos (fecha, nombre, consola_id, pasado, genero_id, year_debut, usuario_id)
    VALUES ('2017/3/6', 'Dark Souls 2', 8, FALSE, 11, 2014, 1);


/* INSERT QUERY NO: 6 */
INSERT INTO juegos (fecha, nombre, consola_id, pasado, genero_id, year_debut, usuario_id)
    VALUES ('2017/4/1', 'Bloodborne', 7, FALSE, 11, 2015, 1);


/* INSERT QUERY NO: 7 */
INSERT INTO juegos (fecha, nombre, consola_id, pasado, genero_id, year_debut, usuario_id)
    VALUES ('2017/4/29', 'Metal Gear', 6, FALSE, 4, 1987, 1);


/* INSERT QUERY NO: 8 */
INSERT INTO juegos (fecha, nombre, consola_id, pasado, genero_id, year_debut, usuario_id)
    VALUES ('2017/5/1', 'Metal Gear 2 Solid Snake', 6, FALSE, 4, 1990, 1);


/* INSERT QUERY NO: 9 */
INSERT INTO juegos (fecha, nombre, consola_id, pasado, genero_id, year_debut, usuario_id)
    VALUES ('2017/5/4', 'Metal Gear Solid ', 6, TRUE, 4, 1998, 1);


/* INSERT QUERY NO: 10 */
INSERT INTO juegos (fecha, nombre, consola_id, pasado, genero_id, year_debut, usuario_id)
    VALUES ('2017/5/5', 'Metal Gear Solid 2: Sons Of Liberty', 6, TRUE, 4, 2001, 1);


/* INSERT QUERY NO: 11 */
INSERT INTO juegos (fecha, nombre, consola_id, pasado, genero_id, year_debut, usuario_id)
    VALUES ('2017/5/1', 'Metal Gear Solid 3: Snake Eater', 6, TRUE, 4, 2004, 1);


/* INSERT QUERY NO: 12 */
INSERT INTO juegos (fecha, nombre, consola_id, pasado, genero_id, year_debut, usuario_id)
    VALUES ('2017/5/23', 'Metal Gear Solid 4: Guns Of The Patriots', 6, TRUE, 4, 2008, 1);


/* INSERT QUERY NO: 13 */
INSERT INTO juegos (fecha, nombre, consola_id, pasado, genero_id, year_debut, usuario_id)
    VALUES ('2018/1/5', 'skate.', 6, FALSE, 3, 2007, 1);


/* INSERT QUERY NO: 14 */
INSERT INTO juegos (fecha, nombre, consola_id, pasado, genero_id, year_debut, usuario_id)
    VALUES ('2018/1/27', 'Mario Kart 8', 10, FALSE, 2, 2014, 1);


/* INSERT QUERY NO: 15 */
INSERT INTO juegos (fecha, nombre, consola_id, pasado, genero_id, year_debut, usuario_id)
    VALUES ('2018/2/14', 'Skate 2', 6, FALSE, 3, 2009, 1);


/* INSERT QUERY NO: 16 */
INSERT INTO juegos (fecha, nombre, consola_id, pasado, genero_id, year_debut, usuario_id)
    VALUES ('2018/3/8', 'The Legend Of Zelda: Breath Of The Wild', 10, FALSE, 1, 2017, 1);


/* INSERT QUERY NO: 17 */
INSERT INTO juegos (fecha, nombre, consola_id, pasado, genero_id, year_debut, usuario_id)
    VALUES ('2018/3/13', 'Skate 3', 6, FALSE, 3, 2010, 1);


/* INSERT QUERY NO: 18 */
INSERT INTO juegos (fecha, nombre, consola_id, pasado, genero_id, year_debut, usuario_id)
    VALUES ('2018/3/15', 'Super Mario 3D World', 10, FALSE, 8, 2013, 1);


/* INSERT QUERY NO: 19 */
INSERT INTO juegos (fecha, nombre, consola_id, pasado, genero_id, year_debut, usuario_id)
    VALUES ('2018/6/28', 'MX vs. ATV Reflex', 8, FALSE, 2, 2009, 1);


/* INSERT QUERY NO: 20 */
INSERT INTO juegos (fecha, nombre, consola_id, pasado, genero_id, year_debut, usuario_id)
    VALUES ('2018/7/4', 'Grand Theft Auto: Vice City', 8, TRUE, 10, 2003, 1);


/* INSERT QUERY NO: 21 */
INSERT INTO juegos (fecha, nombre, consola_id, pasado, genero_id, year_debut, usuario_id)
    VALUES ('2018/7/7', 'Grand Theft Auto: Vice City Stories', 8, TRUE, 10, 2006, 1);


/* INSERT QUERY NO: 22 */
INSERT INTO juegos (fecha, nombre, consola_id, pasado, genero_id, year_debut, usuario_id)
    VALUES ('2018/7/10', 'Grand Theft Auto: Liberty City Stories', 8, TRUE, 10, 2005, 1);


/* INSERT QUERY NO: 23 */
INSERT INTO juegos (fecha, nombre, consola_id, pasado, genero_id, year_debut, usuario_id)
    VALUES ('2018/7/28', 'Pro Evolution Soccer 6', 8, TRUE, 5, 2005, 1);


/* INSERT QUERY NO: 24 */
INSERT INTO juegos (fecha, nombre, consola_id, pasado, genero_id, year_debut, usuario_id)
    VALUES ('2018/8/8', 'Need For Speed Underground', 8, TRUE, 2, 2003, 1);


/* INSERT QUERY NO: 25 */
INSERT INTO juegos (fecha, nombre, consola_id, pasado, genero_id, year_debut, usuario_id)
    VALUES ('2018/8/27', 'Resident Evil DS', 3, FALSE, 13, 1996, 1);


/* INSERT QUERY NO: 26 */
INSERT INTO juegos (fecha, nombre, consola_id, pasado, genero_id, year_debut, usuario_id)
    VALUES ('2018/8/28', 'Need For Speed Underground 2', 8, FALSE, 2, 2004, 1);


/* INSERT QUERY NO: 27 */
INSERT INTO juegos (fecha, nombre, consola_id, pasado, genero_id, year_debut, usuario_id)
    VALUES ('2018/9/9', 'Tony Hawk s Pro Skater 2', 9, FALSE, 3, 2000, 1);


/* INSERT QUERY NO: 28 */
INSERT INTO juegos (fecha, nombre, consola_id, pasado, genero_id, year_debut, usuario_id)
    VALUES ('2018/9/10', 'Tony Hawks Pro Skater', 9, FALSE, 3, 1999, 1);


/* INSERT QUERY NO: 29 */
INSERT INTO juegos (fecha, nombre, consola_id, pasado, genero_id, year_debut, usuario_id)
    VALUES ('2018/9/17', 'Resident Evil Remake', 11, FALSE, 13, 2002, 1);


/* INSERT QUERY NO: 30 */
INSERT INTO juegos (fecha, nombre, consola_id, pasado, genero_id, year_debut, usuario_id)
    VALUES ('2018/9/26', 'Need For Speed Most Wanted', 11, TRUE, 2, 2005, 1);


/* INSERT QUERY NO: 31 */
INSERT INTO juegos (fecha, nombre, consola_id, pasado, genero_id, year_debut, usuario_id)
    VALUES ('2018/9/30', 'Tekken 7', 8, FALSE, 7, 2015, 1);


/* INSERT QUERY NO: 32 */
INSERT INTO juegos (fecha, nombre, consola_id, pasado, genero_id, year_debut, usuario_id)
    VALUES ('2018/10/6', 'Toy Story 2', 9, FALSE, 8, 1999, 1);


/* INSERT QUERY NO: 33 */
INSERT INTO juegos (fecha, nombre, consola_id, pasado, genero_id, year_debut, usuario_id)
    VALUES ('2018/10/31', 'Ratchet And Clank', 5, TRUE, 8, 2002, 1);


/* INSERT QUERY NO: 34 */
INSERT INTO juegos (fecha, nombre, consola_id, pasado, genero_id, year_debut, usuario_id)
    VALUES ('2018/11/4', 'Ratchet & Clank 2: Totalmente a tope', 5, TRUE, 8, 2003, 1);


/* INSERT QUERY NO: 35 */
INSERT INTO juegos (fecha, nombre, consola_id, pasado, genero_id, year_debut, usuario_id)
    VALUES ('2018/11/9', 'Dirt 3', 8, FALSE, 2, 2015, 1);


/* INSERT QUERY NO: 36 */
INSERT INTO juegos (fecha, nombre, consola_id, pasado, genero_id, year_debut, usuario_id)
    VALUES ('2018/11/12', 'Metal Gear Solid 5: Ground Zeroes', 8, TRUE, 4, 2014, 1);


/* INSERT QUERY NO: 37 */
INSERT INTO juegos (fecha, nombre, consola_id, pasado, genero_id, year_debut, usuario_id)
    VALUES ('2018/11/16', 'Hyper Light Drifter ', 8, FALSE, 6, 2016, 1);


/* INSERT QUERY NO: 38 */
INSERT INTO juegos (fecha, nombre, consola_id, pasado, genero_id, year_debut, usuario_id)
    VALUES ('2018/11/23', 'Hollow Knight', 8, FALSE, 6, 2017, 1);


/* INSERT QUERY NO: 39 */
INSERT INTO juegos (fecha, nombre, consola_id, pasado, genero_id, year_debut, usuario_id)
    VALUES ('2018/11/30', 'Metal Gear Solid 5: The Phantom Pain', 8, TRUE, 4, 2015, 1);


/* INSERT QUERY NO: 40 */
INSERT INTO juegos (fecha, nombre, consola_id, pasado, genero_id, year_debut, usuario_id)
    VALUES ('2018/11/30', 'Grow Home', 8, FALSE, 8, 2015, 1);


/* INSERT QUERY NO: 41 */
INSERT INTO juegos (fecha, nombre, consola_id, pasado, genero_id, year_debut, usuario_id)
    VALUES ('2018/12/27', 'Fallout New Vegas', 8, FALSE, 9, 2010, 1);


/* INSERT QUERY NO: 42 */
INSERT INTO juegos (fecha, nombre, consola_id, pasado, genero_id, year_debut, usuario_id)
    VALUES ('2019/1/24', 'Mirrors Edge', 8, TRUE, 8, 2008, 1);


/* INSERT QUERY NO: 43 */
INSERT INTO juegos (fecha, nombre, consola_id, pasado, genero_id, year_debut, usuario_id)
    VALUES ('2019/1/28', 'Dead Space', 8, TRUE, 13, 2008, 1);


/* INSERT QUERY NO: 44 */
INSERT INTO juegos (fecha, nombre, consola_id, pasado, genero_id, year_debut, usuario_id)
    VALUES ('2019/2/28', 'Minecraft', 8, TRUE, 12, 2011, 1);


/* INSERT QUERY NO: 45 */
INSERT INTO juegos (fecha, nombre, consola_id, pasado, genero_id, year_debut, usuario_id)
    VALUES ('2019/4/18', 'Burnout Paradise', 8, FALSE, 2, 2008, 1);


/* INSERT QUERY NO: 46 */
INSERT INTO juegos (fecha, nombre, consola_id, pasado, genero_id, year_debut, usuario_id)
    VALUES ('2019/5/2', 'Metal Gear Solid: Twin Snakes', 8, TRUE, 4, 2004, 1);


/* INSERT QUERY NO: 47 */
INSERT INTO juegos (fecha, nombre, consola_id, pasado, genero_id, year_debut, usuario_id)
    VALUES ('2019/5/8', 'Forager', 8, FALSE, 12, 2019, 1);


/* INSERT QUERY NO: 48 */
INSERT INTO juegos (fecha, nombre, consola_id, pasado, genero_id, year_debut, usuario_id)
    VALUES ('2019/5/9', 'Metal Gear Solid', 6, TRUE, 4, 1998, 1);


/* INSERT QUERY NO: 49 */
INSERT INTO juegos (fecha, nombre, consola_id, pasado, genero_id, year_debut, usuario_id)
    VALUES ('2019/5/11', 'Tony Hawks Pro Skater 3 (PS1)', 9, FALSE, 3, 2001, 1);


/* INSERT QUERY NO: 50 */
INSERT INTO juegos (fecha, nombre, consola_id, pasado, genero_id, year_debut, usuario_id)
    VALUES ('2019/5/13', 'Tony Hawk Pro Skater 2X', 8, FALSE, 3, 2001, 1);


/* INSERT QUERY NO: 51 */
INSERT INTO juegos (fecha, nombre, consola_id, pasado, genero_id, year_debut, usuario_id)
    VALUES ('2019/5/29', 'Spyro 2', 8, TRUE, 8, 1999, 1);


/* INSERT QUERY NO: 52 */
INSERT INTO juegos (fecha, nombre, consola_id, pasado, genero_id, year_debut, usuario_id)
    VALUES ('2019/6/7', 'The Legend Of Zelda: A Link To The Past', 10, FALSE, 1, 1991, 1);


/* INSERT QUERY NO: 53 */
INSERT INTO juegos (fecha, nombre, consola_id, pasado, genero_id, year_debut, usuario_id)
    VALUES ('2019/6/16', 'The Legend Of Zelda: Links Awakening', 10, FALSE, 1, 1993, 1);


/* INSERT QUERY NO: 54 */
INSERT INTO juegos (fecha, nombre, consola_id, pasado, genero_id, year_debut, usuario_id)
    VALUES ('2019/6/19', 'The Legend Of Zelda: Oracle Of Seasons', 10, FALSE, 1, 2001, 1);


/* INSERT QUERY NO: 55 */
INSERT INTO juegos (fecha, nombre, consola_id, pasado, genero_id, year_debut, usuario_id)
    VALUES ('2019/6/26', 'The Legend Of Zelda: Oracle Of Ages', 10, FALSE, 1, 2001, 1);


/* INSERT QUERY NO: 56 */
INSERT INTO juegos (fecha, nombre, consola_id, pasado, genero_id, year_debut, usuario_id)
    VALUES ('2019/6/29', 'The Legend Of Zelda:The Minish Cap', 10, FALSE, 1, 2004, 1);


/* INSERT QUERY NO: 57 */
INSERT INTO juegos (fecha, nombre, consola_id, pasado, genero_id, year_debut, usuario_id)
    VALUES ('2019/7/5', 'Descenders', 8, FALSE, 3, 2019, 1);


/* INSERT QUERY NO: 58 */
INSERT INTO juegos (fecha, nombre, consola_id, pasado, genero_id, year_debut, usuario_id)
    VALUES ('2019/7/16', 'Ratchet And Clank PS4', 7, FALSE, 8, 2016, 1);


/* INSERT QUERY NO: 59 */
INSERT INTO juegos (fecha, nombre, consola_id, pasado, genero_id, year_debut, usuario_id)
    VALUES ('2019/7/25', 'Red Dead Redemption 2 ', 7, FALSE, 10, 2018, 1);


/* INSERT QUERY NO: 60 */
INSERT INTO juegos (fecha, nombre, consola_id, pasado, genero_id, year_debut, usuario_id)
    VALUES ('2019/7/27', 'Resident Evil 7', 7, FALSE, 13, 2017, 1);


/* INSERT QUERY NO: 61 */
INSERT INTO juegos (fecha, nombre, consola_id, pasado, genero_id, year_debut, usuario_id)
    VALUES ('2019/7/30', 'Resident Evil 2 Remake', 7, FALSE, 13, 2019, 1);


/* INSERT QUERY NO: 62 */
INSERT INTO juegos (fecha, nombre, consola_id, pasado, genero_id, year_debut, usuario_id)
    VALUES ('2019/8/1', 'What Remains Of Edith Finch', 7, FALSE, 14, 2017, 1);


/* INSERT QUERY NO: 63 */
INSERT INTO juegos (fecha, nombre, consola_id, pasado, genero_id, year_debut, usuario_id)
    VALUES ('2019/8/2', 'Soma', 7, FALSE, 14, 2015, 1);


/* INSERT QUERY NO: 64 */
INSERT INTO juegos (fecha, nombre, consola_id, pasado, genero_id, year_debut, usuario_id)
    VALUES ('2019/8/4', 'RiME', 7, FALSE, 8, 2017, 1);


/* INSERT QUERY NO: 65 */
INSERT INTO juegos (fecha, nombre, consola_id, pasado, genero_id, year_debut, usuario_id)
    VALUES ('2019/8/6', 'Metal Gear Solid 2: Sons Of Liberty', 6, TRUE, 4, 2001, 1);


/* INSERT QUERY NO: 66 */
INSERT INTO juegos (fecha, nombre, consola_id, pasado, genero_id, year_debut, usuario_id)
    VALUES ('2019/8/15', 'Horizon Zero Dawn', 7, FALSE, 1, 2017, 1);


/* INSERT QUERY NO: 67 */
INSERT INTO juegos (fecha, nombre, consola_id, pasado, genero_id, year_debut, usuario_id)
    VALUES ('2019/9/16', 'God Of War 4', 7, FALSE, 1, 2018, 1);


/* INSERT QUERY NO: 68 */
INSERT INTO juegos (fecha, nombre, consola_id, pasado, genero_id, year_debut, usuario_id)
    VALUES ('2019/10/5', 'Spiderman', 7, FALSE, 1, 2018, 1);


/* INSERT QUERY NO: 69 */
INSERT INTO juegos (fecha, nombre, consola_id, pasado, genero_id, year_debut, usuario_id)
    VALUES ('2019/10/9', 'Spyro Reignited', 8, FALSE, 8, 2019, 1);


/* INSERT QUERY NO: 70 */
INSERT INTO juegos (fecha, nombre, consola_id, pasado, genero_id, year_debut, usuario_id)
    VALUES ('2019/10/11', 'Spyro 2 Reignited', 8, FALSE, 8, 2019, 1);


/* INSERT QUERY NO: 71 */
INSERT INTO juegos (fecha, nombre, consola_id, pasado, genero_id, year_debut, usuario_id)
    VALUES ('2019/10/12', 'Spyro 3 Reignited', 8, FALSE, 8, 2019, 1);


/* INSERT QUERY NO: 72 */
INSERT INTO juegos (fecha, nombre, consola_id, pasado, genero_id, year_debut, usuario_id)
    VALUES ('2019/10/30', 'Metal Gear Solid 3: Snake Eater', 6, TRUE, 4, 2004, 1);


/* INSERT QUERY NO: 73 */
INSERT INTO juegos (fecha, nombre, consola_id, pasado, genero_id, year_debut, usuario_id)
    VALUES ('2019/11/5', 'Super Mario Sunshine', 2, FALSE, 8, 2002, 1);


/* INSERT QUERY NO: 74 */
INSERT INTO juegos (fecha, nombre, consola_id, pasado, genero_id, year_debut, usuario_id)
    VALUES ('2019/11/17', 'Super Metroid', 10, FALSE, 6, 1994, 1);


/* INSERT QUERY NO: 75 */
INSERT INTO juegos (fecha, nombre, consola_id, pasado, genero_id, year_debut, usuario_id)
    VALUES ('2019/11/19', 'Metroid Zero Mission', 10, FALSE, 6, 2004, 1);


/* INSERT QUERY NO: 76 */
INSERT INTO juegos (fecha, nombre, consola_id, pasado, genero_id, year_debut, usuario_id)
    VALUES ('2019/11/23', 'Metroid Fusion', 10, FALSE, 6, 2002, 1);


/* INSERT QUERY NO: 77 */
INSERT INTO juegos (fecha, nombre, consola_id, pasado, genero_id, year_debut, usuario_id)
    VALUES ('2019/11/23', 'Super Mario Galaxy', 10, FALSE, 8, 2007, 1);


/* INSERT QUERY NO: 78 */
INSERT INTO juegos (fecha, nombre, consola_id, pasado, genero_id, year_debut, usuario_id)
    VALUES ('2019/11/24', 'Metroid 2 (AM2R)', 8, FALSE, 6, 2016, 1);


/* INSERT QUERY NO: 79 */
INSERT INTO juegos (fecha, nombre, consola_id, pasado, genero_id, year_debut, usuario_id)
    VALUES ('2019/12/11', 'Blasphemous', 8, FALSE, 6, 2019, 1);


/* INSERT QUERY NO: 80 */
INSERT INTO juegos (fecha, nombre, consola_id, pasado, genero_id, year_debut, usuario_id)
    VALUES ('2019/12/12', 'Horizon Chase Turbo', 8, FALSE, 2, 2018, 1);


/* INSERT QUERY NO: 81 */
INSERT INTO juegos (fecha, nombre, consola_id, pasado, genero_id, year_debut, usuario_id)
    VALUES ('2019/12/14', 'Portal', 8, TRUE, 8, 2007, 1);


/* INSERT QUERY NO: 82 */
INSERT INTO juegos (fecha, nombre, consola_id, pasado, genero_id, year_debut, usuario_id)
    VALUES ('2019/12/15', 'Ori And The Blind Forest', 8, FALSE, 6, 2015, 1);


/* INSERT QUERY NO: 83 */
INSERT INTO juegos (fecha, nombre, consola_id, pasado, genero_id, year_debut, usuario_id)
    VALUES ('2019/12/15', 'Celeste', 8, FALSE, 8, 2018, 1);


/* INSERT QUERY NO: 84 */
INSERT INTO juegos (fecha, nombre, consola_id, pasado, genero_id, year_debut, usuario_id)
    VALUES ('2019/12/21', 'Castlevania Symphony Of The Night', 9, FALSE, 6, 1997, 1);


/* INSERT QUERY NO: 85 */
INSERT INTO juegos (fecha, nombre, consola_id, pasado, genero_id, year_debut, usuario_id)
    VALUES ('2019/12/21', 'Katana ZERO', 8, FALSE, 8, 2019, 1);


/* INSERT QUERY NO: 86 */
INSERT INTO juegos (fecha, nombre, consola_id, pasado, genero_id, year_debut, usuario_id)
    VALUES ('2020/1/3', 'The Witcher', 8, FALSE, 1, 2007, 1);


/* INSERT QUERY NO: 87 */
INSERT INTO juegos (fecha, nombre, consola_id, pasado, genero_id, year_debut, usuario_id)
    VALUES ('2020/1/23', 'Colin McRae Dirt', 8, FALSE, 2, 2007, 1);


/* INSERT QUERY NO: 88 */
INSERT INTO juegos (fecha, nombre, consola_id, pasado, genero_id, year_debut, usuario_id)
    VALUES ('2020/3/5', 'Resident Evil', 8, TRUE, 2, 1996, 1);


/* INSERT QUERY NO: 89 */
INSERT INTO juegos (fecha, nombre, consola_id, pasado, genero_id, year_debut, usuario_id)
    VALUES ('2020/3/10', 'Firewatch', 8, FALSE, 14, 2016, 1);

/* INSERT QUERY PRUEBA */
INSERT INTO juegos (fecha, nombre, consola_id, pasado, genero_id, year_debut, usuario_id)
    VALUES ('2020/3/10', 'Firewatch', 8, FALSE, 14, 2016, 2);
