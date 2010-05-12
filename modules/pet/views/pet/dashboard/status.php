<div class="stats">
	<?php if ( $user_pet->loaded() ): ?>

	<h2><?php echo $user_pet->name; ?></h2>
	<p style="margin-top: -8px;"> Level: <?php echo $user_pet->level; ?> <?php echo $user_pet->race->name; ?> <?php echo $user_pet->colour->name; ?></p>

	<span class="bar hp">
		<?php echo '<span style="width: ' . $pet->percent_hp() . '%"></span>'; ?>
		<p><?php echo $user_pet->hp . ' / '. $user_pet->max_hp; ?></p>
	</span>
	
	<span class="bar energy">
		<?php echo '<span style="width: ' . $pet->percent_energy() . '%"></span>'; ?>
		<p><?php echo $user_pet->energy . ' / '. $user_pet->max_energy; ?></p>
	</span>

	<span class="bar xp">
		<?php echo '<span style="width: ' . $pet->percent_xp() . '%"></span>'; ?>
		<p><?php echo $user_pet->xp . ' / '. $user_pet->max_xp; ?></p>
	</span>
	
	<ul class="left">
		<li>Alignment <span><?php echo $pet->alignment( ); ?></span></li>
		<li>Money <span><?php echo $user_pet->money; ?></span></li>

	</ul>
	
	<ul class="right">
		<li>Strength <span><?php echo $user_pet->strength; ?></span></li>
		<li>Defense <span><?php echo $user_pet->defence; ?></span></li>
		<li>Agility <span><?php echo $user_pet->agility; ?></span></li>
	</ul>
	
	<?php else: ?>
	
	<p>You do not have a pet yet, <?php echo html::anchor( 'pet', 'create one?' ) ?>.</p>
	
	<?php endif ?>

</div>
