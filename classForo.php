<?php

class foro{

	function crearURLParaTema($con){
    
        // $urlForo = "http://localhost/proyecto/foro.html";
        // $tituloTrim = trim($titulo);
        
        // $url = $urlForo . $tituloTrim;
    
        // $_GET[$titulo] = $tituloTrim;
        // return $_SERVER[$urlForo] . '?' . http_build_query($_GET);
    
        // echo "<a href="" . $urlForo . "?pruebaURL"" . "></a>";
        // echo "hola caracola";
    
        $consulta = "SELECT * FROM categorias";
        $res = mysqli_query($con, $consulta);
    
        $tablaURLTema = "";
        $tablaURLTema.= '<table class="table table-hover">';
        $tablaURLTema.= '<thead class="thead-dark"><tr> <th scope="col">Temas</th> </tr></thead>';
    
        if(mysqli_num_rows($res)>0){
            while($row = mysqli_fetch_array($res)){
                // echo "<a data-id='{$row['id']}' href='mostrartema.html?ID={$row['id']}'>{$row['categoria']}</a><br>\n";
                $tablaURLTema.= "<tr><td> <a data-id='{$row['id']}' href='mostrartema.html?ID={$row['id']}'>{$row['categoria']}</a> </td></tr>";
            }
        }
    
        echo $tablaURLTema;
    }

    function mostrarMensajes($con, $categoriaID){
        // $consulta = "SELECT mensaje, usuarioID FROM mensajes WHERE categoriaID='$categoriaID'";
        // $consulta = "SELECT mensajes.mensaje, usuarios.correo, usuarios.conectado FROM mensajes INNER JOIN usuarios on mensajes.usuarioID=usuarios.id WHERE mensajes.categoriaID=$categoriaID ORDER BY mensajes.id";
        $consulta = "SELECT mensajes.mensaje, usuarios.correo, usuarios.conectado, categorias.categoria FROM mensajes INNER JOIN usuarios on mensajes.usuarioID=usuarios.id INNER JOIN categorias on mensajes.categoriaID=categorias.id WHERE mensajes.categoriaID=$categoriaID ORDER BY mensajes.id";
        $res = mysqli_query($con, $consulta);
    
        if (mysqli_errno($con) != 0){
            $res = null;
        }else{
            // echo "Consulta completada!";
        }
    
        $return_arr = array();
    
        while($row = mysqli_fetch_array($res)){
            $mensaje = $row['mensaje'];
            $correo = $row['correo'];
            $conectado = $row['conectado'];
            $categoria = $row['categoria'];
    
            $return_arr[] = array("mensaje" => $mensaje,
                            "conectado" => $conectado,
                            "correo" => $correo,
                            "categoria" => $categoria);
        }
    
        //header --> https://cybmeta.com/ajax-con-json-y-php-ejemplo-paso-a-paso
        header('Content-type: application/json; charset=utf-8');
        //Encoding array in JSON format
        echo json_encode($return_arr);
    }

    function eliminarComentario($con, $comentarioToEliminar){
        $eliminarComentario = "DELETE FROM mensajes WHERE mensaje='$comentarioToEliminar'";
        $res = mysqli_query($con, $eliminarComentario);
    
        if (mysqli_errno($con) != 0){
            $res = null;
        }else{
            echo "Eliminación completada!";
        }
    }

    function crearTema($con, $titulo, $mensaje){

        $insertarTema = "INSERT INTO categorias(categoria, descripcion) VALUES('$titulo', 'nada')";
        $res = mysqli_query($con, $insertarTema);
    
        crearMensaje($con, $titulo, $mensaje);
    
        echo "tema creado";
    }

    function escribirMensajeParaTema($con, $tema, $mensaje){
        $usuarioCorreo = $_SESSION['correo'];
    
        $insertarMensaje = "INSERT INTO mensajes(mensaje, usuarioID, categoriaID) VALUES('$mensaje', (SELECT id FROM usuarios WHERE correo='$usuarioCorreo'), (SELECT id FROM categorias WHERE categoria='$tema'))";
        $res = mysqli_query($con, $insertarMensaje);
    
        echo "mensaje insertado";
    }
}

?>