<?php foreach ( $categories as $c ): ?>

<p>
<?php echo html::anchor( 'forum/category/'.$c->id, $c->title ); ?>
<br />
<?php echo $c->description ?>

</p>

<?php endforeach;?>

