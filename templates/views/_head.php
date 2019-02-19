<?php namespace ProcessWire;
$home = setting('home');
$lang_enable = page()->getLanguages() && $modules->isInstalled("LanguageSupportPageNames");
// Get First Image ( https://processwire.com/docs/fields/images/ )
$image = page()->images ? page()->images->first() : '';
$size = page()->checkbox ? 'contain' : 'cover';
$turbolinks = '';
if (!$user->isLoggedin() && setting('enable-turbolinks')) {
$turbolinks = "\n<script src='" . setting('turbolinks') . "' defer></script>";
}
?>
<!doctype html>
<html lang="<?=setting('lang');?>" prefix="og: http://ogp.me/ns#">
<head id='html-head'>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php if (setting('favicon')): ?>
<link rel="icon" href="<?=setting('favicon');?>"/>
<?php endif;
// SeoMaestro https://processwire.com/talk/topic/20817-seomaestro/
echo page()->seo()->render();
// Pagination
echo seoPagination(page());
// JS files
echo setting('js-files')->each("\n<script src='{value}' defer></script>");
echo $turbolinks;
// CSS Files
// echo cssAsync([urls('templates') . "assets/css/app.css"]);
echo setting('css-files')->each("\n<link rel='stylesheet' href='{value}'>");
// Optional Style
echo "\n<style id='head-style' pw-optional></style>";
// Google Webmaster Tools Werification Code ( /options/advanced-options/gw-code/ )
gwCode(setting('gw-code'));
?>
</head>
<body class='<?=setting('body-classes')->implode(' ')?>'>

<!-- HEADER -->
<header id="header" class='uk-navbar-transparent uk-position-top uk-margin-small-top' style='z-index: 1;'>
  <div class="uk-container uk-container-large uk-light">
    <nav id="masthead-navbar" data-uk-navbar>
        <?php wireIncludeFile('views/parts/_basic-nav.php'); ?>
    </nav>
  </div>
</header><!-- /HEADER -->

<!-- INTRO -->
<div id='intro' class="uk-padding-small uk-background-<?=$size?> uk-overflow-hidden uk-light uk-width-1-1 uk-inline"
                      data-uk-parallax="bgy: -200;" style="background-image: url('<?=$image ? $image->url : ''?>');" data-uk-img>
<div class="uk-overlay-primary uk-position-cover"></div>
<!-- HEADER SEO -->
  <div id='header-seo' class='uk-position-relative header-seo'>
    <h1 id='meta-title' class='meta-title uk-heading-hero uk-text-center uk-margin-large-top'>
      <?=page() == pages('/') ? page('meta_title') : page('title');?>
    </h1>
    <h2 id='meta-description' class='meta-description uk-text-muted'>
      <?=page('meta_description');?>
    </h2>
  <?php if (page() != pages('/')):?>
    <div id="breadcrumb" class='uk-flex uk-flex-right uk-width-1-1'>
      <?=ukBreadcrumb(page(), ['class' => 'uk-card']);?>
    </div>
  <?php endif;?>
  </div><!-- /HEADER SEO -->

<!-- EXTERNAL LINKS -->
  <div id='external-links' class='uk-position-relative uk-margin-medium-top uk-margin-small-bottom'>
    <ul class="uk-iconnav uk-flex uk-flex-center">
       <?=externalLink(setting('options')->external_link,
          [
            'class' => 'external-link'
        ]);
       ?>
    </ul>
  </div><!-- /EXTERNAL LINKS -->

  <?php if($lang_enable == true):?>
  <!-- LANG MENU -->
  <div id='lang-menu' class='uk-card uk-flex uk-flex-right'>
      <ul class='uk-navbar-nav'>
        <?=langMenu(page(),setting('home'));?>
      </ul>
  </div><!-- /LANG MENU -->
  <?php endif; ?>

  <!-- PRIVACY POLICY -->
  <div id='privacy' class='privacy-panel uk-card'>
    <?=privacyPanel(setting('privacy-page'));?>
  </div><!-- /PRIVACY POLICY -->

</div><!-- /INTRO -->

<!-- OFFCANVAS NAVIGATION -->
<div id="offcanvas-nav" data-uk-offcanvas>
  <div class="uk-offcanvas-bar">
    <h3><a href='<?=urls()->root?>'><?=setting('site-name')?></a></h3>
    <?php
    // offcanvas navigation
    // example of caching generated markup (for 600 seconds/10 minutes)
    echo cache()->get('offcanvas-nav', 10, function() {
      return ukNav(pages()->get('/')->children(), [
        'depth' => 1,
        'accordion' => true,
        'blockParents' => [ 'posts' ],
        'repeatParent' => true,
        'noNavQty' => 20
      ]);
    });
    ?>
  </div>
</div><!-- /OFFCANVAS NAVIGATION -->

<?php
// Social Share Buttons ( https://www.addtoany.com/ )
if (setting('enable-share-buttons')) {
echo toAny(['f','t','e']);
}
// Edit Button
echo editBtn(page());
