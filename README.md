Etelix_ETTS
===========

Etelis Ticket Trouble Shoting: tickera de Etelix para manejo de incidencias

22/04/2014
    - Iconos laterales que muestran leyendas de colores de los tickets, cantidad de ticket por color y porcentaje

21/04/2014
    - Cambio de colores de los tickets en datatable. Tickets de 24 horas son blancos, 48 horas son amarillos, mas de 48 horas son rojos, cerrados siguen en verde.
    - Se añadió texto de que puede llegar el mensaje incompleto al descargarlo desde el correo 

15/04/2014
    - Se amplió la interfaz del detalle delticket.
    - Se colocó un botón de refresh(para el chat) en el detalle del ticket.
    - Descarga manual de correos asociados a un número de ticket

07/04/2014
    - Ahora los usuarios internos tienen la posibilidad de agregar mas correos en la interfaz del detalle del ticket(Solo cuando el ticket es abierto etelix_to_carrier)

04/04/2014
    - Se modificó el método saveMailTicket en el modelo MailTicket, ahora si los atributos pueden llegar tanto como array o como un solo atributo

03/04/2014
    - Corrección en adminclose, antes se mostraban todos los tickets cerrados a los carriers, ahora solo se muestran los tickets asociados a ellos.
    - Se agregó un nuevo action en MailticketController(actionSavemailticket), el cual servirá para guardar los mails(ya registrados en mail_user) al dar una nueva respuesta.
    - Nuevos métodos en admin.js: seeOptions(), hideOptions() los cuales muestran u ocultan la opción de agregar un correo.
    - Nuevo método en admin.js: bajarCorreo() el cual al bajar el correo guardará de una vez el mail en la tabla mail_ticket.
    

02/04/2014
    - Corrección en los speech del preview del ticket. No se concatenaba la falla y el pais, ahora ya lo hace.

01/04/2014
    - Ahora el usuario interno tiene la lista de speech en ingles y español
    - Se creo un action nuevo en SpeechController(actionGetspeechsupplier) para obtener los speech de los suppliers y se borro actionGetspeechsupplier en FailureController
    - Se borró el campo id_speech de la tabla failure
    - Se creó una nueva tabla llamada failure_speech
    - Al abrirle un ticket a un supplier, estando seleccionado la falla y el pais, se cargará el speech correspondiente pudiendo seleccionar si setea en ingles o en español
    - Ordenados speech's en preview ticket por idioma. También dependen si es customer o supplier

31/03/2014
    - Se creo un campo nuevo en la tabla failure llamado id_speech que se relaciona con speech. Se agregó en el metodo relations dichas relaciones por cada modelo afectado por el campo agregado
    - Se creó un action nuevo en FailureController (actionGetspeechsupplier) para obtener los speech de los suppliers
    - Se creó un action nuevo en SpeechController (actionGetspeechcustomer) para obtener los speech de los customers

Release 1.1.8.1
28/03/2014(Corrección en master)
	- Corrección en creacion de tickets, comprobacion de option open, cuando es etelix_to_carrier comprueba que exista el correo, si es etelis_as_carrier o carrier_to_etelix, comprueba que exista y que asign_by sea 1
    - En la interfaz "createtocarrier", en el label "Destination IP (Customer IP)", se cambió por "Destination IP (Carrier IP)"
    - Se agrego tested number en la interfaz de etelix to carrier
    - La columna user debe decir el nombre del usuario que abre el ticket (Ya lo hace).

27/03/2014(Correcciones en master)
    - Corrección en el subject de nueva respuesta, se colocó una coma y la palabra "status" después del usuario que 
      escribió la respuesta. También se colocó si es etelix que responde por el carrier si el option_open es "carrier_to_etelix".
    - Ahora el carrier tiene la opción de ver tickets cerrados.
    - Invertido el nombre de las ip en la interfaz tickets etelix a carrier
    - Interfaz "carrier to etelix", si el carrier es supplier/customer, podrá seleccionar alguna de las 2 opciones,
      Sí solo es supplier o solo customer, vendrá seteado por defecto y no podrá cambiar el tipo de carrier

Release 1.1.8 26/03/2014
    - Corrección al cerrar tickets viejos desde el preview del ticket.
    - Ahora desde adminclose se ve la columna country
    - Corregido bug al guardar mails. Ahora los carriers y etelix como
      el carrier solo pueden agregar 5 correos, cuando es etelix al 
      carrier puede agregar los correos que deseen
    - Corregido bug al guardar varios correos, tested number y archivos
    - De la interfaz crear ticket(carrier to etelix), ahora se le permite al carrier seleccionar si abrirá el ticket como customer o supplier.

24/03/2014
    - Corrección en refresh. Ahora al abrir el chat se cancela el refresh y al cerrarlo se continua con el mismo. Siguiendo el mismo flujo cada vez que se abra y cierre el chat.
    - En preview del ticket ahora permite cerrar el ticket
    -Correccion al guardar email en interfaz de crear tickets. Los usuarios internos
     pueden agregar tantos correos deseen, los carriers solo pueden agregar 5. Los correos 
     que sean agregados por usuarios internos, no se veran a la hora de que un carrier
     abra la interfaz de abrir ticket.
    

Release 1.1.7 21/03/2014
	- En la interfaz de administracion de tickets, agregado el pais con mayor incidencia entre los tested number del ticket
    - Cambio del subject al abrir, cerrar o dar una respuesta al ticket.
    - Refresh cada 5 minutos de vista admin
    - Cambio del menu ticket.
    - Corregido error(Aparrecia la validación) al seleccionar date en abrir ticket(Todos los casos) 
    -Cambio en el menu de ticket para usuarios internos
    -Ticket Information - Open TT from Carrier by Etelix, Ticket Information - Open TT to Carrier
    -Corrección en el datepicker del tested number


Release 1.1.6
	- Modificacion de asunto de nueva respuesta, TT from/for Customer/Supplier Carrier, New Etelix/Carrier Status (By Etelix on ETTS), ticket_number (tiempo)
	- Usuarios Internos, pueden abrir tickets a Customers/Suppliers
	- Usuarios internos pueden responder "como" Customer/Supplier
	- Colores diferentes para las respuestas en el chat de mensajes
	- Modificada clase de blink para los tickets con nuevas respuestas
	- Cambio de asunto de correos al crear/nueva respuesta/cerrar tickets

Release 1.1.5
	-Modificada la tabla description_ticket creando los campos: 
		* read_carrier integer DEFAULT 0 read_internal integer DEFAULT 0
	-Loader al mandar una respuesta
	- Se puede restablecer la contrasaña
	- Gmt en ingles
	- Agregado mensaje de confirmacion antes de cerrar un ticket, ticket cerrado no puede volver a ser abierto.
	- Agregada clase de blink para tickets con respuestas no leidas

Release 1.1.4.2
	- Correccion de orden de mensajes en los tickets, estaban apareciendo todos de un solo lado.

Release 1.1.4.1
	- Cambio de from correos a ETELIX Trouble Ticket System (ETTS)
	- Renombrado de los controladores para que queden todos en minusculas

Release 1.1.4
	- Interfaz de creacion de tickets como clientes por usuarios internos
	- Interfaz de cracion de tickets a carriers proveedores
	- Correccion de asunto de correos al crear/nueva respuesta/cerrar tickets
	- Adjuntado de archivos en respuestas de tickets

Release 1.1.3
	- Aumento de ancho de las columnas para el admin de tickets
	- Cambio de asunto en correos electronicos:
	- Formatos de subject
		* Etelix TT System, New TT, 0000000000 nombre_del_carrier
		* Etelix TT System, New Answer, 000000000 nombre_del_carrier
		* Etelix TT System , New Status, 000000000 nombre_del_carrier
Release 1.1.2
	- Cambio de numero por defecto de filas en plugin de datatable
	- Reducido el alto de las filas en los admin tickets

Release 1.1.1
	- Correccion de hora en guardada de descripciones
	- Bloqueada interfaz de uso de tickets a proveedores

Release 1.1
	- Notificacion de respuestas via correo electronico
	- Respuestas de usuarios internos a los tickes

Release 1.0.4
	- Soporte para modificar el status de los tickets hijos
	- Orden de tickets por status y asc y fecha desc
	- Cambio del color de los tickets por ajax
	- Se corrigió el description ticket al mostrar el preview del mismo
	- Corregido boton tickets asociados, solo aparece cuando existen tickets relacionados.

Realese 1.0.3:
	- Nueva Tabla para Tickets, Datatable
	- Se pueden visualizar tickets asociados
	- Validacion de Hora para tested numbers
	- Se arreglo funcion reset para el formulario
	- Modificacion vista crear usuario/actualizar usuario/editarpermisos roles/
	- se elimino la opcion de eliminar usuario

Realese 1.0.2:
	- Se muestran solo tickets de Usuario para cliente
	- Se agrego envio de correo a tt@etelix.com
	- Preview de ticket en gridview

Realese 1.0.1:
	- se ordenaron los carriers alfabeticamente
	- se eliminan carriers de la lista desplegable que ya existan como usuarios
	- corregido el orden de los gmt
	- se agrego la funcion para eliminar por completo correos
	- se le agrego la opcion al cliente para poder ver y editar su perfil

Release 1.0:
	- Enviar Tickets 
	- Adjuntar Archivos
	- Modulo de Usuario
	- Carrier de Sori asociado a usuario tipo cliente
	- Formulario abrir ticket para clientes

21/01/2014
	- Se agregó el campo id_user a la tabla answer_ticket
	- Se muestra la respuesta del ticket
22/01/2014
	- Estilos tipo chat de facebook para la descripcion del ticket en el detalle

23/01/2014
	- Se refresca el area de respuesta al mandar la misma
	- El scroll del area de respuesta queda abajo al abrir el detalle del ticket
24/01/2014
	- Modificado el método ticketsByUser del model Ticket, con parámetro de solo traer
ticket abiertos
	- Cambiada interfaz de respuesta del ticket

27/01/2014
	- Agregado el envío del mail al dar respuesta en el ticket y al cambiar de status

04/02/2014
	- Cambio en el tamaño de las columnas de los tickets relacionados en datatable
	- Agregado el add file completamente funcional al answer ticket

06/02/2014
	- Action en TicketController actionCarriersbyclass

19/02/2014
	- Mejora del tiempo a cambiar de status(Casi inmediato),
	- Borrar correos en la interfaz de abrir tickets logueado como interno
