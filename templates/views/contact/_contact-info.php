<?php namespace ProcessWire;?>

<?=ukHeading3(setting('contact-info'), ['line' => 'left', 'class' => 'uk-text-bold']);?>

<div class="uk-card uk-card-default uk-padding-small uk-margin-bottom">
  <ul class="uk-nav-default uk-nav-parent-icon" data-uk-nav>

    <?php if ($item->phone): ?>
<!-- PHONE -->
      <li>
        <span class="uk-margin-small-right uk-margin-small-bottom" data-uk-icon="icon: phone"></span>
        <?=$item->phone?>
      </li><!-- /PHONE -->
    <?php endif; ?>

    <?php if ($item->e_mail): ?>
<!-- E-MAIL -->
      <li>
          <a href="mailto:<?=$item->e_mail?>"><span class="uk-margin-small-right uk-margin-small-bottom" data-uk-icon="icon: mail"></span>
              <?=$item->e_mail?>
          </a>
      </li><!-- /E-MAIL -->
    <?php endif; ?>

    <?php if ($item->adress): ?>
<!-- ADRESS -->
      <li>
          <span class="uk-margin-small-right uk-margin-small-bottom" data-uk-icon="icon: location"></span>
          <?=$item->adress?>
      </li><!-- /ADRESS -->
    <?php endif; ?>

  </ul>
</div>
