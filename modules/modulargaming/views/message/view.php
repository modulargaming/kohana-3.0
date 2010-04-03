<h2>Messages - Read message</h2>

<div class="left w150"><?php echo $sidebar ?></div>

<div class="right w500">

	<?php echo Message::render() ?>
	
	<h3>Title: <?php echo $message->title ?></h3>
	<p>From: <?php echo $message->from->username ?></p>
	
	<p>Content: <?php echo $message->message ?></p>

	<p>Date: <?php if (isset ($post->created)) echo MG::Ago($message->created) ?></p>
	
	
</div>
