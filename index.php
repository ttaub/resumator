<?php 

  ob_start();   

  include('db.php');

  if( isset($_POST['doc_id']) ) {

    $db->submit_all( $_POST );

    header("Location:http://www.localhost:8888/resumator/stats.php");

    echo "this should have been a redirect";
    
  } 

?>

<!doctype html>

<html lang="en">
<head>
  <meta charset="utf-8">

  <title>Resumator</title>
  <meta name="description" content="Resumator Inc">
  <meta name="author" content="Resumator">

  <!-- include in head to initialize TimeMe -->
  <script src="js/ifvisible.js"></script>
  <script src="js/timeme.js"></script>
  <script type="text/javascript">

    TimeMe.setIdleDurationInSeconds(30);
    TimeMe.setCurrentPageName("my-home-page");
    TimeMe.initialize(); 

  </script>

 </head>

<body>

  <div style="height:600px;width:400px;background: red;" class="heatmap" onclick="heatMyMap()" onmousemove="handleMouseMove()">Move the cursor below me and click to see result</div>

  <form action="index.php" id="resume_form" method="post">

  	Would this person get hired by google?
  	<input type="radio" name="google" value="yes">Yes 
    <input type="radio" name="google" value="no"> No

    <br />
    <br />
    What do you think this persons salary should be? <br />
    <input type="radio" name="salary" value="40000">$40,000 <br />
    <input type="radio" name="salary" value="50000">$50,000 <br />
    <input type="radio" name="salary" value="60000">$60,000 <br />
    <input type="radio" name="salary" value="70000">$70,000 <br />
    <input type="radio" name="salary" value="80000">$80,000 <br />
    <input type="radio" name="salary" value="100000">$100,000 + <br />

    <input type="hidden" name="doc_id" value="1" />

    <!-- <input type="text" name="links[google]" />
    <input type="text" name="links[facebook]" /> -->
    
    
    <a href="http://tomtaubkin.me" class="tracked_link" target="_blank"> Blog </a>
    <a href="http://github.com/ttaub" class="tracked_link" target="_blank"> Github </a>
  
  </form>

  <button id="resume_submit"> Submit Your Resume </button>


  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
  <script src="js/heatmap.js"></script>
  <script src="js/tracking.js"></script>
</body>
</html>