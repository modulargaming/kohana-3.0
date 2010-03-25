<?php foreach ( $posts as $p ): ?>


<h2><?php echo $p->id ?></h2>

<p><?php echo $p->content ?></p>

<p><?php echo $p->user_id ?></p>

<?php endforeach;?>

