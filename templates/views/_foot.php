<?php namespace ProcessWire;?>
<!-- FOOTER -->
<footer id='footer' class="footer uk-card uk-card-body uk-card-large" style='background: #252525'>

<div class="uk-flex uk-flex-wrap uk-flex-around uk-flex-middle">
<!-- SEARCH FORM -->
  <div class='search-form uk-margin-small'>
    <form class='uk-search uk-search-default' action='<?=pages()->get('template=basic-search')->url?>' method='get'>
    <span class="uk-search-icon-flip" data-uk-search-icon></span>
    <input id='search' type='text' name='q' class='uk-search-input'
           placeholder='<?=setting('search-placeholder')?>&hellip;' required>
    </form>       
  </div><!-- /SEARCH FORM -->
<!-- COPYRIGHT TEXT -->
  <div class='copyright'>
    <p class='uk-text-large uk-text-center'>
      <?=editItem(pages()->get('/options/'), 'font-weight: bold;');?>
      <small class='small uk-light'>&copy; <?=date('Y')?> &bull;</small>
      <a href='<?=setting('options')->url_1 ? setting('options')->url_1 : pages('/')->url;?>'>
        <?=setting('options')->text_1;?>
      </a>
    </p>
  </div><!-- /COPYRIGHT TEXT -->
</div>

</footer><!-- /FOOTER -->
<?php
// Display region debugging info
echo debugRegions();
// Google Fonts https://fonts.google.com/
echo googleFonts(['Jura&amp;subset=latin-ext']);
// Google Analytics Tracking Code ( /options/advanced-options/ga-code/ )
gaCode(setting('ga-code'));
?>
<pw-region id="bottom-region"></pw-region>
</body>
</html>
