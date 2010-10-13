<?php echo Message::render() ?>


<div class=group-view>
	<b><?php echo $group->name?></b>
	<br />
	<?php echo $group->description?>
	<br /><br />
<b>Members:</b>
<?php foreach ( $group_users as $u ): ?>
<ul>

<li><?php echo html::anchor( 'profile/view/'.$u->group->user->username, $u->group->user->username); echo '('.$u->title.')'; ?></li>
</ul>
<?php endforeach;?>


	<?php echo __('Created by:') ?>
	<b><?php echo html::anchor( 'profile/view/'.$group->user->id,$group->user->username); ?></b>
	<i><?php echo Time::Ago($group->created) ?></i>
</div>


