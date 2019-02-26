<?php namespace ProcessWire;

if ($input->urlSegment(3)) {
    session()->redirect(pages('http404')->url);
}

if ($input->urlSegment(1)) {
    if (!is_numeric($input->urlSegment(1)) or !is_numeric($input->urlSegment(2))) {
        session()->redirect(pages('http404')->url);
        // throw new Wire404Exception();
    }
}
?>

<!-- CONTENT -->
<div id='content-body' pw-prepend>

<form action="./">

  <select style='background:#bab5af; color:black;' class="uk-select" name='form'
          onchange='location = this.options[this.selectedIndex].value;'>

  <option value='#'><?=setting('select-archives');?></option>

    <?=blogArchive(2015,true)?>

  </select>

</form>

<?php //GET URL SEGMENT
$y = $input->urlSegment(1);
$m = $input->urlSegment(2);

$date_s = "$y/$m/01";
$date_e = "$y/$m/31";
$items = $pages->find("template=blog-post, date>=$date_s, date<=$date_e, sort=-date, limit=12");

if ($y) {
    if (count($items) == 0) {
        session()->redirect(pages('http404')->url);
    }
    echo "<h3>" . sprintf(setting('archives-date'),$y, $m ) . "</h3>";
}
// Blog Posts
foreach ($items as $post) {
  wireIncludeFile('views/parts/_blog-post.php', ['post' => $post]);
}
// Pagination
echo ukPagination($items); ?>

</div><!-- /CONTENT -->

<!-- SIDEBAR -->
<div id='sidebar' pw-prepend>
  <?php wireIncludeFile('views/parts/_blog-links.php'); ?>
</div><!-- /SIDEBAR -->
