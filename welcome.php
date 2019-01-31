<?php
	include('session.php');
  
	function inactividadSesion(){
		
		// Establecer tiempo de vida de la sesión en segundos
		$inactividad = 60;
		// Comprobar si $_SESSION["timeout"] está establecida
		if(isset($_SESSION["timeout"])){
			// Calcular el tiempo de vida de la sesión (TTL = Time To Live)
			$sessionTTL = time() - $_SESSION["timeout"];
			if($sessionTTL > $inactividad){
				session_destroy();
				header("Location: login.php");
			}
		}
		// El siguiente key se crea cuando se inicia sesión
		$_SESSION["timeout"] = time();
	}
	
	inactividadSesion();
?>
<html">
   
   <head>
      <title>Welcome </title>
   </head>
   
   <body>
      <h1>Bienvenido <?php echo $login_session; ?></h1> 
	  
	  
	  <nav class="dropdownmenu">
  <ul>
    <li><a href="../RealizarPedidos/RealizarPedidosMenu.php">Hacer Pedido</a></li>
    <li><a href="../PedidosDeCliente/PedidosClientes.php">Mis pedidos</a>
      <ul id="submenu">
        <li><a href="">Consultar Pedidos</a></li>
        <li><a href="">Consultar por fechas</a></li>      </ul>
    </li>
    <li><a href="">Listado Productos</a></li>
  
  </ul>
</nav>
	  
	  
	  
      <h2><a href = "logout.php">Cerrar Sesion</a></h2>
   </body>
   
</html>