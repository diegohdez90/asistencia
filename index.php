<!DOCTYPE html>
  <head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
    <meta http-equiv="content-type" content="text/html; charset=utf-8 "/>
    <title>Asistencia</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script><link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
	<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<style type="text/css">

	.jumbotron{
		padding-top: 10%;
	}
</style>
<?php

	$servername = "localhost";
	$user = "root";
	$pwd = "veotek";
	$db = "veotek3";


	$my_sql_conn =  new mysqli($servername,$user,$pwd,$db);

    $fechas = array();
    $result = $my_sql_conn->query("select dia_entrada as dia, count(*) as empleados from horario where dia_entrada>='2015-12-12' group by dia_entrada");

    while($rs = $result->fetch_array(MYSQLI_ASSOC)){
      $fechas[$rs['dia']] = $rs['empleados']; 
    }



?>

  </head>

  <body>

  	<nav class="navbar navbar-inverse navbar-fixed-top">
        <div class="container-fluid">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myMenu">
            </button>
            <a class="navbar-brand" href="index.html">Proyectos</a>
          </div>
          <div class="collapse navbar-collapse" id="myMenu">
            <ul class="nav navbar-nav">
              <li class="active"><a href="index.html"><p class="text-center"><i class="material-icons">home</i></p><p class="text-center">Inicio</p></a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right veoteimg">
            </ul>
          </div>
        </div>
      </nav>
  	<div class="jumbotron">
  		<div class="container">
  			<div class="row">
		        <div id="chart_div"></div>
		    </div>
  		</div>
  	</div>
  </body>

  <script type="text/javascript">
google.charts.load('current', {packages: ['corechart', 'line']});
google.charts.setOnLoadCallback(drawBackgroundColor);

function drawBackgroundColor() {
      var data = new google.visualization.DataTable();
      data.addColumn('date', 'Dia');
      data.addColumn('number', 'Empleados');

      data.addRows([
        <?php
          foreach ($fechas as $key => $value) {
            $annio = substr($key, 0,4);
            $mes = substr($key, 5,2);
            $dia = substr($key, 8,2);
        ?>
          [new Date(<?php echo $annio;?>,<?php echo $mes-1;?>,<?php echo $dia;?>),<?php echo $value;?>],
        <?php    
          } 

        ?>
      ]);

      var options = {
      	title: 'Empleados registrados por dia',
        height: 600,
        hAxis: {
          title: 'Dia'
        },
        vAxis: {
          title: 'Empleados'
        },
        backgroundColor: '#f1f8e9'
      };

      var chart = new google.visualization.LineChart(document.getElementById('chart_div'));
      chart.draw(data, options);
    }
  </script>
