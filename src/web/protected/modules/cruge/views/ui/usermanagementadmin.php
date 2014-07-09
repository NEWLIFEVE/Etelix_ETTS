<div class="span12">
    <h2><?php echo ucwords(CrugeTranslator::t('admin', 'Manage Users'));?></h2>
    <table cellpadding="0" cellspacing="0" border="0" class="display" id="example" width="100%">
        <thead>
            <tr>
                <th>Username</th>
                <th>Mail</th>
                <th>Account Status</th>
                <th>Last Access</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $key => $value): ?>
            <tr>
                <td><?= $value['username']; ?></td>
                <td><?= $value['email']; ?></td>
                <td><?= $value['state']; ?></td>
                <td><?= $value['lastusage']; ?></td>
                <td><?= CHtml::link('<i class="icon-pencil"></i> ', array('/cruge/ui/usermanagementupdate','id' => $value['iduser'])); ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>