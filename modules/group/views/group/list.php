<?php echo Message::render() ?>

<?php foreach ($groups as $g): ?>

<div class=group-list>
	<?php echo html::anchor( 'group/list/'.$g->id, $g->name ); ?>
	<br />
	<?php echo __('Created by:') ?>
	<b><?php echo $g->user->username ?></b>
	<i><?php echo Time::Ago($g->created) ?></i>
</div>

<?php endforeach;?>

<div>
	<?php echo html::anchor( 'group/create', 'Create Group' ); ?>
</div>
