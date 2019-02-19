<?php namespace ProcessWire;
$empty_author = '';
// http://cheatsheet.processwire.com/users/users-methods/users-get-name-id-selector/
$user_id = page()->get_user;
// Get All Posts
$posts = pages()->get("template=blog-posts")->children("created_users_id=$user_id, limit=12");
// No Posts Found
if( !count($posts) ) {
	$empty_author = "<h1>" . setting('author-not-add') . "</h1>";
}
?>
<div id='content-body'>
	<?=$empty_author;?>
<div data-uk-grid>
	<div class='uk-width-1-3@s'>
		<?php
				$img = page()->images->first();
				if($img) {
				$img = $img->width(600);
				echo "<img src='$img->url' alt='$img->description'>";
				}
		?>
	</div>
	<div class='uk-width-expand'>
   <?=page()->body;?>
	</div>
</div>

	<?php
	// Blog Posts
	foreach ($posts as $post) {
	  wireIncludeFile('views/parts/_blog-posts.php', ['post' => $post]);
	}
	?>
	<?=ukPagination($posts); ?>
</div>

<div id='sidebar' pw-prepend>
<?php
// Blog Links
wireIncludeFile('views/parts/_blog-links.php'); ?>
</div>
