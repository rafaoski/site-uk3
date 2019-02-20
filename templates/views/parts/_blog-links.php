<?php namespace ProcessWire;
// GET PAGES
$posts = pages()->get("template=blog-posts");
$categories = pages()->get("template=blog-categories");
$archives = pages()->get("template=blog-archives");
?>

<!-- RECENT POSTS -->
<?=ukHeading3(setting('recent-posts'), ['line' => 'left']);?>
<ul>
<?php
foreach ($posts->children('limit=3') as $item ) {
  $edit = editItem($item);
  echo "<li><a href='{$item->url}'>{$item->title}</a> $edit</li>";
}
?>
</ul>
<p><a href='<?=$posts->url?>'>
  <?=setting('more-posts') . ' ' . ukIcon('arrow-right');?></a>
</p><!-- RECENT POSTS -->

<!-- CATEGORIES -->
<?=ukHeading3($categories->title, ['line' => 'left']);?>
<ul>
<?php
foreach ($categories->children('limit=12') as $item ) {
  $edit = editItem($item);
  echo "<li><a href='{$item->url}'>{$item->title}</a> $edit</li>";
}
?>
</ul>
<!-- /CATEGORIES -->

<!-- ARCHIVES -->
<?=ukHeading3($archives->title,['line' => 'left']);?>
<ul class="uk-list">
  <?=blogArchive(2017);?>
</ul><!-- /ARCHIVES -->