<?php namespace ProcessWire;
// Get All Posts
$posts =  pages()->get("template=blog-posts");
?>
<!-- CONTENT -->
<div id='content-body'>
<!-- ALL POSTS -->
<div class='all-posts'>
  <?php editItem($posts, 'margin-top: 10px;');?>
  <a class='uk-button uk-button-text uk-text-left' href='<?=$posts->url?>'>
      <h3 class='uk-heading-hero' style='margin-bottom: 0'>
        <?=setting('all-posts');?>
      </h3>
  </a>
  <p style='margin-bottom: 0; color: black;'>
    <?=$posts->meta_description?></p>
</div><!-- /ALL POSTS -->

<!-- MORE BLOG PAGES -->
<div class='more-blog-pages'>
<?php
// Get Some Blog Pages
$blog_pages = [
  'categories' => pages()->get("template=blog-categories"),
  'tags' => pages()->get("template=blog-tags"),
  'authors' => pages()->get("template=blog-authors"),
  'archives' => pages()->get("template=blog-archives"),
];
foreach ($blog_pages as $item): ?>
<!--  BLOG PAGE -->
<div class='item-more-blog'>
  <?php editItem($item, 'margin-top: 10px;');?>
  <a class='uk-button uk-button-text uk-text-left' href='<?=$item->url?>'>
    <h3 style='font-size: 2.5rem; margin-bottom: 0; margin-top: 15px;'>
      / <?=$item->title?>
       <small style='font-size: 1.2rem'><?=$item->meta_title?></small class='uk-text-small'>
    </h3>
  </a>
</div><!--  /BLOG PAGE -->
<?php endforeach; ?>

</div><!-- /MORE BLOG PAGES -->

</div><!-- /CONTENT -->

<!-- SIDEBAR -->
<div id='sidebar' pw-prepend>
  <?php wireIncludeFile('views/parts/_blog-links.php'); ?>
</div><!-- /SIDEBAR -->
