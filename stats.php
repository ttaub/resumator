
<?php

include('db.php');

$result = $db->select_doc( 1 );

echo json_encode( $result );


?>

<html>
<head>
	<title> A/B testing statistics </title>

	<script type="text/javascript"> 
		var data = <?php echo json_encode( $result ); ?>
		console.log( data ); 
	</script>	
</head>
<body>

  <div style="height:600px;width:400px;background: #999;" class="heatmap" onclick="heatMyMap()" onmousemove="handleMouseMove()">Move the cursor below me and click to see result</div>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
  <script src="js/heatmap.js"></script>
  <script src="js/tracking.js"></script>

</body>
</html>




