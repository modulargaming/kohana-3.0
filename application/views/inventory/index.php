<?php
$p=0;
$page=str_replace('/','',str_replace('/index','',str_replace('/inventory','',$_SERVER['REQUEST_URI'])));
if(!$page){$page=1;}
if(count($inventory)>0){
foreach ( $inventory as $i ){
$i->item_id->load();
$amount=number_format($i->amount);
$s="";
$name = $i->item_id->name;
if($name[strlen($name)-1]!="s" && $amount!="1"){ $s="s"; }
$item[$p]="<a id='item' href='#'>".html::image( "assets/images/items/".$i->item_id->class."/".$i->item_id->image )."<br />$amount $name$s</a>";
$p++;
}
$i=$page*20-20;
while($i<=$page*20-1){
if($i<=count($inventory)-1){
echo $item[$i];
}
$i++;
}
}
else{
echo 'You have no items in your inventory.';
}
echo "<br clear='all' />$pagination";
?>