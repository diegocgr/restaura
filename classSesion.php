<?php

class sesion{

    function getSesion($con){
        // if( isset($_SESSION['opened'])){
        //     echo json_encode($_SESSION);
        // }
    
        // $return_arr[] = array("id" => $id,
        //                     "name" => $name,
        //                     "variety" => $variety);
    
        // $return_arr = array();
    
        $correo = $_SESSION['correo'];
        $contrasena = $_SESSION['contrasena'];
        
        $consulta = "SELECT * FROM usuarios WHERE correo='$correo' AND contrasena='$contrasena'";
        $res = mysqli_query($con, $consulta);
    
        $contadorFilas = 0;
    
        while($row = mysqli_fetch_array($res)) {
            $contadorFilas+= 1;
        }
    
        if($contadorFilas==1){
            echo json_encode($_SESSION);
        }else{
            echo "FAIL";
        }
    }

    function getAdministrador($con, $correoToCheck){
        $consultarAdministrador = "SELECT correo, administrador FROM usuarios WHERE correo='$correoToCheck'";
        $res = mysqli_query($con, $consultarAdministrador);
    
        if (mysqli_errno($con) != 0){
            $res = null;
        }else{
            // echo "Consulta completada!";
        }
    
        $return_arr = array();
    
        while($row = mysqli_fetch_array($res)){
            $correo = $row['correo'];
            $administrador = $row['administrador'];
    
            $return_arr[] = array("correo" => $correo,
                            "administrador" => $administrador);
        }
    
        //header --> https://cybmeta.com/ajax-con-json-y-php-ejemplo-paso-a-paso
        header('Content-type: application/json; charset=utf-8');
        //Encoding array in JSON format
        echo json_encode($return_arr);
    }
    
    function iniciarSesion($con, $correo, $contrasena){
        // $con = $con;
        // $correo = $correo;
        // $contrasena = $contrasena;

    
        if($correo==="" || $contrasena===""){
            echo "FAIL";
        }else{
            $consulta = "SELECT * FROM usuarios WHERE correo='$correo' AND contrasena='$contrasena'";
            // $consulta = "SELECT * FROM usuarios";
    
            $res = mysqli_query($con, $consulta);
    
            if (mysqli_errno($con) != 0){
                // $res = null;
                // $mensaje = "FAIL";
                // echo "errorAmbos";
            }else{
                // echo "Consulta completada!";
                // $mensaje = "OK";
            }
    
            $contadorFilas = 0;
            $correoToCheck = "";
            $contrasenaToCheck = "";
    
            while($row = mysqli_fetch_array($res)) {
                // $contadorFilas+= 1;
                $correoToCheck = $row['correo'];
                $contrasenaToCheck = $row['contrasena'];
            }
    
            if($correoToCheck==$correo && $contrasenaToCheck==$contrasena){
                $_SESSION['correo'] = $correo;
                $_SESSION['contrasena'] = $contrasena;
    
                echo "OK";
                // setConectado($con, $correo);
                $this->setConectado($con, $correo);
            }else{
                echo "errorAmbos";
            }
    
            // if($contadorFilas==1){
            //     echo "OK";
            //     setConectado($con, $correo);
            // }else{
            //     echo "FAIL";
            // }
        }
    }
    
    function setConectado($con, $correo){
        $consulta = "UPDATE usuarios SET conectado=true WHERE correo='$correo'";
        $res = mysqli_query($con, $consulta);
    
        if (mysqli_errno($con) != 0){
            // $res = null;
        }else{
            // echo "Consulta completada!";
        }
    }
    
    function cerrarSesion($con, $correo, $contrasena){
        // $con = $con;
        // $correo = $correo;
        // $contrasena = $contrasena;
    
        if(isset($_SESSION['correo']) && !empty($_SESSION['correo'])){
            $correo = $_SESSION['correo'];
            $contrasena = $_SESSION['contrasena'];
        }
    
        $consulta = "SELECT * FROM usuarios WHERE correo='$correo' AND contrasena='$contrasena'";
        // $consulta = "SELECT * FROM usuarios";
    
        $res = mysqli_query($con, $consulta);
    
        if (mysqli_errno($con) != 0){
            // $res = null;
            // $mensaje = "FAIL";
        }else{
            // echo "Consulta completada!";
            // $mensaje = "OK";
        }
    
        $contadorFilas = 0;
    
        while($row = mysqli_fetch_array($res)) {
            $contadorFilas+= 1;
        }
    
        if($contadorFilas==1){
            echo "OK";
            // setDesconectado($con, $correo);
            $this->setDesconectado($con, $correo);
        }else{
            echo "FAIL";
        }
    }
    
    function setDesconectado($con, $correo){
        $consulta = "UPDATE usuarios SET conectado=false WHERE correo='$correo'";
        $res = mysqli_query($con, $consulta);
    
        if (mysqli_errno($con) != 0){
            // $res = null;
        }else{
            // echo "Consulta completada!";
        }
    
        session_destroy();
    }
}

?>
