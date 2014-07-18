
        <?php 
                //echo CrugeTranslator::t("Filtrar por Controlador:");
                $ar = array(
                        '0'=>CrugeTranslator::t('Ver Todo'),
                        '1'=>CrugeTranslator::t('Otras'),
                        '2'=>CrugeTranslator::t('Cruge'),
                        //'3'=>CrugeTranslator::t('Controladoras'),
                );
                foreach(Yii::app()->user->rbac->enumControllers() as $c)
                        $ar[$c] = $c;
                // build list
//                echo "<ul class='cruge_filters'>";
//                foreach($ar as $filter=>$text)
//                        echo "<li>".CHtml::link($text, array('/cruge/ui/rbaclistops',
//                                'filter'=>$filter))."</li>";
//                echo "</ul>";
        ?>
        





<div class="span9">
    <h2>Operations</h2>
    <div class="filter-controller">
        <div class="input-control select span3">
            <select id="filter-controller">
                <option>Filter By Controller</option>
                <?php foreach ($ar as $filter=>$text): ?>
                    <option value="<?= $filter; ?>"><?= $text; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>
    <?php 
    $this->renderPartial('_listauthitems'
            ,array('dataProvider'=>$dataProvider)
            ,false
            );
    ?>
</div>

<div class="span3">
    <h2>New Operation</h2>
    <div class='auth-item-create-button'>
    <?php echo CHtml::link(CrugeTranslator::t("Create")
            ,Yii::app()->user->ui->getRbacAuthItemCreateUrl(CAuthItem::TYPE_OPERATION),
            array('class' => 'enlace'));?>
    </div>
</div>

<script>
    $('#filter-controller').change(function(){
        if ($(this).val()) {
            $(location).attr('href', _root_ + 'cruge/ui/rbaclistops/filter/' + $(this).val());
        }
    });
</script>