<h2>Messages - Read message</h2>

<div class="left w150"><?php echo $sidebar ?></div>

<div class="right w500">

	<?php echo Message::render() ?>
	
	<h3>Title: <?php echo $message->title ?></h3>
	<p>From: <?php echo $message->from->username ?></p>
	
	<p>Content: <?php echo $message->message ?></p>

	<p>Date: <?php echo Time::date($m->created) ?></p>
	
	<p><?php echo html::anchor('message/delete/'.$message->id, 'Delete') ?></p>
</div>
