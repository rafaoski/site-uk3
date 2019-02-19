<?php namespace ProcessWire;
$authors = page()->children("limit=18"); ?>

<div id='content-body'>

  <div class='uk-child-width-1-2@m uk-grid-match uk-margin-large-bottom' data-uk-grid>
  	<?php foreach($authors as $author):
      $user_id = $author->get_user;
      $auth_count = pages()->get("template=blog-posts")->children("created_users_id=$user_id");
      $img = $author->images->first();
    ?>

    <div class='uk-transition-toggle uk-inline-clip hover' tabindex="0">
      <?php editItem($author, 'uk-margin-small');?>
      <div class="uk-transition-slide-bottom">
          <span class='uk-width-1-1 uk-inline' style='border: 2px solid #da7d02;'></span>
      </div>
        <a href="<?=$author->url?>">
          <div class='uk-background-cover uk-card uk-card-body uk-card-small uk-height-medium uk-transition-toggle'
                style="background-image: url('<?=$img ? $img->url : ''?>');" data-uk-img>

                <div class="uk-overlay-primary uk-position-cover"></div>

                <div class="uk-overlay uk-position-center">
                    <h3 class='uk-text-warning'><?=$author->title?>
                      <span class='uk-badge'><?=count($auth_count);?></span>
                    </h3>
                </div>

                <div class="uk-transition-fade uk-position-cover uk-overlay uk-overlay-primary uk-flex uk-flex-center uk-flex-middle">
                       <div class="uk-position-center uk-overlay uk-flex uk-flex-center uk-flex-middle">
                         <p class='uk-light'><?=$author->meta_title;?></p>
                       </div>
                </div>
          </div>
        </a>
    </div>
  	<?php endforeach; ?>
  </div>

<?php // Pagination
echo ukPagination($authors); ?>
</div><!-- #content-body -->

<div id='sidebar' pw-prepend>
  <?php wireIncludeFile('views/parts/_blog-links.php'); ?>
</div>
