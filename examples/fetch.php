<?php
/**
 * Fetch all records from GDS
 *
 * @author Tom Walder <tom@docnet.nu>
 */
require_once('boilerplate.php');

// Fetch the first record (using the default "SELECT * FROM Kind" query)
$obj_book = $obj_book_store->fetchOne();
describeResult($obj_book);

// Retrieve one by it's Datastore ID
$obj_book = $obj_book_store->fetchById('5066549580791808');
describeResult($obj_book);

// Fetch a book by GQL
$obj_book = $obj_book_store->fetchOne("SELECT * FROM Book WHERE isbn = '1853260304'");
describeResult($obj_book);

// Fetch all
$arr_books = $obj_book_store->fetchAll("SELECT * FROM Book");
describeResult($arr_books);

// Fetch paginated
$obj_book_store->query('SELECT * FROM Book');
while($arr_page = $obj_book_store->fetchPage(5)) {
    describeResult($arr_page);
}



/**
 * Helper function to simplify results display
 *
 * @param $mix_result
 * @param bool $bol_recurse
 */
function describeResult($mix_result, $bol_recurse = FALSE)
{
    if($mix_result instanceof GDS\Entity) {
        $str_class = get_class($mix_result);
        echo "Found single result: [{$str_class}] {$mix_result->getKeyId()}, {$mix_result->title}, {$mix_result->isbn}, {$mix_result->author}", PHP_EOL;
    } elseif (is_array($mix_result)) {
        echo "Found ", count($mix_result), " results", PHP_EOL;
        if($bol_recurse) {
            foreach($mix_result as $mix_row) {
                describeResult($mix_row);
            }
        }
    } else {
        echo "No result(s) found", PHP_EOL;
    }
}