<?php namespace ProcessWire;

/**
 *
 *  LEARN MORE ABOUT MARKUP REGIONS
 *  https://processwire.com/blog/posts/processwire-3.0.49-introduces-a-new-template-file-strategy/
 *  https://processwire.com/blog/posts/processwire-3.0.62-and-more-on-markup-regions/
 *
 */

?>

<div id='content-body' pw-append>
	<?php if(page()->hasChildren) :?>
	<div class="more-pages" style='padding: 20px;'>
		<h3><?=setting('more-pages')?></h3>
		<ul class='page-children'>
	<?php foreach (page()->children as $child): ?>
			<li><a href='<?=$child->url?>'><?=$child->title?></a></li>
	<?php endforeach ?>
		</ul>
	</div>
	<?php endif; ?>
</div><!-- #/content-body -->
