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

<!-- CUSTOM STYLES -->
<head id='html-head' pw-append>
	<style media="screen">
    .ext-blog-author {
    	margin: 0 5px;
    }
		.ext-blog-author svg {
			width: 35px;
		}
	</style>
</head><!-- /CUSTOM STYLES -->

<!-- CONTENT -->
<div id='content-body'>
<?=$empty_author;?>
<?php
	// Blog Posts
	foreach ($posts as $post) {
	  wireIncludeFile('views/parts/_blog-post.php', ['post' => $post]);
	}
?>
<?=ukPagination($posts); ?>
</div><!-- /CONTENT -->

<!-- SIDEBAR -->
<div id='sidebar' pw-prepend>

<?=ukHeading3(setting('more-about') . " <span class='uk-text-bold'>" . page()->title . '</span>'); ?>

<?php
	$img = page()->images->first();
	if($img) {
		$img = $img->width(600);
		echo "<img src='$img->url' alt='$img->description'>";
	}
?>

	<ul class="uk-iconnav uk-flex uk-flex-center">
		<?=externalLink(page()->external_link,
			[
				'class' => 'author-link'
			]);
		?>
	</ul>

	<div class='uk-width-expand'>
		<?=page()->body;?>
	</div>

<?php
// Blog Links
wireIncludeFile('views/parts/_blog-links.php'); ?>
</div><!-- /SIDEBAR -->
