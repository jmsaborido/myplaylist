# Decisiones adoptadas

#### Uso de IGDB
- Debido a que en 2020 la plataforma de IGDB no tiene soporte para PHP usamos el wrapper `jschubert/igdb`.


#### Uso de widgets para Yii2 de Kartik
- Para agilizar el desarrollo y con la idea de reutilizar código se han usado varios widgets ya desarrollados por *Kartik* , tales como: `FileInput`, `Password` y `DateControl`.


#### Falta de imagenes a la hora de crear los juegos

Debido a que a la hora de crear los juegos usamos la API de IGDB, si quisiéramos añadirle las imágenes de cada juego a la búsqueda tendríamos que añadir una petición adicional para cada juego para pedirle la imagen a la API, lo cual aumentaría bastante el tiempo de espera a la hora de obtener resultados.


#### Conversión de mensajes a chat

A la hora de redactar los requisitos, se creía que la inclusión de un chat sería tan fácil como añadirle una extensión de chat, pero estas necesitan de las bases de datos en inglés y/o de la base de datos en MySQL, por lo tanto se uso los mensajes no instantáneos que ya teníamos y le añadimos instantaneidad con PJax.

#### JQuery UI

Debido a que tenemos unos requisitos impuestos por el instituto y da igual si esos requistos se adaptan al proyecto o no, he tenido que usar JQuey UI en una animación en el boton de seguir/dejar de seguir usuarios.
Debido a esto la animacion puede resultar molesta.

#### Géneros y Consolas

Cuando se comenzo el proyecto se creia que las tablas de géneros y consolas serian casi identicas pero estas tienen diferencias intrinsecas a pesar de que sus columnas en la base de datos sean las mismas

Consolas:
Las consolas son las consolas con las que un usuario ha completado un juego, un juego no tiene porque haber salido en esa consola, ya que debido a la emulacion en distintas consolas no podemos controlar que juego ha salido donde, es una tabla que queda al control del desarrollador y es la persona encargada en añadir y borrar consolas.

Géneros: Los géneros son los géneros que tienen un juego. Este genero al ser un dato de la API es un dato en el que el desarrollador no tiene que gestionar los datos. Debido a esto se empezo con guardar el id del genero en la tabla de juegos, pero esto no es lo correcto ya que para la API un juego puede tener varios géneros. La decisiones que se tomaron con la tabla de géneros fueron las siguientes:
1. Guardar solo el género con el índice menor en la base de datos, debido a que siempre va a haber al menos uno.
2. Como la API esta completamente en inglés, se decidio usar la tabla como tabla traductora, coincidiendo el ID de la API con el ID de la tabla géneros.
