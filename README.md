AlphaID
===============

Change numbers for a different string.
Original Blog post 
http://kvz.io/blog/2009/06/10/create-short-ids-with-php-like-youtube-or-tinyurl/


How to use
===============

Add to composer.json

    "repositories": [
        {
	    "type": "vcs",
	    "url": "https://github.com/chepe263/AlphaID"
        }

<?php

/*
@param mixed   $in    String or long input to translate
@param boolean $to_num  Reverses translation when true
@param mixed   $pad_up  Number or boolean padds the result up to a specified length
@param string  $passKey Supplying a password makes it harder to calculate the original ID
@return mixed string or long
chepe263\AlphaID::make($in, $to_num = false, $pad_up = false, $passKey = null)

*/

include "vendor/autoload.php";

$goIn = chepe263\AlphaID::make(8,false,4);
$goOut = chepe263\AlphaID::make($goIn,true,4);

echo "Value: 8".PHP_EOL;
echo "In: ".$goIn.PHP_EOL;
echo "Out: ".$goOut.PHP_EOL;
echo PHP_EOL;




