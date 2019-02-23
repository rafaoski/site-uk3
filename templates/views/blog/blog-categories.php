<?php namespace ProcessWire;
 $categories = page()->children("limit=18");
?>

<!-- CONTENT -->
<div id='content-body' pw-append>
<div class='uk-flex uk-flex-wrap uk-padding' uk-grid>
  <?php foreach($categories as $category): ?>
  <?php editItem($category);?>
    <a class='uk-padding-small hover' href='<?=$category->url?>'>
      <div class='uk-card uk-card-default uk-card-hover uk-card-body uk-margin-small'>
            <h3><?=$category->title?>
              <span style='border-top: 3px solid black;
                    border-left: 3px solid black; border-radius: 50%; padding: 5px 15px;'
                    class='count-category'><?=count($category->references())?>
              </span>
            </h3>
      </div>
    </a>
  <?php endforeach; ?>
</div>

<?=ukPagination($categories); ?>

</div><!-- /CONTENT -->

<!-- SIDEBAR -->
<div id='sidebar' pw-prepend>
  <?php wireIncludeFile('views/parts/_blog-links.php'); ?>
</div><!-- /SIDEBAR -->
