<?php
	
	function mostrarStock($conexionMySQL,$codigoProducto){		
		$respuesta=mysqli_query($conexionMySQL,"select productName,productCode,quantityInStock
												from products
												where productCode='$codigoProducto';");
		if(mysqli_num_rows($respuesta)>0){
			$fila=mysqli_fetch_assoc($respuesta);
			echo "<center><table border='1'>
				<tr>
					<td><b>Producto</b></td>
					<td><b>Cantidad</b></td>
				</tr>
				<tr>
					<td align='center'>".$fila['productName']."</td>
					<td align='center'>".$fila['quantityInStock']."</td>
				</tr>
			
				</table></center>";			
		}else{
			trigger_error("No existe la clave del Producto");
			die();			
		}			
	}
	
	include("../funciones.php");	
	
	$codigoProducto=$_REQUEST['codigoProducto'];
	
	$conexionMySQL=inicarConexion();
	
	mostrarStock($conexionMySQL,$codigoProducto);
	
	cierreConexion($conexionMySQL);
?>