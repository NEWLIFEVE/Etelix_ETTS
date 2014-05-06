<div id=content_detail>
    <div class="grid fluid">
        <h3 class="ticket-information">Ticket #:<?php echo $datos->ticket_number; ?>, Created on <?php echo Utility::getDayByDate($datos->date) . ' at ' . $datos->hour; ?>  <a href="javascript:void(0)" title="Print ticket"><i class="icon-printer"></i></a></h3>
        <div class="row">
            <div class="span5">
                <?php 
                $optionOpen='';
                if ($datos->option_open == 'etelix_as_carrier' || $datos->option_open == 'carrier_to_etelix') $optionOpen='true';
                $mailByTicket=MailUser::getMails(CrugeUser2::getUserTicket($datos->id, true)->iduser, false, $optionOpen, $datos->id);
                $tipoUsuario=CrugeAuthassignment::getRoleUser();
                ?>
                <input type="hidden" id="id_ticket" value="<?php echo $datos->id; ?>">
                <input type="hidden" id="open-ticket" value="<?php echo $datos->option_open; ?>">
                <input type="hidden" id="user-ticket" value="<?php echo CrugeUser2::getUserTicket($datos->id, true)->iduser; ?>">
                <?php if ($datos->id_status != '2' && $tipoUsuario != 'C'): ?>
                <div class="options-hide">
                    <div class="input-control select">
                        <select id="mails" multiple>
                            <?php foreach ($mailByTicket as $mails): ?>
                                <option value="<?php echo $mails['id']; ?>"><?php echo $mails['mail']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="div-agregar-correo">
                        <div class="input-control text span6"  data-role="input-control">
                            <input type="text" id="new_mail" class="validate[custom[email]]" name="new_mail" placeholder="example@example.com" />
                        </div>

                        <div class="input-control text span3">
                            <button class="btn-agregar-correo primary" type="button" onclick="newMailTicket(this)"><i class="icon-floppy on-left"></i>Save</button>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
                <div class="input-control select">
                    Response to&nbsp;  
                    <?php if ($datos->id_status != '2' && $tipoUsuario != 'C'): ?>
                    <a href="javascript:void(0)" class="a-agregar-correo" onclick="seeOptions(this)">Add more email's</a>&nbsp;&nbsp;
                    <span class="options-hide">
                        <a href="javascript:void(0)" class="a-bajar-correo" onclick="bajarCorreo(this)"><i class="icon-arrow-down"></i></a>
                        <a href="javascript:void(0)" class="a-borrar-correo" onclick="borrarCorreo(this)" ><i class="icon-cancel-2 fg-red "></i></a>
                    </span>
                    <?php endif; ?>
                    <select multiple="multiple" readonly="readonly" id="mostrar-mails">
                        <?php foreach (Mail::getMailsTicket($datos->id) as $value): ?>
                        <option value="<?php echo $value->id; ?>"><?php echo $value->mail; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="input-control text block">
                Failure
                <input type="text" id="Ticket_id_failure" value="<?php echo $datos->idFailure->name; ?>" disabled>
                </div>


                <?php
                $originationIp = explode('.', $datos->origination_ip);
                $destinationIp = explode('.', $datos->destination_ip);
                $etelixIp='Etelix IP';
                $customerIp='Customer IP';
                $espacios='';
                if ($datos->option_open=='etelix_to_carrier')
                {
                    $etelixIp='Customer IP';
                    $customerIp='Etelix IP';
                    $espacios='&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';    
                }
                ?>
                <?php if ($datos->origination_ip !== null): ?>

                <div class="_label">Origination IP <small class="text-muted "><em>(<?php echo $customerIp; ?>)</em></small></div>
                <div class="input-control text block" data-role="input-control">
                    <input type="text" value="<?php echo $originationIp[0]; ?>" disabled class="_ip" disabled id="oip1" maxlength="3" >
                    <input type="text" value="<?php echo $originationIp[1]; ?>" disabled class="_ip" disabled id="oip2" maxlength="3" >
                    <input type="text" value="<?php echo $originationIp[2]; ?>" disabled class="_ip" disabled id="oip3" maxlength="3" >
                    <input type="text" value="<?php echo $originationIp[3]; ?>" disabled class="_ip" disabled id="oip4" maxlength="3" >
                </div>
                
                <div class="_label">DestinationIP  <small class="text-muted "><em>(<?php echo $etelixIp; ?>)</em></small></div>
                <div class="input-control text block" data-role="input-control">
                    <input type="text" value="<?php echo $destinationIp[0]; ?>" disabled class="_ip" disabled id="dip1" maxlength="3" >
                    <input type="text" value="<?php echo $destinationIp[1]; ?>" disabled class="_ip" disabled id="dip2" maxlength="3" >
                    <input type="text" value="<?php echo $destinationIp[2]; ?>" disabled class="_ip" disabled id="dip3" maxlength="3" >
                    <input type="text" value="<?php echo $destinationIp[3]; ?>" disabled class="_ip" disabled id="dip4" maxlength="3" >
                </div>
                <?php endif; ?>

                <?php if ($datos->prefix !== null): ?>
                <div class="input-control text block" >
                    Prefix
                    <input type="text" value="<?php echo $datos->prefix; ?>" disabled>
                </div>
                <?php endif; ?>

                <?php if (isset($datos->idGmt->name)): ?>
                <div class="input-control text block">
                    GMT
                    <input type="text" value="<?php  echo $datos->idGmt->name; ?>" disabled>
                </div>
                <?php endif; ?>

                <?php
                $testedNumber=TestedNumber::getNumbers($datos->id);
                ?>
                <?php if ($testedNumber != null): ?>
                <div id="tabla_tested_number" class="grid">
                    <?php $tabla = '<div><table id="tabla_preview"><thead><tr><th>Tested Numbers</th><th>Country</th><th>Date</th><th>Hour</th></thead><tbody>';
                    foreach ($testedNumber as $value){
                        $tabla .= '<tr><td>' . $value->numero . '</td><td id="Ticket_country">' . $value->idCountry->name . '</td><td>' . $value->date . '</td><td>' . $value->hour . '</td></tr>';
                    } 
                    echo $tabla . '</tbody></table></div>';
                    ?>
                </div>
                <?php endif; ?>
            </div> 
            <div class="span7">
                Description <!--<a href="javascript:void(0);" onclick="show(this, '.mails-associates');">View mails associates </a>-->
                <?php if ($tipoUsuario !== 'C'): ?>
                    <a href="javascript:void(0)" id="<?php echo $datos->ticket_number; ?>" class="see-email" title="Refresh messages"><i class="icon-loop"></i></a>
                <?php endif; ?>
                <div class="answer-ticket">
                    <?php $this->renderPartial('_answer', array('datos'=>$datos)); ?>
                    <div class="pre-loader"></div>
                </div>
<!--                <div class="mails-associates">
                    <div class="tab-control" data-role="tab-control">
                        <ul class="tabs">
                            <li class="active"><a href="#_page_1">Mails associates</a></li>
                            <li><a href="#_page_2">Stored in database</a></li>
                        </ul>

                        <div class="frames">
                            <div class="frame" id="_page_1">
                                See message 
                                <small class="text-muted "><em>(It may take several minutes)</em></small>&nbsp;&nbsp;
                                <a href="javascript:void(0)" id="<?php echo $datos->ticket_number; ?>" class="see-email"><i class="icon-download-2"></i></a>&nbsp;&nbsp;
                                <a href="javascript:void(0)" onclick="hide(this, '.mails-associates')" title="Hide mails associates">hide</a>
                                <div class="load-mails">

                                </div>
                            </div>
                            <div class="frame" id="_page_2">
                                <a href="javascript:void(0)" onclick="hide(this, '.mails-associates')" title="Hide mails associates">hide</a>
                            </div>
                        </div>
                    </div>
                </div>
                <p></p>-->
                <?php if ($datos->id_status != '2'): ?>
                <div id="only-open">
                <?php
                if ($tipoUsuario !== 'C'):
                ?>
                <div class="input-control select medium">
                    <select id="speech">
                        <option value="">Speech</option>
                        <optgroup label="English">
                        <?php foreach (Speech::getSpeech($datos->ticket_number) as $value): ?>
                            <option value="<?php echo $value->id; ?>"><?php echo $value->title; ?></option>
                        <?php endforeach; ?>
                        </optgroup>
                        <optgroup label="Spanish">
                        <?php foreach (Speech::getSpeechSpanish($datos->ticket_number) as $value): ?>
                            <option value="<?php echo $value->id; ?>"><?php echo $value->title; ?></option>
                        <?php endforeach; ?>
                        </optgroup>
                    </select>
                </div>

                <?php endif; ?>

                <div class="input-control textarea" data-role="input-control">
                    <textarea name="answer" id="answer"></textarea>
                </div>
                <div class="panel-down-textarea">
                    <div class="option-panel right">
                        <input type="button" value="Send message" class="primary" id="sendmsg" onclick="saveMessage()">
                    </div>
                    <div class="option-panel right">
                        <div id="mulitplefileuploader">Add file</div>
                    </div>
                    <div class="option-panel left confirmation">
                        <div class="input-control checkbox" data-role="input-control">
                            <?php if (CrugeAuthassignment::getRoleUser() != 'C'): ?>
                            <label>
                                <input type="checkbox" id="internalAsCarrier" value="1">
                                <span class="check"></span>  <small class="text-muted ">Respond as Carrier</small>
                            </label>
                            <?php endif; ?>
                            <label>
                                <input type="checkbox" id="close-ticket" value="2">
                                <span class="check"></span> <small class="text-muted ">Close TT</small>
                            </label>
                        </div>
                    </div>
                </div>
                <div id="area-add-file"></div>
                <div id="status"></div>
                <div id="filename"></div>
                </div>
                <?php else: ?>
                    <?php if ($datos->close_ticket != null): ?>
                    <h3>Ticket closed in <?php echo Utility::getDayByDate(substr($datos->close_ticket, 0, 10)) . ' at ' . substr($datos->close_ticket, 11, 12); ?></h3>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>
        
    </div>
</div>