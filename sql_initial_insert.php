<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <h1>I AM HERE</h1>
    <div id="display"></div>
</head>
<body>






    <?php
 /**
  *     Put files in public_html reachable at: 
  *     http://box5859.temp.domains/~richmov8/zoom_games_db_connections.php
  * the more permanent one ??? http://box5859.temp.domains/~richmov8 ???

     * User: richmov8_larryvolz
     * pw: $zgZacNat123
     * Database: richmov8_zoom_games
     * 
     * Game marker: xid (unique for ea game), xdatestamp, xp0_id, xp1_id,xp2_id, xp0_score, xp1_score, xp2_score, 
     * xround_num, xcurr_player, xwinner(int 0-2)
     * cat0, cat0_row0_q, cat0_row0_a,  cat0_row1_q, cat0_row1_a, cat0_row2_q, cat0_row2_a,  cat0_row3_q, cat0_row3_a,  cat0_row4_q, cat0_row4_a,  
     * 
     * ...
     * ...cat5_row5 [total of 77!]
     * 
     * 
     * 
     */


    $categoryArray = "";
    //DONE: test hard-coded values updating db from this php file
    //DONE:  receive posted data
    //DONE: test single value posted to here from js and and then inserted into db

     if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $cat0 = test_input($_POST["cat0"]);
        $cat1 = test_input($_POST["cat1"]);
        $cat2 = test_input($_POST["cat2"]);
        $cat3 = test_input($_POST["cat3"]);
        $cat4 = test_input($_POST["cat4"]);
        $cat5 = test_input($_POST["cat5"]);

        $cat0_row0_q = $_POST["cat0_row0_q"];
        $cat0_row1_q = $_POST["cat0_row1_q"];
        $cat0_row2_q = $_POST["cat0_row2_q"];
        $cat0_row3_q = $_POST["cat0_row3_q"];
        $cat0_row4_q = $_POST["cat0_row4_q"];
        
        $cat1_row0_q = $_POST["cat1_row0_q"];
        $cat1_row1_q = $_POST["cat1_row1_q"];
        $cat1_row2_q = $_POST["cat1_row2_q"];
        $cat1_row3_q = $_POST["cat1_row3_q"];
        $cat1_row4_q = $_POST["cat1_row4_q"];

        $cat2_row0_q = $_POST["cat2_row0_q"];
        $cat2_row1_q = $_POST["cat2_row1_q"];
        $cat2_row2_q = $_POST["cat2_row2_q"];
        $cat2_row3_q = $_POST["cat2_row3_q"];
        $cat2_row4_q = $_POST["cat2_row4_q"];

        $cat3_row0_q = $_POST["cat3_row0_q"];
        $cat3_row1_q = $_POST["cat3_row1_q"];
        $cat3_row2_q = $_POST["cat3_row2_q"];
        $cat3_row3_q = $_POST["cat3_row3_q"];
        $cat3_row4_q = $_POST["cat3_row4_q"];

        $cat4_row0_q = $_POST["cat4_row0_q"];
        $cat4_row1_q = $_POST["cat4_row1_q"];
        $cat4_row2_q = $_POST["cat4_row2_q"];
        $cat4_row3_q = $_POST["cat4_row3_q"];
        $cat4_row4_q = $_POST["cat4_row4_q"];
       
        $cat5_row0_q = $_POST["cat5_row0_q"];
        $cat5_row1_q = $_POST["cat5_row1_q"];
        $cat5_row2_q = $_POST["cat5_row2_q"];
        $cat5_row3_q = $_POST["cat5_row3_q"];
        $cat5_row4_q = $_POST["cat5_row4_q"];


        $cat0_row0_a = $_POST["cat0_row0_a"];
        $cat0_row1_a = $_POST["cat0_row1_a"];
        $cat0_row2_a = $_POST["cat0_row2_a"];
        $cat0_row3_a = $_POST["cat0_row3_a"];
        $cat0_row4_a = $_POST["cat0_row4_a"];
        
        $cat1_row0_a = $_POST["cat1_row0_a"];
        $cat1_row1_a = $_POST["cat1_row1_a"];
        $cat1_row2_a = $_POST["cat1_row2_a"];
        $cat1_row3_a = $_POST["cat1_row3_a"];
        $cat1_row4_a = $_POST["cat1_row4_a"];

        $cat2_row0_a = $_POST["cat2_row0_a"];
        $cat2_row1_a = $_POST["cat2_row1_a"];
        $cat2_row2_a = $_POST["cat2_row2_a"];
        $cat2_row3_a = $_POST["cat2_row3_a"];
        $cat2_row4_a = $_POST["cat2_row4_a"];

        $cat3_row0_a = $_POST["cat3_row0_a"];
        $cat3_row1_a = $_POST["cat3_row1_a"];
        $cat3_row2_a = $_POST["cat3_row2_a"];
        $cat3_row3_a = $_POST["cat3_row3_a"];
        $cat3_row4_a = $_POST["cat3_row4_a"];

        $cat4_row0_a = $_POST["cat4_row0_a"];
        $cat4_row1_a = $_POST["cat4_row1_a"];
        $cat4_row2_a = $_POST["cat4_row2_a"];
        $cat4_row3_a = $_POST["cat4_row3_a"];
        $cat4_row4_a = $_POST["cat4_row4_a"];
       
        $cat5_row0_a = $_POST["cat5_row0_a"];
        $cat5_row1_a = $_POST["cat5_row1_a"];
        $cat5_row2_a = $_POST["cat5_row2_a"];
        $cat5_row3_a = $_POST["cat5_row3_a"];
        $cat5_row4_a = $_POST["cat5_row4_a"];

        $link = connect_to_server();

        
        $sql = "INSERT INTO game_marker_jeopardy (
            cat0, cat1, cat2, cat3, cat4, cat5, 
            cat0_row0_q, cat0_row1_q, cat0_row2_q, cat0_row3_q, cat0_row4_q, 
            cat1_row0_q, cat1_row1_q, cat1_row2_q, cat1_row3_q, cat1_row4_q, 
            cat2_row0_q, cat2_row1_q, cat2_row2_q, cat2_row3_q, cat2_row4_q, 
            cat3_row0_q, cat3_row1_q, cat3_row2_q, cat3_row3_q, cat3_row4_q, 
            cat4_row0_q, cat4_row1_q, cat4_row2_q, cat4_row3_q, cat4_row4_q, 
            cat5_row0_q, cat5_row1_q, cat5_row2_q, cat5_row3_q, cat5_row4_q, 
            cat0_row0_a, cat0_row1_a, cat0_row2_a, cat0_row3_a, cat0_row4_a, 
            cat1_row0_a, cat1_row1_a, cat1_row2_a, cat1_row3_a, cat1_row4_a, 
            cat2_row0_a, cat2_row1_a, cat2_row2_a, cat2_row3_a, cat2_row4_a, 
            cat3_row0_a, cat3_row1_a, cat3_row2_a, cat3_row3_a, cat3_row4_a, 
            cat4_row0_a, cat4_row1_a, cat4_row2_a, cat4_row3_a, cat4_row4_a, 
            cat5_row0_a, cat5_row1_a, cat5_row2_a, cat5_row3_a, cat5_row4_a) VALUES (
            '$cat0','$cat1','$cat2','$cat3','$cat4','$cat5',
            '$cat0_row0_q', '$cat0_row1_q', '$cat0_row2_q', '$cat0_row3_q', '$cat0_row4_q',
            '$cat1_row0_q', '$cat1_row1_q', '$cat1_row2_q', '$cat1_row3_q', '$cat1_row4_q',
            '$cat2_row0_q', '$cat2_row1_q', '$cat2_row2_q', '$cat2_row3_q', '$cat2_row4_q', 
            '$cat3_row0_q', '$cat3_row1_q', '$cat3_row2_q', '$cat3_row3_q', '$cat3_row4_q', 
            '$cat4_row0_q', '$cat4_row1_q', '$cat4_row2_q', '$cat4_row3_q', '$cat4_row4_q', 
            '$cat5_row0_q', '$cat5_row1_q', '$cat5_row2_q', '$cat5_row3_q', '$cat5_row4_q',
            '$cat0_row0_a', '$cat0_row1_a', '$cat0_row2_a', '$cat0_row3_a', '$cat0_row4_a',
            '$cat1_row0_a', '$cat1_row1_a', '$cat1_row2_a', '$cat1_row3_a', '$cat1_row4_a',
            '$cat2_row0_a', '$cat2_row1_a', '$cat2_row2_a', '$cat2_row3_a', '$cat2_row4_a', 
            '$cat3_row0_a', '$cat3_row1_a', '$cat3_row2_a', '$cat3_row3_a', '$cat3_row4_a', 
            '$cat4_row0_a', '$cat4_row1_a', '$cat4_row2_a', '$cat4_row3_a', '$cat4_row4_a', 
            '$cat5_row0_a', '$cat5_row1_a', '$cat5_row2_a', '$cat5_row3_a', '$cat5_row4_a')";

        //hard code test
        // $sql = "INSERT INTO game_marker_jeopardy (cat0, cat1, cat2, cat3, cat4, cat5) VALUES (0,1,2,3,4,5)";

        insertIntoTable($link, $sql);

      }
      
      function test_input($data) {
        // $data = stripslashes($data);
        // $data = htmlspecialchars($data);
        return $data;
      }

      

    
      //TODO: test arrays sent here and inserted into db
      //TODO: test php file sending simple streaming data
     //TODO: test index to listen for simple HTML5 Server-Sent event
     //TODO: test sending simple data to db
     //TODO: code it for full data
     //TODO: write code to send that to the table instead of doing 
     //TODO: pull data from database and send to web page

     


    function insertIntoTable($link, $sql) {
        if (mysqli_query($link, $sql)) {
            // echo "<p>New record created successfully in: client table</p>";
           } else {
             echo "Error: " . $sql . "<br>" . mysqli_error($link);
           }
    }


    function connect_to_server(){
        /**
         * links to server and database and returns the link
         */
            
        $servername = "localhost";
        $username = "richmov8_larryvolz";
        $password = "zgZacNat123";
        $dbname = "richmov8_zoom_games";

        // define("DB_HOST", "localhost");
        // define("DB_USER", "root");
        // define("DB_PASSWORD", "");
        // define("DB_DATABASE", "databasename");

        
        //  echo "ATTEMPTING TO CONNECT<br>";
        
        //CONNECT TO DATABASE
        //global $link;

        echo "ATTEMPTING TO CONNECT<br>";
        
        $link=mysqli_connect ($servername, $username, $password);
        // $link=mysqli_connect (DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

        
        //return error if no connection
        if (!$link){
            die("Connection failed: " . mysqli_connect_error());
        }
        //otherwise confirm success
        echo "<p>Server connected successfully</p>";
        
        //select database
        mysqli_select_db($link, $dbname);
        
        return $link;

        echo ("Reached the PHP file");
        
    }

    

    ?>
</body>
</html>