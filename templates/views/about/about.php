<?php namespace ProcessWire;
$about_items = page()->children("limit=12");
?>

<div pw-append='content-body'>
<?php foreach ($about_items as $about_item):
      $image = $about_item->images->first;
?>
<div class='uk-margin-medium-bottom'>

<div class='uk-flex uk-flex-center uk-flex-middle' data-uk-grid>

<?php if ($image): ?>
  <div class='uk-width-2-3@m'>
    <div class="uk-height-medium uk-cover-container">
      <img src="<?=$image->url;?>" alt="<?=$image->description;?>" data-uk-cover>
        <div class="uk-overlay uk-overlay-primary uk-position-cover uk-flex uk-flex-column uk-flex-center uk-flex-middle uk-light">
          <h3>
            <?=$about_item->meta_title;?>
          </h3>
          <p class='uk-margin-remove'><?=$about_item->meta_description;?></p>
        </div>
    </div>
  </div>
<?php endif; ?>

  <div class='uk-width-expand'>
      <p><?php // /templates/fields/text-medium.php
          echo $about_item->render('body', 'text-medium');
      ?>
      <?php editItem($about_item, 'font-weight: bold');?></p>
  </div>

</div>

<a href="<?=$about_item->url;?>">
  <?=setting('read-more');?> &raquo;
</a>

</div>
<?php endforeach; ?>
    <?=ukPagination($about_items);?>
</div><!-- #/content-body-->
