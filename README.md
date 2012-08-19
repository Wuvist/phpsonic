Overview
========

This is a demo project for proving the possibility of porting pysonic from python to php.

It's *experimental*, *buggy* and *feature in-complete*.

Example
=======
```php
<?php
require_once("SonicObj.php");

// Model definition
class Author extends SonicObj
{
  var $_fields = array(
	    "first_name" => "StringField",
	    "last_name" => "StringField",
	    "age" => "IntField",
	);

	var $_indexes = array(
	    array("age"),
	);
}

class Book extends SonicObj
{
	var $_fields = array(
	    "title" => "StringField",
	    "is_release" => "BoolField",
	    "author_id" => "IntField",
	);

	var $_indexes = array(
	    array("author_id", "is_release"),
	    array("author_id"),
	);
}

// Setup DB connection
SonicObj::$_db = new PDO( 
    'mysql:host=localhost;dbname=phpsonic_test', 
    'root', 
    '',
    array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8") 
);

// Setup redis connection
SonicObj::$_rs = new Redis();
SonicObj::$_rs->pconnect('127.0.0.1');

// Build the tables
Author::build_table();
Book::build_table();

$author = new Author;
$author->first_name = "Bill";
$author->last_name = "Gates";
$author->age = 55;
$author->save();

$book = new Book;
$book->title = "The road ahead";
$book->author_id = $author->id;
$book->is_release = True;
$book->save();

$book = new Book;
$book->title = "The road behind";
$book->author_id = $author->id;
$book->is_release = False;
$book->save();

echo "Find all author age 55:\n";
$authors = Author::find_all_objs(array(
  "age" => 55,
));

foreach ($author as $authors) {
	echo $author->id.$author->first_name."\n";
}

echo "\n\nFind all books by author with id 1:\n";
$author = Author::get(1);
$books = Book::find_all_objs(array(
	"author_id" => $author->id,
));

foreach ($books as $book) {
	echo $book->id.$book->title."\n";
}

echo "\n\nFind all released books by author with id 1:\n";
$books = Book::find_all_objs(array(
	"author_id" => $author->id,
	"is_release" => True,
));

foreach ($books as $book) {
	echo $book->id.$book->title."\n";
}

// List all Book
echo "\n\nList all book:\n";
$books = Book::get_all_objs();
foreach ($book as $books) {
	echo $book->id.$book->title."\n";
}

?>
```