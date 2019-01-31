<?php
	
	//Sesion iniciada
		session_start();
		// var_dump($_SESSION);

	// Sentencia MySQL que nos imprimira la tabla con los clientes
	function sentenciaMySQL($conexionMySQL,$numCustomer){
		$respuesta=mysqli_query($conexionMySQL,"select customers.customerName,orders.orderNumber,orders.orderDate,orders.status
												from customers,orders
												where customers.customerNumber=orders.customerNumber and
												customers.customerNumber=$numCustomer;");
									
		if(mysqli_num_rows($respuesta) > 0){			
			while($fila = mysqli_fetch_assoc($respuesta)){		
			// var_dump($fila);
			echo "<center><table style='border:3px  solid red;'>";
			echo "<tr>
					<td align='center' style='border:3px  solid red;'>$fila[customerName]</td>
					<td style='border:3px  solid red;'>$fila[orderNumber]</td>
					<td style='border:3px  solid red;'>$fila[orderDate]</td>
					<td style='border:3px  solid red;'>$fila[status]</td>
				</tr>";	
			echo "</table></center><br/>";
			cadaUnoDeLosPedidos($conexionMySQL,$fila['orderNumber']);
		}				
		}else{
			echo("No tiene pedidos o no existe el Cliente  ".$numCustomer);			
		}
	}
	
	function cadaUnoDeLosPedidos($conexionMySQL,$orderNumber){
		$respuesta=mysqli_query($conexionMySQL,"select orders.orderNumber, products.productName, orderdetails.quantityOrdered
												from orders,orderdetails,products
												where orders.orderNumber=orderdetails.orderNumber 
												and orderdetails.productCode=products.productCode
												and orders.orderNumber=$orderNumber;");
		
		if(mysqli_num_rows($respuesta) > 0){
			echo "<center><table style='border:3px  solid red;'>
			<tr >
				<td align='center' style='background-color:#F1948A;'>Nombre</td>
				<td align='center' style='background-color:#F1948A;'>Pedidos</td>
				<td align='center' style='background-color:#F1948A;'>Fecha</td>
				<td align='center' style='background-color:#F1948A;'>Estado</td>
			</tr>";
			while($fila = mysqli_fetch_assoc($respuesta)){		
			// var_dump($fila);
			echo "<tr>				
					<td align='center'>$fila[orderNumber]</td>
					<td>$fila[productName]</td>
					<td>$fila[quantityOrdered]</td>
				</tr>";	
		}
			echo "</table></center><br/>";	
		}	
	}
	
	include("../funciones.php");
	
	$numCustomer=trim($_SESSION['id_usuario']);
	
	$conexionMySQL=inicarConexion();
	sentenciaMySQL($conexionMySQL,$numCustomer);
	cierreConexion($conexionMySQL);
	
	





?>