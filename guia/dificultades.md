# Dificultades encontradas


#### IGDB

Debido a que usamos un wrapper de PHP no oficial la documentación que existe sobre este wrapper es limitada apenas hay información y he tenido que experimentar bastante sobre que se puede hacer y que no se puede hacer, además de tener que "traducir" la informacion de la api original a como la deberia de usar el wrapper.

#### Encontrarle un hueco a JQuery UI

Como hemos mencionado en las decisiones, hemos tenido que encontrar el sitio donde menos molestase JQuery UI, por eso hemos definido que el mejor sitio es el boton de seguir y dejar de seguir usuarios ya que aprovechamos la animación para cambiar el texto.

#### *Transición en la base de datos*

Debido a que la base de datos se inicio desde una hoja de cálculo que llevaba desde 2017 recogiendo información hemos tenido que hacer muchos cambios a la base de datos. Estas son las difucultades que hemos encontrado:
1. Al principio era una tabla llamada juegos que tenia `id`, `dia`, `mes`, `año`, `nombre`, `consola`, `pasado`, `genero` y `debut`. Esto se acabo cambiando a `id` `fecha`, `nombre`,`consola_id`,`pasado`,`genero_id` y `debut`.
2. Despues de esto, se cambio la tabla de juegos a juegos completados,separandolo en dos tablas, teniendo en la tabla juegos
`id`, `nombre`,`genero_id` y `debut`(despues se le añadiria a esta tabla los datos de la api). Con lo que la tabla completados quedaria con la siguiente estructura:
`id`, `usuario_id`,`juego_id`,`consola_id`,`fecha` y `pasado`.
3. Como la base de datos tenia los datos almacenados desde 2017, a la hora de cambiar datos, se tenian que cambiar más de 80 entradas, ya sea para juego completado o para juego.
4. Se tuvo que cambiar el formato de la fecha de 'DIA/MES/AÑO' a 'AÑO/MES/DIA' debido a problemas con heroku.
5. Despues de esto se decidio poner que el id del juego fuera el mismo que en la API, pero al final se puso como un campo aparte, teniendo que cambiar 2 veces las entradas.
6. Debido al problema mencionado anteriormente con los géneros, no cambiamos la base de datos porque tendriamos que cambiar 80 entradas de juegos y hacer mínimo el doble de inserciones en otra tabla. Si se empezara este proyecto desde 0 o se tuviera mas tiempo se podria arreglar.
