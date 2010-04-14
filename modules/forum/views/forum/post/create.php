<?php echo Message::render() ?>

<h2>Post</h2>
<?php echo form::open( NULL, array( 'class' => 'forum' ) ); ?>
<fieldset>
	<dl>
		<dt>
			<?php echo form::label('title', 'Title:'); ?><br />
			<span><?php echo __('Length must be between 3 and 20 characters.'); ?></span>
		</dt>
		<dd><?php echo form::input( 'title', $post['title'], array( 'maxlength' => 20 ) ); ?></dd>
	</dl>
	<dl>
		<dt><?php echo form::label( 'content', 'Content:' ); ?></dt>
		<dd><?php echo form::textarea( 'content', $post['content']); ?></dd>
	</dl>
	<?php echo form::submit('post', 'Post reply'); ?>
</fieldset>
<?php echo form::close(); ?>
