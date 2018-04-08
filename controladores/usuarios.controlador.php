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

	/*=======================================
	=            CREAR USUARIO            =
	=======================================*/
	
	public function ctrCrearUsuario() {
		if(isset($_POST["nuevoUsuario"])) {
			if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["nuevoNombre"]) &&
				preg_match('/^[a-zA-Z0-9]+$/', $_POST["nuevoUsuario"]) &&
				preg_match('/^[a-zA-Z0-9]+$/', $_POST["nuevoPassword"])) {

				$tabla = "usuarios";

				$datos = array("nombre" => $_POST["nuevoNombre"],
						"usuario" => $_POST["nuevoUsuario"],
						"password" => $_POST["nuevoPassword"],
						"perfil" => $_POST["nuevoPerfil"]);

				$respuesta = ModeloUsuarios::mdlIngresarUsuario($tabla, $datos);

				if($respuesta == "ok") {
					echo '<script>
					swal({
						type: "success",
						title: "¡El usuario se guardó correctamente!",
						showConfirmButton: true,
						confirmButtonText: "Cerrar",
						closeOnConfirm: false						
					}).then((result)=> {
						if(result.value){
							window.location = "usuarios";
						}
					});
					</script>';
				}
			}
			else {
			echo '<script>
					swal({
						type: "error",
						title: "¡El usuario no puede ir vacío o llevar caracteres especiales!",
						showConfirmButton: true,
						confirmButtonText: "Cerrar",
						closeOnConfirm: false						
					}).then((result)=> {
						if(result.value){
							window.location = "usuarios";
						}
					});
					</script>';
		}
		}

		}

}

?>