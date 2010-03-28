<h2>PM - Inbox</h2>

<div class="left w150"><?php echo $sidebar ?></div>

<div class="right w500">

	<?php echo Message::render() ?>
	
	<?php foreach($messages as $m): ?>
		
		<?php echo $m->title ?>
		
	<?php endforeach ?>
	
</div>