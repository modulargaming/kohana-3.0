<h2>Settings</h2>

<?php echo form::open(); ?>

<fieldset>
	<dl>
		<dt><?php echo form::label('email', 'Email:'); ?></dt>
		<dd><?php echo form::input('email', $user->email); ?></dd>
	</dl>
	<dl>
		<dt>
			<?php echo form::label('email_confirm', 'Confirm Email:'); ?><br />
			<span>Only required if you are changing the email</span>
		</dt>
		<dd><?php echo form::input('email_confirm'); ?></dd>
	</dl>
	<dl>
		<dt><?php echo form::label('password', 'New Password:'); ?></dt>
		<dd>
			<?php echo form::password('password'); ?>
		</dd>
	</dl>
	<dl>
		<dt>
			<?php echo form::label('password_confirm', 'Confirm Password:'); ?><br />
			<span>Only required if you are changing the password.</span>
		</dt>
		<dd>
			<?php echo form::password('password_confirm'); ?>
		</dd>
	</dl>
	
	<?php echo form::submit('edit', 'Edit'); ?>
</fieldset>
<?php echo form::close(); ?>