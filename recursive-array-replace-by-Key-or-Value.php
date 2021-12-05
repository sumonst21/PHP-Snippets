<?php
/**
 * Recursive Array Replace by Key or Value
 * Replaces all occurrences of $Find in $Array by $Replace.
 * Supports multi-dimensional arrays.
 * Read more: http://php.net/manual/en/function.array-replace-recursive.php#118885
 * 
 * @param array $Array The array to be searched
 * @param mixed $Find The value to search for
 * @param mixed $Replace The replacement value
 * @return array The resulting array after the replacements
 */
function ArrayReplace($Array, $Find, $Replace){
      if(is_array($Array)){
            foreach($Array as $Key=>$Val) {
                  if(is_array($Array[$Key])){
                        $Array[$Key] = ArrayReplace($Array[$Key], $Find, $Replace);
                  }else{
                        if($Key === $Find) {
                           $Array[$Key] = $Replace;
                        }
                  }
            }
      }
      return $Array;
}

//Define Array
$Array = array('FirstName'=>"Alex",'DOB'=>'1985-06-12');
echo '<pre>',print_r($Array,1),'</pre>';

//Replace in Array
$Array = ArrayReplace($Array,'DOB',date('j \of\ F Y',strtotime($Array['DOB'])));
echo '<pre>',print_r($Array,1),'</pre>';
