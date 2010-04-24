<h2><?php echo __('Messages').' - '.__('Write a new message') ?></h2>

	<?php echo Message::render() ?>
	
	<?php echo form::open() ?>
	<fieldset>
		<dl>
			<dt><?php echo form::label('to', 'Reciver:'); ?></dt>
			<dd><?php echo form::input('to', $post['to']); ?></dd>
		</dl>
		<dl>
			<dt><?php echo form::label('title', 'Title:'); ?></dt>
			<dd><?php echo form::input('title', $post['title']); ?></dd>
		</dl>
		<dl>
			<dt><?php echo form::label('message', 'Message:'); ?></dt>
			<dd>
				<?php echo form::textarea('message', $post['message']); ?>
			</dd>
		</dl>
		<br /><br />
		
		<?php echo form::submit('send', 'Send'); ?>
	</fieldset>
	<?php echo form::close() ?>

