<?php

include('classSesion.php');
include('classRegistro.php');
include('classForo.php');
include('classConversacion.php');
include('classAdministracion.php');
include('classContacto.php');

session_start();

date_default_timezone_set('Europe/Madrid');

$classSesion = new sesion();
$classRegistro = new registro();
$classForo = new foro();
$classConversacion = new conversacion();
$classAdministracion = new administracion();
$classContacto = new contacto();

function conectarDB(){

	$con = mysqli_connect('localhost', 'root', 'root', 'restaura');
	mysqli_set_charset($con, "utf8");
	if(!$con){
	    die("No se ha podido realizar la conexión. ERROR:" . mysqli_connect_error());
	}else{
        //echo "Conexión establecida";
    }

	return $con;
}

//---------------------------------------------------------------------------------

if( isset($_POST['functionToCall']) && !empty($_POST['functionToCall']) ){
    $functionToCall = $_POST['functionToCall'];
    $conJS = conectarDB();

    switch($functionToCall){
        case 'iniciarSesion': 
            $correo = $_POST['correo'];
            $contrasena = $_POST['contrasena'];

            $classSesion->iniciarSesion($conJS, $correo, $contrasena);
            break;

        case 'cerrarSesion': 
            $correo = $_POST['correo'];
            $contrasena = $_POST['contrasena'];

            $classSesion->cerrarSesion($conJS, $correo, $contrasena);
            break;

        case 'getSesion': 
            $classSesion->getSesion($conJS);
            break;

        case 'registrar': 
            $correo = $_POST['correo'];
            $contrasena = $_POST['contrasena'];
            $contrasenaRepetir = $_POST['contrasenaRepetir'];

            // registrar($conJS, $correo, $contrasena, $contrasenaRepetir);
            $classRegistro->registrar($conJS, $correo, $contrasena, $contrasenaRepetir);
            break;

        case 'enviarCorreo': 
            $correo = $_POST['correo'];
            $concepto = $_POST['concepto'];
            $mensaje = $_POST['mensaje'];
            $fecha = $_POST['fecha'];

            // enviarCorreo($conJS, $correo, $concepto, $mensaje, $fecha);
            $classContacto->enviarCorreo($conJS, $correo, $concepto, $mensaje, $fecha);
            break;

        case 'crearTema': 
            $titulo = $_POST['titulo'];
            $mensaje = $_POST['mensaje'];

            // crearTema($conJS, $titulo, $mensaje);
            $classForo->crearTema($conJS, $titulo, $mensaje);
            break;

        case 'mostrarMensajes': 
            $categoriaID = $_POST['categoriaID'];

            // mostrarMensajes($conJS, $categoriaID);
            $classForo->mostrarMensajes($conJS, $categoriaID);
            break;

        case 'escribirMensajeParaTema': 
            $tema = $_POST['tema'];
            $mensaje = $_POST['mensaje'];

            // escribirMensajeParaTema($conJS, $tema, $mensaje);
            $classForo->escribirMensajeParaTema($conJS, $tema, $mensaje);
            break;

        case 'crearURLParaTema': 
            // $titulo = $_POST['titulo'];

            // crearURLParaTema($conJS);
            $classForo->crearURLParaTema($conJS);
            break;

        case 'crearURLConversaciones':

            // crearURLConversaciones($conJS);
            $classConversacion->crearURLConversaciones($conJS);
            break;

        case 'mostrarConversacion':
            $categoriaID = $_POST['categoriaID'];

            // mostrarConversacion($conJS, $categoriaID);
            $classConversacion->mostrarConversacion($conJS, $categoriaID);
            break;

        case 'escribirMensajeParaChat': 
            $mensaje = $_POST['mensaje'];
            $administradorID = $_POST['administradorID'];

            // escribirMensajeParaChat($conJS, $mensaje, $administradorID);
            $classConversacion->escribirMensajeParaChat($conJS, $mensaje, $administradorID);
            break;

        case 'getTerapeuta':
            $administradorID = $_POST['administradorID'];

            // getTerapeuta($conJS, $administradorID);
            $classConversacion->getTerapeuta($conJS, $administradorID);
            break;

        case 'getAdministrador';
            $correoToCheck = $_POST['correoToCheck'];

            // getAdministrador($conJS, $correoToCheck);
            $classSesion->getAdministrador($conJS, $correoToCheck);
            break;

        case 'getUsuarios':
            // getUsuarios($conJS);
            $classAdministracion->getUsuarios($conJS);
            break;

        case 'modificarUsuario':
            $infoID = $_POST['infoID'];
            $infoCorreo = $_POST['infoCorreo'];
            $infoContrasena = $_POST['infoContrasena'];
            $infoConectado = $_POST['infoConectado'];
            $infoAdministrador = $_POST['infoAdministrador'];

            // modificarUsuario($conJS, $infoID, $infoCorreo, $infoContrasena, $infoConectado, $infoAdministrador);
            $classAdministracion->modificarUsuario($conJS, $infoID, $infoCorreo, $infoContrasena, $infoConectado, $infoAdministrador);
            break;

        case 'eliminarUsuario':
            $infoID = $_POST['infoID'];

            // eliminarUsuario($conJS, $infoID);
            $classAdministracion->eliminarUsuario($conJS, $infoID);
            break;

        case 'eliminarComentario':
            $comentarioToEliminar = $_POST['comentarioToEliminar'];

            // eliminarComentario($conJS, $comentarioToEliminar);
            $classForo->eliminarComentario($conJS, $comentarioToEliminar);
            break;

        case 'crearURLConversacionesAdministrador':

            // crearURLConversacionesAdministrador($conJS);
            $classConversacion->crearURLConversacionesAdministrador($conJS);
            break;

        case 'getAdministradorConversacion':

            // getAdministradorConversacion($conJS);
            $classConversacion->getAdministradorConversacion($conJS);
            break;

        case 'mostrarConversacionAdministrador':
            $categoriaID = $_POST['categoriaID'];

            // mostrarConversacionAdministrador($conJS, $categoriaID);
            $classConversacion->mostrarConversacionAdministrador($conJS, $categoriaID);
            break;

        case 'escribirMensajeParaChatAdministrador':
            $mensaje = $_POST['mensaje'];
            $usuarioID = $_POST['usuarioID'];

            // escribirMensajeParaChatAdministrador($conJS, $mensaje, $usuarioID);
            $classConversacion->escribirMensajeParaChatAdministrador($conJS, $mensaje, $usuarioID);
            break;

        case 'eliminarComentarioConversacion':
            $redactorToEliminar = $_POST['redactorToEliminar'];
            $comentarioToEliminar = $_POST['comentarioToEliminar'];

            // eliminarComentarioConversacion($conJS, $redactorToEliminar, $comentarioToEliminar);
            $classConversacion->eliminarComentarioConversacion($conJS, $redactorToEliminar, $comentarioToEliminar);
            break;

        case 'getContacto':
            $classAdministracion->getContacto($conJS);
            break;

        default:
            echo "Esto es el default";
            break;
    }

}else{
    die("Solicitud no válida.");
}

?>