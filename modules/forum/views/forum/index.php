<?php echo Message::render() ?>

<?php foreach ( $categories as $c ): ?>
<div class=forum-category>
<?php echo html::anchor( 'forum/category/'.$c->id, $c->title ); ?>
<br />
<?php echo $c->description ?>

</div>

<?php endforeach;?>

