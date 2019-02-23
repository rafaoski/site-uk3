<?php namespace ProcessWire;

/**
 * ProcessWire Bootstrap API Ready
 * ===============================
 * This ready.php file is called during ProcessWire bootstrap initialization process.
 * This occurs after the current page has been determined and the API is fully ready
 * to use, but before the current page has started rendering. This file receives a
 * copy of all ProcessWire API variables. This file is an idea place for adding your
 * own hook methods.
 * http://processwire.com/api/hooks/
 * https://processwire.com/api/ref/hook-event/
 *
 */

// SEO Hook 
$wire->addHookAfter('Pages::saveReady', function($event) {
// retrieve first argument by index (0 based)
$page = $event->arguments(0);
// Seo Title
if($page->meta_title == '' && $page->body != '' ) {
	if (preg_match('!(<h3>.+?</h3>)!', $page->body, $matches)) {
		$page->meta_title = sanitizer()->text($matches[1]);
	}
}
// Seo Description
if($page->meta_description == '' && $page->body != '' ) {
	if (preg_match('!(<p>.+?</p>)!', $page->body, $matches)) {
	$page->meta_description = sanitizer()->truncate($matches[1],
		[
		'maxLength' => 190,
		'more' => ' ...'
		]
	);
	}
}
// Simple Information
if ( $page->isChanged('meta_title') || $page->isChanged('meta_description') ) {
	$event->return = $this->message(__('Update Your SEO'));
}
});

// Hook to Minify HTML
$wire->addHookAfter('Page::render', function($event) {
if(page()->template == 'admin') return;
if(!pages('/options/advanced-options/minify-html/')->checkbox) return;
$value  = $event->return;
// https://datayze.com/howto/minify-html-with-php.php
$event->return = preg_replace('/\s+/', ' ', $value);
});

// Hook CSS in the edit Admin page adds auto margins to class ./Inputfield <li>
$wire->addHookAfter('Page::render', function($event) {
if(page()->template != 'admin') return;
if( !pages('/options/')->option_switch->get("name=enable-small-admin-margin") ) return;

// Check Page Name
switch (page()->name) {
	case 'edit':
		# This path will be use custom CSS
		break;
	case 'add':
		# This path will be use custom CSS
		break;
	case 'options':
		# This path will be use custom CSS
		break;
	case 'profile':
		# This path will be use custom CSS
		break;
	default:
		# Default only return;
		return;
	break;
}
// Return Content
$value  = $event->return;
// Custom CSS
$cust_style = "\t<style id='hook-from-ready-php'>\n";
$cust_style .= "\t\t.Inputfield:not(.InputfieldRowFirst){ margin-top: 10px !important; }\n";
$cust_style .= "\t\t#ChildrenPageList, #wrap_Inputfield__pw_page_name, #wrap_template, #wrap_delete_page,
#wrap_Inputfield_latitude, #wrap_Inputfield_ref_1 { margin-top: -10px; }\n";
$cust_style .= "\t</style>\n";
$value = str_replace("</title>", "</title>\n$cust_style", $value);
// set the modified value back to the return value
$event->return = $value;
});

// Hook Admin Custom CSS
$wire->addHookAfter('Page::render', function($event) {
	if(page()->template != 'admin') return;
// Return Content
	$value  = $event->return;
	$templates = urls()->templates;
	$style = "<link rel='stylesheet' href='{$templates}assets/css/admin.css'>";
	$event->return = str_replace("</head>", "\n\t$style</head>", $value);
});

// Reload turbolinks ( Admin Pages )
$wire->addHookAfter('Page::render', function($event) {
if(page()->template != 'admin') return;
$value  = $event->return;
$turbolinks_reload = "<meta name='turbolinks-visit-control' content='reload'>";
$value = str_replace("</head>", "\n\t$turbolinks_reload\n</head>", $value);
// set the modified value back to the return value
$event->return = $value;
});

// Remove unnecessary Categories and Tags
$wire->addHook('Pages::save', function($event) {
$page = $event->arguments('page');
if($page->template != 'options' || $page->checkbox_1 == 0) return;
// Disable the check box after saving the page ( you do not need it the next time you edit the options page )
$page->setAndSave('checkbox_1', 0);
// Categories
$cat_pages = '';
foreach (pages()->get("template=blog-categories")->children as $category) {
	if(!$category->references->count()) {
		$cat_pages .= $category->title . ' , ';
		$category->trash();
	}
}
// Tags
$tag_pages = '';
foreach (pages()->get("template=blog-tags")->children as $tag) {
	if(!$tag->references->count()) {
		$tag_pages .= $tag->title . ' , ';
		$tag->trash();
	}
}

if( $cat_pages ) {
	$event->return = $this->message(__('You have removed the unnecessary Categories: ') . ' ' . $cat_pages);
}

if( $tag_pages ) {
	$event->return = $this->message(__('You have removed the unnecessary Tags: ') . ' ' . $tag_pages);
}

if( $cat_pages == '' && $tag_pages == '' ) {
	$event->return = $this->message(__('No pages found in Categories and Tags to be moved to trash'));
}

});
