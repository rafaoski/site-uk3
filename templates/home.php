<?php namespace ProcessWire;
$sections = pages('/options/')->home_sections;
?>

<div id='content-body' pw-append>
  <?php
    // Home Sections
    $sections = pages('/')->home_sections;
    if ($sections):
    foreach ($sections as $section_options):
    $section= pages()->get("template=$section_options->name");?>
    <section class='home-sections home-<?=$section->name?> uk-margin-large-top'>
      <h3 class='section-heading uk-h1 uk-heading-bullet'>
        <strong><?php editItem($section_options);?> <?=$section_options->text_1;?><br>
        </strong>
      </h3>

      <?php wireincludeFile("views/home-sections/section-{$section_options->name}",
      ['section' => $section, 'section_options' => $section_options]); ?>

      <a href="<?=$section->url;?>">
        <?=setting('read-more');?> &raquo;
      </a><br>
    </section>
  <?php endforeach;
                  endif; ?>
</div><!-- #/content-body -->

<div id="sidebar" pw-append>
  <?php
  $contact = pages()->get("template=contact");
    // Get Last Image ( https://processwire.com/docs/fields/images/ )
    $image = $contact->images ? $contact->images->last() : '';
    wireIncludeFile('views/contact/_contact-info.php', ['item' => $contact]); ?>

    <a href="<?=$contact->url?>"><?= setting('more-contact') . ' ' .  ukIcon('forward');?></a>

</div>
