<?php 
	// permite al usuario seleccionar los AuthItems que conforman a ROLE o TASK
	// las OPERATIONS no tienen childs.
	//
	// argumentos recibidos:
	//
	// $model: instancia de CAuthItem
	//
	// Yii::app()->clientScript->registerCoreScript('jquery');
	$rbac = Yii::app()->user->rbac;
	$roles = $rbac->getRoles();
	$tareas = $rbac->getTasks();
	$operaciones = $rbac->getOperations();
	// items asignados a la instancia de CAuthItem seleccionado ($model)
	$childrens = $rbac->getItemChildren($model->name);

	// ROLES
	$treeDataRoles = array();	
	// TASKS
	$treeDataMenu = array();
	$treeDataError = array();
	$treeDataRegular = array();
	// OPERATIONS
	$treeDataOps = array();

	
        /*
	$iconPin = Yii::app()->user->ui->getResource('pin.png');
	$imgPin = "<img class='pin-on' src='{$iconPin}' title='"
		.CrugeTranslator::t("Click para asignar/desasignar el item")."'>";
         * 
         */
        $imgPin = '&nbsp;';

	//  LISTA DE ROLES 
	//		si hay roles definidos y la vista no es para un TASK.
	//
	if((count($roles) > 0) && ($model->type != CAuthItem::TYPE_TASK)){
		
		foreach($roles as $item){
			$asignado = isset($childrens[$item->name]) ? 'text-info' : '';
			$loop = $rbac->detectLoop($model->name,$item->name) ? "text-alert" : "" ;
			$treeDataRoles[] = array(
				'id'=>$item->name,
				'text'=>"<span class='{$asignado} {$loop}'>".$item->name
					."</span>".$imgPin . "<input type='checkbox' name='assignRoles' class='{$asignado}'>",
				'htmlOptions'=>array('class'=>'authitem',
					'alt'=>$item->name),
			);
		}
	}

	// LISTA DE TAREAS - organizadas segun el uso de sintaxis en descripcion
	//	(leer acerca de la sintaxis en la clase CrugeAuthManager)
	if(count($tareas) > 0){
		$taskinfo = $rbac->explodeTaskArray($tareas);

		// despliega las tareas que son MENU y SUBMENU pero usando
		// un TreeView
		//
		if(count($taskinfo['topmenu']) > 0)
		{
			foreach($taskinfo['topmenu'] as $topTask){
				$text = $rbac->getTaskText($topTask);
				$hasChildren = false;
				$children = array();
				if(isset($taskinfo['childmenu'][$topTask->name]))
				foreach($taskinfo['childmenu'][$topTask->name] as $child){
					$asignado = isset($childrens[$child->name]) ? 
						'text-info' : '';
					$loop = $rbac->detectLoop($model->name,$child->name) ? 
						"text-alert" : "" ;
					$hasChildren = true;
					$children[] = array(
						'id'=>$child->name,
						'text'=>"<span class='itemchildtext authitemsub {$asignado} {$loop}'>"
								.$rbac->getTaskText($child)."</span>".$imgPin . "<input type='checkbox' name='assignRoles' class='{$asignado}'>",
						'htmlOptions'=>array('class'=>'authitemchild'
							,'alt'=>$child->name
							, 'title'=>$child->name),
					);
				}
				$asignado = isset($childrens[$topTask->name]) ? 'text-info' : '';
				$loop = $rbac->detectLoop($model->name,$topTask->name) ? 
						"text-alert" : "" ;
				$treeDataMenu[] = array(
					'id'=>$topTask->name,
					'text'=>"<span class='itemtext authitemtop {$asignado} {
						$loop}'>".$text
						."</span>".$imgPin . "<input type='checkbox' name='assignRoles' class='{$asignado}'>",
					'expanded'=>false,
					'hasChildren'=>$hasChildren,
					'children'=>$children,
					'htmlOptions'=>array('class'=>'authitem',
							'alt'=>$topTask->name, 'title'=>$topTask->name),
				);
			}
		}

		// Muestra las tareas que fueron consideradas menues pero sus
		// nodos padre no existen. (tienen su sintaxis de descripcion errada).
		if(count($taskinfo['orphan'])>0)
			foreach($taskinfo['orphan'] as $orpTask){
				$asignado = isset($childrens[$orpTask->name]) ? 'text-info' : '';
				$loop = $rbac->detectLoop($model->name,$orpTask->name) ? 
						"text-alert" : "" ;
				$treeDataError[] = array(
					'id'=>$orpTask->name,
					'text'=>"<span class='{$asignado} {$loop}'>".
						$rbac->getTaskText($orpTask)."</span>".$imgPin . "<input type='checkbox' name='assignRoles' class='{$asignado}'>",
					'expanded'=>false,
					'hasChildren'=>false,
					'htmlOptions'=>array('class'=>'authitem'
						, 'alt'=>$orpTask->name),
				);
			}

		// Muestra las tareas regulares, aquellas no marcadas con sintaxis.
		// en otras palabras las tareas comunes y silvestres!
		if(count($taskinfo['regular'])>0)
			foreach($taskinfo['regular'] as $task){
				$asignado = isset($childrens[$task->name]) ? 'text-info' : '';
				$loop = $rbac->detectLoop($model->name,$task->name) ? 
						"text-alert" : "" ;
				$treeDataRegular[] = array(
					'id'=>$task->name,
					'text'=>"<span class='{$asignado} {$loop}'>".
						$task->name."</span>".$imgPin . "<input type='checkbox' name='assignRoles' class='{$asignado}'>",
					'expanded'=>false,
					'hasChildren'=>false,
					'htmlOptions'=>array('class'=>'authitem',
						'alt'=>$task->name),
				);
			}
	}

	// LISTA DE OPERACIONES	- organizadas con un filtro
	//
	if(count($operaciones) > 0){

		// arma una lista de categorias en conjunto con el dato 'filter'
		// usado para agrupar las operaciones con el metodo:
		//	$rbac->getOperationsFiltered(...)
		//
		$listacatg = array();
		$listacatg['1'] = CrugeTranslator::t('Variadas');
		$listacatg['3'] = CrugeTranslator::t('Controllers');
		foreach($rbac->enumControllers() as $controllerName)
			$listacatg[$controllerName] = $controllerName;
		$listacatg['2'] = CrugeTranslator::t('Cruge');

		// cada categoria es un sub nodo del arbol CTreeView::operations
		//
		foreach($listacatg as $catg_filter => $catg_name){
			$childs = array();
			foreach($rbac->getOperationsFiltered($catg_filter, $operaciones) 
				as $item){
				// por cada operacion filtrada por $filter la agrega

				$asignado = isset($childrens[$item->name]) ? 'text-info' : '';
				$loop = $rbac->detectLoop($model->name,$item->name) ? 
						"text-alert" : "" ;

				$childs[] = array(
					'id'=>$item->name,
					'text'=>"<span class='{$asignado} {$loop}'>".
						$item->name."</span>".$imgPin . "<input type='checkbox' name='assignRoles' class='{$asignado}'>",
					'htmlOptions'=>array('class'=>'authitem',
						'alt'=>$item->name),
				);
			}

			$treeDataOps[] = array(
				'text'=>$catg_name,
				'hasChildren'=>(count($childs)>0) ? true:false,
				'expanded'=>false,
				'children'=>$childs,
			);
		}

	}

	// por razones de generar orden, no le da al usuario la posibilidad
	// de que a una tarea tipo subitem la componga de otros subitems
	// si se va a generar un enredo (para el).
	//
	if($model->type == CAuthItem::TYPE_ROLE){
		$arrayTareas = array(
			array(
				'text'=>"<b>".CrugeTranslator::t(
					"Tareas Regulares")."</b>", 
				'expanded'=>true, 
				'hasChildren'=>(count($treeDataRegular)>0) ? true : false,
				'children'=>$treeDataRegular,
			),
			array(
				'text'=>"<b>".CrugeTranslator::t(
					"Tareas de tipo Menu")."</b>", 
				'expanded'=>true, 
				'hasChildren'=>(count($treeDataMenu)>0) ? true : false,
				'children'=>$treeDataMenu,
			),
			array(
				'text'=>"<b>".CrugeTranslator::t(
					"Tareas Huerfanas")."</b>", 
				'expanded'=>true, 
				'hasChildren'=>(count($treeDataError)>0) ? true : false,
				'children'=>$treeDataError,
			),
		);
	}else{
		$arrayTareas = array(
			array(
				'text'=>"<b>".CrugeTranslator::t(
					"Tareas Regulares")."</b>", 
				'expanded'=>true, 
				'hasChildren'=>(count($treeDataRegular)>0) ? true : false,
				'children'=>$treeDataRegular,
			),
			array(
				'text'=>"<b>".CrugeTranslator::t(
					"Tareas Huerfanas")."</b>", 
				'expanded'=>true, 
				'hasChildren'=>(count($treeDataError)>0) ? true : false,
				'children'=>$treeDataError,
			),
		);
	}
        
        
//	$this->widget('CTreeView',array(
//		'id'=>'auth-item-tree',
//		'persist'=>'cookie',
//		'data'=>
//		array(
//
//			// ROLES  TREENODE
//			array(
//				'text'=>"<b>".CrugeTranslator::t("Roles")."</b>", 
//				'expanded'=>true, 
//				'children'=>$treeDataRoles,
//			),//end roles treenode
//
//			// TAREAS TREENODE
//			array(
//				'text'=>"<b>".CrugeTranslator::t("Tareas")."</b>", 
//				'expanded'=>true, 
//				'children'=>$arrayTareas,
//			),//end tareas treenode
//
//			// OPERATIONS  TREENODE
//			array(
//				'text'=>"<b>".CrugeTranslator::t(
//					"Operaciones Organizadas por Tipo")."</b>", 
//				'expanded'=>true, 
//				'children'=>$treeDataOps,
//			),//end operations treenode
//			
//		)
//	));
?>
<div class="span12">
    <?php
	echo "<h2>".ucfirst($model->name)." (".
		CrugeTranslator::t($rbac->getAuthItemTypeName($model->type)).")</h2>";
	echo "<h3 class='hint'>".$model->description."</h3>";
	echo "<p>".ucfirst(CrugeTranslator::t(
	"click an item to enable or disable"))."</p>";
    ?>
    <div class="example">
        <ul class="treeview" data-role="treeview">
            <li class="node collapsed">
                <a href="#"><span class="node-toggle"></span>Roles</a>
                <ul>
                    <?php foreach ($treeDataRoles as $r): ?>
                        <li><a href="#" alt="<?= $r['id']; ?>"><?= $r['text']; ?></a></li>
                    <?php endforeach; ?>
                </ul>
            </li>

            <li class="node collapsed">
                <a href="#"><span class="node-toggle"></span>Task</a>
                <ul>
                    <?php foreach ($arrayTareas as $t): ?>
                        <?php if (count($t['children'])): ?>
                            <li class="node collapsed">
                                <a href="#"><span class="node-toggle"></span><?= $t['text']; ?></a>
                                <ul>
                                    <?php foreach ($t['children'] as $c): ?>
                                        <?php if (count($c['children'])): ?>
                                            <li class="node collapsed">
                                                <?php if (count($c['children'])): ?>
                                                    <a href="#" alt="<?= $c['id']; ?>"><span class="node-toggle"></span><?= $c['text']; ?></a>
                                                    <ul>
                                                        <?php foreach ($c['children'] as $c2): ?>
                                                            <li><a href="#" alt="<?= $c2['id']; ?>"><?= $c2['text']; ?></a></li>
                                                        <?php endforeach; ?>
                                                    </ul>
                                                <?php else: ?>
                                                    <a href="#" alt="<?= $c['id']; ?>"><span class="node-toggle"></span><?= $c['text']; ?></a>
                                                <?php endif; ?>
                                            </li>
                                        <?php else: ?>
                                            <li><a href="#" alt="<?= $c['id']; ?>"><?= $c['text']; ?></a></li>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </ul>
                            </li>
                        <?php else: ?>
                            <li><a href="#"><?= $t['text']; ?></a></li>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </ul>
            </li>
            
            <li class="node collapsed">
                <a href="#"><span class="node-toggle"></span>Role-based operations</a>
                <ul>
                    <?php foreach ($treeDataOps as $r): ?>
                        <?php if (count($r['children'])): ?>
                            <li class="node collapsed">
                                <?php if (count($r['children'])): ?>
                                    <a href="#"><span class="node-toggle"></span><?= $r['text']; ?></a>
                                    <ul>
                                        <?php foreach ($r['children'] as $r2): ?>
                                            <li><a href="#"  alt="<?= $r2['id']; ?>"><?= $r2['text']; ?></a></li>
                                        <?php endforeach; ?>
                                    </ul>
                                <?php else: ?>
                                    <a href="#" alt="<?= $r['id']; ?>"><span class="node-toggle"></span><?= $r['text']; ?></a>
                                <?php endif; ?>
                            </li>
                        <?php else: ?>
                            <li><a href="#" alt="<?= $t['id']; ?>"><?= $r['text']; ?></a></li>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </ul>
            </li>
        </ul>
    </div>
</div>
<script>
	$('input[name="assignRoles"]').each(function(){
		var checkbox = $(this);
		checkbox.css("cursor", "pointer");
                
                if (checkbox.attr('class') !== '') {
                    checkbox.prop('checked', true);
                }
                
		checkbox.click(function(){

			// el atributo alt del LI tiene el nombre del item que representa.
			var _li = $(this).parent();
			var thisItemName = _li.attr('alt');
			var span = _li.find('span');

			//var istop = span.hasClass("authitemtop");
			//var issub = span.hasClass("authitemsub");
			//var tiponodo = 0;
			//if(istop==false && issub==false) tiponodo='normal'; // rol, tarea
			//if(istop==true && issub==true) tiponodo='top'; // es un topmenu
			//if(istop==false && issub==true) tiponodo='sub'; // es un submenu

			// el nuevo valor segun el valor checked actual
			var setFlag = span.hasClass('text-info') ? false : true;

			//alert("tiponodo="+tiponodo+" newFlag="+setFlag+", span="
			//	+span.html());
			//return;
			
			var action = '<?php 
				echo Yii::app()->user->ui->getRbacAjaxSetChildItemUrl()?>';
			var jsondata = "{ \"parent\": \"<?php 
				echo $model->name;?>\" , \"child\": "
					+"\""+thisItemName+"\" , \"setflag\": "+setFlag+" }";	
			var loadingUrl = '<?php 
				echo Yii::app()->user->ui->getResource('loading.gif'); ?>';
			var loader = _li.find('span.loader');

			loader.html("<img src='"+loadingUrl+"'>");
			$('#_errorResult').html("");
			jQuery.ajax({
				url: action,
				type: 'post',
				async: true,
				// contentType: "application/json",
				cached: false,
				data: jsondata,
				success: function(data, textStatus, jqXHR){
					loader.html("");
					// si se pudo realizar la accion, aqui data trae un objeto 
					// json con la data del item
					if(data.result == true){
						span.addClass("text-info");
                                                checkbox.prop('checked', true);
					}else{
						span.removeClass("text-info");
                                                checkbox.prop('checked', false);
					}
				},
				error: function(jqXHR, textStatus, errorThrown){
					//$('#_errorResult').html("Ocurrio un error:<hr>"
						//+jqXHR.responseText);
					$('#_errorResult').html("<p class='auth-item-error-msg'>"
					  +"no se pudo agregar<br/>"+jqXHR.responseText+"</p>");
					$('#_errorResult').show("slow");
					setTimeout(function(){
						$('#_errorResult').hide("slow");
						$('#_errorResult').html("");
					},3000);
					loader.html("");
				},
			});
		});
	});

	
</script>

<div id='_errorResult'></div>
<div id='_log'></div>

