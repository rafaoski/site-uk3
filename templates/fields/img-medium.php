<?php namespace ProcessWire;

// https://processwire.com/blog/posts/processwire-3.0.7-expands-field-rendering-page-path-history-and-more/
// render a thumbnail of the first image
if (count($value)) {
// Reset
    $out = '';

// Get medium size ( 640px )
    $medium = 640;

// Get first image
    $image = $value->first()->width($medium);

// Get size
    $height = $image->height;
    $width = $image->width;
  
// Show image
    $out .= "<img src='$image->url' class='img-medium center' alt='$image->description' height='$height' width='$width'> \n";

    return $out;
}
