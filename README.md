Etelix_ETTS
===========

Etelis Ticket Trouble Shoting: tickera de Etelix para manejo de incidencias
-Notificacion de respuestas via correo electronico
-Respuestas de usuarios internos a los tickes
-Soporte para modificar el status de los tickets hijos
-Orden de tickets por status y asc y fecha desc
-Cambio del color de los tickets por ajax
-Se corrigió el description ticket al mostrar el preview del mismo

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
