<?php

	function mostrarStock($conexionMySQL){		
		$respuesta=mysqli_query($conexionMySQL,"select productName,productCode,quantityInStock
												from products 
												order by quantityInStock desc;");
		
		echo "<center><table border='1'>
				<tr>
					<td><b>Producto</b></td>
					<td><b>Cantidad</b></td>
				</tr>";
		
		while($fila=mysqli_fetch_assoc($respuesta)){
			
				echo "<tr>
						<td align='center'>".$fila['productName']."</td>
						<td align='center'>".$fila['quantityInStock']."</td>
					</tr>";
			
				
		}
		echo "</table></center>";	
	}
	
	include("../funciones.php");
	
	$conexionMySQL=inicarConexion();
	
	mostrarStock($conexionMySQL);
	
	cierreConexion($conexionMySQL);



?>