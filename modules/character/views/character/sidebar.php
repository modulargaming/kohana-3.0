<?php if ( $character->loaded() ): ?>

	<h2><?php echo $character->name; ?></h2>
	<p style="margin-top: -8px;"> Level: <?php echo $character->level; ?> <?php echo $character->race->name; ?> <?php  echo $character->class->name; ?></p>
	
	<span class="bar hp">
		<?php echo '<span style="width: ' . $char->percent_hp() . '%"></span>'; ?>
		<p><?php echo $character->hp . ' / '. $character->max_hp; ?></p>
	</span>
	
<?php else: ?>
<p>No Characters</p>
<?php endif; ?>
