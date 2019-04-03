<?php
/*
Since :word should probably be valid, and I guess :word:another should be considered two words, then you cannot say that there is always a space.

Words in natural languages can be followed by dots and other characters.
In digital input, they can be followed by end of line.

I suggest using this regexp:

~:\w+~

It takes any : character followed by at least one alpha character and will end at any character that is not valid letter.

Example: on RegExr.com

You can also try ~:\w+\b~, where \b is word boundary (literally end of word), but I see it not necessary here.

Note: \w stands for [a-zA-Z0-9_] meaning it catches underscores _ and digits 0-9 as well. It works pretty much like variable/function naming in PHP

EDIT (some notes on usage):
You said that in given text (I understand that like input with random things) you want to extract all words prepended with :, for example :word. To do that easily, you should use preg_match_all() function with PREG_PATTERN_ORDER flag.

Example:


 */

$regex = '~(:\w+)~';
if (preg_match_all($regex, $input, $matches, PREG_PATTERN_ORDER)) {
   foreach ($matches[1] as $word) {
      echo $word .'<br/>';
   }
}


// src: https://stackoverflow.com/questions/28714937/php-find-all-words-starting-with
