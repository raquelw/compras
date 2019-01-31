<?php

		
	include("../funciones.php");
	
	$matrizDatos=[];
	
	$uno=[trim($_REQUEST['producto1']),trim($_REQUEST['cantidad1'])];
	$dos=[trim($_REQUEST['producto2']),trim($_REQUEST['cantidad2'])];
	$tres=[trim($_REQUEST['producto3']),trim($_REQUEST['cantidad3'])];
	$cuatro=[trim($_REQUEST['producto4']),trim($_REQUEST['cantidad4'])];
	$cinco=[trim($_REQUEST['producto5']),trim($_REQUEST['cantidad5'])];		
	
	
	function introducirMatriz($seleccion){
		global $matrizDatos;		
		if($seleccion[0]!="defecto" && $seleccion[1]>0){
				comprobarRepetidos($seleccion);
				array_push($matrizDatos,$seleccion);
				
		}		
	}
	
	function comprobarMatriz(){
		global $matrizDatos;
		if(count($matrizDatos)==0){
			trigger_error("No has pedido nada");
			die();
		}
	}
	
	function comprobarRepetidos($seleccion){
		global $matrizDatos;
		for ($i=0;$i<count($matrizDatos);$i++){			
			if($seleccion[0]==$matrizDatos[$i][0]){
				echo $seleccion[0];
				trigger_error("Se repiten cosas");
				die();
			}	
		}		
	}
	
	function tramite($conexionMySQL){
		global $matrizDatos;	
		$numeroOrden=insertarOrden($conexionMySQL);
		echo "++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++</br>";
		for($i=0;$i<count($matrizDatos);$i++){
			$respuesta=mysqli_query($conexionMySQL,"select productName,quantityInStock
												from products
												where productName='".$matrizDatos[$i][0]."';");			
			$respuesta=mysqli_fetch_assoc($respuesta);
			if($respuesta['quantityInStock']<$matrizDatos[$i][1]){
				mysqli_rollback($conexionMySQL);
				trigger_error("No hay StocK del Producto ".$matrizDatos[$i][0]);
				die();				
			}else{
				insertarDetalles($conexionMySQL,$matrizDatos[$i],$numeroOrden,($i+1));
				actualizarProducto($conexionMySQL,$matrizDatos[$i]);	
				echo "-----------------------------------------------------------------";
			}
			echo "</br>";
		}
		mysqli_commit($conexionMySQL);		
	}
	
	function insertarOrden($conexionMySQL){
		$numero=mysqli_query($conexionMySQL,'select max(orderNumber) from orders;');
		$numero=mysqli_fetch_assoc($numero);
		$numero=$numero['max(orderNumber)'];
		$numero=(int)$numero+1;
		$valido=mysqli_query($conexionMySQL,'insert into orders (orderNumber,orderDate,requiredDate,shippedDate,status,comments,customerNumber)
											values ('.$numero.','.curdate().','.curdate().',null,"In Process",null,119);');
		if($valido==true){
			echo "Se ha añadido correctamente la ORDEN<br>";
		}else{
			echo "No se ha añadido correctamente la ORDEN<br>";
		}
		return $numero;
	}
	
	function curdate() {
		return date('Y-m-d');
	}
	
	function insertarDetalles($conexionMySQL,$datos,$numberOrder,$orderLineNumber){
		$sentencia=mysqli_query($conexionMySQL,'select productCode,buyPrice from products where productName="'.$datos[0].'";');	
		$sentencia=mysqli_fetch_assoc($sentencia);			
		$productCode=$sentencia['productCode'];
		$priceEach=$sentencia['buyPrice'];		
		
		$valido=mysqli_query($conexionMySQL,'insert into orderdetails (orderNumber,productCode,quantityOrdered,priceEach,orderLineNumber)
											values ('.$numberOrder.',"'.$sentencia['productCode'].'",'.$datos[1].',"'.$sentencia['buyPrice'].'",'.$orderLineNumber.');');
		if($valido==true){
			echo "Se ha añadido correctamente el producto ".$datos[0]."<br>";
		}else{
			echo "No se ha añadido correctamente el producto ".$datos[0]."<br>";
		}		
	
	}
	
	function actualizarProducto($conexionMySQL,$datos){
		$cantidadActual=mysqli_query($conexionMySQL,'select quantityInStock from products where productName="'.$datos[0].'";');
		$cantidadActual=mysqli_fetch_assoc($cantidadActual);
		$cantidadActual=$cantidadActual['quantityInStock'];
		$nuevaCantidad=(int)$cantidadActual-(int)$datos[1];
		$valido=mysqli_query($conexionMySQL,'update products set quantityInStock = '.$nuevaCantidad.' where  productName="'.$datos[0].'";');
		
		if($valido==true){
			echo "Se ha actualizado el Stock de ".$datos[0]."<br>";
		}else{
			echo "No se ha actualizado el Stock de ".$datos[0]."<br>";
		}	
	}
	
	//Inicio de la Conexion
	$conexionMySQL=inicarConexion();	
	
	//Recopilamos la informacion
	introducirMatriz($uno);
	introducirMatriz($dos);
	introducirMatriz($tres);
	introducirMatriz($cuatro);
	introducirMatriz($cinco);
	
	//Comprobamos la validez de los datos
	comprobarMatriz();
	
	//Lo llevamos acabo todo
	tramite($conexionMySQL);	
	
	//Cierre de conexion
	cierreConexion($conexionMySQL);
	
	





?>