<form method="post" name="form" id="form">
    <div class="table-report">
        <div class="row">
            <div class="span12 table-report-header">
                <div class="span3 offset1">
                    <div class="input-control select">
                        <select id="select-carrier">
                            <option>Select carrier</option>
                            <option>Customer</option>
                            <option>Supplier</option>
                            <option>Both</option>
                        </select>
                    </div>
                </div>
                <div class="span3 offset5">
                    <div class="input-control text span3" data-role="input-control">
                        <input readonly="readonly" value="<?php echo date('Y-m-d'); ?>"  placeholder="Select day" class="date" type="text" name="report0" id="search-date">
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="span12 table-report-content">
                <table class="table" width="100%" >
                    <thead>
                        <tr>
                            <th>See tickets</th>                    
                            <th>Category</th>
                            <th>Total</th>
                            <th>See tickets</th>                    
                            <th>Category</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="white">
                            <td>
                                <div class="input-control radio default-style">
                                    <label>
                                        <input type="radio" name="rb-report" id="report-pending-1" value="1">
                                        <span class="check"></span>
                                    </label>
                                </div>
                            </td>
                            <td>Tickets opens today</td>
                            <td class="display-data"></td>
                            <td>
                                <div class="input-control radio default-style">
                                    <label>
                                        <input type="radio" name="rb-report" id="report-close-1" value="5">
                                        <span class="check"></span>
                                    </label>
                                </div>
                            </td>
                            <td>Tickets closed white</td>
                            <td class="display-data"></td>
                        </tr>
                        <tr class="yellow">
                            <td>
                                <div class="input-control radio default-style">
                                    <label>
                                        <input  type="radio" name="rb-report" id="report-pending-2" value="2">
                                        <span class="check"></span>
                                    </label>
                                </div>
                            </td>
                            <td>Tickets pendign yellow</td>
                            <td class="display-data"></td>
                            <td>
                                <div class="input-control radio default-style">
                                    <label>
                                        <input type="radio" name="rb-report" id="report-close-2" value="6">
                                        <span class="check"></span>
                                    </label>
                                </div>
                            </td>
                            <td>Tickets closed yellow</td>
                            <td class="display-data"></td>
                        </tr>
                        <tr class="red">
                            <td>
                                <div class="input-control radio default-style">
                                    <label>
                                        <input type="radio" name="rb-report" id="report-pending-3" value="3">
                                        <span class="check"></span>
                                    </label>
                                </div>
                            </td>
                            <td>Tickets pending red</td>
                            <td class="display-data"></td>
                            <td>
                                <div class="input-control radio default-style">
                                    <label>
                                        <input type="radio" name="rb-report" id="report-close-3" value="7">
                                        <span class="check"></span>
                                    </label>
                                </div>
                            </td>
                            <td>Tickets closed red</td>
                            <td class="display-data"></td>
                        </tr>
                        
                        <tr class="pending">
                            <td>
                                <div class="input-control radio default-style">
                                    <label>
                                        <input type="radio" name="rb-report" id="report-pending-4" value="4">
                                        <span class="check"></span>
                                    </label>
                                </div>
                            </td>
                            <td>Tickets pending without activity</td>
                            <td class="display-data"></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr class="total">
                            <td>
                                <div class="input-control radio default-style">
                                    <label>
                                        <input type="radio" name="rb-report" id="report-pending-0" value="8">
                                        <span class="check"></span>
                                    </label>
                                </div>
                            </td>
                            <td>Total tickets open</td>
                            <td class="set-total"></td>
                            <td>
                                <div class="input-control radio default-style">
                                    <label>
                                        <input checked="checked" type="radio" name="rb-report" id="report-close-0" value="9">
                                        <span class="check"></span>
                                    </label>
                                </div>
                            </td>
                            <td>Total tickets closed</td>
                            <td class="set-total"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <?php $this->renderPartial('_datatable'); ?>
</form>
<div class="reportes-laterales derecha">
    <a class='itemreporte' href='javascript:void(0)' id='print-btn' rel="/site/print" title="Print tickets">
        <span class='reporte'>
            <span class="text-visible"><img src="/images/print.png" width="40" height="43"></span>
        </span>
    </a>
    
    <a class='itemreporte' href='javascript:void(0)' id='excel-btn' rel="/site/excel" title="Export tickets to excel">
        <span class='reporte'>
            <span class="text-visible"><img src="/images/excel.png" width="43" height="43"></span>
        </span>
    </a>
    
    <a class='itemreporte' href='javascript:void(0)' id='mail-btn' rel="/site/mail" title="Send tickets by email">
        <span class='reporte'>
            <span class="text-visible"><img src="/images/mail.png" width="43" height="33"></span>
        </span>
    </a>
</div>
<!--<div id="container" style="height: 400px"></div>-->