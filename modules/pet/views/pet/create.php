<h2>Pet creation</h2>

<?php foreach ($errors as $v): ?>

	<?php echo $v; ?><br />

<?php endforeach; ?>

<?php echo form::open(); ?>

<fieldset>
	<dl>
		<dt><?php echo form::label( 'name', 'Pet name:' ); ?></dt>
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
			<?php echo form::label( 'colour_id', 'Colour:' ); ?><br />
			<span><a href="#">Summary about the colours</a></span>
		</dt>
		<dd><?php echo form::select( 'class', $colours, $post['colour'] ); ?></dd>
	</dl>
	<dl>
		<?php echo form::submit('create', 'Create Pet'); ?>
	</dl>
</fieldset>

<?php echo form::close(); ?>
