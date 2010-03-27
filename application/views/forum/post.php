<h2>Post</h2>
<?php foreach ($errors as $v): ?>
<?php echo $v; ?><br />
<?php endforeach; ?>
<?php echo form::open( NULL, array( 'class' => 'forum' ) ); ?>
<fieldset>
<dl>
<dt>
<?php echo form::label('title', 'Title:'); ?><br />
<span>Length must be between 3 and 20 characters.</span>
</dt>
<dd><?php echo form::input( 'title', $post['title'], array( 'maxlength' => 20 ) ); ?></dd>
</dl>
<dl>
<dt><?php echo form::label( 'content', 'Content:' ); ?></dt>
<dd><?php echo form::textarea( 'content', $post['content']); ?></dd>
</dl>
<dl>
<dt><?php echo Captcha::instance()->render(); ?></dt>
<dd><?php echo form::input( 'captcha', $post['captcha'] ); ?><br />Type the characters you see in the picture.</dd>
</dl>
<?php echo form::submit('post', 'post'); ?>
</fieldset>
<?php echo form::close(); ?>