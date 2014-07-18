<form method="post" name="form" id="form" action="/site/yiiexcel">
    <div class="table-report">
        <div class="row">
            <div class="span12 table-report-header">
                <div class="span3 offset1">
                    <div class="input-control select">
                        <select id="select-carrier">
                            <option value="">Select carrier</option>
                            <option value="Customer">Customer</option>
                            <option value="Supplier">Supplier</option>
                            <option value="both">Both</option>
                        </select>
                    </div>
                </div>
                <div class="span3 offset5">
                    <div class="input-control text span3" data-role="input-control">
                        <input readonly="readonly" value="<?= date('Y-m-d'); ?>"  placeholder="Select day" class="date" type="text" name="date" id="search-date">
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
                            <th>Supplier</th>
                            <th>Customer</th>
                            <th>Total</th>
                            <th></th>
                            <th>Previous Day</th>
                            <th></th>
                            <th>A Week Ago</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="white">
                            <td>
                                <div class="content-radio">
                                    <div class="input-statistics">
                                        <div class="input-control radio default-style">
                                            <label>
                                                <input checked="checked" type="radio" name="rb-report" id="report-1" value="1">
                                                <span class="check"></span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="link-statistics">
                                        <a href="#table-statistisc" title="Go to the table" class="go-link"><i class="icon-arrow-down-5"></i></a>
                                    </div>
                                </div>
                            </td>
                            <td>Open white within 24 hours</td>
                            <td class="display-supplier">&nbsp;</td>
                            <td class="display-customer">&nbsp;</td>
                            <td class="display-data"></td>
                            <td class="arrow"></td>
                            <td class="subtract-one-day"></td>
                            <td class="arrow2"></td>
                            <td class="subtract-seven-days"></td>
                        </tr>
                        <tr class="yellow">
                            <td>
                                <div class="content-radio">
                                    <div class="input-statistics">
                                        <div class="input-control radio default-style">
                                            <label>
                                                <input type="radio" name="rb-report" id="report-2" value="2">
                                                <span class="check"></span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="link-statistics">
                                        <a href="#table-statistisc" title="Go to the table" class="go-link"><i class="icon-arrow-down-5"></i></a>
                                    </div>
                                </div>
                            </td>
                            <td>Open yellow within 48 hours</td>
                            <td class="display-supplier">&nbsp;</td>
                            <td class="display-customer">&nbsp;</td>
                            <td class="display-data"></td>
                            <td class="arrow"></td>
                            <td class="subtract-one-day"></td>
                            <td class="arrow2"></td>
                            <td class="subtract-seven-days"></td>
                        </tr>
                        <tr class="red">
                            <td>
                                <div class="content-radio">
                                    <div class="input-statistics">
                                        <div class="input-control radio default-style">
                                            <label>
                                                <input type="radio" name="rb-report" id="report-3" value="3">
                                                <span class="check"></span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="link-statistics">
                                        <a href="#table-statistisc" title="Go to the table" class="go-link"><i class="icon-arrow-down-5"></i></a>
                                    </div>
                                </div>
                            </td>
                            <td>Open red with more than 48 hours</td>
                            <td class="display-supplier">&nbsp;</td>
                            <td class="display-customer">&nbsp;</td>
                            <td class="display-data"></td>
                            <td class="arrow"></td>
                            <td class="subtract-one-day"></td>
                            <td class="arrow2"></td>
                            <td class="subtract-seven-days"></td>
                        </tr>
                        <tr class="total">
                            <td>
                                <div class="content-radio">
                                    <div class="input-statistics">
                                        <div class="input-control radio default-style">
                                            <label>
                                                <input type="radio" name="rb-report" id="report-4" value="13">
                                                <span class="check"></span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="link-statistics">
                                        <a href="#table-statistisc" title="Go to the table" class="go-link"><i class="icon-arrow-down-5"></i></a>
                                    </div>
                                </div>
                            </td>
                            <td>Total open</td>
                            <td class="total-supplier">&nbsp;</td>
                            <td class="total-customer">&nbsp;</td>
                            <td class="total-data" <!--title="<div class='diagram'>
                                <div class='diagram-yellow'></div>
                                <div class='diagram-white'></div>
                                <div class='diagram-red'></div>
                            </div>"-->></td>
                            <td class="total-arrow"></td>
                            <td class="total-one-day"></td>
                            <td class="total-arrow2"></td>
                            <td class="total-seven-days"></td>
                        </tr>
                        
                        <tr class="white">
                            <td>
                                <div class="content-radio">
                                    <div class="input-statistics">
                                        <div class="input-control radio default-style">
                                            <label>
                                                <input type="radio" name="rb-report" id="report-5" value="4">
                                                <span class="check"></span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="link-statistics">
                                        <a href="#table-statistisc" title="Go to the table" class="go-link"><i class="icon-arrow-down-5"></i></a>
                                    </div>
                                </div>
                            </td>
                            <td>Closed white today</td>
                            <td class="display-supplier">&nbsp;</td>
                            <td class="display-customer">&nbsp;</td>
                            <td class="display-data"></td>
                            <td class="arrow"></td>
                            <td class="subtract-one-day"></td>
                            <td class="arrow2"></td>
                            <td class="subtract-seven-days"></td>
                        </tr>
                        <tr class="yellow">
                            <td>
                                <div class="content-radio">
                                    <div class="input-statistics">
                                        <div class="input-control radio default-style">
                                            <label>
                                                <input type="radio" name="rb-report" id="report-6" value="5">
                                                <span class="check"></span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="link-statistics">
                                        <a href="#table-statistisc" title="Go to the table" class="go-link"><i class="icon-arrow-down-5"></i></a>
                                    </div>
                                </div>
                            </td>
                            <td>Closed yellow today</td>
                            <td class="display-supplier">&nbsp;</td>
                            <td class="display-customer">&nbsp;</td>
                            <td class="display-data"></td>
                            <td class="arrow"></td>
                            <td class="subtract-one-day"></td>
                            <td class="arrow2"></td>
                            <td class="subtract-seven-days"></td>
                        </tr>
                        <tr class="red">
                            <td>
                                <div class="content-radio">
                                    <div class="input-statistics">
                                        <div class="input-control radio default-style">
                                            <label>
                                                <input type="radio" name="rb-report" id="report-7" value="6">
                                                <span class="check"></span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="link-statistics">
                                        <a href="#table-statistisc" title="Go to the table" class="go-link"><i class="icon-arrow-down-5"></i></a>
                                    </div>
                                </div>
                            </td>
                            <td>Closed red today</td>
                            <td class="display-supplier">&nbsp;</td>
                            <td class="display-customer">&nbsp;</td>
                            <td class="display-data"></td>
                            <td class="arrow"></td>
                            <td class="subtract-one-day"></td>
                            <td class="arrow2"></td>
                            <td class="subtract-seven-days"></td>
                        </tr>
                        <tr class="total">
                            <td>
                                <div class="content-radio">
                                    <div class="input-statistics">
                                        <div class="input-control radio default-style">
                                            <label>
                                                <input type="radio" name="rb-report" id="report-8" value="14">
                                                <span class="check"></span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="link-statistics">
                                        <a href="#table-statistisc" title="Go to the table" class="go-link"><i class="icon-arrow-down-5"></i></a>
                                    </div>
                                </div>
                            </td>
                            <td>Total closed</td>
                            <td class="total-supplier">&nbsp;</td>
                            <td class="total-customer">&nbsp;</td>
                            <td class="total-data"></td>
                            <td class="total-arrow"></td>
                            <td class="total-one-day"></td>
                            <td class="total-arrow2"></td>
                            <td class="total-seven-days"></td>
                        </tr>
                        
                        <tr class="white">
                            <td>
                                <div class="content-radio">
                                    <div class="input-statistics">
                                        <div class="input-control radio default-style">
                                            <label>
                                                <input type="radio" name="rb-report" id="report-9" value="7">
                                                <span class="check"></span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="link-statistics">
                                        <a href="#table-statistisc" title="Go to the table" class="go-link"><i class="icon-arrow-down-5"></i></a>
                                    </div>
                                </div>
                            </td>
                            <td>No activity white today</td>
                            <td class="display-supplier">&nbsp;</td>
                            <td class="display-customer">&nbsp;</td>
                            <td class="display-data"></td>
                            <td class="arrow"></td>
                            <td class="subtract-one-day"></td>
                            <td class="arrow2"></td>
                            <td class="subtract-seven-days"></td>
                        </tr>
                        <tr class="yellow">
                            <td>
                                <div class="content-radio">
                                    <div class="input-statistics">
                                        <div class="input-control radio default-style">
                                            <label>
                                                <input type="radio" name="rb-report" id="report-10" value="8">
                                                <span class="check"></span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="link-statistics">
                                        <a href="#table-statistisc" title="Go to the table" class="go-link"><i class="icon-arrow-down-5"></i></a>
                                    </div>
                                </div>
                            </td>
                            <td>No activity yellow today</td>
                            <td class="display-supplier">&nbsp;</td>
                            <td class="display-customer">&nbsp;</td>
                            <td class="display-data"></td>
                            <td class="arrow"></td>
                            <td class="subtract-one-day"></td>
                            <td class="arrow2"></td>
                            <td class="subtract-seven-days"></td>
                        </tr>
                        <tr class="red">
                            <td>
                                <div class="content-radio">
                                    <div class="input-statistics">
                                        <div class="input-control radio default-style">
                                            <label>
                                                <input type="radio" name="rb-report" id="report-11" value="9">
                                                <span class="check"></span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="link-statistics">
                                        <a href="#table-statistisc" title="Go to the table" class="go-link"><i class="icon-arrow-down-5"></i></a>
                                    </div>
                                </div>
                            </td>
                            <td>No activity red today</td>
                            <td class="display-supplier">&nbsp;</td>
                            <td class="display-customer">&nbsp;</td>
                            <td class="display-data"></td>
                            <td class="arrow"></td>
                            <td class="subtract-one-day"></td>
                            <td class="arrow2"></td>
                            <td class="subtract-seven-days"></td>
                        </tr>
                        <tr class="total">
                            <td>
                                <div class="content-radio">
                                    <div class="input-statistics">
                                        <div class="input-control radio default-style">
                                            <label>
                                                <input type="radio" name="rb-report" id="report-12" value="15">
                                                <span class="check"></span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="link-statistics">
                                        <a href="#table-statistisc" title="Go to the table" class="go-link"><i class="icon-arrow-down-5"></i></a>
                                    </div>
                                </div>
                            </td>
                            <td>Total no activity</td>
                            <td class="total-supplier">&nbsp;</td>
                            <td class="total-customer">&nbsp;</td>
                            <td class="total-data"></td>
                            <td class="total-arrow"></td>
                            <td class="total-one-day"></td>
                            <td class="total-arrow2"></td>
                            <td class="total-seven-days"></td>
                        </tr>
                        
                        <tr class="white">
                            <td>
                                <div class="content-radio">
                                    <div class="input-statistics">
                                        <div class="input-control radio default-style">
                                            <label>
                                                <input type="radio" name="rb-report" id="report-13" value="10">
                                                <span class="check"></span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="link-statistics">
                                        <a href="#table-statistisc" title="Go to the table" class="go-link"><i class="icon-arrow-down-5"></i></a>
                                    </div>
                                </div>
                            </td>
                            <td>Escalated white today</td>
                            <td class="display-supplier">&nbsp;</td>
                            <td class="display-customer">&nbsp;</td>
                            <td class="display-data"></td>
                            <td class="arrow"></td>
                            <td class="subtract-one-day"></td>
                            <td class="arrow2"></td>
                            <td class="subtract-seven-days"></td>
                        </tr>
                        <tr class="yellow">
                            <td>
                                <div class="content-radio">
                                    <div class="input-statistics">
                                        <div class="input-control radio default-style">
                                            <label>
                                                <input type="radio" name="rb-report" id="report-14" value="11">
                                                <span class="check"></span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="link-statistics">
                                        <a href="#table-statistisc" title="Go to the table" class="go-link"><i class="icon-arrow-down-5"></i></a>
                                    </div>
                                </div>
                            </td>
                            <td>Escalated yellow today</td>
                            <td class="display-supplier">&nbsp;</td>
                            <td class="display-customer">&nbsp;</td>
                            <td class="display-data"></td>
                            <td class="arrow"></td>
                            <td class="subtract-one-day"></td>
                            <td class="arrow2"></td>
                            <td class="subtract-seven-days"></td>
                        </tr>
                        <tr class="red">
                            <td>
                                <div class="content-radio">
                                    <div class="input-statistics">
                                        <div class="input-control radio default-style">
                                            <label>
                                                <input type="radio" name="rb-report" id="report-15" value="12">
                                                <span class="check"></span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="link-statistics">
                                        <a href="#table-statistisc" title="Go to the table" class="go-link"><i class="icon-arrow-down-5"></i></a>
                                    </div>
                                </div>
                            </td>
                            <td>Escalated red today</td>
                            <td class="display-supplier">&nbsp;</td>
                            <td class="display-customer">&nbsp;</td>
                            <td class="display-data"></td>
                            <td class="arrow"></td>
                            <td class="subtract-one-day"></td>
                            <td class="arrow2"></td>
                            <td class="subtract-seven-days"></td>
                        </tr>
                        <tr class="total">
                            <td>
                                <div class="content-radio">
                                    <div class="input-statistics">
                                        <div class="input-control radio default-style">
                                            <label>
                                                <input type="radio" name="rb-report" id="report-16" value="16">
                                                <span class="check"></span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="link-statistics">
                                        <a href="#table-statistisc" title="Go to the table" class="go-link"><i class="icon-arrow-down-5"></i></a>
                                    </div>
                                </div>
                            </td>
                            <td>Total Escalated</td>
                            <td class="total-supplier">&nbsp;</td>
                            <td class="total-customer">&nbsp;</td>
                            <td class="total-data"></td>
                            <td class="total-arrow"></td>
                            <td class="total-one-day"></td>
                            <td class="total-arrow2"></td>
                            <td class="total-seven-days"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <?php $this->renderPartial('_datatable'); ?>
    <div class="reportes-laterales derecha">
        <a class='itemreporte' href='javascript:void(0)' id='print-btn' rel="/site/print" title="Print tickets">
            <span class='reporte'>
                <span class="text-visible"><img src="/images/print.png" width="40" height="43"></span>
            </span>
        </a>

        <a class='itemreporte' href='javascript:void(0)' id='excel-btn' rel="/site/yiiexcel" title="Export tickets to excel">
            <span class='reporte'>
                <span class="text-visible"><img src="/images/excel.png" width="43" height="43"></span>
            </span>
        </a>

        <a class='itemreporte' href='javascript:void(0)' id='mail-btn' rel="/site/mailyiiexcel" title="Send tickets by email">
            <span class='reporte'>
                <span class="text-visible"><img src="/images/mail.png" width="43" height="33"></span>
            </span>
        </a>
    </div>
</form>