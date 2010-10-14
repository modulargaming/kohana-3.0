<?php echo Message::render() ?>

<?php foreach ( $groups as $g ): ?>
<div class=group-list>
<?php echo html::anchor( 'group/groups/'.$g->id, $g->name ); ?>
<br />
<?php echo $g->description ?>

</div>

<?php endforeach;?>

<div>
        <?php echo html::anchor( 'group/groups/'.'1/'.'new_group', 'Create group' ); ?>
</div>

