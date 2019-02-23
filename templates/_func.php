<?php namespace ProcessWire;

/**
 *
 * @param Page|null $item
 *
 */
function privacyPanel($item = null) {
if (!$item) return;
$out = '';
$out .= "<a class='uk-button uk-button-text uk-text-warning uk-padding-small' href='{$item->url}'>";
$out .= ukIcon('info', ['ratio' => 1.5]) . ' ' . $item->title;
$out .= "<span class='uk-text-muted'>$item->meta_title</span></a>";
return editItem($item) . $out;
}


/**
 *
 * @param array $href ( url to  stylesheets )
 *
 */
function cssAsync(array $href) {
$out = "\n<script>\n";
foreach ($href as $key => $link) {
$out .= "var giftofspeed_$key = document.createElement('link');
giftofspeed_$key.rel = 'stylesheet';
giftofspeed_$key.href = '$link';
var godefer = document.getElementsByTagName('link')[0];
godefer.parentNode.insertBefore(giftofspeed_$key, godefer);";
}
$out .= "\n</script>";
return $out;
}

/**
 *
 * @param Page $page
 *
 */
function seoPagination($page)
{
	$out = '';
// https://processwire.com/blog/posts/processwire-2.6.18-updates-pagination-and-seo/
    if (input()->pageNum > 1) {
        $out .= "<meta name='robots' content='noindex,follow'>\n";
    }
// https://weekly.pw/issue/222/
    if (config()->pagerHeadTags) {
        $out .= config()->pagerHeadTags . "\n";
    }

		return $out;
}

/**
 *
 * @param PageArray $external_links
 * @param array $options
 *
 */
function externalLink(PageArray $external_links, array $options = []) {
$p_templ = page()->template;
$style = (isset($options['style']) && !empty($options['style'])) ? "style='{$options['style']}'" : '';
$class = (isset($options['class']) && !empty($options['class'])) ? "class='{$options['class']}'" : '';
$ratio = (isset($options['ratio']) && !empty($options['ratio'])) ? "{$options['ratio']}" : '1.3';
    $out = '';
    foreach ($external_links as $link) {
    $icon = $link->text_1 ? "data-uk-icon='icon:$link->text_1; ratio: $ratio'" : '';
    $title = $link->text_3 ? "title='$link->text_3'" : '';
    $li_class = "ext-$p_templ external_link-" . sanitizer()->pageName($link->text_1, true);
    $target = $link->checkbox ?  "target='_blank'" : '';
    $no_follow = $link->checkbox_1 ?  "rel='nofollow'" : '';
    $all_items = "$icon $title $target $no_follow";
        if($link->text_1 == 'rss' && $link->url_1 == '') $link->url_1 = pages()->get("template=blog-rss")->url;
        $out .= "<li class='$li_class uk-padding-remove'>";
        $out .= "<a $class $style href='$link->url_1' $all_items>$link->text_2 </a></li>";
    }
    return $out;
}

/**
 * Given a group of pages, render a simple <ul> navigation
 *
 * This is here to demonstrate an example of a simple shared function.
 * Usage is completely optional.
 *
 * @param PageArray $items
 *
 */

function renderNav(PageArray $items, $home = false) {

	if( $home == true ) $items->prepend(pages('/'));

    if(!$items->count()) return;

    $out = '';

	// cycle through all the items
	foreach($items as $item) {

		// render markup for each navigation item as an <li>
		if($item->id == wire('page')->id) {
			// if current item is the same as the page being viewed, add a "current" class to it
			$out .= "<li class='current' aria-current='true'>";
		} else {
			// otherwise just a regular list item
			$out .= "<li>";
		}

		// markup for the link
		$out .= "<a href='$item->url'>$item->title</a>";

		// close the list item
		$out .= "</li>";
    }

    return $out;

}

/**
 * Given a group of pages, render a <ul> navigation tree
 *
 * This is here to demonstrate an example of a more intermediate level
 * shared function and usage is completely optional. This is very similar to
 * the renderNav() function above except that it can output more than one
 * level of navigation (recursively) and can include other fields in the output.
 *
 * @param array|PageArray $items
 * @param int $maxDepth How many levels of navigation below current should it go?
 * @param string $fieldNames Any extra field names to display (separate multiple fields with a space)
 * @param string $class CSS class name for containing <ul>
 * @return string
 *
 */
function renderNavTree($items, $maxDepth = 0, $fieldNames = '', $class = 'nav')
{

    // if we were given a single Page rather than a group of them, we'll pretend they
    // gave us a group of them (a group/array of 1)
    if ($items instanceof Page) {
        $items = array($items);
    }

    // $out is where we store the markup we are creating in this function
    $out = '';

    // cycle through all the items
    foreach ($items as $item) {
        // markup for the list item...
        // if current item is the same as the page being viewed, add a "current" class to it
        $out .= $item->id == wire('page')->id ? "<li class='current'>" : "<li>";

        // markup for the link
        $out .= "<a href='$item->url'>$item->title</a>";

        // if there are extra field names specified, render markup for each one in a <div>
        // having a class name the same as the field name
        if ($fieldNames) {
            foreach (explode(' ', $fieldNames) as $fieldName) {
                $value = $item->get($fieldName);
                if ($value) {
                    $out .= " <div class='$fieldName'>$value</div>";
                }
            }
        }

        // if the item has children and we're allowed to output tree navigation (maxDepth)
        // then call this same function again for the item's children
        if ($item->hasChildren() && $maxDepth) {
            if ($class == 'nav') {
                $class = 'nav nav-tree';
            }
            $out .= renderNavTree($item->children, $maxDepth-1, $fieldNames, $class);
        }

        // close the list item
        $out .= "</li>";
    }

    // if output was generated above, wrap it in a <ul>
    if ($out) {
        $out = "<ul class='$class'>$out</ul>\n";
    }

    // return the markup we generated above
    return $out;
}

/********* MULTI LANGUAGE SUPPORT *********/

/**
 *
 * @param Page $page
 * @param Page $root
 *
 */
function linkTag($page, $root)
{

    // If Multi Language Modules activate
    if (!$page->getLanguages()) {
        return '';
    }
    $out = '';
    // handle output of 'hreflang' link tags for multi-language
    // this is good to do for SEO in helping search engines understand
    // what languages your site is presented in
    foreach (languages() as $language) {
        // if this page is not viewable in the language, skip it
        if (!$page->viewable($language)) {
            continue;
        }
        // get the http URL for this page in the given language
        $url = $page->localHttpUrl($language);
        // hreflang code for language uses language name from homepage
        $hreflang = $root->getLanguageValue($language, 'name');
        // if($hreflang == 'home') $hreflang = page()->ts['languageCode'];
        // output the <link> tag: note that this assumes your language names are the same as required by hreflang.
        $out .= "\t<link rel='alternate' hreflang='$hreflang' href='$url' />\n";
    }
    return $out;
}

/**
 *
 * @param Page $page
 * @param Page $root
 *
 */
function langMenu($page, $root)
{
    // If Enable Multilanguage Modules
    if (!page()->getLanguages()) {
        return '';
    }
    $out = '';
    foreach (languages() as $language) {
    // is page viewable in this language?
        if (!$page->viewable($language)) {
            continue;
        }
        if ($language->id == user()->language->id) {
            $out .= "<li class='uk-active'>";
            $icon = "<i data-feather='flag'></i>";
        } else {
            $out .= "<li>";
            $icon = '';
        }
        $url = $page->localUrl($language);
        $hreflang = $root->getLanguageValue($language, 'name');
        if($hreflang == 'home') $hreflang = 'x-default';
        $out .= "<a hreflang='$hreflang' href='$url'>$language->title $icon</a></li>";
    }
    return $out;
}


/**
 *
 * @param Page $item
 * @param Page $root
 *
 */
// function langMenu($page, $root) {
// // If Language Support PageNames Modules activate
// if(!modules()->isInstalled("LanguageSupportPageNames")) return;
// // If Enable Multilanguage Modules
// if(!page()->getLanguages()) return '';
//   $out = '';
//   $langs = '';
//   $basic_lang = '';
//
// // Start Loop
// foreach(languages() as $language) {
//
//     $url = $page->localUrl($language);
//     $hreflang = $root->getLanguageValue($language, 'name');
//
//     // is page viewable in this language?
//     if(!$page->viewable($language)) continue;
//
//     if($language->id == user()->language->id) {
//     // Prevent if language prefix is not
//     if($hreflang == 'home') $hreflang = 'x-default';
//
//     $basic_lang .= "<a hreflang='$hreflang' href='#'>" . setting('lang') . "</a>";
//     // $basic_lang .= "<a hreflang='$hreflang' href='#'>$language->title</a>";
//
//     } else {
//
//     $langs .= "<li><a class='uk-text-uppercase' hreflang='$hreflang' href='$url'>$language->title</a></li>";
//     }
//
// }
//
// // language switcher / navigation
// $out .= "<ul class='uk-margin-small-left language-switcher uk-navbar-nav'>";
// $out .= "<li class='uk-active'>";
// $out .= $basic_lang;
//
// $out .= "<div class='uk-navbar-dropdown'>";
// $out .= "<ul class='uk-nav uk-navbar-dropdown-nav'>";
// $out .= $langs;
// $out .= "</ul>";
// $out .= "</div>";
//
// $out .= "</li>";
// $out .= "</ul><!-- /.language-switcher -->";
//
// return $out;
// }

/*****************************************************************************************
 * ProcessWire/Uikit functions for rendering comments and comment forms
 *
 * Note: comment threads (depth), stars and votes are not yet supported in here.
 *
 */

/**
 * Render a ProcessWire comment using Uikit markup
 *
 * @param Comment $comment
 * @return string
 *
 */
function Comment(Comment $comment) {

	$text = $comment->getFormatted('text');
	$cite = $comment->getFormatted('cite');
	$website = $comment->getFormatted('website');
	$field = $comment->getField();
	$page = $comment->getPage();
	$classes = array();
	$metas = array();
	$gravatar = '';
	$replies = '';

	if($field->get('useGravatar')) {
		$img = $comment->gravatar($field->get('useGravatar'), $field->get('useGravatarImageset'));
		if($img) $gravatar = "<div class='uk-width-auto'><img class='uk-comment-avatar' src='$img' alt='$cite'></div>";
	}

	if($website) $cite = "<a href='$website' rel='nofollow' target='_blank'>$cite</a>";
	$created = wireDate('relative', $comment->created);

	if($field->get('usePermalink')) {
		$permalink = $page->httpUrl;
		$urlSegmentStr = $this->wire('input')->urlSegmentStr;
		if($urlSegmentStr) $permalink .= rtrim($permalink, '/') . $urlSegmentStr . '/';
		$permalink .= '#Comment' . $comment->id;
		$permalink = "<a href='$permalink'>" . __('Permalink') . "</a>";
		$metas[] = "<li>$permalink</li>";
	}

	$classes = implode(' ', $classes);
	$metas = implode('', $metas);

	$out = "
		<article id='Comment$comment->id' class='$classes uk-comment uk-comment-primary' data-comment='$comment->id'>
			<header class='uk-comment-header uk-grid-medium uk-flex-middle' data-uk-grid>
				$gravatar
				<div class='uk-width-expand'>
					<h4 class='uk-comment-title uk-margin-remove'>$cite</h4>
					<ul class='uk-comment-meta uk-subnav uk-subnav-divider uk-margin-remove-top'>
						<li>$created</li>
						$metas
					</ul>
				</div>
			</header>
			<div class='uk-comment-body'>
				$text
			</div>
		</article>
		$replies
	";

	return $out;
}

/**
 * Render a list of ProcessWire comments using Uikit markup
 *
 * Note: does not currently support threaded comments (comment depth).
 * Use ProcessWire’s built-in comments rendering for that purpose.
 *
 * @param CommentArray $comments
 * @param array|string $options Options to modify default behavior
 *  - `id` (string): HTML id attribute of the comments list (default='comments').
 * @return string
 *
 */
function Comments(CommentArray $comments, $options = array()) {

	$defaults = array(
		'id' => 'comments',
	);

	if(!count($comments)) return '';
	$options = _ukMergeOptions($defaults, $options);

	$out = "<ul id='$options[id]' class='uk-comment-list'>";

	foreach($comments as $comment) {
		$out .= "<li class='uk-margin'>" . Comment($comment) . "</li>";
	}

	$out .= "</ul>";

	return $out;
}

/**
 * Render a comment posting form
 *
 * @param CommentArray $comments
 * @param array $options See `CommentForm` class for all options.
 * @return string
 *
 */
function CommentForm(CommentArray $comments, array $options = array()) {

	$defaults = array(
		'headline' => "",
		'successMessage' => setting('success-message'),
		'pendingMessage' => setting('pending-message'),
		'errorMessage' => setting('error-message'),
     'labels' => array(
         'cite' => setting('comment-cite'),
         'email' => setting('comment-email'),
         'website' => setting('comment-website'),
         'stars' => setting('comment-stars'),
         'text' => setting('comment-text'),
         'submit' => setting('comment-submit'),
         'starsRequired' => setting('stars-required'),
 )
	);

	$options = _ukMergeOptions($defaults, $options);
	$options['successMessage'] = ukAlertSuccess($options['successMessage'], 'check');
	$options['pendingMessage'] = ukAlertSuccess($options['pendingMessage'], 'check');
	$options['errorMessage'] = ukAlertDanger($options['errorMessage'], 'warning');

	if(!isset($options['attrs']) || !isset($options['attrs']['class'])) {
		$options['attrs'] = array('class' => 'uk-comment uk-comment-primary');
	}

	$adjustments = array(
		"<input type='text'" => "<input type='text' class='uk-input'",
		"<p class='CommentForm" => "<p class='uk-margin-remove-top CommentForm",
		"<textarea " => "<textarea class='uk-textarea' ",
		"<button " => "<button class='uk-button uk-button-primary' ",
		"<label " => "<label class='uk-form-label' ",
	);

	$out = $comments->renderForm($options);
	$out = str_replace(array_keys($adjustments), array_values($adjustments), $out);

	return $out;
}

/**
 * @param Page $items Page Children to start the render images
 * @param bool $check Check if comments on the options page have been turned off
 */
function countComments($items, $check) {
	$id = $items->comments->last() ? $items->comments->last()->id : '#';
	if($id == '#') return;
if(!$check) return;
$out = '';
  $out = "<a href='$items->url#Comment$id'>";
  $out .= "<span class='uk-margin-small-bottom'>" . ukIcon('comments') . ' ' . count($items->comments) . "<span>";
  $out .= "</a>";
return $out;
}

/**
 *
 * @param int $startDate or whenever you want it to start like 2017
 * @param string $where where is location archive ( 'sidebar' or 'archives' )
 *
 */
function blogArchive($startDate = 2018, $option = false)
{

    $blogPage = pages()->get("template=blog-posts");
// Reset Form
    $out = '';
// $startYear = date("Y"); // this year
    $endDate = date("Y"); // this year
    $now = time();

//CODE FROM => https://processwire.com/talk/topic/263-creating-archives-for-newsblogs-sections/
    for ($year = $endDate; $year >= $startDate; $year--) {
        for ($month = 12; $month > 0; $month--) {
            $startTime = strtotime("$year-$month-01"); // 2011-12-01 example
            if ($startTime > $now) {
                continue; // don't bother with future dates
            }
            if ($month == 12) {
                $endTime = strtotime(($year+1) . "-01-01");
            } else {
                $endTime = strtotime("$year-" . ($month+1) . "-01");
            }
            $entries = $blogPage->children("date>=$startTime, date<$endTime"); // or substitute your own date field
            $date = date("Y-m", $startTime);
            $url = pages()->get("template=blog-archives")->url . date("Y", $startTime) . "/" . date("m", $startTime) . '/';
            $count = count($entries);
            if ($count > 0) {
                if ($option == true) {
                    $out .= "<option value='$url'>$date - ($count)</option>";
                } else {
                    $out .= "<li><a href='$url'>$date - ($count)</a></li>";
                }
            }
        }
    }

    return $out;
}

/**
 *
 * @param Page $post
 * @param Page $user
 */
function blogInfo($post, $user) {
	$out = '';
	$count_comments = countComments($post, setting('enable-comments'));
	// Categories
	if (count($post->categories)) {
	// echo ' / ' . pages()->get("template=blog-categories")->title . ' ';
	echo ukIcon('hashtag') . ' ';
	$post->categories->implode(" <small>|</small> ", function($cat) {
	echo "<a style='font-size: 1.5rem; color: #1c98d5;' href='{$cat->url}'>{$cat->title}</a> ";
	});
	}
	// Tags
	if (count($post->tags)) {
	// echo ' / ' . pages()->get("template=blog-tags")->title . ' ';
	echo ukIcon('tag') . ' ';
	$post->tags->implode(" | ", function($tag) {
	echo "<a style='font-size: 1.5rem; color: #1c98d5;' href='{$tag->url}'>{$tag->title}</a> ";
	});
	}
	echo ukIcon('user') . ' ';
	echo "<a style='font-size: 1.5rem; color: #1c98d5;' href='$user->url'>$user->title</a> /
	$post->date / $count_comments";
}

/********* END MULTI LANGUAGE SUPPORT *********/

/**
 *
 * https://processwire.com/blog/posts/processwire-3.0.107-core-updates/
 *
 * @param Page $item
 *
 */
function articleLinks($page)
{
    $out = '';
    $links = $page->links();
// If another page has links to this page
    if ($links->count()) {
        $out .= "<h3>" . __('You might also like:') . "</h3>";
        $out .= $links->each("<li><a href={url}>{title}</a></li>") . '<br>';
    }
    return $out;
}

/**
 *
 * Prev Next Button
 * Basic Example echo prNx($page)
 *
 * @param Page|null $item
 *
 */
function prNx($item = null)
{

// Prev Next Button
    $p_next = $item->next();
    $p_prev = $item->prev();

    $out = '';

// link to the prev blog post, if there is one
if ($p_prev->id) {
    $icon_prev = ukIcon('arrow-left');
		$out .= "<a href='$p_prev->url'>$icon_prev $p_prev->title</a>";
    }

// link to the next blog post, if there is one
    if ($p_next->id) {
        $icon_next = ukIcon('arrow-right');
        $out .= "<a href='$p_next->url'>$p_next->title $icon_next</a>";
    }

    return $out;
}

/**
 *
 * Google Webmaster Tools Verification Code
 *
 * @param string|null $code
 *
 */
function gwCode($code = null)
{
    if ($code) {
        echo "<meta name='google-site-verification' content='$code' />\n";
    }
}

/**
 *
 * https://developers.google.com/analytics/devguides/collection/analyticsjs/
 *
 * @param string $code Google Analytics Tracking Code
 *
 */
function gaCode($code = null)
{
if($code) {
echo "\t<script async src='https://www.googletagmanager.com/gtag/js?id=UA-{$code}'></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', 'UA-{$code}');
    </script>";
    }
}

/**
 *
 * @param array $fonts
 *
 */
function googleFonts(array $fonts)
{

// Implode to format => 'Roboto','Montserrat','Limelight','Righteous'
$font_family = implode("','", $fonts);

return"\t<script>
      /* ADD GOOGLE FONTS WITH WEBFONTLOADER ( BETTER PAGESPEED )
          https://github.com/typekit/webfontloader
      */
      WebFontConfig = {
              google: {
              families: ['$font_family']
          }
      };
          (function(d) {
              var wf = d.createElement('script'), s = d.scripts[0];
              wf.src = 'https://ajax.googleapis.com/ajax/libs/webfont/1.6.26/webfont.js';
              wf.async = true;
              s.parentNode.insertBefore(wf, s);
          })(document);
\t</script>\n";
}

/**
 *
 * @param Page $page
 *
 */
function editBtn($page)
{
    if ($page->editable()) {
      echo "<div class='uk-padding-small'><a class='uk-button uk-button-large uk-button-primary' href='" . $page->editURL . "'>";
      echo setting('edit-page') . "</a></div>";
    }
}

/**
 *
 * @param Page $item
 *
 */
function editItem($item, $style = '') {
    $out = '';
    if($item->editable) {
        $out .= " <a class='edit-item uk-button uk-button-text' href='$item->editUrl' style='$style'>";
        $out .=  ukIcon('pencil', ['ratio' => 1.5]);
        $out .= "</a>";
        echo $out;
    }
  }

/**
 *
 * @param string $class
 *
 */
function debugRegions($class = 'sec-debug')
{
    $out = '';

if (config()->debug && user()->isSuperuser()) {
$out .= "\n\t\t<section id='debug' class='$class'>
<h2>Debug Regions</h2>
            <!--PW-REGION-DEBUG-->
        \n\t\t</section>\n";
    }
 return $out;
}
