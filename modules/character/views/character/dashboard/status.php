<div class="stats">
	<?php if ( $character->loaded() ): ?>

	<h2><?php echo $character->name; ?></h2>
	<p style="margin-top: -8px;">
<?php echo $char->alignment( ); ?> 
<?php echo $character->race->name; ?> 
<?php echo $character->class->name; ?> 
<br />
	</p>
<?php
$image = 'assets/images/characters/' . $character->race->name.'/'.$character->class->name.'.png';
$image = strtolower($image);
echo html::image($image);
?>	


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


                <li>Level: <span><?php echo $character->level; ?></span></li>
                <li>Strength: <span><?php echo $character->strength; ?></span></li>
                <li>Defense: <span><?php echo $character->defence; ?></span></li>
                <li>Agility: <span><?php echo $character->agility; ?></span></li>
                <li>Money: <span><?php echo $character->money; ?></span></li>


	
	</ul>

	<?php else: ?>
	
	<p>You do not have a character yet, <?php echo html::anchor( 'character', 'create one?' ) ?>.</p>
	
	<?php endif ?>

</div>
