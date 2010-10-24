<?php echo Message::render() ?>

<h2>Create Group</h2>
<?php echo form::open( NULL, array( 'class' => 'group' ) ); ?>
<fieldset>
	<dl>
		<dt>
			<?php echo form::label('name', 'Name:'); ?><br />
			<span><?php echo __('Length must be between 3 and 25 characters.'); ?></span>
		</dt>
		<dd><?php echo form::input( 'name', $post['name'], array( 'maxlength' => 25 ) ); ?></dd>
	</dl>
	<dl>
		<dt><?php echo form::label( 'description', 'Description:' ); ?></dt>
		<dd><?php echo form::textarea( 'description', $post['description']); ?></dd>
	</dl>
	<?php echo form::submit('post', 'Create Group'); ?>
</fieldset>
<?php echo form::close(); ?>
