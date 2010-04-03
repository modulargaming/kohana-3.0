<?php echo Message::render() ?>

<p>
<?php echo $post->user->username ?>
<br />
<?php echo $post->content ?>
<br />
<?php if (isset $post->created) echo MG::Ago($post->created) ?>

</p>

