<?php
require 'vendor/autoload.php';
$neo4j = new EndyJasmi\Neo4j;

session_start();

if($_POST['action'] == 'all'){


	$user = $_SESSION['user'];

	$query = 'Match (n:Person) return collect(n.name) as f';

	try{
		$result = $neo4j->statement($query);
		//echo "hi";
	}
	catch (EndyJasmi\Neo4j\Error\Neo\ClientError\Statement\InvalidSyntax $e) {
    // Caught here!
    //throw $e;
		echo $e;
	}

	catch (EndyJasmi\Neo4j\Error\Neo\ClientError\Statement $e) {
    // Caught here!
    //throw $e;
		echo $e;
	}

	catch (EndyJasmi\Neo4j\Error\Neo\ClientError $e) {
    // Caught here!
    //throw $e;
		echo $e;
	}
	catch (EndyJasmi\Neo4j\Error\Neo $e) {
		echo "no";
	}

	if(!is_null($result)){
		$arr = $result[0]['f'];

		foreach ($arr as  $value) {
			echo $value;
			echo "<br>";
		}
	}

}

else if($_POST['action'] == 'friends'){

	$user1 = $_SESSION['user'];

	$query = 'match (a:Person {username:'."\"$user1\"".'})-[:FRIEND_OF]-(n) Return Distinct collect(n.name) as f';

	try{
		$result = $neo4j->statement($query);
		//echo "hi";
	}
	catch (EndyJasmi\Neo4j\Error\Neo\ClientError\Statement\InvalidSyntax $e) {
    // Caught here!
    //throw $e;
		echo $e;
	}

	catch (EndyJasmi\Neo4j\Error\Neo\ClientError\Statement $e) {
    // Caught here!
    //throw $e;
		echo $e;
	}

	catch (EndyJasmi\Neo4j\Error\Neo\ClientError $e) {
    // Caught here!
    //throw $e;
		echo $e;
	}
	catch (EndyJasmi\Neo4j\Error\Neo $e) {
		echo "no";
	}

	if(!is_null($result))
	{
		//var_dump($result[0]['n']);
		$arr = $result[0]['f'];

		foreach ($arr as  $value) {
			echo $value;
			echo "<br>";
		}

	}



}


else if($_POST['action'] == 'add'){
	$user1 = $_SESSION['user'];
	$user2 = $_POST['user2'];

	$query = 'match (a:Person {username:'."\"$user1\"".'}), (b:Person {username:'."\"$user2\"".'})
	CREATE (a)-[r:'.FRIEND_OF.']->(b)
	RETURN r';

	try{
		$result = $neo4j->statement($query);
		//echo "hi";
	}
	catch (EndyJasmi\Neo4j\Error\Neo\ClientError\Statement\InvalidSyntax $e) {
    // Caught here!
    //throw $e;
		echo $e;
	}

	catch (EndyJasmi\Neo4j\Error\Neo\ClientError\Statement $e) {
    // Caught here!
    //throw $e;
		echo $e;
	}

	catch (EndyJasmi\Neo4j\Error\Neo\ClientError $e) {
    // Caught here!
    //throw $e;
		echo $e;
	}
	catch (EndyJasmi\Neo4j\Error\Neo $e) {
		echo "no";
	}

	if(!is_null($result))
	{
		//var_dump($result[0]['n']);
		$arr = $result[0]['r'];

		echo $arr;

	}
	else{
		echo "Adding Failed";
	}


}

else if($_POST['action'] == 'mutual'){
	$user1 = $_SESSION['user'];
	$user2 = $_POST['user2'];

$query = 'match (:Person {username:'."\"$user1\"".'})-[:FRIEND_OF]-(n)-[:FRIEND_OF]-(:Person {username:'."\"$user2\"".'}) return collect(n.name) as m';
try{
		$result = $neo4j->statement($query);
		//echo "hi";
	}
	catch (EndyJasmi\Neo4j\Error\Neo\ClientError\Statement\InvalidSyntax $e) {
    // Caught here!
    //throw $e;
		echo $e;
	}

	catch (EndyJasmi\Neo4j\Error\Neo\ClientError\Statement $e) {
    // Caught here!
    //throw $e;
		echo $e;
	}

	catch (EndyJasmi\Neo4j\Error\Neo\ClientError $e) {
    // Caught here!
    //throw $e;
		echo $e;
	}
	catch (EndyJasmi\Neo4j\Error\Neo $e) {
		echo "no";
	}

	if(!is_null($result)){
		$arr = $result[0]['m'];

		//echo $arr;

		foreach ($arr as  $value) {
			echo $value;
			echo "<br>";
		}
	}


}

else if($_POST['action'] == 'interest'){
	$user = $_SESSION['user'];
	$interest = $_POST['interest'];
	$query = 'match (:Interest {name:'."\"$interest\"".'})-[:LIKE]-(p) return collect(p.name) as k';

	try{
		$result = $neo4j->statement($query);
		//echo "hi";
	}
	catch (EndyJasmi\Neo4j\Error\Neo\ClientError\Statement\InvalidSyntax $e) {
    // Caught here!
    //throw $e;
		echo $e;
	}

	catch (EndyJasmi\Neo4j\Error\Neo\ClientError\Statement $e) {
    // Caught here!
    //throw $e;
		echo $e;
	}

	catch (EndyJasmi\Neo4j\Error\Neo\ClientError $e) {
    // Caught here!
    //throw $e;
		echo $e;
	}
	catch (EndyJasmi\Neo4j\Error\Neo $e) {
		echo "no";
	}

	if(!is_null($result)){
		$arr = $result[0]['k'];

		//echo $arr;

		foreach ($arr as  $value) {
			echo $value;
			echo "<br>";
		}
	}



}

else {
	echo "Wrong choice";
}


?>
