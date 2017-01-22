function registrar(){
	var obj = {
		razonSocial : $("#razon_social").val(),
		rif 				: $("#rif-list").val()+'-'+$("#rifField").val(),
		nombre 			: $("#nombre").val(),
		apellido 		: $("#apellido").val(),
		cedula 			: $("#ced-list").val()+'-'+$("#cedula").val(),
		usuario 		: $("#usuario").val(),
		pass 				: $("#pass").val(),
		conf 				: $("#confirmacion").val()
		};
	console.log(obj);
	$.ajax({
		url:'../php/registros.php',
		data:obj,
		dataType:'json',
		method:'POST',
		success:function(response){
			if (response.Success){
				alert(response.Msg);
			}
			else{
				alert(response.Msg+' '+response.Error)
			}
		},
		error:function(xhr,status,error){
			alert(xhr.status+' '+error);
		}
		});
}
/**/