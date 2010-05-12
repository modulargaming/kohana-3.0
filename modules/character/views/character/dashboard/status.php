<div class="stats">
	<?php if ( $character->loaded() ): ?>

	<h2><?php echo $character->name; ?></h2>
	<p style="margin-top: -8px;">
 Level: <?php echo $character->level; ?> 
<?php echo $char->alignment( ); ?> 
<?php echo $character->race->name; ?> 
<?php echo $character->class->name; ?> 
	(&pound;<?php echo $character->money; ?>)

	</p>
	


	<ul class="left">
		<div class="red">
		<li>
		<?php echo 'Health: '.$character->hp . ' / '. $character->max_hp; ?>
		<?php echo '('.$char->percent_hp() . '%)'; ?>
		</li>
		</div>

		<div class="green">
		<li>
		<?php echo 'Energy: '.$character->energy . ' / '. $character->max_energy; ?>
		<?php echo '('.$char->percent_energy() . '%)'; ?>
		</li>
		</div>

		<div class="blue">
		<li>
		<?php echo 'Experience: '.$character->xp . ' / '. $character->max_xp; ?>
		<?php echo '('.$char->percent_xp() . '%)'; ?>
		</li>
		</div>

                <li>Strength <span><?php echo $character->strength; ?></span></li>
                <li>Defense <span><?php echo $character->defence; ?></span></li>
                <li>Agility <span><?php echo $character->agility; ?></span></li>


	
	</ul>
	
	<?php else: ?>
	
	<p>You do not have a character yet, <?php echo html::anchor( 'character', 'create one?' ) ?>.</p>
	
	<?php endif ?>

</div>
