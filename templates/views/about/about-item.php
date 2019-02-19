<?php namespace ProcessWire;?>

<div id='content-body' pw-append>

<h3><?=sprintf('More Pages <strong>%1s</strong>', page()->rootParent->title);?></h3>

<ul><?php
  foreach (page()->rootParent->children as $item ) {
    if($item->name != page()->name) {
      echo "<li><a href='$item->url'>$item->title</a></li>";
    }
  }
?></ul>
</div>
