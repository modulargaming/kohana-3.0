<?php if ( $user_pet->loaded() ): ?>

	<h2><?php echo $user_pet->name; ?></h2>
<div>
<?php echo $user_pet->colour->name; ?>&nbsp;
<?php echo $user_pet->race->name; ?>  <br />
<div class="red">Health: <?php  echo $user_pet->hp.'/'.$user_pet->max_hp ?></div>
<div class="green">Energy: <?php  echo $user_pet->energy.'/'.$user_pet->max_energy ?></div>
<div class="blue">Experience: <?php  echo $user_pet->xp.'/'.$user_pet->max_xp ?></div>
</div>
	
<?php else: ?>
<p>No Pets</p>
<?php endif; ?>
