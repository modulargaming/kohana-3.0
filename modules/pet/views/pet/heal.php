<h2>Heal your Pet</h2>

<?php echo Message::display() ?>

Welcome to the magical healing centre, for a small fee we can give you some magical herbs that will refill your health.<br /><br />

<span class="bar hp">
	<?php echo '<span style="width: ' . $user_pet->percent_hp() . '%"></span>'; ?>
	<p><?php echo $pet->hp . ' / '. $pet->max_hp; ?></p>
</span>
<br />
<?php echo form::open(); ?>
<fieldset>
	<dl>
		<dt>
			<?php echo form::label('amount', 'Amount:'); ?><br />
			<span>(2gold per health point)</span>
		</dt>
		<dd><?php echo form::input( 'amount', $pet->max_hp - $pet->hp ); ?></dd>
	</dl>
	<br />
	<?php echo form::submit('heal', 'Heal'); ?>
</fieldset>
<?php echo form::close(); ?>
