<?php echo Message::render() ?>

<?php foreach ( $posts as $p ): ?>

<div class=forum-title>
<?php echo html::anchor( 'forum/post/'.$p->id, $p->title ); ?>
</div>

<div class=forum-content>

<?php echo $p->content ?>
</div>

<div>
Created by <?php echo $p->user->username ?> <?php echo MG::Ago($p->created) ?>
</div>

<?php endforeach;?>

<div class=strong>
<?php echo html::anchor( 'forum/topic/'.$topic->id.'/new_post', 'Create Post' ); ?>
</div>
