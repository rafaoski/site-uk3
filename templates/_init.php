<?php namespace ProcessWire;
/**
 * This _init.php file is called automatically by ProcessWire before every page render
 * More Info To Learn Basics
 * https://processwire.com/api/ref/
 * https://processwire.com/api/variables/pages/
 * https://processwire.com/api/ref/page/children/
 * https://processwire.com/blog/posts/processwire-3.0.119-and-new-site-updates/
 * https://processwire.com/blog/posts/processwire-3.0.49-introduces-a-new-template-file-strategy/
 * https://processwire.com/blog/posts/processwire-3.0.62-and-more-on-markup-regions/
 * https://processwire.com/blog/posts/processwire-3.0.39-core-updates/#new-functions-api
 * https://processwire.com/blog/posts/processwire-3.0.7-expands-field-rendering-page-path-history-and-more/
 * https://processwire.com/blog/posts/processwire-2.5.2/
 * https://processwire.com/api/ref/page-image/size/
 * https://processwire.com/api/ref/page-image/
 *
 */
/** @var ProcessWire $wire */

// Set Jquery For Blog Post
urls()->set('jquery', 'wire/modules/Jquery/JqueryCore/JqueryCore.js');

setting([
// Url Settings
    'root' => urls()->root,
// Get homepage ... Example Usage: $home->title, $home->url
    'home' =>  pages()->get('/'),
// Templates URL
    'templates' => urls()->templates,
// Basic SEO
    'meta-title' => page('meta_title|title'),
    'meta-description' => page('meta_description'),
    'canonical-url' => page()->httpUrl(),
// Options Page
    'options' => pages('/options/'),
    'site-name' => pages('/options/')->meta_title,
    'site-description' => pages('/options/')->meta_description,
    'favicon' => pages('/options/')->favicon ? pages('/options/')->favicon->url : '',
    'logo' => pages('/options/')->logo ? pages('/options/')->logo->url : '',
    'logo-class' => pages('/options/')->logo ? pages('/options/')->logo->description : '',
    'enable-comments' => pages('/options/')->option_switch->get("name=enable-comments"),
    'enable-turbolinks' => pages('/options/')->option_switch->get("name=enable-turbolinks"),
    'enable-share-buttons' => pages('/options/')->option_switch->get("name=enable-share-buttons"),
    // https://processwire.com/api/ref/functions/wire-date/
    // 'sire-date' => wireDate('ts', page()->date_time_field),
    // https://processwire.com/api/ref/wire-date-time/date/
    'basic-datetime' => datetime()->date('ts'),
// Advanced Options
    'gw-code' => pages('/options/advanced-options/gw-code/')->checkbox ? pages('/options/advanced-options/gw-code/')->text_1 : '',
    'ga-code' => pages('/options/advanced-options/ga-code/')->checkbox ? pages('/options/advanced-options/ga-code/')->text_1 : '',
// Language Prefix => en ( views/_head.php )
    'lang' => pages('/options/')->text_2,
// Images Options
    'img-medium' => page()->render('images', 'img-medium'),
// Custom CSS Classes
    'body-classes' => WireArray([
        'template-' . page()->template->name,
        'page-' . page()->id,
    ]),
// Privacy Policy Page
    'privacy-page' => pages()->get("template=basic-privacy"),
// Get Styles
    'css-files' => WireArray([
         urls('templates') . "assets/css/app.css"
    ]),
// Get Scripts
    'js-files' => WireArray([
      urls('templates') . "assets/js/app.js"
    ]),
    'turbolinks' => urls('templates') . "assets/js/turbolinks.js",
// Basic Transate
    'search-placeholder' => __('Search'),
    'search-info' => __('Search the site'),
    'edit' => __('Edit'),
    'edit-page' => __('Edit Page'),
    'read-more' => __('Read More'),
    'more-pages' => __('More Pages'),
    'found-pages' => __("Found %d page(s)."),
    'no-found' =>  __('Sorry, no results were found.'),
    'mobile-nav' =>  __('Mobile Nav Menu'),
// Blog Translate ( views/blog/all-files* )
    'select-archives' => __('Select Archives'),
    'archives-date' => __('Date -- %1s/%2s'),
    'author-not-add' => __('Author did not add any entries'),
    'author-more-articles' => __('See more of my articles'),
    'more-about' => __('More About'),
    'also-like' => __('You might also like:'),
    'recent-posts' => __('Recent Posts'),
    'more-posts' => __('More posts'),
    'in-blog' => __('In The Blog'),
    'all-posts' => __('List All Posts'),
    'written-by' => __('Written by'),
    'posted-in' => __('Posted in'),
    'on' => __('on %s'),
// Comments Form
    'post-comment' => __('Post a comment'),
    'success-message' => __('Thank you, your comment has been posted.'),
    'pending-message' => __('Your comment has been submitted and will appear once approved by the moderator.'),
    'error-message' => __('Your comment was not saved due to one or more errors.') . ' ' .
    __('Please check that you have completed all fields before submitting again.'),
    'comment-cite' => __('Your Name'),
    'comment-email' => __('Your E-Mail'),
    'comment-website' => __('Website'),
    'comment-stars' => __('Your Rating'),
    'comment-text' => __('Comments'),
    'comment-submit' => __('Submit'),
    'stars-required' => __('Please select a star rating'),
// Contact Info Translate
    'contact-info' => __('Contact Info'),
    'more-contact' => __('More Contact Information'),
// Contact Form Translate
    'not-fill' => __('Do Not Fill First Security Input !!!'),
    'contact-form' => __('Contact Form'),
    'label-name' => __('Name'),
    'label-email' => __('E-Mail'),
    'label-message' => __('Message'),
    'submit' => __('Submit'),
    'reset' => __('Reset'),
    'show-form' => __('Show Form'),
    'label-success' => __('Success !!! Your message has been sent'),
    'label-accept' => __('By submitting a query, you accept'),
    'label-privacy' => __('privacy policy'),
    'something_wrong' => __('Something Wrong !!! Try it again'),
    'fill-fields' => __('Fill the fields correctly !!!'),
    'csrf-match' =>  __('Stop ... Session CSRF Not Match !!!'),
]);

include_once('./_uikit.php');
include_once('./_func.php');

// ADD USER => https://processwire.com/api/variables/user/
    // $u = $users->add('user-demo');
    // $u->pass = "demo99";
    // $u->addRole("guest");
    // $u->save();

// RESET PASSWORD => https://processwire.com/talk/topic/1736-forgot-backend-password-how-do-you-reset/
    // $u = $users->get('admin'); // or whatever your username is
    // $u->of(false);
    // $u->pass = 'your-new-password';
    // $u->save();
