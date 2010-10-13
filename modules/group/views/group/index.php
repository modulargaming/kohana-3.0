<?php echo Message::render() ?>

<?php foreach ( $groups as $g ): ?>
<div class=group-category>
<?php echo html::anchor( 'group/list/'.$g->id, $g->name ); ?>
<br />
<?php echo $g->description ?>

</div>

<?php endforeach;?>

