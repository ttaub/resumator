<?php 

include('db.php');

?>

<!doctype html>

<html lang="en">
<head>
  <meta charset="utf-8">

  <title>Resumator</title>
  <meta name="description" content="The resumator">
  <meta name="author" content="Resumator">

  <!-- <link rel="stylesheet" href="css/styles.css?v=1.0"> -->

  <!--[if lt IE 9]>
  <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
  <![endif]-->
</head>

<body>

  <form action="stats.php" id="resume_form" method="post">

  	Would this person get hired by google?
  	<input type="checkbox" name="google" value="yes">Yes 
    <input type="checkbox" name="google" value="no"> No

    <br />
    What do you think this persons salary should be? <br />
    <input type="checkbox" name="salary" value="40000">$40,000 <br />
    <input type="checkbox" name="salary" value="50000">$50,000 <br />
    <input type="checkbox" name="salary" value="60000">$60,000 <br />
    <input type="checkbox" name="salary" value="70000">$70,000 <br />
    <input type="checkbox" name="salary" value="80000">$80,000 <br />
    <input type="checkbox" name="salary" value="100000">$100,000 + <br />
    
    
    <a href="http://tomtaubkin.me" class="tracked_link" target="_blank"> Blog </a>
    <a href="http://github.com/ttaub" class="tracked_link" target="_blank"> Github </a>


  </form>

  <button id="resume_submit"> Submit Your Resume </button>


  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
  <script type="text/javascript">

    var page_clicks = {};

    function add_to_form( formId, name, data ) {

      $('<input />').attr('type', 'hidden')
      .attr('name', name)
      .attr('value', data)
      .appendTo( formId );
    }

    $( document ).ready(function() {
    	
      $('.tracked_link').click(function(){

        var href = this.href;

        if( page_clicks[ href ] === undefined ) {

          page_clicks[ "" + href ] = 1; 

        } else {

          page_clicks[ "" + href ] += 1; 
        }
    
      });

      var time = 111;
      var tracking_points = [];


      $( "#resume_submit" ).click(function() {

        add_to_form('#resume_form', 'points', JSON.stringify(tracking_points));
        add_to_form('#resume_form', 'time', time);
        add_to_form('#resume_form', 'links', JSON.stringify(page_clicks));

        //console.log($('#resume_form').serialize());
       $("#resume_form").submit();

     });
    });

  </script>
</body>
</html>