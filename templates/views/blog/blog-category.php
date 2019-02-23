<?php namespace ProcessWire;
// Get All Posts
$posts = pages()->get("template=blog-posts")->children("categories=$page, limit=12");
// No Posts Found
// if( !count($category) ) {
// // Add this page to the trash bin because it is not assigned to any entry
// 	$page->trash();
// // Show 404
// 	throw new Wire404Exception();
// }
?>

<!-- CONTENT -->
<div id='content-body'>
  <?php
  // Blog Posts
  foreach ($posts as $post) {
    wireIncludeFile('views/parts/_blog-post.php', ['post' => $post]);
  }
  ?>
  <?=ukPagination($posts);?>
</div><!-- /CONTENT -->

<!-- SIDEBAR -->
<div id='sidebar' pw-prepend>
  <?php wireIncludeFile('views/parts/_blog-links.php'); ?>
</div><!-- /SIDEBAR -->
