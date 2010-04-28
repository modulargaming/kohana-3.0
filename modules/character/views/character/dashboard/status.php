<div class="stats">
	<?php if ( $character->loaded() ): ?>

	<h2><?php echo $character->name; ?></h2>
	<p style="margin-top: -8px;"> Level: <?php echo $character->level; ?> <?php echo $character->race->name; ?> <?php echo $character->class->name; ?></p>

	<span class="bar hp">
		<?php echo '<span style="width: ' . $char->percent_hp() . '%"></span>'; ?>
		<p><?php echo $character->hp . ' / '. $character->max_hp; ?></p>
	</span>
	
	<span class="bar energy">
		<?php echo '<span style="width: ' . $char->percent_energy() . '%"></span>'; ?>
		<p><?php echo $character->energy . ' / '. $character->max_energy; ?></p>
	</span>

	<span class="bar xp">
		<?php echo '<span style="width: ' . $char->percent_xp() . '%"></span>'; ?>
		<p><?php echo $character->xp . ' / '. $character->max_xp; ?></p>
	</span>
	
	<ul class="left">
		<li>Alignment <span><?php echo $char->alignment( ); ?></span></li>
		<li>Money <span><?php echo $character->money; ?></span></li>

	</ul>
	
	<ul class="right">
		<li>Strength <span><?php echo $character->strength; ?></span></li>
		<li>Defense <span><?php echo $character->defence; ?></span></li>
		<li>Agility <span><?php echo $character->agility; ?></span></li>
	</ul>
	
	<h2 style="text-align: left">Actions</h2>
	
	<?php echo html::anchor( 'battle', 'Attack a Monster' ); ?><br />
	<?php echo html::anchor( 'character/heal', 'Heal' ); ?><br />
	<?php echo html::anchor( 'character/train', 'Train' ); ?><br />
	<?php echo html::anchor( 'travel', 'Travel' ); ?><br />
	<?php echo html::anchor( 'zone', 'Explore' ); ?><br />
	
	<?php else: ?>
	
	<p>You do not have a character yet, <?php echo html::anchor( 'character', 'create one?' ) ?>.</p>
	
	<?php endif ?>

</div>
