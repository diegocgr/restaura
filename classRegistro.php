<?php

class registro{

	function registrar($con, $correo, $contrasena, $contrasenaRepetir){

        $contrasenasIguales = "";
        $registroError = "";
        $existe = true;
    
        if($contrasena===$contrasenaRepetir){
            if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
                // $emailErr = "Invalid email format";
                // echo $emailErr;
                $registroError.="malCorreo";
            }
        
            if (!preg_match("#.*^(?=.{8,20})(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*\W).*$#", $contrasena)) {
                // echo "Password must be at least 8 characters in length and must contain at least one number, one upper case letter, one lower case letter and one special character.";
                $registroError.="malContrasena";
            }
    
            if($registroError===""){
                // echo "todo bien";
                // $existe = consultarCorreo($con, $correo);
                $existe = $this->consultarCorreo($con, $correo);
    
                if($existe===true){
                    $registroError = "existeCorreo";
                    echo $registroError;
                }else{
                    $insertarUsuario = "INSERT INTO usuarios(correo, contrasena, conectado, administrador) VALUES('$correo', '$contrasena', false, false)";
                    $res = mysqli_query($con, $insertarUsuario);
                    echo "usuarioCreado";
                }
    
            }else{
                echo $registroError;
            }
    
        }else{
            $contrasenasIguales = "malContrasenasIgual";
            echo $contrasenasIguales;
        }
        
    }
    
    function consultarCorreo($con, $correo){
        $contadorFilas = 0;
        $existe = true;
    
        $consultaCorreo = "SELECT * FROM usuarios WHERE correo='$correo'";
        $res = mysqli_query($con, $consultaCorreo);
    
        while($row = mysqli_fetch_array($res)) {
            $contadorFilas+= 1;
        }
    
        if($contadorFilas==1){
            $existe = true;
        }else{
            $existe = false;
        }
    
        return $existe;
    }

}

?>