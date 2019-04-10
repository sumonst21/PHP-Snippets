/*
PHP has some great functions for parsing and outputting comma separated value (CSV) files, but it falls short when it comes to returning that data as a string. Sure, you could map over the array with implode, but what would the result of that be if you're dealing with information that contains commas within the values themselves? Luckily, you can combine PHP's built-in functions with some well-placed stream-wrapping to fill the gaps.

First of all, the following functions are supported by PHP out-of-the-box:

fgetcsv - Similar to fgets() except that fgetcsv() parses the line it reads for fields in CSV format and returns an array containing the fields read.
fputcsv - Formats a line (passed as a fields array) as CSV and write it (terminated by a newline) to the specified file handle.
str_getcsv - (PHP 5.3.0 +) Parses a string input for fields in CSV format and returns an array containing the fields read.
The snippet of code below implements a new str_putcsv, which expects an array of associative arrays, and returns a CSV formatted string.
*/

/**
 * Convert a multi-dimensional, associative array to CSV data
 * @param  array $data the array of data
 * @return string       CSV text
 */
function str_putcsv($data) {
        # Generate CSV data from array
        $fh = fopen('php://temp', 'rw'); # don't create a file, attempt
                                         # to use memory instead

        # write out the headers
        fputcsv($fh, array_keys(current($data)));

        # write out the data
        foreach ( $data as $row ) {
                fputcsv($fh, $row);
        }
        rewind($fh);
        $csv = stream_get_contents($fh);
        fclose($fh);

        return $csv;
}
