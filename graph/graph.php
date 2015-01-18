<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Graph Search</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/sb-admin.css" rel="stylesheet">
    <link href="css/plugins/morris.css" rel="stylesheet">
    <link href="font-awesome-4.1.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

    <?php
    session_start();
    ?>

    <div id="wrapper">
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Graph Search</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php">Graph Search</a>
            </div>
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav side-nav">
                    <li class="active">
                        <a href="users.php"><Home Page</a>
                    </li>
                    <li>
                        <a href="index.php"><i class="fa fa-fw fa-wrench"></i> Graph Search</a>
                    </li>
                </ul>
            </div>
        </nav>
        
        
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Welcome </span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="bootstrap-elements.html">Welcome</a>
            </div>

            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">
                    <li>
                        <a href="./logout.php">Logout</a>
                    </li>
                </ul>
            </div>
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav side-nav">
                    <li class="">
                        <a href="./users.php"><i class="fa fa-fw fa-user"></i>Home</a>
                    </li>
                    <li>
                        <a href="./graph.php"><i class="fa fa-fw fa-wrench"></i> Graph Search</a>
                    </li>
                </nav>



                <div id="page-wrapper">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-lg-12">
                                <h1 class="page-header">
                                    Graph  <small>Search</small>
                                </h1>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"> Friends of Friends</h3>
                                </div>
                                <div class="panel-body">
                                    <div class="list-group">

                                        <form action="" method="POST">
                                            <!--UPLOAD THE LIST HERE IN RECURSION-->
                                            <a href="#" class="list-group-item">
                                                <span class="badge"></span>
                                                <input class="form-control" placeholder="Name Of friend" id="user2" name="user2" type="text">
                                                <input type="text" name="action" value="fof" hidden>
                                                <br>
                                                <input class="btn btn-lg btn-success btn-block" type="submit" id="login" value="Search »">

                                            </a>
                                        </form>

                                        <?php

                                        if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action']=="fof") {
                                           require 'vendor/autoload.php';
                                           $neo4j = new EndyJasmi\Neo4j;   

                                           $user1 = $_POST['user2'];
                                           $query = 'match (:Person {username:'."\"$user1\"".'})-[:FRIEND_OF]-(p) return collect(p.name) as k';

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

                                        if(!is_null($result)){
                                            $arr = $result[0]['k'];

                                            
                                            echo "<br>";

                                            foreach ($arr as  $value) {

                                                ?>

                                                <form action="./profile.php" method="POST">
                                                    <button class="form-control" type="text" name="user" id="user" value="<?php echo $value; ?>" ><?php echo $value; ?></button>
                                                    <br>
                                                </form>

                                                <?php
                                            }
                                        }


                                    }
                                    ?>

                                    
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    
                    <div class="col-lg-4">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title"> People with Common Interests</h3>
                            </div>
                            <div class="panel-body">
                                <div class="list-group">


                                    <!--UPLOAD THE LIST HERE IN RECURSION-->
                                    
                                    <form action="" method="POST">
                                        <!--UPLOAD THE LIST HERE IN RECURSION-->
                                        <a href="#" class="list-group-item">
                                            <span class="badge"></span>
                                            <input class="form-control" placeholder="Interest" id="interest" name="interest" type="text">
                                            <input type="text" name="action" value="int" hidden>
                                            <br>
                                            <input class="btn btn-lg btn-success btn-block" type="submit" id="login" value="Search »">

                                        </a>
                                    </form>
                                    <br>

                                    <?php

                                    if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action']=="int") {
                                       require 'vendor/autoload.php';
                                       $neo4j = new EndyJasmi\Neo4j;   

                                       $interest = $_POST['interest'];
                                       $query = 'match (:Interest {name:'."\"$interest\"".'})-[:LIKES]-(p) return collect(p.name) as k';
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

                                    if(!is_null($result)){
                                        $arr = $result[0]['k'];



                                        echo "<br>";

                                        foreach ($arr as  $value) {

                                            ?>
                                            
                                            <form action="./profile.php" method="POST">
                                                <button class="form-control" type="text" name="user" id="user" value="<?php echo $value; ?>" ><?php echo $value; ?></button>
                                                <br>
                                            </form>

                                            <?php
                                        }
                                    }


                                }
                                ?>



                            </div>
                        </div>
                    </div>
                </div>


                <div class="col-lg-4">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title"> Mutual Friends</h3>
                        </div>
                        <div class="panel-body">
                            <div class="list-group">


                               <form action="" method="POST">
                                <!--UPLOAD THE LIST HERE IN RECURSION-->
                                <a href="#" class="list-group-item">
                                    <span class="badge"></span>
                                    <input class="form-control" placeholder="Name of Friend" id="user2" name="user2" type="text">
                                    <input type="text" name="action" value="mutual" hidden>
                                    <br>
                                    <input class="btn btn-lg btn-success btn-block" type="submit" id="login" value="Search »">

                                </a>
                            </form>

                            <?php

                            if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action']=="mutual") {
                               require 'vendor/autoload.php';
                               $neo4j = new EndyJasmi\Neo4j;  

                               $user1 = $_SESSION['user']; 

                               $user2 = $_POST['user2'];
                               $query = 'match (:Person {username:'."\"$user1\"".'})-[:FRIEND_OF]-(n)-[:FRIEND_OF]-(:Person {username:'."\"$user2\"".'}) return collect(n.name) as m';
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

                            if(!is_null($result)){
                                $arr = $result[0]['m'];

                                echo "<br>";

                                foreach ($arr as  $value) {

                                    ?>

                                    <form action="./profile.php" method="POST">
                                        <button class="form-control" type="text" name="user" id="user" value="<?php echo $value; ?>" ><?php echo $value; ?></button>
                                        <br>
                                    </form>

                                    <?php
                                }
                            }


                        }
                        ?>



                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<script src="js/jquery.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/plugins/morris/raphael.min.js"></script>
<script src="js/plugins/morris/morris.min.js"></script>
<script src="js/plugins/morris/morris-data.js"></script>

</body>

</html>
