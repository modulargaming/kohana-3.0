<div class="stats">
	<?php if ( $tep->loaded() ): ?>

	<h2><?php echo $tep->name; ?></h2>
	<p style="margin-top: -8px;"> Level: <?php echo $tep->level; ?> <?php echo $tep->colour->name; ?> <?php echo $tep->race->name; ?></p>

	<span class="bar hp">
		<?php echo '<span style="width: ' . $pet->percent_hp() . '%"></span>'; ?>
		<p><?php echo $tep->hp . ' / '. $tep->max_hp; ?></p>
	</span>
	
	<span class="bar energy">
		<?php echo '<span style="width: ' . $pet->percent_energy() . '%"></span>'; ?>
		<p><?php echo $tep->energy . ' / '. $tep->max_energy; ?></p>
	</span>

	<span class="bar xp">
		<?php echo '<span style="width: ' . $pet->percent_xp() . '%"></span>'; ?>
		<p><?php echo $tep->xp . ' / '. $tep->max_xp; ?></p>
	</span>
	
	<ul class="right">
		<li>Strength <span><?php echo $tep->strength; ?></span></li>
		<li>Defense <span><?php echo $tep->defence; ?></span></li>
		<li>Agility <span><?php echo $tep->agility; ?></span></li>
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
