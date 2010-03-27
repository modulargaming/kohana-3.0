<?php echo Message::render() ?>

<?php foreach ( $topics as $t ): ?>

<p>
<?php echo html::anchor( 'forum/topic/'.$t->id, $t->title ); ?>
<br />
<?php echo MG::Ago($t->created) ?>

</p>

<?php endforeach;?>

