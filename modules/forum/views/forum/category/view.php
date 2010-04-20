<?php echo Message::render() ?>

<?php foreach ($topics as $t): ?>

<div class=forum-topic>
	<?php echo html::anchor( 'forum/topic/'.$t->id, $t->title ); ?>
	<br />
	<?php echo __('Created by:') ?>
	<b><?php echo $t->user->username ?></b>
	<i><?php echo Time::Ago($t->created) ?></i>
</div>

<?php endforeach;?>

<div>
	<?php echo html::anchor( 'forum/category/'.$category->id.'/new_topic', 'Create topic' ); ?>
</div>
