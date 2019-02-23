<?php namespace ProcessWire;
// This is the template file for main /blog/ page that lists blog post summaries.
// If there are more than 12 posts, it also paginates them.
$posts = page()->children('limit=12');
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
