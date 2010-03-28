<h2>PM - Read message</h2>

<div class="left w150"><?php echo $sidebar ?></div>

<div class="right w500">

	<?php echo Message::render() ?>
	
	<h3><?php echo $message->title ?></h3>
	<p>From: <?php echo $message->from->username ?></p>
	
	<p><?php echo $message->message ?></p>
	
	
</div>