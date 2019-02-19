<?php namespace ProcessWire;
// Get Mail
$save_message = page('save_message');
$contact_mail = page()->e_mail;
$email_subject = page()->email_subject;
$privacy_page = setting('privacy-page')->url;

// Optional
// $from_page = page()->httpUrl;

// Get Map Latitude and Longitude
// https://www.latlong.net/
// https://www.openstreetmap.org/
$latitude = page()->latitude;
$longitude = page()->longitude;
$marker_text = page()->marker_text;
?>

<!-- CONTENT BODY -->
<div id='content-body'>
<?php if (page('meta_title')): ?>
  <div class="uk-card uk-card-default uk-card-body uk-margin">
    <?=ukIcon('info', ['ratio' => 2.2, 'class' => 'uk-text-warning'])?>
    <h3 class='uk-margin-small'><?=page('meta_title');?></h3>
  </div>
<?php endif; ?>

<?php // Include contact form
wireIncludeFile("views/contact/_c-form",
    [
    'save_message' => $save_message, // true or false
    'contact_page' => page(), // Get Contact Page to save items pages('/contact/')
    'contact_item' => 'contact-item', // Template to create item ( It must have a body field )
    'mail_to' => $contact_mail ?: 'user@gmail.com', // Send To Mail
    'email_subject' => $email_subject, // Mail Subject
    'privacy_page' => $privacy_page, // Privacy Policy Page
    // 'from_page' => $from_page // Get Url Page
    ]
);?>
</div><!-- /#content-body -->

<div id="footer" pw-before>
  <div class="more__footer-info">
    <div class="uk-card uk-card-small uk-card-body uk-text-large">
      <?=page()->body;?>
    </div>
      <?php if($latitude && $longitude) :?>
        <div id='map' class='uk-margin-medium-top'></div>
      <?php endif; ?>
  </div>
</div>

<!-- SIDEBAR -->
<div id='sidebar'>
<?php
  // Get Last Image ( https://processwire.com/docs/fields/images/ )
  $image = page()->images ? page()->images->last() : '';
  wireIncludeFile('views/contact/_contact-info.php', ['item' => page()]);
?>
  <div class='uk-background-cover uk-card uk-card-body uk-card-small uk-light'
       style="background-image: url(<?=$image->url;?>);" data-uk-img>
    <div class="uk-overlay-primary uk-position-cover"></div>
    <div class='uk-card uk-light'><?=page()->sidebar;?></div>
  </div>
</div>
<!-- SIDEBAR -->

<head id='html-head' pw-append>
<?php if (!$user->isLoggedin() && setting('enable-turbolinks')) {
echo "<meta name='turbolinks-visit-control' content='reload'>\n";
}
?>
<style>
      .hide-robot {
          display: none;
      }
      #map {
          height: 380px;
          box-sizing: unset;
      }
  </style>
</head>

<?php if($latitude && $longitude) :?>
<pw-region id="bottom-region">

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.3.4/dist/leaflet.css"/>

    <script src="https://unpkg.com/leaflet@1.3.4/dist/leaflet.js"></script>

    <script>
    var map = L.map('map').setView([<?=$latitude?>, <?=$longitude?>], 13);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    <?php if($marker_text) :
    // Sanitizer Full Markdown https://processwire.com/api/ref/sanitizer/entities-markdown/g/ ?>
    L.marker([<?=$latitude?>, <?=$longitude?>]).addTo(map)
        .bindPopup("<?=$sanitizer->entitiesMarkdown($marker_text, true)?>")
        .openPopup();
    <?php endif;?>
    </script>

</pw-region>
<?php endif;
