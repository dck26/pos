<?php

class ControladorUsuarios {

	/*=======================================
	=            INGRESO USUARIO            =
	=======================================*/
	
	public function ctrIngresoUsuario() {

		if(isset($_POST['ingresoUsuario']) && isset($_POST['ingresoPassword'])) {

			if(preg_match('/^[a-zA-Z0-9]+$/', $_POST['ingresoUsuario']) &&
			   preg_match('/^[a-zA-Z0-9]+$/', $_POST['ingresoPassword'])) {
				
				$tabla = "usuarios";

				$item = "usuario";

				$valor = $_POST['ingresoUsuario'];

				$respuesta = ModeloUsuarios::MdlMostrarUsuarios($tabla, $item, $valor);

				if($respuesta["usuario"] == $_POST["ingresoUsuario"] &&
				   $respuesta["password"] == $_POST["ingresoPassword"]) {

				   	$_SESSION["iniciarSesion"] = "ok";

				   echo '<script>
				   			window.location = "inicio";
				   		</script>';

				}
				else {

					echo '<br><div class="alert alert-danger">Error al ingresar. Vuelve a intentar.</div>';
				
				}

			}


		}
	}

}

?>