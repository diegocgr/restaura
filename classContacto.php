<?php

class contacto{

	function enviarCorreo($con, $correo, $concepto, $mensaje, $fecha){
        // $guardarConsulta = "UPDATE usuarios SET correo='$infoCorreo', contrasena='$infoContrasena', conectado=$infoConectado, administrador=$infoAdministrador WHERE id=$infoID";
        $guardarConsulta = "INSERT INTO contacto(correo, concepto, mensaje, fecha) VALUES('$correo', '$concepto', '$mensaje', '$fecha')";
        //INSERT INTO conversacion(mensaje, redactor, usuarioID, administradorID) VALUES('$mensaje', '$usuarioCorreo', (SELECT id FROM usuarios WHERE correo='$usuarioCorreo'), $administradorID)
        $res = mysqli_query($con, $guardarConsulta);
    
        if (mysqli_errno($con) != 0){
            $res = null;
        }else{
            echo "Consulta guardada!";
        }
    }

}

?>
