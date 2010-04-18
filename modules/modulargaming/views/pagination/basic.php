<p class="pagination">
	
	<!--
	<?php if ($first_page !== FALSE): ?>
		<a href="<?php echo $page->url($first_page) ?>"><?php echo __('First') ?></a>
	<?php else: ?>
		<span><?php echo __('First') ?></span>
	<?php endif ?>
	-->

	<?php if ($previous_page !== FALSE): ?>
		<a href="<?php echo $page->url($previous_page) ?>"><?php echo __('Previous') ?></a>
	<?php else: ?>
		<span><?php echo __('Previous') ?></span>
	<?php endif ?>

	<?php for ($i = 1; $i <= $total_pages; $i++): ?>

		<?php if ($i == $current_page): ?>
			<strong><?php echo $i ?></strong>
		<?php else: ?>
			<a href="<?php echo $page->url($i) ?>"><?php echo $i ?></a>
		<?php endif ?>

	<?php endfor ?>

	<?php if ($next_page !== FALSE): ?>
		<a href="<?php echo $page->url($next_page) ?>"><?php echo __('Next') ?></a>
	<?php else: ?>
		<span><?php echo __('Next') ?></span>
	<?php endif ?>
	
	<!--
	<?php if ($last_page !== FALSE): ?>
		<a href="<?php echo $page->url($last_page) ?>"><?php echo __('Last') ?></a>
	<?php else: ?>
		<span><?php echo __('Last') ?></span>
	<?php endif ?>
	-->

</p>