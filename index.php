<html>
	<head>
		<meta charset="UTF-8">
		<link rel="stylesheet" href="css/bootstrap.min.css"/>
		<link rel="stylesheet" href="css/style.css"/>
		<title>RANK</title>
	</head>
	
	<body>
	
		<?php

			header("Content-Type: text/html; charset=ISO-8859-1",true);
			
			//SqlServer Connection
			$dbhost   = "localhost";   
			$db       = "RF_WORLD";   
			$user     = "rf"; 
			$password = "12345";  
		    $imgSrc = "";
			$serverName = "localhost"; 
			$connectionInfo = array( "Database"=>$db, "UID"=>$user, "PWD"=>$password);
			$conn = sqlsrv_connect( $serverName, $connectionInfo);

			if( $conn ) {
				 //echo "Connection established.<br />";
			}else{
				 //echo "Connection could not be established.<br />";
				 die( print_r( sqlsrv_errors(), true));
			}
			//SQL DATA SEARCH
			$sqlPvpRankToday = "SELECT TOP 100
								  tb.Serial
								  ,tb.Name
								  ,tb.Lv
								  ,tp.[Kill]
								  ,tp.Death
								  ,tp.[PvpPoint]
								  ,PvpTempCash
								  ,tb.Race
								  ,tb.Lv
								FROM tbl_pvporderview as tp
								LEFT JOIN 
									tbl_base as tb ON tp.serial = tb.Serial 
								ORDER BY PvpTempCash DESC
						";
						
			$params = array();
			$options = array("Scrollable" => SQLSRV_CURSOR_KEYSET);
			$selectPvpRankToday = sqlsrv_query($conn, $sqlPvpRankToday, $params, $options);

			//SQL ERROR OUTPUT 
			if( $selectPvpRankToday === false ) {
				die( print_r( sqlsrv_errors(), true));
			}
			
			//------------------------------------------------------------------------------------------------------------------//
		?>
		<table class="table table-striped" >
		  <thead class="thead-dark">
			<tr align="center">
			  <th scope="col">RANK</th>
			  <th scope="col">NAME</th>
			  <th scope="col">RACE</th>
			  <th scope="col">LEVEL</th>
			  <th scope="col">KILL</th>
			  <th scope="col">DEATH</th>
			  <th scope="col">PVP POINT</th>
			  <th scope="col">TEMPORARY POINT</th>
			</tr>
		  </thead>
		  <tbody>
		  <?php 	
			
			$numRow = 0;
			
			//SQL READ DATA 
			
			while ($line = sqlsrv_fetch_array($selectPvpRankToday, SQLSRV_FETCH_ASSOC)) 
			{
				$name = $line["Name"];
				$race = $line["Race"];
				$serial = $line["Serial"];
				$level = $line["Lv"];
				$kill = $line["Kill"];
				$death = $line["Death"];
				$pvpPoint = $line["PvpPoint"];
				$temporaryPoint = $line["PvpTempCash"];
				$numRow++;
				$imgSrc = "";
				$raceName = "";
				
				if($race == 4){
					$raceName = "Accretia";
					$imgSrc = "viewer/img/acc.jpg";
				}
				if($race == 0 || $race == 1){
					$raceName = "Bellato";
					$imgSrc = "viewer/img/bell.jpg";
				}
				if($race == 2 || $race == 3){
					$raceName = "Cora";
					$imgSrc = "viewer/img/cora.jpg";
				}	
			?>
			
			
			<tr align="center">
			  <th scope="row">
				  <?php echo $numRow; ?> 
			  </th>
			  
			  <td id="tdName">
				  <?php echo $name; ?>
			  </td>
			  
			  <td id="tdRace">
			     <?php //echo $raceName; ?>
				 <img src="<?php echo $imgSrc; ?>" alt="<?php echo $raceName; ?>" title="<?php echo $raceName; ?>"></img>
			  </td>
			  
			  <td>
				  <?php echo $level; ?>
			  </td>
			  
			   <td>
				  <?php echo $kill; ?>
			  </td>
			  
			   <td>
				  <?php echo $death; ?>
			  </td>
			  
			 <td>
				  <?php echo $pvpPoint; ?>
			  </td>
			  
			  <td>
				  <?php echo $temporaryPoint; ?>
			  </td>
			 
			</tr>
			<?php 
				}
			?>
		  </tbody>
		</table>
	
	</body>
	
</html>