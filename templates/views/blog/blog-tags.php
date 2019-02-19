<?php namespace ProcessWire;
 $tags = page()->children("limit=40");
?>

<div id='content-body' pw-append>

<div class='uk-flex uk-flex-around'>
  <?php foreach($tags as $tag): ?>
    <div>
          <?php editItem($tag);?>
          <a href='<?=$tag->url?>' class='uk-inline'>
          <h3><?=$tag->title?>
            <span style='border-top: 3px solid black;
                  border-left: 3px solid black; border-radius: 50%; padding: 5px 15px;'
                  class='count-category'><?=count($tag->references())?>
            </span>
          </h3>
        </a>
    </div>
  <?php endforeach; ?>

</div>

<?=ukPagination($tags); ?>

</div><!-- #/content -->

<div id='sidebar' pw-prepend>
  <?php wireIncludeFile('views/parts/_blog-links.php'); ?>
</div>
