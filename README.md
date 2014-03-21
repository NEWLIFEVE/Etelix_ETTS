Etelix_ETTS
===========

Etelis Ticket Trouble Shoting: tickera de Etelix para manejo de incidencias
Release 1.1.6
	- Modificacion de asunto de nueva respuesta, TT from/for Customer/Supplier Carrier, New Etelix/Carrier Status (By Etelix on ETTS), ticket_number (tiempo)
	- Usuarios Internos, pueden abrir tickets a Customers/Suppliers
	- Usuarios internos pueden responder "como" Customer/Supplier
	- Colores diferentes para las respuestas en el chat de mensajes
	- Modificada clase de blink para los tickets con nuevas respuestas
	- Cambio de asunto de correos al crear/nueva respuesta/cerrar tickets

21/03/2014
        - Cambio del subject al abrir, cerrar o dar una respuesta al ticket.
        - Refresh cada 5 minutos de vista admin
        - Cambio del menu ticket.
        - Corregido error(Aparrecia la validación) al seleccionar date en abrir ticket(Todos los casos)

17/03/2014
        -Correccion al guardar email en interfaz de crear tickets. Los usuarios internos
         pueden agregar tantos correos deseen, los carriers solo pueden agregar 5. Los correos 
         que sean agregados por usuarios internos, no se veran a la hora de que un carrier
         abra la interfaz de abrir ticket.
        -Cambio en el menu de ticket para usuarios internos
        -Ticket Information - Open TT from Carrier by Etelix, Ticket Information - Open TT to Carrier
        -Corrección en el datepicker del tested number


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
