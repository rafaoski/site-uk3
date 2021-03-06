<?php namespace ProcessWire;
// Get User Name
$user = pages()->findOne("template=blog-author, get_user.id=$post->createdUser");
// Get Comments
$count_comments = countComments($post, setting('enable-comments'));
// Get Post Image
$image = $post->images ? $post->images->first() : '';
// Img Size
$size = $post->checkbox ? 'contain' : 'cover';
?>
<!-- ARTICLE -->
<article class="uk-article article-<?=$post->name;?> uk-margin-medium-top">

<?php
  // If Not Single Post
  if (page()->template != 'blog-post'): ?>

<!-- ARTICLE TITLE -->
    <h3 class="uk-article-title">
      <a class="uk-link-reset" href="<?=$post->url?>" style='font-size: 2.5rem;'>
        <?=$post->title;?>
      </a>
      <?=countComments($post, setting('enable-comments'));?>
    </h3><!-- /ARTICLE TITLE -->

<!-- ARTICLE META -->
    <p class="uk-article-meta"><?=setting('written-by');?>
      <a href="<?=$user->url;?>"><?=$user->title;?></a>
    <?php
     // Posted On
        echo sprintf( setting('on'),$post->date) . '.';
    // Posted in Categories
        echo setting('posted-in') . ' ';
            if (count($post->categories)) {
              $post->categories->implode(" <small>|</small> ", function($cat) {
                echo "<a href='{$cat->url}'>{$cat->title}</a> ";
              });
            }
?>  </p><!-- /ARTICLE META -->

<!-- ARTICLE IMAGE -->
    <div class="uk-background-<?=$size?> uk-flex uk-flex-center uk-flex-middle uk-flex-column uk-inline"
         style="background-image: url(<?=$image->url;?>);" data-uk-img>
         <div class="uk-overlay-primary uk-position-cover"></div>
         <?php
         if (setting('enable-share-buttons')) {
           $share_btn = modules()->MarkupSocialShareButtons->render();
           echo str_replace("MarkupSocialShareButtons cf",
           "m-social-posts uk-iconnav uk-flex uk-flex-center uk-margin-medium-top svg-lighten", $share_btn);
         }
         ?>
        <p class='uk-card uk-light uk-text-lead uk-margin-medium-bottom uk-padding-small'>
          <?=$post->render('body', 'text-medium');?>...</p>
    </div><!-- /ARTICLE IMAGE -->

<!-- READ MORE LINK  -->
    <a href="<?=$post->url?>">
          <?=setting('read-more');?>
          <?=ukIcon('arrow-right');?>
    </a>

<?php // Else Only Body
  else:
      echo page()->body;
    endif; ?>
</article><!-- /ARTICLE -->
