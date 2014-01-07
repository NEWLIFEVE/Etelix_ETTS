<?php
/* @var $this TicketController */
/* @var $model Ticket */

$this->breadcrumbs=array(
	'Tickets'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List Ticket', 'url'=>array('index')),
	array('label'=>'Create Ticket', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#ticket-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>




<!--<div class="span12">
    <h2>My Tickets</h2>
    <div class="example">
        <table id="tabla_preview">
            <thead>
                <tr>
                    <th>Ticket Number</th>
                    <th>Failure</th>
                    <th>Status</th>
                    <th>Origination IP</th>
                    <th>Destination IP</th>
                    <th>Prefix</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>-->





<!--<h1>Manage Tickets</h1>-->



<?php // echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php 
$this->renderPartial('_search',array(
	'model'=>$model,
)); 
?>
</div><!-- search-form -->

<?php
$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'ticket-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'ticket_number',
             array(
            'name'=>'idFailure',
            'value'=>'$data->idFailure->name',
            'type'=>'text',
            'header' => 'Failure'
            ),
             array(
            'name'=>'idStatus',
            'value'=>'$data->idStatus->name',
            'type'=>'text',
            'header' => 'Status'
            ),
		'origination_ip',
		'destination_ip',
		/*
		'date',
		'machine_ip',
		'hour',
		'prefix',
		'id_gmt',
		'ticket_number',
		*/
		array(
			'class'=>'CButtonColumn',
                        'template'=>'{detail}',
                        'buttons'=>array(
                            'detail' => array( //botón para la acción nueva
//                                'class'=>'CLinkColumn',
                                'label'=>'descripción accion_nueva', // titulo del enlace del botón nuevo
                                'imageUrl'=>Yii::app()->request->baseUrl.'/images/view.gif', //ruta icono para el botón
//                                'url'=>'$data->id',
                                'click'=>'js:function(e){ e.preventDefault();   
                                    $.Dialog({
                                    shadow: true,
                                    overlay: true,
                                    flat:true,
                                    icon:false,
                                    title: false,
                                    width: 510,
                                    height: 300,
                                    padding: 0,
                                    draggable: true,
                                    content:"<img src='.Yii::app()->request->baseUrl.'/images/work.jpg>"

                                });}',
                                'header'=>'button'
                            ),
                        ),
		),
	),
));
?>