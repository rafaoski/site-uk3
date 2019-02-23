<?php namespace ProcessWire;
 $tags = page()->children("limit=40");
?>

<!-- CONTENT -->
<div id='content-body' pw-append>
<div class='uk-flex uk-flex-wrap uk-padding' uk-grid>
  <?php foreach($tags as $tag): ?>
    <a href='<?=$tag->url?>' class='hover'>
      <div class='uk-margin-small'>
          <?php editItem($tag);?>
          <h3><?=$tag->title?>
            <span style='border-top: 3px solid black;
                  border-left: 3px solid black; border-radius: 50%; padding: 5px 15px;'
                  class='count-category'><?=count($tag->references())?>
            </span>
          </h3>
      </div>
    </a>
  <?php endforeach; ?>
</div>

<?=ukPagination($tags); ?>

</div><!-- /CONTENT -->

<!-- SIDEBAR -->
<div id='sidebar' pw-prepend>
  <?php wireIncludeFile('views/parts/_blog-links.php'); ?>
</div><!-- /SIDEBAR -->
