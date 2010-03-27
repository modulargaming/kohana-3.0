<h2>PM - Write a new message</h2>

<div class="left"><?php echo $sidebar ?></div>

<div class="left">

	<?php echo form::open() ?>
	<fieldset>
		<dl>
			<dt><?php echo form::label('to', 'Reciver:'); ?></dt>
			<dd><?php echo form::input('to'); ?></dd>
		</dl>
		<dl>
			<dt><?php echo form::label('message', 'message:'); ?></dt>
			<dd>
				<?php echo form::textarea('message'); ?>
			</dd>
		</dl>
		<br /><br />
		
		<?php echo form::submit('send', 'Send'); ?>
	</fieldset>
	<?php echo form::close() ?>

</div>