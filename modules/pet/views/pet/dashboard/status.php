<div class="stats">
	<?php if ( $pet->loaded() ): ?>

	<h2><?php echo $pet->name; ?></h2>
	<p style="margin-top: -8px;"> Level: <?php echo $pet->level; ?> <?php echo $pet->colour->name; ?> <?php echo $pet->race->name; ?></p>

	<span class="bar hp">
		<?php echo '<span style="width: ' . $pet->percent_hp() . '%"></span>'; ?>
		<p><?php echo $pet->hp . ' / '. $pet->max_hp; ?></p>
	</span>
	
	<span class="bar energy">
		<?php echo '<span style="width: ' . $pet->percent_energy() . '%"></span>'; ?>
		<p><?php echo $pet->energy . ' / '. $pet->max_energy; ?></p>
	</span>

	<span class="bar xp">
		<?php echo '<span style="width: ' . $pet->percent_xp() . '%"></span>'; ?>
		<p><?php echo $pet->xp . ' / '. $pet->max_xp; ?></p>
	</span>
	
	<ul class="right">
		<li>Strength <span><?php echo $pet->strength; ?></span></li>
		<li>Defense <span><?php echo $pet->defence; ?></span></li>
		<li>Agility <span><?php echo $pet->agility; ?></span></li>
	</ul>
	
	<h2 style="text-align: left">Actions</h2>
	
	<?php echo html::anchor( 'battle', 'Attack a Monster' ); ?><br />
	<?php echo html::anchor( 'pet/heal', 'Heal' ); ?><br />
	<?php echo html::anchor( 'pet/train', 'Train' ); ?><br />
	<?php echo html::anchor( 'travel', 'Travel' ); ?><br />
	<?php echo html::anchor( 'zone', 'Explore' ); ?><br />
	
	<?php else: ?>
	
	<p>You do not have a pet yet, <?php echo html::anchor( 'pet', 'create one?' ) ?>.</p>
	
	<?php endif ?>

</div>
