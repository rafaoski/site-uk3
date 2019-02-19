<?php namespace ProcessWire;?>

<div class='uk-flex uk-flex-center uk-flex-middle' data-uk-grid>

  <div class='uk-width-expand'>
      <p><?php // /templates/fields/text-medium.php
          echo $section->render('body', 'text-medium');
      ?>
      <?php editItem($section, 'font-weight: bold');?></p>
  </div>
</div>
