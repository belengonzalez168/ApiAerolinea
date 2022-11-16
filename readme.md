# VUELING API
API REST que permite manejar un CRUD de los vuelos disponibles por la Aerolinea TUDAI y la informacion asosiada a los mismos, pudiendo ordenar, paginar y filtrar los resultados
Cada vuelo cuenta con los siguientes campos de información:
- id_vuelo : Codigo de identificación unico de vuelo, el mismo se genera de manera automatica, no pudiendo modificarse
- numero : Numero asociado a la ruta realizada
- id_ciudad : Codigo unico de ciudad destino
- fecha : Dia de partida del vuelo
- horaSalida : Horario de salida del vuelo
- horaLlegada : Horario de llegada a destino del vuelo
- escalas : Vdentica si el vuelo es directo o cuenta con escalas
- precio : Valor en dolares del vuelo

A su vez permite manejar un CRUD de las ventas de los vuelos disponibles pudiendo ordenar, paginar y filtrar los resultados
De cada venta se registra:
- id_venta : Codigo de identificación unico de vuelo, el mismo se genera de manera automatica, no pudiendo modificarse
- id_vuelo : asociado a los vuelos disponible
- pasajero : nombre y apellido del pasajero

# Importar base de datos
Importar desde PHPMyAdmin(o derivados) database/aerolinea.sql

# Pruebas desde PostMan 
Las funcionalidades se puede probar desde postman ingresando como endpoint de la API:
- Si desea manejar los vuelos disponobles:
  http://localhost/proyectos/aerolinea-tpe2/vuelo

- sidesea manejar las ventas:
  http://localhost/proyectos/aerolinea-tpe2/venta

# Obtener los Vuelos Disponibles 

-TRAER TODOS
method: GET
Para obtener todos los registros de vuelos: http://localhost/proyectos/aerolinea-tpe2/vuelo

# Obtener los Ventas

-TRAER TODOS
method: GET
Para obtener todos los registros de ventas: http://localhost/proyectos/aerolinea-tpe2/venta

# Obtener un vuelo por su codigo único 
method: GET
Para obtener un vuelo por su registro unico: http://localhost/proyectos/aerolinea-tpe2/vuelo/id_vuelo

# Obtener una venta por su codigo único 
method: GET
Para obtener un venta por su registro unico: http://localhost/proyectos/aerolinea-tpe2/venta/id_venta

# mostrar los vuelos ordenados por un criterio a definir
method: GET
Si se desea obtener los registros ordenados, tanto de manera ascendente como descendente, debe agregar a la URI el parametro ?sort=(campo a ordenar)&order=(asc o desc), por ejemplo si quisieramos ordenar los vuelos por su precio de forma ascendente la URI seria:
http://localhost/proyectos/aerolinea-tpe2/vuelo?sort=precio&order=asc

Esta funcionalidad se encuentra disponible para todos los campos ("id_vuelo" , "numero" , "id_ciudad" , "fecha" , "horaSalida" , "horaLlegada" , "escalas" , "precio" )

# mostrar las ventas ordenadas por un criterio a definir
method: GET
Si se desea obtener los registros ordenados, tanto de manera ascendente como descendente, debe agregar a la URI el parametro ?sort=(campo a ordenar)&order=(asc o desc), por ejemplo si quisieramos ordenar los vuelos por su codigo de venta de forma ascendente la URI seria:
http://localhost/proyectos/aerolinea-tpe2/venta?sort=id_venta&order=asc

Esta funcionalidad se encuentra disponible para todos los campos ("id_venta" , "id_vuelo" , "pasajero")

# mostrar los vuelos filtrados por un criterio a definir
method: GET
Para obtener los registros en funcion de un filtro, se debe gregar a la URI el parametro ?filter=(campo a filtrar)&value=(condicion), por ejemplo si quisiera ver solo los vuelos directos la URI sería:
http://localhost/proyectos/aerolinea-tpe2/vuelo?filter=escalas&value=Vuelo directo

Esta funcionalidad se encuentra disponible para todos los campos ("id_vuelo" , "numero" , "id_ciudad" , "fecha" , "horaSalida" , "horaLlegada" , "escalas" , "precio" )

# mostrar las ventas filtrados por un criterio a definir
method: GET
Para obtener los registros en funcion de un filtro, se debe gregar a la URI el parametro ?filter=(campo a filtrar)&value=(condicion), por ejemplo si quisiera ver solo las ventas cuyo pasajero sea "Belen Gonzalez" la URI sería:
http://localhost/proyectos/aerolinea-tpe2/venta?filter=pasajero&value=Belen Gonzalez

Esta funcionalidad se encuentra disponible para todos los campos ("id_venta" , "id_vuelo" , "pasajero")

# Filtrado y ordenado de vuelos
method: GET
-TRAER TODOS LOS VUELOS POR UN ORDEN DEFINIDO FILTRADOS LOS QUE CUMPLAN CON UNA CONDICION DETERMINADA
Las funcionalidades de filtrado y orden se pueden utilizar en conjunto, por ejemplo si quisieramos ordenar los precios de manera ascendentes para una ruta determinada la URi sería:
http://localhost/proyectos/aerolinea-tpe2/vuelo?sort=precio&order=asc&filter=numero&value=245GV8

# Filtrado y ordenado de ventas
method: GET
-TRAER TODOS LOS VUELOS POR UN ORDEN DEFINIDO FILTRADOS LOS QUE CUMPLAN CON UNA CONDICION DETERMINADA
Las funcionalidades de filtrado y orden se pueden utilizar en conjunto, por ejemplo si quisieramos ordenar las ventas de manera ascendentes para un pasajero determinado la URi sería:
http://localhost/proyectos/aerolinea-tpe2/venta?sort=id_venta&order=asc&?filter=pasajero&value=Belen Gonzalez

# traer los vuelos paginados
method: GET
Para obtener los registros de forma paginada se agrega en la URI el parametro ?page=(pagina solicitada)&limit=(cantidad de registros por pagina), por ejemplo si me quisiera traer la pagina 3 donde cada pagina cuenta con 5 vuelos la URI sería:
http://localhost/proyectos/aerolinea-tpe2/vuelo?page=3&limit=5


# traer los ventas paginadas
method: GET
Para obtener los registros de forma paginada se agrega en la URI el parametro ?page=(pagina solicitada)&limit=(cantidad de registros por pagina), por ejemplo si me quisiera traer la pagina 2 donde cada pagina cuenta con 10 ventas la URI sería:
http://localhost/proyectos/aerolinea-tpe2/vuelo?page=2&limit=10


# Crear un Vuelo
method: POST
-Para crear un vuelo se deben ingresar todos los campos requeridos del mismo utilizando la URI:
http://localhost/proyectos/aerolinea-tpe2/vuelo

# Registrar un venta
method: POST
-Para crear un vuelo se deben ingresar todos los campos requeridos del mismo utilizando la URI:
http://localhost/proyectos/aerolinea-tpe2/venta

# Borrar un vuelo
method: Delete
-Para borrar un vuelo se debe identificar el ID (id_vuelo) del mismo en la URI:
http://localhost/proyectos/aerolinea-tpe2/vuelo/id_vuelo

# Borrar una venta
method: Delete
-Para borrar un vuelo se debe identificar el ID (id_vuelo) del mismo en la URI:
http://localhost/proyectos/aerolinea-tpe2/vuelo/id_venta


