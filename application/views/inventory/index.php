<?php
for($i=1; $i<=count($inventory); $i++){
	$amount=number_format($inventory[$i]['amount']);
	$s="";
	$name=$items[$inventory[$i]['item_id']]['name'];
	if($name[strlen($name)-1]!="s" && $amount!="1"){ $s="s"; }
	echo "<a id='item' href='#'>".html::image( "assets/images/items/".$items[$inventory[$i]['item_id']]['class']."/".$items[$inventory[$i]['item_id']]['image'] )."<br />$amount $name$s</a>";
}
if(count($inventory)==0){
	echo 'You have no items in your inventory.';
}
?>