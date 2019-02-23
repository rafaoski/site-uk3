<?php namespace ProcessWire;
// Get User Name
$user = pages()->findOne("template=blog-author, get_user.id=$page->createdUser");
?>
<!-- CUSTOM SCRIPTS / STYLES -->
<head id='html-head' pw-append>
	<script src='<?=urls('jquery');?>' defer></script>
	<script src='<?=urls()->FieldtypeComments?>comments.min.js' defer></script>
	<link rel="stylesheet" href="<?=urls()->FieldtypeComments?>comments.css">
</head><!-- /CUSTOM SCRIPTS / STYLES -->

<!-- BLOG INFO -->
<div id="breadcrumb" pw-before>
	<div id="blog-info">
		<p class='blog-info' style='color: aliceblue; margin-bottom: 10px; font-size: 1.7rem; text-align: left;'>
			<?=blogInfo(page(), $user);?>
		</p>
	</div>
</div><!-- /BLOG INFO -->

<!-- CONTENT -->
<div id='content-body'>
<?php
// Social Share Buttons
if (setting('enable-share-buttons')) {
// https://github.com/somatonic/MarkupSocialShareButtons
$share_btn = modules()->MarkupSocialShareButtons->render();
echo str_replace("MarkupSocialShareButtons cf", "m-social-post uk-iconnav uk-flex uk-flex-center", $share_btn);
}
wireIncludeFile('views/parts/_blog-post.php', ['post' => page()]); ?><!-- /BLOG POST -->

<!-- PREVIOUS NEXT BLOG POST -->
<div class="nav-page uk-flex uk-flex-around uk-margin-small">
	<?=prNx(page());?>
</div><!-- /PREVIOUS NEXT BLOG POST -->

<?php
// https://processwire.com/blog/posts/processwire-3.0.107-core-updates/
$links = page()->links();
// If another page has links to this page
if ($links->count()): ?>
<h3><?=setting('also-like');?></h3>
<ul>
 <?=$links->each("<li><a href={url}>{title}</a></li>");?>
</ul>
<?php endif;
// IF Enable Comments
if(setting('enable-comments')) {
// comments
$comments = page()->comments;

// comment list
if(count($comments)) {
	echo ukHeading3("Comments", "icon=comments");
	echo Comments($comments);
}

// comment form
echo ukHeading3(setting('post-comment'), "icon=comment");
echo CommentForm($comments);
}
?>
</div><!-- /CONTENT -->

<!-- SIDEBAR -->
<div id='sidebar' pw-prepend>
<?php
// Post Images
$img = page()->images->first();
if($img) {
	$img = $img->width(600);
	echo "<img class='uk-visible@s' src='$img->url' alt='$img->description'>";
}
?>
  <?php wireIncludeFile('views/parts/_blog-links.php'); ?>
</div><!-- /SIDEBAR -->
