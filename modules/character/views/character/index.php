<div class="stats">

	<h2><?php echo $character->name; ?></h2>
	<p style="margin-top: -8px;">Level 1 <?php echo $character->race->name; ?> Warrior</p>

	<span class="bar hp">
		<?php echo '<span style="width: ' . $char->percent_hp() . '%"></span>'; ?>
		<p><?php echo $character->hp . ' / '. $character->max_hp; ?></p>
	</span>
	
	<ul class="left">
		<li>Alignment <span><?php echo $char->alignment( ); ?></span></li>
		<li>Gold <span><?php echo $character->money; ?></span></li>
	</ul>
	
	<ul class="right">
		<li>Energy <span><?php echo $character->energy; ?></span></li>
		<li>Gold <span>2135</span></li>
	</ul>
	
	<?php echo html::anchor( 'battle', 'Attack a Monster' ); ?><br />
	<?php echo html::anchor( 'character/heal', 'Heal' ); ?><br />
	<?php echo html::anchor( 'travel', 'Travel' ); ?><br />
	
	
</div>

<div class="right">
	<p>Welcome to the character info, this will give you a basic overview of your character stats.</p>
</div>
