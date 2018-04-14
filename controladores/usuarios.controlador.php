<?php

class ControladorUsuarios {

	/*=======================================
	=            INGRESO USUARIO            =
	=======================================*/
	
	public function ctrIngresoUsuario() {

		if(isset($_POST['ingresoUsuario']) && isset($_POST['ingresoPassword'])) {

			if(preg_match('/^[a-zA-Z0-9]+$/', $_POST['ingresoUsuario']) &&
			   preg_match('/^[a-zA-Z0-9]+$/', $_POST['ingresoPassword'])) {

			   	$encriptar = crypt($_POST['ingresoPassword'],'$2a$07$usesomesillystringforsalt$');
				
				$tabla = "usuarios";

				$item = "usuario";

				$valor = $_POST['ingresoUsuario'];

				$respuesta = ModeloUsuarios::MdlMostrarUsuarios($tabla, $item, $valor);

				if($respuesta["usuario"] == $_POST["ingresoUsuario"] &&
				   $respuesta["password"] == $encriptar) {

				   	$_SESSION["iniciarSesion"] = "ok";
				    $_SESSION["id"] = $respuesta["id"];
				    $_SESSION["nombre"] = $respuesta["nombre"];
				    $_SESSION["usuario"] = $respuesta["usuario"];
				    $_SESSION["foto"] = $respuesta["foto"];
				    $_SESSION["perfil"] = $respuesta["perfil"];

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

				/*======================================
				=            VALIDAR IMAGEN            =
				======================================*/
				$ruta = "";

				if(isset($_FILES["nuevaFoto"]["tmp_name"])) {

					list($ancho, $alto) = getimagesize($_FILES["nuevaFoto"]["tmp_name"]);
					
					$nuevoAncho = 500;
					$nuevoAlto = 500;

					/*===========================================================
					=            CREAR EL DIRECTORIO PARA EL USUARIO            =
					===========================================================*/
					
					$directorio = "vistas/img/usuarios/".$_POST["nuevoUsuario"];

					mkdir($directorio,0755);

					/*=============================================================================
					=            SE APLICAN LAS FUNCIONES DE ACUERDO AL TIPO DE IMAGEN            =
					=============================================================================*/

					if($_FILES["nuevaFoto"]["type"] == "image/jpeg") {

						$aleatorio = mt_rand(100,999);

						$ruta = "vistas/img/usuarios/".$_POST["nuevoUsuario"]."/".$aleatorio.".jpg";

						$origen = imagecreatefromjpeg($_FILES["nuevaFoto"]["tmp_name"]);

						$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

						imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);

						imagejpeg($destino, $ruta);

					}
					if($_FILES["nuevaFoto"]["type"] == "image/png") {

						$aleatorio = mt_rand(100,999);

						$ruta = "vistas/img/usuarios/".$_POST["nuevoUsuario"]."/".$aleatorio.".png";

						$origen = imagecreatefrompng($_FILES["nuevaFoto"]["tmp_name"]);

						$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

						imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);

						imagepng($destino, $ruta);

					}
					
				}

				$tabla = "usuarios";

				$encriptar = crypt($_POST["nuevoPassword"],'$2a$07$usesomesillystringforsalt$');

				$datos = array("nombre" => $_POST["nuevoNombre"],
						"usuario" => $_POST["nuevoUsuario"],
						"password" => $encriptar,
						"perfil" => $_POST["nuevoPerfil"],
						"foto" => $ruta);

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

	/*=======================================
	=            MOSTRAR USUARIO            =
	=======================================*/
	
	static public function ctrMostrarUsuarios($item, $valor) {

		$tabla = "usuarios";
		$respuesta = ModeloUsuarios::MdlMostrarUsuarios($tabla, $item, $valor);

		return $respuesta;

	}

}

?>