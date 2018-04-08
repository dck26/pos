<?php

require_once "conexion.php";

class ModeloUsuarios {

	/*========================================
	=            MOSTRAR USUARIOS            =
	========================================*/
	
	static public function mdlMostrarUsuarios($tabla, $item, $valor){

		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item");

		$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);

		$stmt -> execute();

		return $stmt -> fetch();

		$stmt -> close();

		$stmt = null;



	}

	/*========================================
	=            REISTRO USUARIOS            =
	========================================*/	
	
	static public function mdlIngresarUsuario($tabla, $datos) {

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(nombre, usuario, password, perfil) 
			values (:nombre, :usuario, :perfil");

		$stmt -> bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
		$stmt -> bindParam(":usuario", $datos["usuario"], PDO::PARAM_STR);
		$stmt -> bindParam(":password", $datos["password"], PDO::PARAM_STR);
		$stmt -> bindParam(":perfil", $datos["nombre"], PDO::PARAM_STR);

		if($stmt->execute()) {

			return "ok";
		}
		else {
			return "error";
		}
		$stmt->close();
		$stmt = null;



	}
	

}