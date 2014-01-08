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
//                'name'=>'User',
                'value'=>'CrugeUser2::getUserTicket($data->id)',
                'type'=>'text',
                'header' => 'User',
                'htmlOptions'=>array(
                    'width'=>'100',
                ),
                ),
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
//                                'options' => array('rel' => '$data->id'),
                                'label'=>'descripción accion_nueva', // titulo del enlace del botón nuevo
                                'imageUrl'=>Yii::app()->request->baseUrl.'/images/view.gif', //ruta icono para el botón
                                'url'=>'$data->id',
                                'click'=>'js:function(e){ 
                                    e.preventDefault();
                                    $.ajax({
                                        type:"POST",
                                        url:"getdataticket",
                                        data:{idTicket:$(this).attr("href")},
                                        success:function(data){
                                            $.Dialog({
                                                shadow: true,
                                                overlay: true,
                                                flat:true,
                                                icon: "<span class=icon-eye-2></span>",
                                                title: "Ticket Information",
                                                width: 510,
                                                height: 300,
                                                padding: 0,
                                                draggable: true,
                                                content:"<div id=content_preview>"+data+"</div>"
                                            });
                                        }
                                    });
                                    
                                }',
                            ),
                        ),
		),
	),
));
?>

<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/tickets/admin.js',CClientScript::POS_END); ?>