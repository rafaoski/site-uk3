<?php namespace ProcessWire;
$sections = pages('/options/')->home_sections;
?>
<!-- CONTENT BODY  -->
<div id='content-body' pw-append>
  <?php
    // Home Sections
    $sections = pages('/')->home_sections;
    if ($sections):
    foreach ($sections as $section_options):
    $section= pages()->get("template=$section_options->name");?>
<!-- SECTION -->
    <section class='home-sections home-<?=$section->name?> uk-margin-large-top'>
<!-- SECTION HEADING -->
      <h3 class='section-heading uk-h1 uk-heading-bullet'>
          <?php editItem($section_options);?>
          <?=$section_options->text_1;?>
      </h3><!-- /SECTION HEADING -->
<!-- SECTION CONTENT -->
      <?php wireincludeFile("views/home-sections/section-{$section_options->name}",
      ['section' => $section, 'section_options' => $section_options]); ?><!-- /SECTION CONTENT -->
<!-- SECTION READ MORE -->
      <a href="<?=$section->url?>">
        <?=setting('read-more');?>
        <?=ukIcon('arrow-right');?>
      </a><!-- /SECTION READ MORE -->
    </section><!-- /SECTION -->
  <?php endforeach;
                  endif; ?>
</div><!-- CONTENT BODY  -->

<!-- SIDEBAR -->
<div id="sidebar" pw-append>
  <?php
    $contact = pages()->get("template=contact");
    // Get Last Image ( https://processwire.com/docs/fields/images/ )
    $image = $contact->images ? $contact->images->last() : '';
    wireIncludeFile('views/contact/_contact-info.php', ['item' => $contact]); ?>
    <a href="<?=$contact->url?>"><?= setting('more-contact') . ' ' .  ukIcon('forward');?></a>
</div><!-- /SIDEBAR -->
