<?php
/**
 * La clase está destinada a guardar los mails en la tabla description_ticket, de
 * aquellos correos que coincidadn con los números de tickets guardados en base
 * de datos. Esta operación se ejecutará cada cierto tiempo
 *
 * @author Nelson Marcano
 * @package commands
 */
class MailCommand extends CConsoleCommand
{
    /**
     * Guarda automáticamente en base de datos los correos que tengan asociado un  número de ticket.
     * También borra los correos al a hacer la comprobación del número de ticket.
     * @param array $args
     */
    public function run($args)
    {
        error_reporting(E_ALL & ~E_NOTICE); 
        $imap = new Imap();
        $mails = $imap->runConsole(10);
        if (!empty($mails)) {
            $imap->deleteMessage($mails, true);
        }
        $imap->close();
    }
}
