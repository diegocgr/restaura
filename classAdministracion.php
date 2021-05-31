<?php

class administracion{

	function getUsuarios($con){
        $consultarUsuarios = "SELECT * FROM usuarios";
        $res = mysqli_query($con, $consultarUsuarios);
    
        if (mysqli_errno($con) != 0){
            $res = null;
        }else{
            // echo "Consulta completada!";
        }
    
        $return_arr = array();
    
        while($row = mysqli_fetch_array($res)){
            $id = $row['id'];
            $correo = $row['correo'];
            $contrasena = $row['contrasena'];
            $conectado = $row['conectado'];
            $administrador = $row['administrador'];
    
            $return_arr[] = array("id" => $id,
                            "correo" => $correo,
                            "contrasena" => $contrasena,
                            "conectado" => $conectado,
                            "administrador" => $administrador);
        }
    
        //header --> https://cybmeta.com/ajax-con-json-y-php-ejemplo-paso-a-paso
        header('Content-type: application/json; charset=utf-8');
        //Encoding array in JSON format
        echo json_encode($return_arr);
    }
    
    function modificarUsuario($con, $infoID, $infoCorreo, $infoContrasena, $infoConectado, $infoAdministrador){
    
        $actualizarUsuario = "UPDATE usuarios SET correo='$infoCorreo', contrasena='$infoContrasena', conectado=$infoConectado, administrador=$infoAdministrador WHERE id=$infoID";
        $res = mysqli_query($con, $actualizarUsuario);
    
        if (mysqli_errno($con) != 0){
            $res = null;
        }else{
            echo "Modificación completada!";
        }
    }
    
    function eliminarUsuario($con, $infoID){
    
        $eliminarUsuario = "DELETE FROM usuarios WHERE id=$infoID";
        $res = mysqli_query($con, $eliminarUsuario);
    
        if (mysqli_errno($con) != 0){
            $res = null;
        }else{
            echo "Eliminación completada!";
        }
    }

    function getContacto($con){
        $consultarContacto = "SELECT * FROM contacto";
        $res = mysqli_query($con, $consultarContacto);
    
        if (mysqli_errno($con) != 0){
            $res = null;
        }else{
            // echo "Consulta completada!";
        }
    
        $return_arr = array();
    
        while($row = mysqli_fetch_array($res)){
            $id = $row['id'];
            $correo = $row['correo'];
            $concepto = $row['concepto'];
            $mensaje = $row['mensaje'];
            $fecha = $row['fecha'];
    
            $return_arr[] = array("id" => $id,
                            "correo" => $correo,
                            "concepto" => $concepto,
                            "mensaje" => $mensaje,
                            "fecha" => $fecha);
        }
    
        //header --> https://cybmeta.com/ajax-con-json-y-php-ejemplo-paso-a-paso
        header('Content-type: application/json; charset=utf-8');
        //Encoding array in JSON format
        echo json_encode($return_arr);
    }

}

?>
