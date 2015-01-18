<?php
require 'vendor/autoload.php';
$neo4j = new EndyJasmi\Neo4j;	
$errorMessage = "nope";

if($_POST["action"] == "login"){

	$Username = $_POST["username"];
	$Password = $_POST["password"];

	$query = 'match (n:Person {username:'."\"$Username\"".'}) return n';

		//echo $parameters;

		//echo "gs";
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


//echo "g";
	//var_dump($result);
	/*<?PHP print $errorMessage;?>*/
	if(!is_null($result))
	{
		//var_dump($result[0]['n']);
		$arr = $result[0]['n'];
		//echo "Afsaf";
		//echo $arr;
		echo $arr['username'];
		if($arr['password'] == $Password){
			session_start();
			$_SESSION["user"] = $Username;
			$_SESSION["name"] = $arr['name'];
			$_SESSION["email"] = $arr['email'];
			$_SESSION['login'] = true;
			header("Location: ./users.php");
			die();
		}
		else{
			header("Location: ./wrong.php");
			die();
		}
		//echo "sdfg";
	}
	else{
		echo "None";

	}

}
else if($_POST["action"] == "signup"){


	$Username = $_POST["username"];
	$Password = $_POST["password"];
	$Name = $_POST["name"];
	$Email = $_POST["email"];


	$query = 'match (n:Person {username:'."\"$Username\"".'}) return n';

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



	if(is_null($result[0]['n']))
	{
		$query = 'create (n:Person {person}) return n';
		$parameters = [
		'person' => [
		'name' => $Name,
		'username' => $Username,
		'password' => $Password,
		'email' => $Email
		]
		];

		$result = $neo4j->statement($query, $parameters);


		if(!is_null($result))

		{
			session_start();
			$_SESSION["user"] = $Username;
			$_SESSION["name"] = $Name;
			$_SESSION["email"] = $Email;
			$_SESSION['login'] = true;
			header("Location: ./users.php");
						die();	
		}
		//echo "sdfg";
	}
	else{
		echo "User Already Exist";

	}

}
else{
	echo "POST";
}




?>