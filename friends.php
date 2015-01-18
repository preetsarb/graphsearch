<?php

require 'vendor/autoload.php';
$neo4j = new EndyJasmi\Neo4j;

session_start();

if($_POST['action'] == "add"){

	$user1 = $_SESSION['name'];

	$user2 = $_POST['name'];

	echo $user1;
	echo $user2;

	$query = 'MATCH (n:Person {name : '."\"$user1\"".'}), (m:Person {name:'."\"$user2\"".' })
	CREATE (n)-[r:FRIEND_OF]->(m) return r';


	
	try{
		$result = $neo4j->statement($query);
	}
	catch (EndyJasmi\Neo4j\Error\Neo\ClientError\Statement\InvalidSyntax $e) {
		echo $e;
	}

	catch (EndyJasmi\Neo4j\Error\Neo\ClientError\Statement $e) {
		echo $e;
	}

	catch (EndyJasmi\Neo4j\Error\Neo\ClientError $e) {
		echo $e;
	}
	catch (EndyJasmi\Neo4j\Error\Neo $e) {
		echo "no";
	}

	$status = $result->getStatus();

	if($status['relationships_created']){
		header("Location: ./users.php");
	}


}
if($_POST['action'] == "remove"){

	$user1 = $_SESSION['name'];

	$user2 = $_POST['name'];

	echo $user1;
	echo $user2;

	$query = 'MATCH (n:Person {name : '."\"$user1\"".'})-[r]-(m:Person {name:'."\"$user2\"".' })
	Delete r';


	
	try{
		$result = $neo4j->statement($query);
	}
	catch (EndyJasmi\Neo4j\Error\Neo\ClientError\Statement\InvalidSyntax $e) {
		echo $e;
	}

	catch (EndyJasmi\Neo4j\Error\Neo\ClientError\Statement $e) {
		echo $e;
	}

	catch (EndyJasmi\Neo4j\Error\Neo\ClientError $e) {
		echo $e;
	}
	catch (EndyJasmi\Neo4j\Error\Neo $e) {
		echo "no";
	}

	$status = $result->getStatus();

	if($status['relationship_deleted']){
		header("Location: ./users.php");
	}


}
?>