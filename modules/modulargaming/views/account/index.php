<h2><?php echo __('Settings') ?></h2>

<?php echo Message::render() ?>

<?php echo form::open() ?>

<fieldset>
	<dl>
		<dt><?php echo form::label('email', 'E-mail address:') ?></dt>
		<dd><?php echo form::input('email', $user->email) ?></dd>
	</dl>
	<dl>
		<dt>
			<?php echo form::label('confirm_email', 'Confirm e-mail address:') ?><br />
			<span><?php echo __('Only required if you are changing the e-mail adress.') ?></span>
		</dt>
		<dd><?php echo form::input('confirm_email') ?></dd>
	</dl>
	<dl></dl>
	<dl>
		<dt><?php echo form::label('password', 'New password:') ?></dt>
		<dd>
			<?php echo form::password('password') ?>
		</dd>
	</dl>
	<dl>
		<dt>
			<?php echo form::label('password_confirm', 'Confirm password:') ?><br />
			<span><?php echo __('Only required if you are changing the password.') ?></span>
		</dt>
		<dd>
			<?php echo form::password('password_confirm') ?>
		</dd>
	</dl>
	<dl></dl>
	<dl>
		<dt>
			<?php echo form::label('old_password', 'Current password:') ?><br />
			<span><?php echo __('Required for making sure you are you.') ?></span>
		</dt>
		<dd>
			<?php echo form::password('old_password') ?>
		</dd>
	</dl>
	
	<?php echo form::submit('edit', 'Edit') ?>
</fieldset>
<?php echo form::close() ?>