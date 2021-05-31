$(document).ready(function(){
    
    
    let classIndice = new Indice();
    // limpiarCampos();
    // getFrases();
    classIndice.limpiarCampos();
    classIndice.getFrases();

    let classSesion = new Sesion();
    // usarCredenciales();
    // $("#sesion").click(iniciarSesion);
    // $("#desconectar").click(cerrarSesion);
    classSesion.usarCredenciales();
    $("#sesion").click(classSesion.iniciarSesion);
    $("#desconectar").click(classSesion.cerrarSesion);

    let classRegistro = new Registro();
    // $("#enviarRegistro").click(registro);
    $("#enviarRegistro").click(classRegistro.registro);

    let classForo = new Foro();
    // $("#enviarTema").click(crearTema);
    $("#enviarTema").click(classForo.crearTema);

    let classContacto = new Contacto();
    // $("#enviarContacto").click(enviarCorreo);
    $("#enviarContacto").click(classContacto.enviarCorreo);

    // consultarIDTema();
    // $(".class_temas").click(mostrarTema2);
    // window.addEventListener('popstate', function(e){console.log('url changed')});
});

class Indice{
    constructor(){}

    limpiarCampos(){
        $("#correo").val("");
        $("#contrasena").val("");
    }

    getFrases(){
        $.getJSON('https://type.fit/api/quotes', function(data) {
            // console.log(data);
            // console.log(data.length);
            // console.log(data[0].author);
    
            var random = Math.floor(Math.random() * (data.length - 0 + 1)) + 0;
            // console.log(random);
            // console.log(data[random].text);
            // console.log(data[random].author);
            $("#cita").html('"' + data[random].text + '"');
            $("#autor").html(data[random].author);
        });
    }

}

class Sesion{
    constructor(){}

    iniciarSesion(event){
        var thisClass = this;

        var correo = $("#correo").val();
        var contrasena = $("#contrasena").val();
        console.log(correo);
        console.log(contrasena);

        $.ajax({
            url: 'main.php',
            type: 'POST',
            data: {functionToCall: 'iniciarSesion', correo: correo, contrasena: contrasena},
            success: function(data){
                console.log(data);
                
                if(data=="OK"){
                    // $('#nombreUsuario').html(correo);
                    $('#bloqueUsuario').removeClass("noMostrar");
                    $('#bloqueUsuario').addClass("mostrar");
                    $('#bloqueTema').removeClass("noMostrar");
                    $('#bloqueTema').addClass("mostrar");
                    $('#bloqueConversacion').removeClass("noMostrar");
                    $('#bloqueConversacion').addClass("mostrar");

                    // $('#bloqueIniciarSesion').html("Bienvenido " + "<strong>" + correo + "</strong>");
                    // $('#bloqueIniciarSesion').addClass("marginBienvenido");

                    $('#bloqueIniciarSesion').addClass("noMostrar");
                    $('#mensajeBienvenida').removeClass("noMostrar");
                    $('#mensajeBienvenida').addClass("mostrar");
                    $('#mensajeBienvenida').addClass("marginBienvenido");
                    $('#nombreUsuario').html(correo.split("@")[0]);

                    // mostrarCaregorias(); 
                }else if(data=="errorAmbos"){
                    $('#correo').addClass("errorIniciarSesion");
                    $('#contrasena').addClass("errorIniciarSesion");
                    $("#correo").val("Error al iniciar sesión");

                    // setTimeout(thisClass.resetIniciarSesion, 3000);

                    setTimeout(function(){ 
                        $('#correo').removeClass("errorIniciarSesion");
                        $('#contrasena').removeClass("errorIniciarSesion");
                        $("#correo").val("");
                        $("#contrasena").val("");
                    }, 3000);
                }else{
                    console.log(data);
                }
            },
            error: function(data){
                console.log(data);
            }
        })
        event.preventDefault();
    }

    resetIniciarSesion(){
        $('#correo').removeClass("errorIniciarSesion");
        $('#contrasena').removeClass("errorIniciarSesion");
        $("#correo").val("");
        $("#contrasena").val("");
    }

    cerrarSesion(event){
        var correo = $("#correo").val();
        var contrasena = $("#contrasena").val();
    
        $.ajax({
            url: 'main.php',
            type: 'POST',
            data: {functionToCall: 'cerrarSesion', correo: correo, contrasena: contrasena},
            success: function(data){
                console.log(data);
                
                if(data=="OK"){
                    $('#bloqueUsuario').removeClass("mostrar");
                    $('#bloqueUsuario').addClass("noMostrar");
    
                    $('#bloqueTema').removeClass("mostrar");
                    $('#bloqueTema').addClass("noMostrar");
                    $('#bloqueConversacion').removeClass("mostrar");
                    $('#bloqueConversacion').addClass("noMostrar");
    
                    $('#bloqueIniciarSesion').removeClass("noMostrar");
                    $('#bloqueIniciarSesion').addClass("mostrar");
                    $('#mensajeBienvenida').removeClass("mostrar");
                    $('#mensajeBienvenida').addClass("noMostrar");
                    $('#mensajeBienvenida').removeClass("marginBienvenido");
                    $('#nombreUsuario').html("");
    
                    window.location.href = "http://localhost/proyecto/index.html";
                    
                }else{
                    console.log(data);
                }
            },
            error: function(data){
                console.log(data);
            }
        })
        event.preventDefault();
    }

    usarCredenciales(){
        var thisClass = this;

        $.ajax({
            url: 'main.php',
            type: 'POST',
            dataType: 'JSON',
            data: {functionToCall: 'getSesion'},
            success: function(data){
                console.log(data);
    
                console.log(data.correo);
                console.log(data.contrasena);
                
                if(data.correo!==undefined){
                    thisClass.getAdministrador(data.correo);
                }else{
                    console.log("No hay credenciales");
                }    
            },
            error: function(data){
                console.log(data);
            }
        })
    }

    getAdministrador(correo){
        var correoToCheck = correo;
        var esAdministrador = 0;
    
        $.ajax({
            url: 'main.php',
            type: 'POST',
            data: {functionToCall: 'getAdministrador', correoToCheck: correoToCheck},
            success: function(data){
                console.log(data);
                console.log(data[0].administrador);
    
                esAdministrador = data[0].administrador;
                let classInterfaz = new Interfaz();
    
                if(esAdministrador==1){
                    classInterfaz.mostrarInterfazAdministrador(data[0].correo);
                    // mostrarInterfazAdministrador(data[0].correo);
                }else{
                    classInterfaz.mostrarInterfazUsuario(data[0].correo);
                    // mostrarInterfazUsuario(data[0].correo);
                }
            },
            error: function(data){
                console.log(data);
            }
        })
    }
}

class Interfaz{
    constructor(){}

    mostrarInterfazUsuario(correo){
        $('#bloqueUsuario').removeClass("noMostrar");
        $('#bloqueUsuario').addClass("mostrar");
        $('#bloqueTema').removeClass("noMostrar");
        $('#bloqueTema').addClass("mostrar");
        $('#bloqueConversacion').removeClass("noMostrar");
        $('#bloqueConversacion').addClass("mostrar");
        $('#bloqueIniciarSesion').addClass("noMostrar");
        $('#mensajeBienvenida').removeClass("noMostrar");
        $('#mensajeBienvenida').addClass("mostrar");
        $('#mensajeBienvenida').addClass("marginBienvenido");
        $('#nombreUsuario').html(correo.split("@")[0]);
    
        let classForo = new Foro();
        classForo.crearURLParaTema();
        // crearURLParaTema();
    
        let classConversacion = new Conversacion();
        classConversacion.crearURLConversaciones();
        // crearURLConversaciones();
    }
    
    mostrarInterfazAdministrador(correo){
        $('#refRegistro').addClass("noMostrar");
    
        $('#refAdministracion').removeClass("noMostrar");
        $('#refAdministracion').addClass("mostrar");
    
        $('#bloqueIniciarSesion').addClass("noMostrar");
        
        $('#mensajeBienvenida').removeClass("noMostrar");
        $('#mensajeBienvenida').addClass("mostrar");
        $('#mensajeBienvenida').addClass("marginBienvenido");
        $('#nombreUsuario').html(correo.split("@")[0]);
    
        $('#bloqueAdministracion').removeClass("noMostrar");
        $('#bloqueAdministracion').addClass("mostrar");

        $('#bloqueContacto').removeClass("noMostrar");
        $('#bloqueContacto').addClass("mostrar");
    
        $('.eliminarComentario').removeClass("noMostrar");
        $('.eliminarComentario').addClass("mostrar");
    
        $('#bloqueUsuario').removeClass("noMostrar");
        $('#bloqueUsuario').addClass("mostrar");
        $('#bloqueTema').removeClass("noMostrar");
        $('#bloqueTema').addClass("mostrar");
    
        let classForo = new Foro();
        classForo.crearURLParaTema();
        // crearURLParaTema();
    
        $('#bloqueConversacion').removeClass("noMostrar");
        $('#bloqueConversacion').addClass("mostrar");

        let classConversacion = new Conversacion();
        classConversacion.crearURLConversacionesAdministrador();
        // crearURLConversacionesAdministrador();
    }

}

class Registro{
    constructor(){}

    registro(event){
        var correo = $("#correoRegistro").val();
        var contrasena = $("#contrasenaRegistro").val();
        var contrasenaRepetir = $("#contrasenaRepetirRegistro").val();
    
        $("#avisoCorreoRegistro").html("");
        $("#avisoContrasenaRegistro").html("");
        $("#avisoContrasenaRepetirRegistro").html("");
    
        // console.log(correo);
        // console.log(contrasena);
        // console.log(contrasenaRepetir);
    
        $.ajax({
            url: 'main.php',
            type: 'POST',
            dataType: 'html', 
            data: {functionToCall: 'registrar', correo: correo, contrasena: contrasena, contrasenaRepetir: contrasenaRepetir},
            success: function(data){
                console.log(data);
    
                if(data=="malContrasenasIgual"){
                    $("#avisoContrasenaRegistro").html("Las contraseñas no coinciden");
                    $("#avisoContrasenaRepetirRegistro").html("Las contraseñas no coinciden");
                }else if(data=="malCorreomalContrasena"){
                    $("#avisoCorreoRegistro").html("Introduce un correo válido, por favor");
                    $("#avisoContrasenaRegistro").html("Introduce una contraseña válida, por favor");
                }else if(data=="malCorreo"){
                    $("#avisoCorreoRegistro").html("Introduce un correo válido, por favor");
                }else if(data=="malContrasena"){
                    $("#avisoContrasenaRegistro").html("Introduce una contraseña válida, por favor");
                }else if(data=="existeCorreo"){
                    $("#avisoCorreoRegistro").html("Este correo ya está en uso");
                }else{
                    console.log("Usuario creado correctamente");
                }
    
    
            },
            error: function(data){
                console.log(data);
            }
        })
    
        event.preventDefault();
    }
}

class Foro{
    constructor(){}

    crearTema(event){
        var titulo = $("#tituloTema").val();
        var mensaje = $("#mensajeTema").val();
    
        $.ajax({
            url: 'main.php',
            type: 'POST',
            data: {functionToCall: 'crearTema', titulo: titulo, mensaje: mensaje},
            success: function(data){
                console.log(data);
            },
            error: function(data){
                console.log(data);
            }
        })
    
        event.preventDefault();
    }

    crearURLParaTema(){
        $.ajax({
            url: 'main.php',
            type: 'POST',
            data: {functionToCall: 'crearURLParaTema'},
            success: function(data){
                // console.log(data);
                $("#URLtemas").html(data);
    
                // $(".class_temas").click(function(){
                //     var categoriaID = $(this).data("id");
                //     var titulo = $(this)[0].innerText;
    
                //     // alert(categoriaID + " " + titulo);
                //     mostrarTema2(titulo, categoriaID);
                //     // mentira();
                // });
            },
            error: function(data){
                console.log(data);
            }
        })
    }

}

class Conversacion{
    constructor(){}

    crearURLConversaciones(){
        $.ajax({
            url: 'main.php',
            type: 'POST',
            data: {functionToCall: 'crearURLConversaciones'},
            success: function(data){
                // console.log(data);
                $("#URLConversaciones").html(data);
            },
            error: function(data){
                console.log(data);
            }
        })
    }
    
    crearURLConversacionesAdministrador(){
        $.ajax({
            url: 'main.php',
            type: 'POST',
            data: {functionToCall: 'crearURLConversacionesAdministrador'},
            success: function(data){
                // console.log(data);
                $("#URLConversaciones").html(data);
            },
            error: function(data){
                console.log(data);
            }
        })
    }

}

class Contacto{
    constructor(){}

    enviarCorreo(event){
        var correo = $("#correoContacto").val();
        var concepto = $("#conceptoContacto").val();
        var mensaje = $("#mensajeContacto").val();

        var d = new Date();
        var month = '' + (d.getMonth() + 1);
        var day = '' + d.getDate();
        var year = d.getFullYear();
    
        if (month.length < 2) 
            month = '0' + month;
        if (day.length < 2) 
            day = '0' + day;
        var fecha = [year, month, day].join('-');
    
        $.ajax({
            url: 'main.php',
            type: 'POST',
            data: {functionToCall: 'enviarCorreo', correo: correo, concepto: concepto, mensaje: mensaje, fecha: fecha},
            success: function(data){
                console.log(data);

                $("#correoContacto").val("");
                $("#conceptoContacto").val("");
                $("#mensajeContacto").val("");
            },
            error: function(data){
                console.log(data);
            }
        })
    
        event.preventDefault();
    }
}

// function iniciarSesion(event){
//     var correo = $("#correo").val();
//     var contrasena = $("#contrasena").val();
//     console.log(correo);
//     console.log(contrasena);

//     $.ajax({
//         url: 'main.php',
//         type: 'POST',
//         data: {functionToCall: 'iniciarSesion', correo: correo, contrasena: contrasena},
//         success: function(data){
//             console.log(data);
            
//             if(data=="OK"){
//                 // $('#nombreUsuario').html(correo);
//                 $('#bloqueUsuario').removeClass("noMostrar");
//                 $('#bloqueUsuario').addClass("mostrar");
//                 $('#bloqueTema').removeClass("noMostrar");
//                 $('#bloqueTema').addClass("mostrar");
//                 $('#bloqueConversacion').removeClass("noMostrar");
//                 $('#bloqueConversacion').addClass("mostrar");

//                 // $('#bloqueIniciarSesion').html("Bienvenido " + "<strong>" + correo + "</strong>");
//                 // $('#bloqueIniciarSesion').addClass("marginBienvenido");

//                 $('#bloqueIniciarSesion').addClass("noMostrar");
//                 $('#mensajeBienvenida').removeClass("noMostrar");
//                 $('#mensajeBienvenida').addClass("mostrar");
//                 $('#mensajeBienvenida').addClass("marginBienvenido");
//                 $('#nombreUsuario').html(correo.split("@")[0]);

//                 // mostrarCaregorias(); 
//             }else if(data=="errorAmbos"){
//                 $('#correo').addClass("errorIniciarSesion");
//                 $('#contrasena').addClass("errorIniciarSesion");
//                 $("#correo").val("Error al iniciar sesión");
//                 setTimeout(resetIniciarSesion, 3000);
//             }else{
//                 console.log(data);
//             }
//         },
//         error: function(data){
//             console.log(data);
//         }
//     })
//     event.preventDefault();
// }

// function resetIniciarSesion(){
//     $('#correo').removeClass("errorIniciarSesion");
//     $('#contrasena').removeClass("errorIniciarSesion");
//     $("#correo").val("");
//     $("#contrasena").val("");
// }



// function cerrarSesion(event){
//     var correo = $("#correo").val();
//     var contrasena = $("#contrasena").val();

//     $.ajax({
//         url: 'main.php',
//         type: 'POST',
//         data: {functionToCall: 'cerrarSesion', correo: correo, contrasena: contrasena},
//         success: function(data){
//             console.log(data);
            
//             if(data=="OK"){
//                 $('#bloqueUsuario').removeClass("mostrar");
//                 $('#bloqueUsuario').addClass("noMostrar");

//                 $('#bloqueTema').removeClass("mostrar");
//                 $('#bloqueTema').addClass("noMostrar");
//                 $('#bloqueConversacion').removeClass("mostrar");
//                 $('#bloqueConversacion').addClass("noMostrar");

//                 $('#bloqueIniciarSesion').removeClass("noMostrar");
//                 $('#bloqueIniciarSesion').addClass("mostrar");
//                 $('#mensajeBienvenida').removeClass("mostrar");
//                 $('#mensajeBienvenida').addClass("noMostrar");
//                 $('#mensajeBienvenida').removeClass("marginBienvenido");
//                 $('#nombreUsuario').html("");

//                 window.location.href = "http://localhost/proyecto/index.html";
                
//             }else{
//                 console.log(data);
//             }
//         },
//         error: function(data){
//             console.log(data);
//         }
//     })
//     event.preventDefault();
// }

// function usarCredenciales(){
//     $.ajax({
//         url: 'main.php',
//         type: 'POST',
//         dataType: 'JSON',
//         data: {functionToCall: 'getSesion'},
//         success: function(data){
//             console.log(data);

//             console.log(data.correo);
//             console.log(data.contrasena);
            
//             if(data.correo!==undefined){
//                 getAdministrador(data.correo);
//             }else{
//                 console.log("No hay credenciales");
//             }    
//         },
//         error: function(data){
//             console.log(data);
//         }
//     })
// }

// function registro(event){
//     var correo = $("#correoRegistro").val();
//     var contrasena = $("#contrasenaRegistro").val();
//     var contrasenaRepetir = $("#contrasenaRepetirRegistro").val();

//     $("#avisoCorreoRegistro").html("");
//     $("#avisoContrasenaRegistro").html("");
//     $("#avisoContrasenaRepetirRegistro").html("");

//     // console.log(correo);
//     // console.log(contrasena);
//     // console.log(contrasenaRepetir);

//     $.ajax({
//         url: 'main.php',
//         type: 'POST',
//         dataType: 'html', 
//         data: {functionToCall: 'registrar', correo: correo, contrasena: contrasena, contrasenaRepetir: contrasenaRepetir},
//         success: function(data){
//             console.log(data);

//             if(data=="malContrasenasIgual"){
//                 $("#avisoContrasenaRegistro").html("Las contraseñas no coinciden");
//                 $("#avisoContrasenaRepetirRegistro").html("Las contraseñas no coinciden");
//             }else if(data=="malCorreomalContrasena"){
//                 $("#avisoCorreoRegistro").html("Introduce un correo válido, por favor");
//                 $("#avisoContrasenaRegistro").html("Introduce una contraseña válida, por favor");
//             }else if(data=="malCorreo"){
//                 $("#avisoCorreoRegistro").html("Introduce un correo válido, por favor");
//             }else if(data=="malContrasena"){
//                 $("#avisoContrasenaRegistro").html("Introduce una contraseña válida, por favor");
//             }else if(data=="existeCorreo"){
//                 $("#avisoCorreoRegistro").html("Este correo ya está en uso");
//             }else{
//                 console.log("Usuario creado correctamente");
//             }


//         },
//         error: function(data){
//             console.log(data);
//         }
//     })

//     event.preventDefault();
// }

// function enviarCorreo(event){
//     var correo = $("#correoContacto").val();
//     var concepto = $("#conceptoContacto").val();
//     var mensaje = $("#mensajeContacto").val();

//     $.ajax({
//         url: 'main.php',
//         type: 'POST',
//         data: {functionToCall: 'enviarCorreo', correo: correo, concepto: concepto, mensaje: mensaje},
//         success: function(data){
//             console.log(data); 
//         },
//         error: function(data){
//             console.log(data);
//         }
//     })

//     event.preventDefault();
// }

// function mostrarTema(titulo, categoriaID){
//     // alert(categoriaID + titulo);
//     var contenidoTema = "";
//     contenidoTema+=`<h1 id="tituloTema">${titulo}</h1>`;

//     var contenidoFormulario = "";
//     contenidoFormulario+=`
//         <form>
//             <div class="form-group">
//                 <label for="mensajeParaTema">Tu respuesta</label>
//                 <textarea class="form-control" id="mensajeParaTema" rows="6" placeholder="Escribe aquí tu respuesta"></textarea>
//             </div>
//             <button id="enviarMensajeParaTema" type="submit" class="btn btn-primary">Enviar</button>
//         </form>
//     `; 

//     $.ajax({
//         url: 'main.php',
//         type: 'POST',
//         data: {functionToCall: 'mostrarMensajes', categoriaID: categoriaID},
//         success: function(data){
//             // console.log(data);

//             for(var i=0; i<data.length; i++){
//                 var correo = data[i].correo;
//                 var mensaje = data[i].mensaje;
//                 var conectado = data[i].conectado;

//                 if(conectado==1){
//                     conectado = "conectado";
//                 }else{
//                     conectado = "desconectado";
//                 }

//                 contenidoTema+= `<p>${mensaje} escrito por ${correo} que está ${conectado}</p><br>`;
//             }

//             $("#bloqueUsuario").html(contenidoTema);
//             $("#bloqueTema").html(contenidoFormulario);
//             $("#enviarMensajeParaTema").click(escribirMensajeParaTema);
//             // crearURLParaTema(titulo);
//         },
//         error: function(data){
//             console.log(data);
//         }
//     })
// }



// function crearURLParaTema(titulo){
//     $.ajax({
//         url: 'main.php',
//         type: 'POST',
//         data: {functionToCall: 'crearURLParaTema', titulo: titulo},
//         success: function(data){
//             console.log(data);
//         },
//         error: function(data){
//             console.log(data);
//         }
//     })
// }



// function consultarIDTema(){
//     var url = window.location.href;

//     $.ajax({
//         url: 'main.php',
//         type: 'POST',
//         data: {functionToCall: 'consultarIDTema', url: url},
//         success: function(data){
//             console.log(data);
//         },
//         error: function(data){
//             console.log(data);
//         }
//     })
// }

// function mentira(){
//     $(window).on('load', function() {
//         console.log('All assets are loaded')
//     })
// }

// function mostrarTema2(titulo, categoriaID){
//     // alert(categoriaID + titulo);
//     var contenidoTema = "";
//     contenidoTema+=`<h1 id="tituloTema">${titulo}</h1>`;

//     var contenidoFormulario = "";
//     contenidoFormulario+=`
//         <form>
//             <div class="form-group">
//                 <label for="mensajeParaTema">Tu respuesta</label>
//                 <textarea class="form-control" id="mensajeParaTema" rows="6" placeholder="Escribe aquí tu respuesta"></textarea>
//             </div>
//             <button id="enviarMensajeParaTema" type="submit" class="btn btn-primary">Enviar</button>
//         </form>
//     `; 

//     $.ajax({
//         url: 'main.php',
//         type: 'POST',
//         data: {functionToCall: 'mostrarMensajes', categoriaID: categoriaID},
//         success: function(data){
//             // console.log(data);

//             for(var i=0; i<data.length; i++){
//                 var correo = data[i].correo;
//                 var mensaje = data[i].mensaje;
//                 var conectado = data[i].conectado;

//                 if(conectado==1){
//                     conectado = "conectado";
//                 }else{
//                     conectado = "desconectado";
//                 }

//                 contenidoTema+= `<p>${mensaje} escrito por ${correo} que está ${conectado}</p><br>`;
//             }

//             $("#bloqueUsuario").html(contenidoTema);
//             $("#bloqueTema").html(contenidoFormulario);
//             $("#enviarMensajeParaTema").click(escribirMensajeParaTema);
//         },
//         error: function(data){
//             console.log(data);
//         }
//     })
// }



