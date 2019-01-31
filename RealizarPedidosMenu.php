<?php
	include("../funciones.php");
	
	$conexionMySQL=inicarConexion();
	
	function sentencia($conexionMySQL){
		$respuesta=mysqli_query($conexionMySQL,'select products.productName
												from products;');
		return $respuesta;
	}
	
	function añadirProducto($conexionMySQL,$nombreProducto,$cantidad){
		
	}
?>
<html>
	<head>
		<style type="text/css">		
			form{
				width:80%;
				height:;
				margin:2% auto;
				background-color:white;
				text-align:center;
			}
			
			form > table{
				width:100%;
				color:black;
				border:1px solid white;
				
			}			
			.titulo {
				background-color:black;
				color:white;				
			}

			form table select{
				width:100%;
				height:100%;
			}
			
			
			
		</style>
	</head>
	<body style="background-color:#ebdaae;">			
		<form name="mi_formulario" action="RealizarPedidos.php" method="get">						
			<table >
				<tr>
					<td colspan="3" align="center" class="titulo"><font size="4"><i>Que compras..</i></font></td>
				</tr>
				<tr>
					<td><b><u></u>Producto y cantidad:</b></td>
					<td>
						<select name="producto1">								
								<?php
								$respuesta=sentencia($conexionMySQL);
								echo "<option value='defecto'>Seleccione..</option>";
								while($fila=mysqli_fetch_assoc($respuesta)){
									echo "<option>$fila[productName]</option>";
								}									
								?>
							
						</select>					
					<td><input type="number" name="cantidad5" value="0" style="width:100%;"></td>
				</tr>
				<tr>
					<td colspan="3" align="center"><input type="submit" name="anadir" value="Anadir Producto" style="width:33%;"><input type="submit" name="borrar" value="Borrar Carrito" style="width:33%;"><input type="submit" name="tramitar" value="Comprar Productos" style="width:33%;"></td>
				</tr>
			</table>								
		</form>		
	</body>
</html>