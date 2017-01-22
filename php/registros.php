<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
include ('conexion.php');

$razonSocial = isset($_POST['razonSocial'])?$_POST['razonSocial']:null;

$cedula  = isset($_POST['cedula'])?$_POST['cedula']:null;
$rif     = isset($_POST['rif'])?$_POST['rif']:null;
$usuario = isset($_POST['usuario'])?$_POST['usuario']:null;
$pass    = isset($_POST['pass'])?$_POST['pass']:null;

$nombre   = isset($_POST['nombre'])?$_POST['nombre']:null;
$apellido = isset($_POST['apellido'])?$_POST['apellido']:null;
$conf     = isset($_POST['conf'])?$_POST['conf']:null;

$data = array('Success' => false, 'Msg' => '', 'Error' => '');
#verificar si el rif ya existe en la DB
#validar numero de cedula y rif solo numeros

if (!is_null($razonSocial) && !is_null($rif) && !is_null($nombre) && !is_null($apellido) && !is_null($pass) && !is_null($cedula) && !is_null($usuario)) {
	if ($pass == $conf) {#verificar que la contrase;a y la verificar sean iguales
		if (strlen($pass) > 6 && strlen($pass) < 17) {# contrase;a debe tener mas de 6 caracteres y menor o igual a 16
			#validacion de la cedula V-#
			//separa por el guion
			list($v_e_p, $num_cedula) = explode("-", $cedula);// [V/E/P,#]
			if (is_numeric($num_cedula)) {
				#validando rif
				list($j_v, $num_rif) = explode("-", $rif);// [J/V,#]
				if (is_numeric($num_rif)) {
					$usuario = strtoupper(trim($usuario));#elimina los espacios en blanco y pone el nombre de usuario en mayus.
					#validando el nombre del usuario
					$sql    = "SELECT usuario FROM usuarios WHERE usuario = '$usuario'";
					$result = $mysqli->query($sql);
					if ($result->num_rows == 0) {
						if (strlen($usuario) > 3 && strlen($usuario) < 8) {#el nombre del usuario debe contener mas de 3 caracteres y menos de 8
							$nombre_completo = $apellido.', '.$nombre;
							$pass            = sha1(md5($pass));
							$sql             = sprintf("INSERT INTO usuarios (razonsocial,rif,nombre,cedula,usuario,password) VALUES('%s','%s','%s','%s','%s','%s')",
								mysqli_real_escape_string($mysqli, $razonSocial),
								mysqli_real_escape_string($mysqli, $j_v.'-'.$num_rif),
								mysqli_real_escape_string($mysqli, $nombre_completo),
								mysqli_real_escape_string($mysqli, $v_e_p.'-'.$num_cedula),
								mysqli_real_escape_string($mysqli, $usuario),
								mysqli_real_escape_string($mysqli, $pass)
							);
							if ($mysqli->query($sql)) {
								$data['Success'] = true;
								$data['Msg']     = 'Usuario '.$nombre_completo.' registrado exitosamente';
							} else {
								$data['Msg']   = 'Ocurrio un error al momenot de registrar';
								$data['Error'] = $mysqli->error;
							}#fin else
						} else {

							$data['Msg'] = 'Nombre de usuario muy corto';
						}
					} else {

						$data['Msg'] = "Nombre de usuario no esta disponible";
					}
				} else {

					$data['Msg'] = 'Numero de rif no valido';
				}
			} else {

				$data['Msg'] = 'Numero de cedula no valido';
			}
		}
		#fin longitud de la contrase;a
		 else {

			$data['Msg'] = 'Contrase;a muy corta';

		}
	}
	#fin if contrase;as iguales
} else {

	$data['Msg'] = 'Todos los campos deben ser completados';
}

echo json_encode($data);
?>