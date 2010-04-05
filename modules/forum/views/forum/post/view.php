<?php echo Message::render() ?>

<div class=forum-title>
<?php echo html::anchor( 'forum/post/'.$post->id, $post->title ); ?>
</div>

<div class=forum-content>

<?php echo $post->content ?>
</div>

<div>
Created by: 
<?php echo $post->user->username ?> 
<?php echo MG::Ago($post->created) ?>
<?php if ($user->id == $p->user->id) 
{
echo html::anchor( 'forum/post/'.$p->id.'/delete', ' Edit ' );
echo html::anchor( 'forum/post/'.$p->id.'/delete', ' Delete ' );
}                                       
?>

</div>


