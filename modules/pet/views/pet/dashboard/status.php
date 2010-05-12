<div class="stats">
	<?php if ( $user_pet->loaded() ): ?>

	<h2><?php echo $user_pet->name; ?></h2>
	<p style="margin-top: -8px;">
 Level: <?php echo $user_pet->level; ?> 
<?php echo $pet->alignment( ); ?> 
<?php echo $user_pet->colour->name; ?> 
<?php echo $user_pet->race->name; ?> 
	(&pound;<?php echo $user_pet->money; ?>)

	</p>
	


	<ul class="left">
		<div class="red">
		<li>
		<?php echo 'Health: '.$user_pet->hp . ' / '. $user_pet->max_hp; ?>
		<?php echo '('.$pet->percent_hp() . '%)'; ?>
		</li>
		</div>

		<div class="green">
		<li>
		<?php echo 'Energy: '.$user_pet->energy . ' / '. $user_pet->max_energy; ?>
		<?php echo '('.$pet->percent_energy() . '%)'; ?>
		</li>
		</div>

		<div class="blue">
		<li>
		<?php echo 'Experience: '.$user_pet->xp . ' / '. $user_pet->max_xp; ?>
		<?php echo '('.$pet->percent_xp() . '%)'; ?>
		</li>
		</div>
	
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
