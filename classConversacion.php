<?php

class conversacion{

	function crearURLConversaciones($con){
        $consulta = "SELECT * FROM usuarios WHERE administrador=1";
        $res = mysqli_query($con, $consulta);
    
        $tablaURLConversacion = "";
        $tablaURLConversacion.= '<table class="table table-hover">';
        $tablaURLConversacion.= '<thead class="thead-dark"><tr> <th scope="col">Terapeutas</th> </tr></thead>';
    
        if(mysqli_num_rows($res)>0){
            while($row = mysqli_fetch_array($res)){
                // echo "<a data-id='{$row['id']}' href='mostrarconversacion.html?ID={$row['id']}'>{$row['correo']}</a><br>\n";
                $tablaURLConversacion.= "<tr><td> <a data-id='{$row['id']}' href='mostrarconversacion.html?ID={$row['id']}'>{$row['correo']}</a> </td></tr>";
            }
        }
    
        echo $tablaURLConversacion;
    }

    function crearURLConversacionesAdministrador($con){
        $usuarioCorreo = $_SESSION['correo'];
    
        // $consulta = "SELECT DISTINCT(redactor) FROM conversacion WHERE administradorID = (SELECT id FROM usuarios WHERE correo='$usuarioCorreo')";
        // $consulta = select distinct(conversacion.redactor), usuarios.id from conversacion inner join usuarios on conversacion.usuarioID=usuarios.id where administradorID = (select id from usuarios where correo = 'terapeuta1@gmail.com');
        $consulta = "SELECT DISTINCT(conversacion.redactor), usuarios.id FROM conversacion INNER JOIN usuarios ON conversacion.usuarioID=usuarios.id WHERE administradorID =(SELECT id FROM usuarios WHERE correo='$usuarioCorreo') AND redactor <> '$usuarioCorreo'";
        $res = mysqli_query($con, $consulta);
    
        $tablaURLConversacion = "";
        $tablaURLConversacion.= '<table class="table table-hover">';
        $tablaURLConversacion.= '<thead class="thead-dark"><tr> <th scope="col">Pacientes</th> </tr></thead>';
    
        if(mysqli_num_rows($res)>0){
            while($row = mysqli_fetch_array($res)){
                // echo "<a data-id='{$row['id']}' href='mostrarconversacion.html?ID={$row['id']}'>{$row['correo']}</a><br>\n";
                $tablaURLConversacion.= "<tr><td> <a data-id='{$row['id']}' href='mostrarconversacion.html?ID={$row['id']}'>{$row['redactor']}</a> </td></tr>";
            }
        }
    
        echo $tablaURLConversacion;
    }

    function getTerapeuta($con, $administradorID){
        $consultarTerapeuta = "SELECT correo FROM usuarios WHERE id=$administradorID";
        $res = mysqli_query($con, $consultarTerapeuta);
    
        if (mysqli_errno($con) != 0){
            $res = null;
        }else{
            // echo "Consulta completada!";
        }
    
        $return_arr = array();
    
        while($row = mysqli_fetch_array($res)){
            $correo = $row['correo'];
    
            $return_arr[] = array("correo" => $correo);
        }
    
        //header --> https://cybmeta.com/ajax-con-json-y-php-ejemplo-paso-a-paso
        header('Content-type: application/json; charset=utf-8');
        //Encoding array in JSON format
        echo json_encode($return_arr);
    }

    function getAdministradorConversacion($con){
        $usuarioCorreo = $_SESSION['correo'];
    
        $consultarAdministrador = "SELECT correo, administrador FROM usuarios WHERE correo='$usuarioCorreo'";
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

    function mostrarConversacion($con, $categoriaID){
        $usuarioCorreo = $_SESSION['correo'];
        
        $consulta = "SELECT conversacion.mensaje, conversacion.redactor, usuarios.conectado FROM conversacion INNER JOIN usuarios on conversacion.usuarioID=usuarios.id WHERE conversacion.administradorID=$categoriaID AND conversacion.usuarioID=(SELECT id FROM usuarios WHERE correo='$usuarioCorreo') ORDER BY conversacion.id";
        $res = mysqli_query($con, $consulta);
    
        if (mysqli_errno($con) != 0){
            $res = null;
        }else{
            // echo "Consulta completada!";
        }
    
        $return_arr = array();
    
        while($row = mysqli_fetch_array($res)){
            $mensaje = $row['mensaje'];
            $redactor = $row['redactor'];
            $conectado = $row['conectado'];
    
            $return_arr[] = array("mensaje" => $mensaje,
                            "redactor" => $redactor,
                            "conectado" => $conectado);
        }
    
        //header --> https://cybmeta.com/ajax-con-json-y-php-ejemplo-paso-a-paso
        header('Content-type: application/json; charset=utf-8');
        //Encoding array in JSON format
        echo json_encode($return_arr);
    }

    function mostrarConversacionAdministrador($con, $categoriaID){
        $usuarioCorreo = $_SESSION['correo'];
        
        // $consulta = "SELECT conversacion.mensaje, conversacion.redactor, usuarios.conectado FROM conversacion INNER JOIN usuarios on conversacion.usuarioID=usuarios.id WHERE conversacion.administradorID=$categoriaID AND conversacion.usuarioID=(SELECT id FROM usuarios WHERE correo='$usuarioCorreo') ORDER BY conversacion.id";
        $consulta = "SELECT conversacion.mensaje, conversacion.redactor, usuarios.conectado FROM conversacion INNER JOIN usuarios on conversacion.usuarioID=usuarios.id WHERE conversacion.administradorID=(SELECT id FROM usuarios WHERE correo='$usuarioCorreo') AND conversacion.usuarioID=$categoriaID ORDER BY conversacion.id";
        $res = mysqli_query($con, $consulta);
    
        if (mysqli_errno($con) != 0){
            $res = null;
        }else{
            // echo "Consulta completada!";
        }
    
        $return_arr = array();
    
        while($row = mysqli_fetch_array($res)){
            $mensaje = $row['mensaje'];
            $redactor = $row['redactor'];
            $conectado = $row['conectado'];
    
            $return_arr[] = array("mensaje" => $mensaje,
                            "redactor" => $redactor,
                            "conectado" => $conectado);
        }
    
        //header --> https://cybmeta.com/ajax-con-json-y-php-ejemplo-paso-a-paso
        header('Content-type: application/json; charset=utf-8');
        //Encoding array in JSON format
        echo json_encode($return_arr);
    }

    function escribirMensajeParaChat($con, $mensaje, $administradorID){
        $usuarioCorreo = $_SESSION['correo'];
    
        $insertarMensaje = "INSERT INTO conversacion(mensaje, redactor, usuarioID, administradorID) VALUES('$mensaje', '$usuarioCorreo', (SELECT id FROM usuarios WHERE correo='$usuarioCorreo'), $administradorID)";
        
        //INSERT INTO conversacion(mensaje, redactor, usuarioID, administradorID) VALUES ('otra prueba de chat', 'diego-x-d@hotmail.com', 2, 4);
        
        $res = mysqli_query($con, $insertarMensaje);
    
        echo "mensaje insertado";
    }

    function escribirMensajeParaChatAdministrador($con, $mensaje, $usuarioID){
        $usuarioCorreo = $_SESSION['correo'];
    
        // $insertarMensaje = "INSERT INTO conversacion(mensaje, redactor, usuarioID, administradorID) VALUES('$mensaje', '$usuarioCorreo', (SELECT id FROM usuarios WHERE correo='$usuarioCorreo'), $administradorID)";
        $insertarMensaje = "INSERT INTO conversacion(mensaje, redactor, usuarioID, administradorID) VALUES('$mensaje', '$usuarioCorreo', $usuarioID, (SELECT id FROM usuarios WHERE correo='$usuarioCorreo'))";
        
        //INSERT INTO conversacion(mensaje, redactor, usuarioID, administradorID) VALUES ('otra prueba de chat', 'diego-x-d@hotmail.com', 2, 4);
        
        $res = mysqli_query($con, $insertarMensaje);
    
        echo "mensaje insertado";
    }

    function eliminarComentarioConversacion($con, $redactorToEliminar, $comentarioToEliminar){
        $eliminarComentario = "DELETE FROM conversacion WHERE mensaje='$comentarioToEliminar' AND redactor LIKE '$redactorToEliminar%'";
        $res = mysqli_query($con, $eliminarComentario);
    
        if (mysqli_errno($con) != 0){
            $res = null;
        }else{
            echo "Eliminación completada!";
        }
    }

}

?>
