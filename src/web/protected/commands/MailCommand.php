<?php
/**
 * Description of MailCommand:
 * La clase está destinada a guardar los mails en la tabla description_ticket, de
 * aquellos correos que coincidadn con los números de tickets guardados en base
 * de datos. Esta operación se ejecutará cada cierto tiempo
 *
 * @author Nelson Marcano
 */
class MailCommand extends CConsoleCommand
{
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
