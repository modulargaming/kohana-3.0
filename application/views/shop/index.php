<h2><?php echo $shop->name ?></h2>

<div class="items">
<?php foreach ( $items as $i ): ?>
	<div class="item">
		<?php
		echo html::anchor(
			'shop/' . $shop->id . '/view/' . $i->id,
			html::image( 'assets/images/items/' . $i->image )
		)
		?>
		
		<div class="hidden">
			<h3><?php echo $i->name?></h3>
			<ul>
				<li>Class: <?php echo $i->class ?></li>
				<li>Amount: <?php echo $i->amount ?></li>
			</ul>
		</div>
		
		
	</div>
	
	<!--<?php echo $i->amount; ?>-->
	<!--<?php echo html::anchor( 'shop/' . $shop->id . '/view/' . $i->id, $i->name ) ?>-->

<?php endforeach ?>
</div>