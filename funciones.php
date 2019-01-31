<?php
	// set_error_handler("errores");
	
	//Errores
	function errores($error_level,$error_message){
			echo "<div style='border:6px double red;width:60%;margin:5% 20% 5% 20%;'>Codigo: ".$error_level." /",$error_message."</div>";
			echo '<center><a href="../index.html">Atras</a></center>';
			die();			
	}

	// Iniciar Conexion con la Base de Datos
	function inicarConexion(){
		
		// Parametros para la Base de Datos
		$servername="localhost";
		$usuario="root";
		$contrasena="rootroot";
		$baseDatos="classicmodels";
		
		$conexionMySQL=mysqli_connect($servername,$usuario,$contrasena,$baseDatos);		
		return $conexionMySQL;
	}
	
	
	// Cierre Conexion con la Base de Datos
	function cierreConexion($conexionMySQL){
		mysqli_close($conexionMySQL);
	}
	
	
	
	
	
	




?>

