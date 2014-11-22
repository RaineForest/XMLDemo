<?php
Header('Content-type: text/xml');
$title = '';
$author = '';
if(isset($_GET["title"])) $title = $_GET["title"];
if(isset($_GET["author"])) $author = $_GET["author"];
$title = pg_escape_string($title);
$author = pg_escape_string($author);

$db_conn = pg_connect("host=localhost user=pi password=a") or die("cannot connect to db");
$db_query = "select query_to_xml(E'select * from book where author like \'%".$author."%\' and title like \'%".$title."%\'', false, false, '')";
$result = pg_query($db_conn, $db_query);
if(!$result) {
	echo "An error occured";
	pg_close($db_conn);
	exit;
}
while($row = pg_fetch_row($result)) {
	echo $row[0];
}
pg_close($db_conn);
?>

