<?php echo Message::render() ?>

<div class=forum-title>
	<?php echo html::anchor( 'forum/post/'.$post->id, $post->title ); ?>
</div>

<div class=forum-content>
	<?php echo $post->content ?>
</div>

<div>
<?php echo __('Created by:') ?>
<?php echo $post->user->username ?> 
<?php echo MG::Ago($post->created) ?>
<?php if ($user->id == $post->user->id): ?>
	<?php echo html::anchor( 'forum/post/'.$post->id.'/edit', 'Edit' ) ?>
	<?php echo html::anchor( 'forum/post/'.$post->id.'/delete', 'Delete' ) ?>
<?php endif ?>

</div>


