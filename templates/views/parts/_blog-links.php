<?php namespace ProcessWire;
// GET PAGES
$posts = pages()->get("template=blog-posts");
$categories = pages()->get("template=blog-categories");

// RECENT POSTS
echo "<h3>" . setting('recent-posts') . "</h3>";
echo "<ul>";
foreach ($posts->children('limit=3') as $item ) {
    $edit = editItem($item);
    echo "<li><a href='{$item->url}'>{$item->title}</a> $edit</li>";
}
echo "</ul>";

// CATEGORIES
echo "<h3>" . $categories->title . "</h3>";
echo "<ul>";
foreach ($categories->children('limit=12') as $item ) {
    $edit = editItem($item);
    echo "<li><a href='{$item->url}'>{$item->title}</a> $edit</li>";
}
echo "</ul>";

// ARCHIVES
echo "<h3>" . pages()->get("template=blog-archives")->title . "</h3>";?>
<ul class="uk-list">
  <?=blogArchive(2017);?>
</ul>
