<?php if ( $character->loaded() ): ?>

	<h2><?php echo $character->name; ?></h2>
<div>
<?php echo $character->race->name; ?>&nbsp;
<?php echo $character->class->name; ?><br />
<div class="red">Health: <?php  echo $character->hp.'/'.$character->max_hp ?></div>
<div class="green">Energy: <?php  echo $character->energy.'/'.$character->max_energy ?></div>
<div class="blue">Experience: <?php  echo $character->xp.'/'.$character->max_xp ?></div>
</div>
	
	
<?php else: ?>
<p>No Characters</p>
<?php endif; ?>
