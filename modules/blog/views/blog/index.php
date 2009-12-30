<h2>Blog</h2>

<div class="blog">
	
	<?php foreach ( $post as $v ): ?>
	
		<div class="post">
			<h3><?php echo $v->title; ?></h3>
			
			<?php echo $v->content; ?>
		</div>
		<?php echo $v->verbose('created_on'); ?>
		
	<?php endforeach; ?>
	
</div>