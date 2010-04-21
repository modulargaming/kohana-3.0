<h2>Character creation</h2>

<?php foreach ($errors as $v): ?>

	<?php echo $v; ?><br />

<?php endforeach; ?>

<?php echo form::open(); ?>

<fieldset>
	<dl>
		<dt><?php echo form::label( 'name', 'Character name:' ); ?></dt>
		<dd><?php echo form::input( 'name', $post['name'] ); ?></dd>
	</dl>
	<dl>
		<dt>Gender:</dt>
		<dd>
			<?php echo form::label( 'gender', form::radio('gender', 'male', TRUE) . ' Male' ); ?>
			<?php echo form::label( 'gender', form::radio('gender', 'female', FALSE) . ' Female' ); ?>
		</dd>
	</dl>
	<dl>
		<dt>
			<?php echo form::label( 'race_id', 'Race:' ); ?><br />
			<span><a href="#">Summary about the races</a></span>
		</dt>
		<dd><?php echo form::select( 'race', $races, $post['race'] ); ?></dd>
	</dl>
	<dl>
		<dt>
			<?php echo form::label( 'class_id', 'Class:' ); ?><br />
			<span><a href="#">Summary about the classes</a></span>
		</dt>
		<dd><?php echo form::select( 'class', $classes, $post['class'] ); ?></dd>
	</dl>
	<dl>
		<?php echo form::submit('create', 'Create Character'); ?>
	</dl>
</fieldset>

<?php echo form::close(); ?>
