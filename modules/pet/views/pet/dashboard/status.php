<div class="stats">
	<?php if ( $user_pet->loaded() ): ?>

	<h2><?php echo $user_pet->name; ?></h2>
	<p style="margin-top: -8px;"> Level: <?php echo $user_pet->level; ?> <?php echo $user_pet->colour->name; ?> <?php echo $user_pet->race->name; ?></p>

	<span class="bar hp">
		<?php echo '<span style="width: ' . $user_pet->percent_hp() . '%"></span>'; ?>
		<p><?php echo $user_pet->hp . ' / '. $user_pet->max_hp; ?></p>
	</span>
	
	<span class="bar energy">
		<?php echo '<span style="width: ' . $user_pet->percent_energy() . '%"></span>'; ?>
		<p><?php echo $user_pet->energy . ' / '. $user_pet->max_energy; ?></p>
	</span>

	<span class="bar xp">
		<?php echo '<span style="width: ' . $user_pet->percent_xp() . '%"></span>'; ?>
		<p><?php echo $user_pet->xp . ' / '. $user_pet->max_xp; ?></p>
	</span>
	
	<ul class="right">
		<li>Strength <span><?php echo $user_pet->strength; ?></span></li>
		<li>Defense <span><?php echo $user_pet->defence; ?></span></li>
		<li>Agility <span><?php echo $user_pet->agility; ?></span></li>
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
