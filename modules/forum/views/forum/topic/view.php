<?php echo Message::render() ?>

<?php foreach ($posts as $p): ?>

<div class=forum-title>
	<?php echo html::anchor( 'forum/post/'.$p->id, $p->title ); ?>
</div>

<div class=forum-content>
	<?php echo $p->content ?>
</div>

<div>
	<?php echo __('Created by:') ?> 
	<b><?php echo $p->user->username ?></b>
	<i><?php echo Time::Ago($p->created) ?></i>
	
	<?php if ($user->id == $p->user->id): ?>
		<?php echo html::anchor( 'forum/post/'.$p->id.'/edit', 'Edit' ) ?>
		<?php echo html::anchor( 'forum/post/'.$p->id.'/delete', 'Delete' ) ?>
	<?php endif ?>
	
</div>

<?php endforeach;?>

<div class=strong>
	<?php echo html::anchor( 'forum/topic/'.$topic->id.'/reply', 'Reply' ); ?>
</div>
