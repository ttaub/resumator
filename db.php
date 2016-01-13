<?php

include('config.php');

class db {

	////////// CREATE THE CONNECTION
	
	private $conn = Null;

	function __construct( $servername, $username, $password, $dbname ) {
		
		// Create connection
		$this->conn = mysqli_connect($servername, $username, $password, $dbname);

		// Check connection
		if (!$this->conn) {
		    die("Connection failed: " . mysqli_connect_error());
		} else {
			//echo("Connection Succesful");
		}	

	}

	////////// GENERAL HELPERS
	
	public function safe_select( $sql ) {
		
		$result = $this->conn->query( $sql );

		if ($result->num_rows > 0) {

		    $data = [];

			while($row = $result->fetch_assoc()) {
				
				array_push($data, $row);
			}

			return $data;

		} else {

		    return false;
		}

	}

	function test() {

		echo "test";

	}

	////////// FORM SUBMISSION FUNCTIONS
	
	function submit_all( $form ) {

		//$this->test();
		
		$this->submit_count( $form['doc_id'] );

		$this->submit_polls( $form['doc_id'], $form['google'], $form['salary'] );

		$this->submit_metrics( $form['doc_id'], $form['time_spent'], $form['histo'] );

		if( isset( $form['links']) ) {

			$this->submit_links( $form['doc_id'], $form['links'] );

		}

	}

	protected function submit_count( $doc_id ) {

		$sql = "UPDATE resume SET submit_count = submit_count + 1 WHERE id = {$doc_id};";

		$this->conn->query( $sql );

	}

	protected function submit_polls( $doc_id, $google, $salary ) {

		$sql = "INSERT INTO resumator.polls (doc_id, question, response) VALUES";

		$sql .= "(" . $doc_id . " , 'Would google hire this person?', '" . $google . "'),";

		$sql .= "(" . $doc_id . " , 'What would their salary be?', '" . $salary . "');";

		$this->conn->query( $sql );

	}

	protected function submit_metrics( $doc_id, $time_spent, $histo ) {

		$sql = "INSERT INTO resumator.metrics (doc_id, time_spent, histo)";

		$sql .= "VALUES (" . $doc_id . " , " . $time_spent . ", '" . $histo . "');";

		$this->conn->query( $sql );

	}

	protected function submit_links( $doc_id, $links ) {

		foreach ( array_keys($links) as $key ) {

			$sql = "SELECT * FROM links WHERE name = '" . $key . "' LIMIT 1;";

			$result = db::safe_select( $sql )[0];

			if( is_array( $result) ) {

				//print_r($result);

				$clicks = $result['clicks'] + $links[$key];
				
				$sql = "UPDATE resumator.links SET clicks = " . $clicks . " WHERE links.link_id = " . $result['link_id'] . ";";

			} else {

				$sql = "INSERT INTO resumator.links (doc_id, name, clicks) VALUES";

				$sql .= "(" . $doc_id . ",'" . $key . "'," . $links[$key] . ");";
			}
		}

		$this->conn->query( $sql );

	}

	/////////// DATABASE DATA FUNCTIONS
	
	function select_doc( $doc_id ) {

		$data = [];

		$data['histo'] = $this->select_histo( $doc_id );
		$data['polls'] = $this->select_polls( $doc_id );
		$data['time_spent'] = $this->select_time_spent( $doc_id );
		$data['links'] = $this->select_links( $doc_id );
		
		print_r( $data );

		return $data;

	}

	public function select_histo( $doc_id ) {

		$histo = "";

		$sql = "SELECT histo FROM metrics WHERE doc_id = {$doc_id};";

		$result = db::safe_select( $sql );

		if( is_array($result) ) {

			foreach( $result as $val) {

				$histo .= $val['histo']; 

			}

		} else {

			die("histo could not be selected");
		}
		
		return $histo;

	}

	public function select_polls( $doc_id ) {

		$polls = "";

		$sql = "SELECT * FROM polls WHERE doc_id = {$doc_id};";

		$result = db::safe_select( $sql );

		print_r( $result );

		if( is_array($result) ) {

			foreach( $result as $val ) {

				$question = $val['question'];
				$response = $val['response'];

				if( isset($polls[ $question ][ $response ]) ) {

					$polls[ $question ][ $response ] += 1;
			
				} else {

					$polls[ $question ][ $response ] = 1;
				}
			}

		} else {

			die("polls could not be selected");
		}

		return $polls;	

	}

	public function select_time_spent( $doc_id ) {
		
		$sql = "SELECT avg(time_spent) FROM metrics WHERE doc_id = {$doc_id};";

		$result = db::safe_select( $sql );

		return $result[0]['avg(time_spent)'];

	}

	public function select_links( $doc_id ) {

		$links = [];
		
		$sql = "SELECT submit_count FROM resume WHERE id = {$doc_id}";

		$result = db::safe_select( $sql );

		$total = $result[0]['submit_count'];

		$sql = "SELECT * FROM links WHERE doc_id = {$doc_id}";

		$result = db::safe_select( $sql );

		if( $result != false ) {
			foreach( $result as $val ) {

				$links[ $val['name'] ] = $val['clicks'] / $total;
			}
		}

		//print_r( $links );

		return $links;
 	}


}

$db = new db( $servername, $username, $password, $dbname );






 
 
