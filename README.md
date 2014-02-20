Etelix_ETTS
===========

Etelis Ticket Trouble Shoting: tickera de Etelix para manejo de incidencias
- Agregado mensaje de confirmacion antes de cerrar un ticket, ticket cerrado no puede volver a ser abierto.
- Agregada clase de blink para tickets con respuestas no leidas
- Interfaz de creacion de tickets como clientes por usuarios internos
- Interfaz de cracion de tickets a carriers proveedores
- Cambio de asunto de correos al crear/nueva respuesta/cerrar tickets
- Adjuntado de archivos en respuestas de tickets

Release 1.1.2
- Cambio de numero por defecto de filas en plugin de datatable
- Reducido el alto de las filas en los admin tickets

Release 1.1.1
-Correccion de hora en guardada de descripciones
-Bloqueada interfaz de uso de tickets a proveedores

Release 1.1
-Notificacion de respuestas via correo electronico
-Respuestas de usuarios internos a los tickes

Release 1.0.4
-Soporte para modificar el status de los tickets hijos
-Orden de tickets por status y asc y fecha desc
-Cambio del color de los tickets por ajax
-Se corrigió el description ticket al mostrar el preview del mismo
-Corregido boton tickets asociados, solo aparece cuando existen tickets relacionados.

Realese 1.0.3:
-Nueva Tabla para Tickets, Datatable
-Se pueden visualizar tickets asociados
-Validacion de Hora para tested numbers
-Se arreglo funcion reset para el formulario
-Modificacion vista crear usuario/actualizar usuario/editarpermisos roles/
-se elimino la opcion de eliminar usuario

Realese 1.0.2:
-Se muestran solo tickets de Usuario para cliente
-Se agrego envio de correo a tt@etelix.com
-Preview de ticket en gridview

Realese 1.0.1:
-se ordenaron los carriers alfabeticamente
-se eliminan carriers de la lista desplegable que ya existan como usuarios
-corregido el orden de los gmt
-se agrego la funcion para eliminar por completo correos
-se le agrego la opcion al cliente para poder ver y editar su perfil

Release 1.0:
-Enviar Tickets 
-Adjuntar Archivos
-Modulo de Usuario
-Carrier de Sori asociado a usuario tipo cliente
-Formulario abrir ticket para clientes

21/01/2014
-Se agregó el campo id_user a la tabla answer_ticket
-Se muestra la respuesta del ticket

22/01/2014
-Estilos tipo chat de facebook para la descripcion del ticket en el detalle

23/01/2014
-Se refresca el area de respuesta al mandar la misma
-El scroll del area de respuesta queda abajo al abrir el detalle del ticket

24/01/2014
-Modificado el método ticketsByUser del model Ticket, con parámetro de solo traer
ticket abiertos
-Cambiada interfaz de respuesta del ticket

27/01/2014
-Agregado el envío del mail al dar respuesta en el ticket y al cambiar de status

04/02/2014
-Cambio en el tamaño de las columnas de los tickets relacionados en datatable
-Agregado el add file completamente funcional al answer ticket

06/02/2014
-Action en TicketController actionCarriersbyclass

19/02/2014
-Modificada la tabla description_ticket creando los campos: 
 read_carrier integer DEFAULT 0 read_internal integer DEFAULT 0
-Clase animada a los tickets que tengan respuesta nueva
-Loader al mandar una respuesta
-Mejora del tiempo a cambiar de status(Casi inmediato),
-confirm al querer cerrar ticket,
-Una vez cerrarado no se pueder reabrir el ticket
-Borrar correos en la interfaz de abrir tickets logueado como interno

20/02/2014
-Se puede restablecer la contrasaña
-Gmt en ingles