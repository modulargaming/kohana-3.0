<?php if ( $character->loaded() ): ?>

	<h2><?php echo $character->name; ?></h2>
<div>
<?php echo $character->race->name; ?> 
<?php echo $character->class->name; ?> <br />
<font color=red><?php  echo $character->hp.'/'.$character->max_hp ?></font>
<font color=green><?php  echo $character->energy.'/'.$character->max_energy ?></font>
</div>
	
	
<?php else: ?>
<p>No Characters</p>
<?php endif; ?>
