<h2>Train your Pet</h2>

<?php echo Message::display() ?>

Welcome to the magical training centre. Train your skills here.<br /><br />


Energy:<br />
<span class="bar energy">
	<?php echo '<span style="width: ' . $char->percent_energy() . '%"></span>'; ?>
	<p><?php echo $user_pet->energy . ' / '. $user_pet->max_energy; ?></p>
</span>
<?php foreach ($skills as $s): ?>
<?php echo $s.' '.$user_pet->$s.' ';?>
<?php echo html::anchor("character/train/$s","Increase"); ?><br />
<?php endforeach; ?>
