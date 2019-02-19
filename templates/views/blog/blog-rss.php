<?php namespace ProcessWire;

$rss = modules()->get("MarkupRSS");
$rss->title = setting('recent-posts');
$rss->render(pages()->get("template=blog-posts")->children("limit=12"));
