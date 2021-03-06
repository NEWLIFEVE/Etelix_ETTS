<!DOCTYPE html>
<html lang="<?php echo Yii::app()->language;?>">
    <head>
        <title><?php echo CHtml::encode($this->pageTitle); ?></title>
        <meta charset="<?php echo Yii::app()->charset;?>">
        <!--<link href="<?php // echo Yii::app()->theme->baseUrl; ?>/css/normalize.css" rel="stylesheet" type="text/css">-->
        <link href="<?php echo Yii::app()->theme->baseUrl; ?>/css/metro-bootstrap.css" rel="stylesheet" type="text/css">
        <link href="<?php echo Yii::app()->theme->baseUrl; ?>/css/metro-bootstrap-responsive.css" rel="stylesheet" type="text/css">
        <link href="<?php echo Yii::app()->theme->baseUrl; ?>/js/prettify/prettify.css" rel="stylesheet">
        <link href="<?php echo Yii::app()->theme->baseUrl; ?>/css/docs.css" rel="stylesheet" type="text/css">
             
        <?php Yii::app()->clientScript->registerCssFile(Yii::app()->clientScript->getCoreScriptUrl().'/jui/css/base/jquery-ui.css'); ?>
        <?php Yii::app()->clientScript->registerCoreScript('jquery'); ?>
        <?php Yii::app()->clientScript->registerCoreScript('jquery.ui'); ?>
        
        <script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/jquery/jquery.widget.min.js"></script>
        <script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/jquery/jquery.mousewheel.js"></script>
        <script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/prettify/prettify.js"></script>
     
        <!-- Local JavaScript -->
        <script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/metro/metro-loader.js"></script>
        <script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/metro/metro-dropdown.js"></script>
                
        <!-- Local JavaScript -->
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/modules/etts.js"></script>
        <script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/docs.js"></script>
        
        <link rel="shortcut icon" href="<?php echo Yii::app()->request->baseUrl; ?>/images/favicon.ico" type="image/x-icon"/> 
    </head>
    <body class="metro">
        <header class="bg-dark">
            <!--AQUÍ COMIENZA EL MENU -->
            <div class="navigation-bar dark">
                <div class="navigation-bar-content container">
                    <a href="/" class="element"><span class=""><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/tkt.png"></span> <?php echo Yii::app()->name; ?> <sup>ETELIX</sup></a>
                    <!-- SI SE LOGUEA EL USUARIO -->
                    <?php if (!Yii::app()->user->isGuest): ?>
                        <span class="element-divider"></span>
                        <?php echo CHtml::link('<i class="icon-home on-right on-left"></i> Home', array('/site/index'), array('class' => 'element')); ?>
                        <?php $items = Yii::app()->user->rbac->getMenu(); ?>
                        <?php if ($items): ?>
                            <?php for ($i = 0; $i < count($items); $i++): ?>
                                <div class="element">
                                    <?php echo CHtml::link('<i class="'.Utility::menuIcon($items[$i]['label']).'"></i> '.$items[$i]['label'], '#', array('class' => 'dropdown-toggle')); ?>
                                    <?php 
                                    if (isset($items[$i]['items'])) {
                                    $this->widget('zii.widgets.CMenu', array(
                                            'items'=>$items[$i]['items'],
                                            'htmlOptions'=>array(
                                                'class'=>'dropdown-menu',
                                                'id' => 'base-submenu',
                                                'data-role' => 'dropdown'
                                                ),
                                    )); } ?>
                                </div>
                            <?php endfor; ?>
                        <?php endif; ?>
                        <!-- MENU ADMIN -->
                        <?php if (Yii::app()->user->isSuperAdmin): ?>
                            <div class="element">
                                <?php echo CHtml::link('<i class="icon-box-add on-right on-left"></i> Tickets', '#', array('class' => 'dropdown-toggle')); ?>
                                <?php $this->widget('zii.widgets.CMenu', array(
                                        'items'=>Yii::app()->user->ui->AdminItemsAlternative,
                                        'htmlOptions'=>array(
                                            'class'=>'dropdown-menu',
                                            'id' => 'base-submenu',
                                            'data-role' => 'dropdown'
                                            ),
                                    )); ?>
                            </div>
                            <div class="element">
                                <?php echo CHtml::link('<i class="icon-user on-right on-left"></i> Manage Users', '#', array('class' => 'dropdown-toggle')); ?>
                                <?php $this->widget('zii.widgets.CMenu', array(
                                        'items'=>Yii::app()->user->ui->adminItems,
                                        'htmlOptions'=>array(
                                            'class'=>'dropdown-menu',
                                            'id' => 'base-submenu',
                                            'data-role' => 'dropdown'
                                            ),
                                    )); ?>
                            </div>
                        <?php endif; ?>
                        <!-- EDIT PROFILE -->
                        <?php if (Yii::app()->user->checkAccess('cliente') || Yii::app()->user->checkAccess('account_managers')): ?>
                            <?php if (!Yii::app()->user->isSuperAdmin): ?>
                            <?php echo CHtml::link('<i class="icon-pencil on-right on-left"></i> Edit Profile', array('/cruge/ui/editprofile'), array('class' => 'element')); ?>
                            <?php endif; ?>
                        <?php endif; ?>
                        
                        <?php echo CHtml::link('<i class="icon-locked on-right on-left"></i> Logout ('.Yii::app()->user->name.')', Yii::app()->user->ui->logoutUrl, array('class' => 'element')); ?>
                        <span class="element-divider"></span>
                    <?php endif; //FIN DEL LOGUEO ?> 
                </div>
            </div><!-- /MENU -->
        </header>
        <div class="page">
            <div class="page-region">
                <div class="page-region-content">
                    <h1 style="border-bottom: 1px solid silver">
                        Etelix Trouble Ticket System <small class="on-right">ETELIX</small>
                    </h1>
                    <div class="grid">
                        <div class="row">
                            <!--<pre><?php // print_r($items); ?></pre>-->
                            <?php echo $content; ?>
                        </div>
                    </div>
                </div>
            </div>
            <footer>
                Copyright &copy; <?php echo date('Y'); ?> ETELIX All Rights Reserved. Version 1.4.2
            </footer>
        </div>
        <script>
        var _root_ = "<?php echo Yii::app()->getBaseUrl(true) . '/'; ?>";
        </script>
        <?php echo Yii::app()->user->ui->displayErrorConsole(); ?>
    </body>
</html>