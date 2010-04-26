<?php echo Message::render() ?>

<div>
<?php echo __('Username:') ?>
<?php echo $profile->username ?> 
<br />
<?php echo __('Last login:') ?>
<?php echo Time::Ago($profile->last_login) ?>

<?php if ($user->id != $profile->id): ?>
	<?php echo html::anchor( 'message/create/'.$user->id, 'Mail' ) ?>
<?php endif ?>

</div>


