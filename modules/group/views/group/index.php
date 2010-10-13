<?php echo Message::render() ?>

<?php foreach ( $groups as $g ): ?>
<div class=group-list>
<?php echo html::anchor( 'group/view/'.$g->id, $g->name ); ?>
<br />
<?php echo $g->description ?>

</div>

<?php endforeach;?>

