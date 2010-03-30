<?php echo Message::render() ?>

<?php foreach ( $posts as $p ): ?>

<p>
<?php echo $p->user->username ?>
<br />
<?php echo $p->content ?>
<br />
<?php echo MG::Ago($p->created) ?>

</p>

<?php endforeach;?>

<p>
<?php echo html::anchor( 'forum/create/'.$topic->id, 'Create Post' ); ?>
</p>
