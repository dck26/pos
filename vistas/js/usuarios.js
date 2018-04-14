/*====================================================
=            SUBIENDO LA FOTO DEL USUARIO            =
====================================================*/

$(".nuevaFoto").change(function(){

	var imagen = this.files[0];
	if(imagen["type"] != "image/jpeg" && imagen["type"] != "image/png"){
		$(".nuevaFoto").val("");

		swal({
			title: "Error al subir la imagen",
			text: "El formato debe ser JPG o PNG",
			type: "error",
			confirmButtonText: "Cerrar"
		}); 

	}
	else if (imagen["size"] > 4000000) {
		$(".nuevaFoto").val("");

		swal({
			title: "Error al subir la imagen",
			text: "La imagen debe pesar menos de 4 MB",
			type: "error",
			confirmButtonText: "Cerrar"
		}); 
	}
	else {
		var datosImagen = new FileReader;
		datosImagen.readAsDataURL(imagen);

		$(datosImagen).on("load", function(event){

			var rutaImagen = event.target.result;
			$(".previsualizar").attr("src", rutaImagen);


		})
	}
})