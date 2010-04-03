<h2><?php echo $shop->name ?></h2>
<p><?php echo $shop->description ?></p>

<div class="items">
<?php foreach ( $items as $i ): ?>
	<div class="item">
		<?php
		echo html::anchor(
			'shop/' . $shop->id . '/view/' . $i->id,
			html::image( 'assets/images/items/' . $i->image )
		)
		?>
	</div>
	
	<!--<?php echo $i->amount; ?>-->
	<!--<?php echo html::anchor( 'shop/' . $shop->id . '/view/' . $i->id, $i->name ) ?>-->

<?php endforeach ?>
</div>