<?php namespace ProcessWire;
$home = setting('home');
$logo_margin = '';
?>
<!-- NAVBAR LEFT -->
<div class="uk-navbar-left uk-text-center">
    <?php editItem(pages()->get('/options/'));?>
    <a class='uk-button uk-button-text' style='padding-bottom: 5px;' href="<?=pages('/')->url;?>">
        <span class='site-name uk-text-large'><?=setting('site-name')?></span>
        <?php if(setting('logo')) :?>
        <img src="<?=setting('logo');?>" class='site-logo <?=setting('logo-class');?> uk-margin-small-bottom'
        alt="<?=setting('site-name')?>" width="60">
        <?php endif;?><br>
        <span class='site-description uk-text-muted'><?=setting('site-description')?></span>
    </a>
</div><!-- /NAVBAR LEFT -->

<!-- NAVBAR CENTER -->
<div class="uk-navbar-center uk-visible@l">
  <div class="uk-navbar-item">
    <?=ukNavbarNav($home->and($home->children), [
      'dropdown' => [ 'blog', 'about' ]
    ])?>
  </div>
</div><!-- /NAVBAR CENTER -->

<!-- OFFCANVAS NAV TOGGLE -->
<div class="offcanvas-nav uk-navbar-right uk-hidden@l">
    <a href="#offcanvas-nav" aria-label="<?=__('mobile-nav');?>" data-uk-toggle>
      <?=ukIcon('menu', 1.3)?>
    </a>
</div><!-- /OFFCANVAS NAV TOGGLE -->
