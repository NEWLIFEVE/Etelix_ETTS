<div class="span12">
    <h2><?php echo ucwords(CrugeTranslator::t("user sessions"));?></h2>
    <table cellpadding="0" cellspacing="0" border="0" class="display" id="example" width="100%">
        <thead>
            <tr>
                <th>#</th>
                <th>User</th>
                <th>Status</th>
                <th>Created</th>
                <th>Last Usage</th>
                <th>Usage Count</th>
                <th>Expire</th>	
                <th>Ipaddress</th>	
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($data as $d): ?>
            <tr>
                <td><?= $d->idsession; ?></td>
                <td><?= $d->user != null ? $d->user->username : ''; ?></td>
                <td><?= $d->status === 1 ? 'Active' : 'Closed'; ?></td>
                <td><?= date('jS F Y h:i:s', $d->created); ?></td>
                <td><?= date('jS F Y h:i:s', $d->lastusage);  ?></td>
                <td><?= $d->usagecount; ?></td>
                <td><?= date('jS F Y h:i:s', $d->expire); ?></td>
                <td><?= $d->ipaddress; ?></td>
                <td><?= CHtml::Link(
                        '<i class="icon-cancel-2 fg-red"></i>',
                        'javascript:void(0)',
                        array('id' => 'deleteSession', 'rel' => $d['idsession'])); 
                ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>