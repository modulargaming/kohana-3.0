<?php echo Message::render() ?>


<div class=group-view>
	<?php echo $group->name?>
	<br />
	<?php echo $group->description?>
	<br />
	<?php echo __('Created by:') ?>
	<b><?php echo $group->user->username ?></b>
	<i><?php echo Time::Ago($group->created) ?></i>
</div>


