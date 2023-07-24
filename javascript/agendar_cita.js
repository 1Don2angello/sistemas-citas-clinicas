var VentanaActual = 1;
var Servicio_Seleccionado = null;
var Cliente_ID = 0;

var Datos_Cliente_Registrado = null;

Array_Validacion_Datos_Cliente = [];
Array_Horarios = [];

$(document).ready(function () {
  inicizalizar();
  eventos();

  _llenar_combo_servicios();
});

function inicizalizar() {
  try {
    //https://www.jqueryscript.net/time-clock/multilingual-calendar-date-picker.html
    $("#date_fecha").calendar({
      months: [
        "Enero",
        "Febrero",
        "Marzo",
        "Abril",
        "Mayo",
        "Junio",
        "Julio",
        "Agosto",
        "Septiembre",
        "Octubre",
        "Noviembre",
        "Diciembre",
      ],
      days: ["Lun", "Mar", "Mie", "Jue", "Vie", "Sab", "Dom"],
      color: "#ff0000",

      onSelect: function (event) {
        if (VentanaActual != 2) {
          return false;
        }

        $("#hid_hora").val("");
        $("#contenedor_horas").empty();

        var formato_fecha = "";
        formato_fecha +=
          event.label.split(".")[2] +
          "-" +
          event.label.split(".")[1] +
          "-" +
          event.label.split(".")[0];

        $("#hid_fecha").val(formato_fecha);

        var fecha_seleccionada = new Date(formato_fecha);
        fecha_seleccionada.setHours(23);
        fecha_seleccionada.setMinutes(59);
        fecha_seleccionada.setSeconds(0);
        var fecha_actual = new Date();
        fecha_actual.setDate(fecha_actual.getDate() + -1);

        if (fecha_seleccionada < fecha_actual) {
          const Toast_a = Swal.mixin({
            toast: true,
            position: "top-end",
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
              toast.addEventListener("mouseenter", Swal.stopTimer);
              toast.addEventListener("mouseleave", Swal.resumeTimer);
            },
          });

          Toast_a.fire({
            icon: "error",
            title:
              "La fecha seleccionada ya ha pasado. Favor de seleccionar otra",
          });

          return false;
        }

        generar_lista_horarios(formato_fecha);
      },
    });

    $("#paso_1").show();
    $("#btn_anterior").hide();

    consultar_validaciones_cliente();
    consultar_horarios();
  } catch (ex) {
    alert("error [inicizalizar -> function]: " + ex);
  }
}

function eventos() {
  $("#btn_anterior").on("click", function (e) {
    e.preventDefault();

    //si estamos en la ultima venta de confirmacion y damos clic en regresar
    if (VentanaActual == 4) {
      Cliente_ID = 0;
      Datos_Cliente_Registrado = null;

      $("#confirma_nombre").text("N/A");
      $("#confirma_correo").text("N/A");
      $("#confirma_telefono").text("N/A");
      $("#confirma_domicilio").text("N/A");
      $("#confirma_nota").text("N/A");
    }

    VentanaActual -= 1;
    cambiar_ventana();
  });

  $("#btn_siguiente").on("click", function (e) {
    e.preventDefault();

    var validacion = validar_campos();
    if (validacion != "") {
      const Toast = Swal.mixin({
        toast: true,
        position: "top-end",
        showConfirmButton: false,
        timer: 3500,
        timerProgressBar: true,
        didOpen: (toast) => {
          toast.addEventListener("mouseenter", Swal.stopTimer);
          toast.addEventListener("mouseleave", Swal.resumeTimer);
        },
      });

      Toast.fire({
        icon: "error",
        title:
          '<span style="font-weight:bold; font-size:18px;">Error de validación:</span><br><br> ' +
          validacion,
      });

      return false;
    }

    if (VentanaActual == 1) {
      $("#contenedor_horas").empty();
    }

    if (VentanaActual == 3) {
      $("#confirma_servicio").text(
        $("#select_servicio option:selected").text()
      );
      $("#confirma_proveedor").text(
        $("#select_proveedor option:selected").text()
      );
      $("#confirma_fecha").text($("#hid_fecha").val());
      $("#confirma_hora").text($("#hid_hora").val());
      $("#confirma_duracion").text($("#txt_descripcion_duracion").text());
      $("#confirma_precio").text($("#txt_descripcion_costo").text());

      if (Cliente_ID == 0) {
        $("#confirma_nombre").text(
          $("#txt_nombre").val() +
            " " +
            $("#txt_apellido_p").val() +
            " " +
            $("#txt_apellido_m").val()
        );

        if ($("#txt_correo").val() != "")
          $("#confirma_correo").text($("#txt_correo").val());

        if ($("#txt_telefono").val() != "")
          $("#confirma_telefono").text($("#txt_telefono").val());

        if ($("#txt_domicilio").val() != "")
          $("#confirma_domicilio").text($("#txt_domicilio").val());

        if ($("#txt_nota").val() != "")
          $("#confirma_nota").text($("#txt_nota").val());
      } else {
        $("#confirma_nombre").text(
          Datos_Cliente_Registrado.clientes_nombre +
            " " +
            Datos_Cliente_Registrado.clientes_apellido_p +
            " " +
            Datos_Cliente_Registrado.clientes_apellido_m
        );

        if (Datos_Cliente_Registrado.clientes_correo != "")
          $("#confirma_correo").text(Datos_Cliente_Registrado.clientes_correo);

        if (Datos_Cliente_Registrado.clientes_telefono != "")
          $("#confirma_telefono").text(
            Datos_Cliente_Registrado.clientes_telefono
          );

        if (Datos_Cliente_Registrado.clientes_direccion != "")
          $("#confirma_domicilio").text(
            Datos_Cliente_Registrado.clientes_direccion
          );

        if ($("#txt_nota").val() != "")
          $("#confirma_nota").text($("#txt_nota").val());
      }
    }

    if (VentanaActual == 4) {
      if (Cliente_ID == 0) {
        if (registrar_cliente() == false) {
          return false;
        }
      }

      /* enviar_correo(); */
      registrar_cita();
    } else {
      VentanaActual += 1;
      cambiar_ventana();
    }
  });

  $("#select_servicio").change(function () {
    try {
      _llenar_combo_proveedores($("#select_servicio").val());
      consultar_info_servicio($("#select_servicio").val());
    } catch (ex) {
      alert("error [select_servicio -> change]: " + ex);
    }
  });

  $(".button").on("click", function (e) {
    consultar_horarios();
  });

  $("#txt_telefono").keydown(function (e) {
    var key = e.charCode || e.keyCode || 0;

    if ($("#txt_telefono").val().length == 10) {
      // allow backspace, tab, delete, arrows, numbers and keypad numbers ONLY
      return key == 8 || key == 9 || key == 46 || (key >= 37 && key <= 40);
    }
  });
}

function validar_campos() {
  var resultado = "";

  if (VentanaActual == 1) {
    if ($("#select_servicio").val() == -1) {
      resultado += "-Favor de seleccionar el servicio primero.<br>";
    }

    if ($("#select_proveedor").val() == -1) {
      resultado += "-Favor de seleccionar el proveedor primero.<br>";
    }
  }

  if (VentanaActual == 2) {
    if (
      $(".calendar .calendar-frame table tbody .selected").val() == undefined
    ) {
      resultado += "-Favor de seleccionar un día primero.<br>";
    }

    if ($("#hid_hora").val() == "") {
      resultado += "-Primero seleccione la hora de la cita.<br>";
    }
  }

  if (VentanaActual == 3) {
    if (consultar_cliente_registrado() == false) {
      if (obtener_campo_validacion("nombre_cliente") == "true") {
        if ($("#txt_nombre").val() == "")
          resultado += "- El campo 'nombre' es un dato obligatorio.<br>";
      }

      if (obtener_campo_validacion("apellido_p_cliente") == "true") {
        if ($("#txt_apellido_p").val() == "")
          resultado +=
            "- El campo 'apellido paterno' es un dato obligatorio.<br>";
      }

      if (obtener_campo_validacion("apellido_m_cliente") == "true") {
        if ($("#txt_apellido_m").val() == "")
          resultado +=
            "- El campo 'apellido materno' es un dato obligatorio.<br>";
      }

      if (obtener_campo_validacion("telefono_cliente") == "true") {
        if ($("#txt_telefono").val() == "")
          resultado += "- El campo 'telefono' es un dato obligatorio.<br>";
        else if ($("#txt_telefono").val().length != 10)
          resultado += "- El campo 'telefono' es incorrecto.<br>";
      }

      if (obtener_campo_validacion("correo_cliente") == "true") {
        if ($("#txt_correo").val() == "") {
          resultado += "- El campo 'correo' es un dato obligatorio.<br>";
        } else {
          var regex =
            /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
          if (regex.test($("#txt_correo").val()) == false) {
            resultado += "- El campo 'correo' es incorrecto.<br>";
          }
        }
      }

      if (obtener_campo_validacion("direccion_cliente") == "true") {
        if ($("#txt_domicilio").val() == "")
          resultado += "- El campo 'domicilio' es un dato obligatorio.<br>";
      }

      if (obtener_campo_validacion("edad_cliente") == "true") {
        if ($("#txt_edad").val() == "")
          resultado += "- El campo 'edad' es un dato obligatorio.<br>";
        else if (
          parseInt($("#txt_edad").val(), 10) <= 0 ||
          parseInt($("#txt_edad").val(), 10) >= 150
        )
          resultado += "- El campo 'edad' es incorrecto.<br>";
      }
    }
  }

  return resultado;
}

function cambiar_ventana() {
  if (VentanaActual >= 2) {
    $("#btn_anterior").show();
  } else {
    $("#btn_anterior").hide();
  }

  if (VentanaActual == 4) {
    $("#btn_siguiente").text("Finalizar");
  } else {
    $("#btn_siguiente").text("Siguiente");
  }

  var porcentaje = VentanaActual * 25;
  $("#barra_progreso").attr("aria-valuenow", porcentaje);
  $("#barra_progreso").css("width", porcentaje + "%");
  $("#barra_progreso").text(porcentaje + "%");

  $(".contenedor_paso").hide();
  $("#paso_" + VentanaActual).show();

  $(window).scrollTop(0);
}

function _llenar_combo_servicios() {
  try {
    $("#select_servicio option").remove();

    $.ajax({
      type: "POST",
      url: "../controladores/catalogos/cat_servicios_controller.php",
      data: { funcion: "combo_servicios" },
      async: false,
      success: function (datos) {
        if (datos !== null) {
          //console.log(datos);
          datos = JSON.parse(datos);

          document.getElementById("select_servicio").innerHTML +=
            "<option value='-1'>- seleccionar -</option>";

          array_categorias = [];
          for (var i = 0; i < datos.length; i++) {
            if (array_categorias.indexOf(datos[i].extra) == -1)
              array_categorias.push(datos[i].extra);
          }

          var contenido = "";
          for (var j = 0; j < array_categorias.length; j++) {
            contenido += "<optgroup label='" + array_categorias[j] + "'>";

            for (var i = 0; i < datos.length; i++) {
              if (datos[i].extra == array_categorias[j])
                contenido +=
                  "<option value='" +
                  datos[i].id +
                  "'>" +
                  datos[i].texto +
                  "</option>";
            }

            contenido += "</optgroup>";
          }

          document.getElementById("select_servicio").innerHTML += contenido;
        }
      },
      error: function (datos) {
        alert(datos.responseText);
      },
    });
  } catch (e) {
    alert("Error [_llenar_combo_servicios -> function]" + e);
  }
}

function _llenar_combo_proveedores(id_servicio) {
  try {
    $("#select_proveedor option").remove();

    $.ajax({
      type: "POST",
      url: "../controladores/catalogos/cat_usuarios_controller.php",
      data: { funcion: "consultar_usuarios_servicio", id: id_servicio },
      async: false,
      success: function (datos) {
        if (datos !== null) {
          //console.log(datos);
          datos = JSON.parse(datos);

          if (datos.length == 0)
            document.getElementById("select_proveedor").innerHTML +=
              "<option value='-1'>- seleccionar -</option>";

          var contenido = "";
          for (var i = 0; i < datos.length; i++) {
            contenido +=
              "<option value='" +
              datos[i].id +
              "'>" +
              datos[i].texto +
              "</option>";
          }

          document.getElementById("select_proveedor").innerHTML += contenido;
        }
      },
      error: function (datos) {
        alert(datos.responseText);
      },
    });
  } catch (e) {
    alert("Error [_llenar_combo_proveedores -> function]" + e);
  }
}

function consultar_info_servicio(id_servicio) {
  try {
    $.ajax({
      type: "POST",
      url: "../controladores/catalogos/cat_servicios_controller.php",
      data: { funcion: "consultar_info_servicio", id: id_servicio },
      async: false,
      success: function (datos) {
        if (datos !== null) {
          //console.log(datos);
          datos = JSON.parse(datos);
          Servicio_Seleccionado = datos[0];

          //console.log(Servicio_Seleccionado);

          $("#txt_descripcion_categoria").text(
            Servicio_Seleccionado.cls_descripcion_categoria
          );
          $("#txt_descripcion_servicio").text(
            Servicio_Seleccionado.servicios_descripcion
          );
          $("#txt_descripcion_costo").text(
            "$ " + Servicio_Seleccionado.servicios_precio + ".00"
          );
          $("#txt_descripcion_duracion").text(
            Servicio_Seleccionado.servicios_duracion + " min."
          );
        }
      },
      error: function (datos) {
        alert(datos.responseText);
      },
    });
  } catch (e) {
    alert("Error [consultar_info_servicio -> function]" + e);
  }
}

function consultar_horarios() {
  try {
    var filtros = new Object();
    filtros.configuracion_clase = "horarios";

    $.ajax({
      type: "POST",
      url: "../controladores/operaciones/configuracion_controller.php",
      data: { funcion: "consultar", obj_filtros: JSON.stringify(filtros) },
      async: false,
      success: function (datos) {
        if (datos !== null) {
          try {
            //console.log(datos);
            datos = JSON.parse(datos);
            Array_Horarios = datos;

            for (var i = 0; i < datos.length; i++) {
              if (
                datos[i].configuracion_nombre == "horario_lunes_inicio" &&
                datos[i].configuracion_valor == ""
              ) {
                $("#date_fecha table tbody tr").each(function (index) {
                  $(this)
                    .children("td")
                    .each(function (index2) {
                      if (index2 == 0) {
                        $(this).addClass("disabled");
                        $(this).css({
                          "background-color": "lightgray",
                          "pointer-events": "none",
                        });
                      }
                    });
                });
              }

              if (
                datos[i].configuracion_nombre == "horario_martes_inicio" &&
                datos[i].configuracion_valor == ""
              ) {
                $("#date_fecha table tbody tr").each(function (index) {
                  $(this)
                    .children("td")
                    .each(function (index2) {
                      if (index2 == 1) {
                        $(this).addClass("disabled");
                        $(this).css({
                          "background-color": "lightgray",
                          "pointer-events": "none",
                        });
                      }
                    });
                });
              }

              if (
                datos[i].configuracion_nombre == "horario_miercoles_inicio" &&
                datos[i].configuracion_valor == ""
              ) {
                $("#date_fecha table tbody tr").each(function (index) {
                  $(this)
                    .children("td")
                    .each(function (index2) {
                      if (index2 == 2) {
                        $(this).addClass("disabled");
                        $(this).css({
                          "background-color": "lightgray",
                          "pointer-events": "none",
                        });
                      }
                    });
                });
              }

              if (
                datos[i].configuracion_nombre == "horario_jueves_inicio" &&
                datos[i].configuracion_valor == ""
              ) {
                $("#date_fecha table tbody tr").each(function (index) {
                  $(this)
                    .children("td")
                    .each(function (index2) {
                      if (index2 == 3) {
                        $(this).addClass("disabled");
                        $(this).css({
                          "background-color": "lightgray",
                          "pointer-events": "none",
                        });
                      }
                    });
                });
              }

              if (
                datos[i].configuracion_nombre == "horario_viernes_inicio" &&
                datos[i].configuracion_valor == ""
              ) {
                $("#date_fecha table tbody tr").each(function (index) {
                  $(this)
                    .children("td")
                    .each(function (index2) {
                      if (index2 == 4) {
                        $(this).addClass("disabled");
                        $(this).css({
                          "background-color": "lightgray",
                          "pointer-events": "none",
                        });
                      }
                    });
                });
              }

              if (
                datos[i].configuracion_nombre == "horario_sabado_inicio" &&
                datos[i].configuracion_valor == ""
              ) {
                $("#date_fecha table tbody tr").each(function (index) {
                  $(this)
                    .children("td")
                    .each(function (index2) {
                      if (index2 == 5) {
                        $(this).addClass("disabled");
                        $(this).css({
                          "background-color": "lightgray",
                          "pointer-events": "none",
                        });
                      }
                    });
                });
              }

              if (
                datos[i].configuracion_nombre == "horario_domingo_inicio" &&
                datos[i].configuracion_valor == ""
              ) {
                $("#date_fecha table tbody tr").each(function (index) {
                  $(this)
                    .children("td")
                    .each(function (index2) {
                      if (index2 == 6) {
                        $(this).addClass("disabled");
                        $(this).css({
                          "background-color": "lightgray",
                          "pointer-events": "none",
                        });
                      }
                    });
                });
              }
            }
          } catch (ex) {
            alert("Error [consultar_horarios -> ajax]" + ex);
          }
        }
      },
      error: function (datos) {
        alert(datos.responseText);
      },
    });
  } catch (e) {
    alert("Error [consultar_horarios -> function]" + e);
  }
}

function generar_lista_horarios(formato_fecha) {
  //registros de configuracion
  if (Array_Horarios.length != 0) {
    $("#contenedor_horas").empty();

    var Xmas95 = new Date(formato_fecha);
    var weekday = Xmas95.getDay();

    var array_horas_disponibles = [];

    var hora_inicial = "";
    var hora_final = "";

    for (var i = 0; i < Array_Horarios.length; i++) {
      if (
        weekday == 0 &&
        Array_Horarios[i].configuracion_nombre == "horario_lunes_inicio"
      )
        hora_inicial = Array_Horarios[i].configuracion_valor;

      if (
        weekday == 0 &&
        Array_Horarios[i].configuracion_nombre == "horario_lunes_final"
      )
        hora_final = Array_Horarios[i].configuracion_valor;

      if (
        weekday == 1 &&
        Array_Horarios[i].configuracion_nombre == "horario_martes_inicio"
      )
        hora_inicial = Array_Horarios[i].configuracion_valor;

      if (
        weekday == 1 &&
        Array_Horarios[i].configuracion_nombre == "horario_martes_final"
      )
        hora_final = Array_Horarios[i].configuracion_valor;

      if (
        weekday == 2 &&
        Array_Horarios[i].configuracion_nombre == "horario_miercoles_inicio"
      )
        hora_inicial = Array_Horarios[i].configuracion_valor;

      if (
        weekday == 2 &&
        Array_Horarios[i].configuracion_nombre == "horario_miercoles_final"
      )
        hora_final = Array_Horarios[i].configuracion_valor;

      if (
        weekday == 3 &&
        Array_Horarios[i].configuracion_nombre == "horario_jueves_inicio"
      )
        hora_inicial = Array_Horarios[i].configuracion_valor;

      if (
        weekday == 3 &&
        Array_Horarios[i].configuracion_nombre == "horario_jueves_final"
      )
        hora_final = Array_Horarios[i].configuracion_valor;

      if (
        weekday == 4 &&
        Array_Horarios[i].configuracion_nombre == "horario_viernes_inicio"
      )
        hora_inicial = Array_Horarios[i].configuracion_valor;

      if (
        weekday == 4 &&
        Array_Horarios[i].configuracion_nombre == "horario_viernes_final"
      )
        hora_final = Array_Horarios[i].configuracion_valor;

      if (
        weekday == 5 &&
        Array_Horarios[i].configuracion_nombre == "horario_sabado_inicio"
      )
        hora_inicial = Array_Horarios[i].configuracion_valor;

      if (
        weekday == 5 &&
        Array_Horarios[i].configuracion_nombre == "horario_sabado_final"
      )
        hora_final = Array_Horarios[i].configuracion_valor;

      if (
        weekday == 6 &&
        Array_Horarios[i].configuracion_nombre == "horario_domingo_inicio"
      )
        hora_inicial = Array_Horarios[i].configuracion_valor;

      if (
        weekday == 6 &&
        Array_Horarios[i].configuracion_nombre == "horario_domingo_final"
      )
        hora_final = Array_Horarios[i].configuracion_valor;
    }

    if (parseInt(hora_inicial, 10) < 10) hora_inicial = "0" + hora_inicial;

    //convertir minutos a horas para poder restar la ultima hora de consulta a la hroa final
    var valor_resta = Math.trunc(Servicio_Seleccionado.servicios_duracion / 60);

    var nueva_hora = hora_inicial + ":00";
    array_horas_disponibles.push(nueva_hora);

    do {
      nueva_hora = sumar_minutos(
        nueva_hora,
        Servicio_Seleccionado.servicios_duracion
      );

      array_horas_disponibles.push(nueva_hora);

      if (nueva_hora.split(":")[0] == hora_final) {
        array_horas_disponibles.splice(array_horas_disponibles.length - 1, 1);
      }

      var valor_hora_n = parseInt(nueva_hora.split(":")[0], 10);
      var valor_hora_f = parseInt(hora_final, 10) - valor_resta;
    } while (valor_hora_n < valor_hora_f);

    //------------- ELIMINAR HORARIOS DESCANSOS ------------------

    array_horario_descansos = consultar_descansos(weekday);

    if (array_horario_descansos.length != 0) {
      array_horas_disponibles_tmp = [];

      for (var j = 0; j < array_horas_disponibles.length; j++) {
        for (var i = 0; i < array_horario_descansos.length; i++) {
          if (
            evaluar_entre_horas(
              array_horario_descansos[i].descansos_inicio,
              array_horario_descansos[i].descansos_final,
              array_horas_disponibles[j]
            ) == false
          ) {
            array_horas_disponibles_tmp.push(array_horas_disponibles[j]);
          }
        }
      }

      array_horas_disponibles = array_horas_disponibles_tmp;
    }

    //------------- (fin eliminar horarios descansos) ------------

    //------------ ELIMINAR HORARIOS OCUPADOS -------------------

    array_citas_ocupadas = consultar_citas(formato_fecha);

    if (array_citas_ocupadas.length != 0) {
      for (var j = 0; j < array_citas_ocupadas.length; j++) {
        var index = array_horas_disponibles.indexOf(
          array_citas_ocupadas[j].citas_hora
        );
        if (index != -1) {
          array_horas_disponibles.splice(index, 1);
        }
      }
    }

    //------------ (fin eliminar horarios ocupados) -------------------

    //--------------- ELIMINAR HORAS QUE YA HAYAN PASADO -------------

    var fecha_seleccionada = new Date($("#hid_fecha").val());
    var fecha_actual = new Date();
    fecha_actual.setDate(fecha_actual.getDate() + -1);

    if (fecha_actual.getDate() == fecha_seleccionada.getDate()) {
      var array_tmp = [];
      var hora_actual =
        fecha_actual.getHours() + ":" + fecha_actual.getMinutes();
      for (var i = 0; i < array_horas_disponibles.length; i++) {
        //evaluamos que la hora del array sea mayor que la hora actual
        if (comparar_dos_horas(array_horas_disponibles[i], hora_actual) == 1) {
          array_tmp.push(array_horas_disponibles[i]);
        }
      }

      array_horas_disponibles = array_tmp;
    }

    //--------------- (fin eliminar horas que ya hayan pasado) -------

    //---- ELIMINAR HORAS OCUPADAS DEL PROVEEDOR (MISMA FECHA DIFERENTE SERVICIO) -------

    try {
      $.ajax({
        type: "POST",
        url: "../controladores/operaciones/citas_controller.php",
        data: {
          funcion: "consultar_horas_ocupadas",
          proveedor_id: $("#select_proveedor").val(),
          fecha: formato_fecha,
        },
        async: false,
        success: function (datos) {
          if (datos !== null) {
            try {
              //console.log(datos);
              datos = JSON.parse(datos);

              if (datos.length >= 1) {
                var array_horas_ocupadas_tmp = [];

                //evaluamos si alguna hora de la lista cae dentro de los intervalos de horas ocupadas
                for (var i = 0; i < array_horas_disponibles.length; i++) {
                  for (var j = 0; j < datos.length; j++) {
                    var hora_inicio_o = datos[j].hora_inicio;
                    var hora_fin_o = sumar_minutos(
                      datos[j].hora_inicio,
                      datos[j].duracion
                    );

                    //econtramos todas las horas que el provvedor ya tenga ocupadas y que figuren en la lista diponibles
                    if (
                      evaluar_entre_horas(
                        hora_inicio_o,
                        hora_fin_o,
                        array_horas_disponibles[i]
                      ) == true
                    ) {
                      array_horas_ocupadas_tmp.push(array_horas_disponibles[i]);
                      break;
                    }
                  }
                }

                //agregamos solo las horas que no aparezcan como ocupadas en array_horas_ocupadas_tmp
                var array_temporal = [];

                var encontrado = false;
                for (var i = 0; i < array_horas_disponibles.length; i++) {
                  encontrado = false;
                  for (var j = 0; j < array_horas_ocupadas_tmp.length; j++) {
                    if (
                      array_horas_disponibles[i] == array_horas_ocupadas_tmp[j]
                    ) {
                      encontrado = true;
                      break;
                    }
                  }

                  if (encontrado == false) {
                    array_temporal.push(array_horas_disponibles[i]);
                  }
                }

                array_horas_disponibles = array_temporal;
              }
            } catch (ex) {
              alert(
                "Error [consultar_descansos -> ajax, consultar_horas_ocupadas]" +
                  ex
              );
            }
          }
        },
        error: function (datos) {
          alert(datos.responseText);
        },
      });
    } catch (e) {
      alert("Error [consultar_descansos -> function]" + e);
    }

    //------------------ (fin eliminar horas ocupadas del proveedor) --------------------

    if (array_horas_disponibles.length == 0) {
      const Toast_a = Swal.mixin({
        toast: true,
        position: "top-end",
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
          toast.addEventListener("mouseenter", Swal.stopTimer);
          toast.addEventListener("mouseleave", Swal.resumeTimer);
        },
      });

      Toast_a.fire({
        icon: "warning",
        title:
          "La fecha seleccionada no tiene horarios disponibles, favor de seleccionar otra",
      });
    }

    for (var i = 0; i < array_horas_disponibles.length; i++) {
      $("#contenedor_horas").append(
        '<button type="button" class="list-group-item list-group-item-action">' +
          array_horas_disponibles[i] +
          "</button>"
      );
    }

    $("#contenedor_horas .list-group-item").on("click", function (e) {
      e.preventDefault();
      $(".list-group-item").removeClass("active");
      $(this).addClass("active");

      $("#hid_hora").val($(this).text());
    });
  }
}

//retorna 1 si la hora_muestra es mayor, 2 si la hora referencia es mayor
function comparar_dos_horas(hora_muestra, hora_referencia) {
  var horas1 = parseInt(hora_muestra.split(":")[0], 10);
  var minutos1 = parseInt(hora_muestra.split(":")[1], 10);

  var horas2 = parseInt(hora_referencia.split(":")[0], 10);
  var minutos2 = parseInt(hora_referencia.split(":")[1], 10);

  if (horas1 < horas2) {
    return 2;
  } else if (horas1 > horas2) {
    return 1;
  } else if (horas1 == horas2) {
    if (minutos1 < minutos2) {
      return 2;
    } else if (minutos1 > minutos2) {
      return 1;
    } else {
      return 2;
    }
  }
}

function sumar_minutos(hora, minutos) {
  var hrs = parseInt(hora.split(":")[0], 10);
  var min = parseInt(hora.split(":")[1], 10);

  var min_add = parseInt(minutos, 10);

  min += min_add;

  while (min >= 60) {
    min -= 60;
    hrs++;
  }

  var hora_res = hrs + "";
  if (hrs < 10) {
    hora_res = "0" + hrs;
  }

  var min_res = min;
  if (min < 10) {
    min_res = "0" + min;
  }

  if (hrs >= 24 && min >= 0) {
    return "24:00";
  } else {
    return hora_res + ":" + min_res;
  }
}

function evaluar_entre_horas(hora_inicio, hora_final, hora) {
  if (hora_inicio.toString().includes(":") == false) {
    hora_inicio += ":00";
  }

  if (hora_final.toString().includes(":") == false) {
    hora_final += ":00";
  }

  var hora_hrs = parseInt(hora.split(":")[0], 10);
  var hora_min = parseInt(hora.split(":")[1], 10);

  var hora_ini = parseInt(hora_inicio);
  var hora_fin = parseInt(hora_final);

  var hora_fin_min = parseInt(hora_final.split(":")[1], 10);

  var estado = 0;

  while (estado != 4 && estado != 2 && estado != 5) {
    switch (estado) {
      case 0:
        if (hora_hrs >= hora_ini) {
          estado = 1;
        } else {
          estado = 5;
        }

        break;

      case 1:
        if (hora_hrs < hora_fin) {
          estado = 2;
        } else if (hora_hrs == hora_fin) {
          estado = 3;
        } else {
          estado = 5;
        }

        break;

      case 3:
        if (hora_min < hora_fin_min) {
          estado = 4;
        } else {
          estado = 5;
        }

        break;
    }
  }

  if (estado == 2 || estado == 4) {
    return true;
  } else {
    return false;
  }
}

function consultar_descansos(dia) {
  var dias_semana = [
    "Lunes",
    "Martes",
    "Miercoles",
    "Jueves",
    "Viernes",
    "Sabado",
    "Domingo",
  ];

  try {
    array_resultado = [];

    $.ajax({
      type: "POST",
      url: "../controladores/operaciones/descansos_controller.php",
      data: { funcion: "consultar" },
      async: false,
      success: function (datos) {
        if (datos !== null) {
          try {
            //console.log(datos);
            datos = JSON.parse(datos);

            for (var i = 0; i < datos.length; i++) {
              if (datos[i].descansos_dia == dias_semana[dia]) {
                array_resultado.push(datos[i]);
              }
            }
          } catch (ex) {
            alert("Error [consultar_descansos -> ajax, consultar]" + ex);
          }
        }
      },
      error: function (datos) {
        alert(datos.responseText);
      },
    });

    return array_resultado;
  } catch (e) {
    alert("Error [consultar_descansos -> function]" + e);
  }
}

function consultar_citas(fecha) {
  var array_resultado = [];

  var filtros = new Object();
  filtros.citas_fecha = fecha;
  filtros.citas_servicios_id = $("#select_servicio").val();
  filtros.citas_proveedor_id = $("#select_proveedor").val();
  filtros.citas_sala = "";
  filtros.citas_atendidas = "";
  console.log("Contenido de obj_filtros:", filtros);
  try {
    $.ajax({
      type: "POST",
      url: "../controladores/operaciones/citas_controller.php",
      data: { funcion: "consultar", obj_filtros: JSON.stringify(filtros) },
      async: false,
      success: function (datos) {
        console.log("contenido de datos==",datos);
        if (datos !== null) {
          try {
            console.log(datos);
            datos = JSON.parse(datos);
            array_resultado = datos;
          } catch (ex) {
            alert("Error [consultar_descansos -> ajax, consultar 2]" + ex);
          }
        }
      },
      error: function (datos) {
        alert(datos.responseText);
      },
    });

    return array_resultado;
  } catch (e) {
    alert("Error [consultar_descansos -> function]" + e);
  }
}

function consultar_validaciones_cliente() {
  try {
    var obj_filtros = new Object();
    obj_filtros.configuracion_clase = "validacion_cliente";

    $.ajax({
      type: "POST",
      async: false,
      url: "../controladores/operaciones/configuracion_controller.php",
      data: { funcion: "consultar", obj_filtros: JSON.stringify(obj_filtros) },
      success: function (response) {
        try {
          //console.log(response);
          var jsonData = JSON.parse(response);

          for (var i = 0; i < jsonData.length; i++) {
            var fila = new Object();
            fila.configuracion_nombre = jsonData[i].configuracion_nombre;
            fila.configuracion_clase = jsonData[i].configuracion_clase;
            fila.configuracion_valor = jsonData[i].configuracion_valor;

            Array_Validacion_Datos_Cliente.push(fila);

            if (
              fila.configuracion_nombre == "nombre_cliente" &&
              fila.configuracion_valor == "true"
            )
              $("label[for='txt_nombre']").text(
                $("label[for='txt_nombre']").text() + " (*)"
              );

            if (
              fila.configuracion_nombre == "apellido_p_cliente" &&
              fila.configuracion_valor == "true"
            )
              $("label[for='txt_apellido_p']").text(
                $("label[for='txt_apellido_p']").text() + " (*)"
              );

            if (
              fila.configuracion_nombre == "apellido_m_cliente" &&
              fila.configuracion_valor == "true"
            )
              $("label[for='txt_apellido_m']").text(
                $("label[for='txt_apellido_m']").text() + " (*)"
              );

            if (
              fila.configuracion_nombre == "telefono_cliente" &&
              fila.configuracion_valor == "true"
            )
              $("label[for='txt_telefono']").text(
                $("label[for='txt_telefono']").text() + " (*)"
              );

            if (
              fila.configuracion_nombre == "direccion_cliente" &&
              fila.configuracion_valor == "true"
            )
              $("label[for='txt_domicilio']").text(
                $("label[for='txt_domicilio']").text() + " (*)"
              );

            if (
              fila.configuracion_nombre == "correo_cliente" &&
              fila.configuracion_valor == "true"
            )
              $("label[for='txt_correo']").text(
                $("label[for='txt_correo']").text() + " (*)"
              );

            if (
              fila.configuracion_nombre == "sexo_cliente" &&
              fila.configuracion_valor == "true"
            )
              $("label[for='select_sexo']").text(
                $("label[for='select_sexo']").text() + " (*)"
              );

            if (
              fila.configuracion_nombre == "edad_cliente" &&
              fila.configuracion_valor == "true"
            )
              $("label[for='txt_edad']").text(
                $("label[for='txt_edad']").text() + " (*)"
              );
          }
        } catch (ex_ajax) {
          alert("[consultar_validaciones_cliente -> ajax]: " + ex_ajax);
        }
      },
      error: function (e) {
        alert(e.responseText);
      },
    });
  } catch (ex) {
    alert("[consultar_validaciones_cliente -> function]: " + ex);
  }
}

function obtener_campo_validacion(nombre) {
  var result = "";

  for (var i = 0; i < Array_Validacion_Datos_Cliente.length; i++) {
    if (Array_Validacion_Datos_Cliente[i].configuracion_nombre == nombre) {
      result = Array_Validacion_Datos_Cliente[i].configuracion_valor;
      break;
    }
  }

  return result;
}

function consultar_cliente_registrado() {
  resultado = true;

  try {
    $(".loader").css("display", "block");

    var obj_filtros = new Object();
    obj_filtros.clientes_nombre = $("#txt_nombre").val();
    obj_filtros.clientes_apellido_p = $("#txt_apellido_p").val();
    obj_filtros.clientes_apellido_m = $("#txt_apellido_m").val();

    $.ajax({
      type: "POST",
      async: false,
      url: "../controladores/catalogos/cat_clientes_controller.php",
      data: {
        funcion: "consultar_exacto",
        obj_filtros: JSON.stringify(obj_filtros),
      },
      success: function (response) {
        try {
          console.log(response);
          var jsonData = JSON.parse(response);

          if (jsonData.length == 0) {
            Cliente_ID = 0;
            resultado = false;
          } else {
            Datos_Cliente_Registrado = jsonData[0];
            Cliente_ID = jsonData[0].clientes_id;
          }
        } catch (ex_ajax) {
          alert("[consultar_cliente_registrado -> ajax]: " + ex_ajax);
        }
      },
      error: function (e) {
        alert(e.responseText);
      },
    });

    $(".loader").fadeOut("slow");
  } catch (ex) {
    alert("[consultar_cliente_registrado -> function]: " + ex);
  }

  return resultado;
}
/* 
function registrar_cliente() {
  resultado = true;

  try {
    $(".loader").css("display", "block");
    var obj_filtros = new Object();
    obj_filtros.clientes_nombre = $("#txt_nombre").val();
    obj_filtros.clientes_apellido_p = $("#txt_apellido_p").val();
    obj_filtros.clientes_apellido_m = $("#txt_apellido_m").val();
    obj_filtros.clientes_telefono = $("#txt_telefono").val();
    obj_filtros.clientes_correo = $("#txt_correo").val();
    obj_filtros.clientes_direccion = $("#txt_domicilio").val();
    obj_filtros.clientes_sexo = $("#select_sexo option:selected").text();
    obj_filtros.clientes_edad =
      $("#txt_edad").val() == "" ? 0 : parseInt($("#txt_edad").val(), 10);

    console.log("Contenido de obj_filtros:", obj_filtros);
    console.log("JSON de obj_filtros:", JSON.stringify(obj_filtros));

    $.ajax({
      type: "POST",
      async: false,
      url: "../controladores/catalogos/cat_clientes_controller.php",
      data: { funcion: "agregar", obj_filtros: JSON.stringify(obj_filtros) },
      success: function (response) {
        debugger;
        try {
          console.log(response);
          var jsonData = JSON.parse(response);

          $(".loader").fadeOut("slow");
          if (jsonData.mensaje != "correcto") {
            Swal.fire({
              title: "Error",
              text: "Ha ocurrido un error agregando el registro, intentalo de nuevo más tarde",
              icon: "error",
              confirmButtonText: "aceptar",
            });

            resultado = false;
          } else {
            Cliente_ID = jsonData.id;
            console.log(Cliente_ID);
          }
        } catch (ex_ajax) {
          alert(Cliente_ID);
          alert("[registrar_cliente -> ajax]: " + ex_ajax);
        }
      },
      error: function (e) {
        alert(e.responseText);
        $(".loader").fadeOut("slow");
      },
    });
    // En lugar de asignar el ID a la variable Cliente_ID, devuélvelo como resultado
    // return jsonData.id; 
  } catch (ex) {
    alert("[registrar_cliente -> function]: " + ex);
  }

  return resultado;
} */

function registrar_cita() {
  $(".loader").css("display", "block");

  try {
    var obj_filtros = {
      citas_servicios_id: $("#select_servicio").val(),
      citas_proveedor_id: $("#select_proveedor").val(),
      citas_clientes_id: Cliente_ID, // Utilizar ClienteID en lugar de
      citas_estatus: "activo",
      citas_fecha: $("#hid_fecha").val(),
      citas_hora: $("#hid_hora").val(),
      citas_notas: $("#txt_nota").val(),
      citas_sala: "",
    };

    console.log("Contenido de obj_filtros:", obj_filtros);

    $.ajax({
      type: "POST",
      url: "../controladores/operaciones/citas_controller.php",
      data: { funcion: "agregar", obj_filtros: JSON.stringify(obj_filtros) },
      success: function (response) {
        try {
          console.log(response);

          var jsonData = JSON.parse(response);

          if (jsonData.mensaje == "correcto") {
            Swal.fire({
              title: "La cita se ha registrado correctamente",
              text: "Datos de la cita:\n" + JSON.stringify(obj_filtros),
              icon: "success",
              confirmButtonText: "Salir",
            }).then((result) => {
              window.location.href = "../index.html";
            });
          } else {
            Swal.fire({
              title:
                "Ha ocurrido un error registrando la cita, favor de intentarlo más tarde",
              icon: "error",
              confirmButtonText: "Salir",
            }).then((result) => {
              window.location.href = "../index.html";
            });
          }
        } catch (ex_ajax) {
          alert("[registrar_cita -> ajax]: " + ex_ajax);
        }

        $(".loader").fadeOut("slow");
      },
      error: function (xhr, status, error) {
        $(".loader").fadeOut("slow");
        alert(error);
      },
    });
  } catch (ex) {
    alert("[registrar_cita -> function]: " + ex);
  }
}

/* function enviar_correo() {
  $(".loader").css("display", "block");

  try {
    var obj_filtros = new Object();
    obj_filtros.configuracion_clase = "envio_correos";

    $.ajax({
      type: "POST",
      async: false,
      url: "../controladores/operaciones/configuracion_controller.php",
      data: { funcion: "consultar", obj_filtros: JSON.stringify(obj_filtros) },
      success: function (response) {
        try {
          //console.log(response);
          var jsonData = JSON.parse(response);

          var envio_activo = false;
          var correo = "";
          var clave = "";

          for (var i = 0; i < jsonData.length; i++) {
            if (jsonData[i].configuracion_nombre == "enviar_correo") {
              envio_activo = JSON.parse(jsonData[i].configuracion_valor);
            }

            if (jsonData[i].configuracion_nombre == "cuenta_correo") {
              correo = jsonData[i].configuracion_valor;
            }

            if (jsonData[i].configuracion_nombre == "clave_correo") {
              clave = jsonData[i].configuracion_valor;
            }
          }

          if (envio_activo == true) {
            var nombre_empresa = "";
            var correo_destino = "";
            var nombre_cliente = "";
            var correo_cliente = "";
            var telefono_cliente = "";
            var nombre_proveedor = $(
              "#select_proveedor option:selected"
            ).text();
            var nombre_servicio = $("#select_servicio option:selected").text();
            var mensaje = "";

            if (Datos_Cliente_Registrado == null) {
              nombre_cliente =
                $("#txt_nombre").val() +
                " " +
                $("#txt_apellido_p").val() +
                " " +
                $("#txt_apellido_m").val();
              telefono_cliente = $("#txt_telefono").val();
              correo_cliente = $("#txt_correo").val();
            } else {
              correo_cliente = Datos_Cliente_Registrado.clientes_correo;
              telefono_cliente = Datos_Cliente_Registrado.clientes_telefono;
              nombre_cliente =
                Datos_Cliente_Registrado.clientes_nombre +
                " " +
                Datos_Cliente_Registrado.clientes_apellido_p +
                " " +
                Datos_Cliente_Registrado.clientes_apellido_m;
            }

            var filtro = new Object();
            filtro.configuracion_clase = "info_empresa";
            $.ajax({
              type: "POST",
              async: false,
              url: "../controladores/operaciones/configuracion_controller.php",
              data: {
                funcion: "consultar",
                obj_filtros: JSON.stringify(filtro),
              },
              success: function (response) {
                try {
                  //console.log(response);
                  var jsonData = JSON.parse(response);
                  nombre_empresa = jsonData[0].configuracion_valor;
                } catch (ex_ajax) {
                  alert("[enviar_correo -> ajax_empresa]: " + ex_ajax);
                }
              },
              error: function (e) {
                alert(e.responseText);
              },
            });

            mensaje +=
              "<img src='cid:logo_nn' alt='Logo' width='100' height='100'/><br>";
            mensaje += "<h1>" + nombre_empresa + "</h1><br>";

            mensaje +=
              "<span style='font-weight:bold'>Estimad@ " +
              nombre_proveedor +
              ".</span><br>";
            mensaje +=
              "Se ha agendado una nueva cita para tu servicio de " +
              nombre_servicio +
              "<br><br>";
            mensaje += "Datos de la cita:<br>";
            mensaje += "<ul>";
            mensaje += "<li>Cliente: " + nombre_cliente + "</li>";
            mensaje += "<li>Fecha: " + $("#hid_fecha").val() + "</li>";
            mensaje += "<li>Hora: " + $("#hid_hora").val() + "</li>";
            mensaje += "<li>Teléfono: " + telefono_cliente + "</li>";
            mensaje += "<li>Correo: " + correo_cliente + "</li>";
            mensaje += "<li>Notas extras: " + $("#txt_nota").val() + "</li>";
            mensaje += "</ul>";
            mensaje +=
              "<br><br><br>Culaquier cambio que se realice en la cita favor de contactar al cliente y notificarle.";

            $.ajax({
              type: "POST",
              async: false,
              url: "../controladores/catalogos/cat_usuarios_controller.php",
              data: {
                funcion: "consultar_por_id",
                id: $("#select_proveedor").val(),
              },
              success: function (response) {
                try {
                  //console.log(response);
                  var jsonData = JSON.parse(response);
                  correo_destino = jsonData[0].usuarios_correo;
                } catch (ex_ajax) {
                  alert("[enviar_correo -> ajax_proveedor]: " + ex_ajax);
                }
              },
              error: function (e) {
                alert(e.responseText);
              },
            });

            $.ajax({
              type: "POST",
              async: false,
              url: "../controladores/utils/enviar_mail.php",
              data: {
                correo_origen: correo,
                clave: clave,
                correo_destino: correo_destino,
                asunto: "Nueva cita agendada",
                mensaje_html: mensaje,
                imagen: "../../img/logotipo.jpg",
              },
              success: function (response) {
                try {
                  //console.log(response);
                  var jsonData = JSON.parse(response);
                  if (jsonData.mensaje != "correcto") {
                    Swal.fire({
                      title: "Error",
                      text:
                        "Ha ocurrido un error enviando el correo, pero su cita ha sido registrada. Favor de contactar con administración para verificar: " +
                        jsonData.mensaje,
                      icon: "error",
                      confirmButtonText: "aceptar",
                    });
                  }
                } catch (ex_ajax) {
                  alert("[enviar_correo -> ajax_envio]: " + ex_ajax);
                }
              },
              error: function (e) {
                alert(e.responseText);
              },
            });
          }
        } catch (ex_ajax) {
          alert("[enviar_correo -> ajax]: " + ex_ajax);
        }
      },
      error: function (e) {
        alert(e.responseText);
      },
    });
  } catch (ex) {
    alert("Error [enviar_correo -> function]: " + ex);
  }

  $(".loader").css("display", "none");
} */
