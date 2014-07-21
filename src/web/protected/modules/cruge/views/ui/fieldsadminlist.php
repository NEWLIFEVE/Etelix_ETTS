
<div class="span9">
    <h2><?php echo ucwords(CrugeTranslator::t("custom fields"));?></h2>
    <table cellpadding="0" cellspacing="0" border="0" class="display" id="example" width="100%">
        <thead>
            <tr>
                <th>Internal Name</th>
                <th>Public Name</th>
                <th>Required</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($data as $d): ?>
            <tr>
                <td><?= $d->fieldname; ?></td>
                <td><?= $d->longname; ?></td>
                <td><?= $d->required; ?></td>
                <td>
                    <?= CHtml::Link(
                        '<i class="icon-pencil"></i>',
                        array('/cruge/ui/fieldsadminupdate', 'id' => $d->idfield)); 
                    ?>
                    <?= CHtml::Link(
                        '<i class="icon-cancel-2 fg-red"></i>',
                        'javascript:void(0)',
                        array('id' => 'deleteField', 'rel' => $d->idfield)); 
                    ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<div class="span3">
    <h2>New Field</h2>
    <div class='auth-item-create-button'>

        <?php echo CHtml::link(CrugeTranslator::t("Create")
            ,array('/cruge/ui/fieldsadmincreate'),
            array('class' => 'enlace'));?>
    </div>
</div>