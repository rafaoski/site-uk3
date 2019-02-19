<?php namespace ProcessWire;?>

<div class="blog-items uk-child-width-1-2@s" data-uk-grid>
<?php foreach ($section->children("limit=2") as $item):
  // Get Post Image
  $image = $item->images ? $item->images->first() : '';
  // Img Size
  $size = $item->checkbox ? 'contain' : 'cover';
  ?>
  <div class='item-content hover'>
    <h3>
      <?=$item->title;?>
    </h3>
    <a href="<?=$item->url;?>">
      <div class="uk-background-<?=$size?> uk-inline uk-height-medium uk-flex uk-flex-center uk-flex-middle"
           style="background-image: url(<?=$image->url;?>);" data-uk-img>
           <div class="uk-overlay-primary uk-position-cover"></div>
        <p class='uk-card uk-light uk-padding-small'><?=$item->meta_title;?></p>
      </div><!-- ./item-background -->
    </a>
      <?php editItem($item, 'font-weight: bold; margin-top: 5px;');?>
  </div><!-- ./item-content -->
<?php endforeach; ?>
</div><!-- ./about-items -->
