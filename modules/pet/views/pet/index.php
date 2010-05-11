<div class="stats">

	<h2><?php echo $pet->name; ?></h2>
	<p style="margin-top: -8px;">Level: <?php echo $pet->level; ?> <?php echo $pet->race->name; ?><?php echo $pet->class->name; ?></p>

	<span class="bar hp">
		<?php echo '<span style="width: ' . $char->percent_hp() . '%"></span>'; ?>
		<p><?php echo $pet->hp . ' / '. $pet->max_hp; ?></p>
	</span>
	
	<ul class="left">
		<li>Alignment <span><?php echo $char->alignment( ); ?></span></li>
		<li>Gold <span><?php echo $pet->money; ?></span></li>
	</ul>
	
	<ul class="right">
		<li>Energy <span><?php echo $pet->energy; ?></span></li>
		<li>Gold <span>2135</span></li>
	</ul>
	
	<?php echo html::anchor( 'battle', 'Attack a Monster' ); ?><br />
	<?php echo html::anchor( 'pet/heal', 'Heal' ); ?><br />
	<?php echo html::anchor( 'pet/train', 'Train' ); ?><br />
	<?php echo html::anchor( 'travel', 'Travel' ); ?><br />
	
	
</div>

<div class="right">
	<p>Welcome to the pet info, this will give you a basic overview of your pet stats.</p>
</div>
