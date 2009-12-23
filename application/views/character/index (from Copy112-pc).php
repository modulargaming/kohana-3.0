<h2><?php echo $character->name; ?></h2>

<div class="left">
	<p style="margin-top: -8px;">Level 1 <?php echo $character->race->name; ?> Warrior</p

	<ul class="stats left">		<li></li>		<li></li>	</ul>

	Name: <?php echo $character->name; ?><br />
	Race: <?php echo $character->race->name; ?><br />
	Alignment: <?php echo $char->alignment( ); ?><br />
	Gold: <?php echo $character->money; ?><br />
	HP: <?php echo $character->hp; ?> / <?php echo $character->maxhp; ?><br />
	
	<span class="bar">
		<span class="red" style="width: <?php echo $char->percent_hp(); ?>%"><?php echo $char->percent_hp(); ?>%</span>
	</span>
	<br />
	<?php echo html::anchor( 'battle', 'Attack a Monster' ); ?><br />
	<?php echo html::anchor( 'character/heal', 'Heal' ); ?>

</div>

<div class="right">
	<p>Welcome to the character info, this will give you a basic overlook of your chracters stats.</p>
	<p>Aenean rutrum consectetur leo! Phasellus ac felis at augue vestibulum faucibus? Suspendisse accumsan, neque 
	vitae pellentesque mollis, lorem risus ornare sapien, sit amet malesuada nisi orci a nulla. Nullam eu.</p>
</div>
