<form method="post" name="form" id="form">
    <div class="table-report">
        <div class="row">
            <div class="span12 table-report-header">
                <div class="span3 offset9">
                    <div class="input-control text span3" data-role="input-control">
                        <input readonly="readonly"  placeholder="Select day" class="date" type="text" name="report0" id="search-date">
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="span12 table-report-content">
                <table class="table bordered" width="100%" >
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
                        <tr>
                            <td>
                                <div class="input-control radio default-style">
                                    <label>
                                        <input type="radio" name="report-pending" id="report-pending-0">
                                        <span class="check"></span>
                                    </label>
                                </div>
                            </td>
                            <td>Total tickets pending</td>
                            <td class="set-total"></td>
                            <td>
                                <div class="input-control radio default-style">
                                    <label>
                                        <input type="radio" name="report-close" id="report-close-0">
                                        <span class="check"></span>
                                    </label>
                                </div>
                            </td>
                            <td>Total tickets closed</td>
                            <td class="set-total"></td>
                        </tr>
                        <tr>
                            <td>
                                <div class="input-control radio default-style">
                                    <label>
                                        <input type="radio" name="report-pending" id="report-pending-1">
                                        <span class="check"></span>
                                    </label>
                                </div>
                            </td>
                            <td>Tickets pending white</td>
                            <td class="display-data"></td>
                            <td>
                                <div class="input-control radio default-style">
                                    <label>
                                        <input type="radio" name="report-close" id="report-close-1">
                                        <span class="check"></span>
                                    </label>
                                </div>
                            </td>
                            <td>Tickets closed white</td>
                            <td class="display-data"></td>
                        </tr>
                        <tr>
                            <td>
                                <div class="input-control radio default-style">
                                    <label>
                                        <input type="radio" name="report-pending" id="report-pending-2">
                                        <span class="check"></span>
                                    </label>
                                </div>
                            </td>
                            <td>Tickets pendign yellow</td>
                            <td class="display-data"></td>
                            <td>
                                <div class="input-control radio default-style">
                                    <label>
                                        <input type="radio" name="report-close" id="report-close-2">
                                        <span class="check"></span>
                                    </label>
                                </div>
                            </td>
                            <td>Tickets closed yellow</td>
                            <td class="display-data"></td>
                        </tr>
                        <tr>
                            <td>
                                <div class="input-control radio default-style">
                                    <label>
                                        <input type="radio" name="report-pending" id="report-pending-3">
                                        <span class="check"></span>
                                    </label>
                                </div>
                            </td>
                            <td>Tickets pending red</td>
                            <td class="display-data"></td>
                            <td>
                                <div class="input-control radio default-style">
                                    <label>
                                        <input type="radio" name="report-close" id="report-close-3">
                                        <span class="check"></span>
                                    </label>
                                </div>
                            </td>
                            <td>Tickets closed red</td>
                            <td class="display-data"></td>
                        </tr>
                        <tr>
                            <td>
                                <div class="input-control radio default-style">
                                    <label>
                                        <input type="radio" name="report-pending" id="report-pending-4">
                                        <span class="check"></span>
                                    </label>
                                </div>
                            </td>
                            <td>Tickets pending without description</td>
                            <td class="display-data"></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <?php $this->renderPartial('_datatable', array('')); ?>
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