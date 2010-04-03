<h2>Settings</h2>

<?php echo Message::render() ?>

<?php echo form::open() ?>

<fieldset>
	<dl>
		<dt><?php echo form::label('email', 'Email:') ?></dt>
		<dd><?php echo form::input('email', $user->email) ?></dd>
	</dl>
	<dl>
		<dt>
			<?php echo form::label('confirm_email', 'Confirm Email:') ?><br />
			<span>Only required if you are changing the email</span>
		</dt>
		<dd><?php echo form::input('confirm_email') ?></dd>
	</dl>
	<dl></dl>
	<dl>
		<dt><?php echo form::label('password', 'New Password:') ?></dt>
		<dd>
			<?php echo form::password('password') ?>
		</dd>
	</dl>
	<dl>
		<dt>
			<?php echo form::label('password_confirm', 'Confirm Password:') ?><br />
			<span>Only required if you are changing the password.</span>
		</dt>
		<dd>
			<?php echo form::password('password_confirm') ?>
		</dd>
	</dl>
	<dl></dl>
	<dl>
		<dt>
			<?php echo form::label('old_password', 'Current Password:') ?><br />
			<span>Required for making sure you are you.</span>
		</dt>
		<dd>
			<?php echo form::password('old_password') ?>
		</dd>
	</dl>
	
	<?php echo form::submit('edit', 'Edit') ?>
</fieldset>
<?php echo form::close() ?>