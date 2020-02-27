
<!DOCTYPE html>
  <html lang="es-MX">
  <head>
    <meta charset="utf-8">
      <title>Enterprise Resource Planning.</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Avant">
    <meta name="author" content="The Red Team">

    <link rel="stylesheet" href="assets/css/styles.css?=121">
    <link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600' rel='stylesheet' type='text/css'>
    <link href='assets/demo/variations/default.css' rel='stylesheet' type='text/css' media='all' id='styleswitcher'>
    <link href='assets/demo/variations/default.css' rel='stylesheet' type='text/css' media='all' id='headerswitcher'>
    <link rel='stylesheet' type='text/css' href='assets/plugins/form-select2/select2.css' />
    <link rel='stylesheet' type='text/css' href='assets/plugins/codeprettifier/prettify.css' />
    <link rel='stylesheet' type='text/css' href='assets/plugins/form-toggle/toggles.css' />
    <link rel='stylesheet' type='text/css' href='assets/plugins/progress-skylo/skylo.css' />
    <script type="text/javascript" src="assets/js/less.js"></script>
    <style>
      .borde{
        border-top: 1px solid #e6e7e8;
        padding-top: 15px;
      }
    </style>
  </head>
  <body style="padding-top: 0px !important">
    <div id="page-container">
      <div id='wrap'>
        <div class="container">
          <div class="row">
            <div class="col-md-12">
              <h1>Registro de Candidatos </h1>
              <div id="message">
                <div class="alert alert-info"><a href="#" class="close" data-dismiss="alert">&times;</a>Los Datos marcados con <strong>(*) son obligatorios.</strong></div>
              </div>
              <form  action="" class="form-horizontal row-border" method="post" id="frm-empleado" name="formEmpleado">
                <div class="panel panel-midnightblue"> <!-- Prestaciones Integrales -->
                  <div class="panel-heading">
                    <h4>
                      Solicitud de empleo
                    </h4>
                    <div class="options">
                      <a href="javascript:;"><i class="fa fa-cog"></i></a>
                      <a href="javascript:;" onclick=""><i class="fa fa-times"></i></a>
                      <a href="javascript:;" class="panel-collapse"><i class="fa fa-chevron-down"></i></a>
                    </div>
                  </div>
                  <div class="panel-body collapse in">
                    <div class="col-md-4">
                      <div class="form-group">
                        <label class="col-sm-4 control-label">Fecha*</label>
                        <div class="col-sm-6">
                          <div class="input-group date ">
                            <input type="text" class="form-control" value="<?= date("Y-m-d") ?>" disabled>
                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                          </div>
                        </div>
                        <a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Fecha de hoy">
                          <span class="fa fa-info-circle"></span>
                        </a>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label class="col-sm-4 control-label">Puesto Deseado*</label>
                        <div class="col-sm-6">
                          <input type="text" class="form-control" id="puesto" name="puesto" value="" placeholder="Ingrese el puesto deseado" title="Ingrese el puesto deseado" tabindex="1" required />
                        </div>
                        <a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Ingrese el puesto deseado">
                          <span class="fa fa-info-circle"></span>
                        </a>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label class="col-sm-4 control-label">Sueldo Bruto Deseado*</label>
                        <div class="col-sm-6">
                          <input type="text" class="form-control" id="sueldo_bruto" name="sueldo_bruto" value="" placeholder="Sueldo bruto deseado" title="Sueldo bruto deseado" tabindex="2" required />
                        </div>
                        <a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Sueldo bruto deseado">
                          <span class="fa fa-info-circle"></span>
                        </a>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="panel panel-midnightblue">
                  <div class="panel-heading">
                    <h4>
                       Información del candidato
                    </h4>
                    <div class="options">
                      <a href="javascript:;"><i class="fa fa-cog"></i></a>
                      <!--a href="javascript:;" onclick="()"><i class="fa fa-refresh"></i></a-->
                      <a href="javascript:;" class="panel-collapse"><i class="fa fa-chevron-down"></i></a>
                    </div>
                  </div>
                  <div class="panel-body collapse in">
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="col-sm-4 control-label">Nombre(s)*</label>
                          <div class="col-sm-6">
                            <input type="text" class="form-control" id="nombre" name="nombre" value="" placeholder="Ingrese su Nombre(s)" title="Nombre del candidato" tabindex="3"/>
                          </div>
                          <div class="col-sm-1">
                            <a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Nombre del candidato">
                              <span class="fa fa-info-circle"></span>
                            </a>
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="col-sm-4 control-label">Apellido Paterno*</label>
                          <div class="col-sm-6">
                            <input type="text" class="form-control" id="app" name="app" value="" placeholder="Ingrese su apellido paterno" title="Ingrese su apellido paterno" tabindex="4"/>
                          </div>
                          <div class="col-sm-1">
                            <a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Ingrese su apellido paterno">
                              <span class="fa fa-info-circle"></span>
                            </a>
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="col-sm-4 control-label">Apellido Materno*</label>
                          <div class="col-sm-6">
                            <input type="text" class="form-control" id="apm" name="apm" value="" placeholder="Ingrese su  Apellido Materno " title="Ingrese su apellido materno" tabindex="5"/>
                          </div>
                          <div class="col-sm-1">
                            <a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Ingrese su apellido materno">
                              <span class="fa fa-info-circle"></span>
                            </a>
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="col-sm-4 control-label">Fecha de Nacimiento*</label>
                          <div class="col-sm-6">
                            <div class="input-group date datepicker">
                              <input type="text" class="form-control" id="fecha_nac" name="fecha_nac" placeholder="Seleccione su fecha de nacimiento" title="Seleccione su fecha de nacimiento" value="" tabindex="6" onchange="calcEdad()" required />
                              <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                            </div>
                          </div>
                          <div class="col-sm-1">
                            <a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Seleccione su fecha de nacimiento">
                              <span class="fa fa-info-circle"></span>
                            </a>
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="col-sm-4 control-label">Correo Electrónico*</label>
                          <div class="col-sm-6">
                            <input type="text" class="form-control" id="email" name="email" value="" placeholder="ejemplo@correo.com" title="Ingrese su correo electrónico" tabindex="7" onchange="validarEmail()"/>
                          </div>
                          <div class="col-sm-1">
                            <a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Ingrese su correo electrónico (ejemplo@correo.com)">
                              <span class="fa fa-info-circle"></span>
                            </a>
                          </div>
                          <label id="res_correo"></label>
                        </div>
                        <div class="form-group">
                          <label class="col-sm-4 control-label">Calle *</label>
                          <div class="col-sm-6">
                            <input type="text" class="form-control" id="nombre" name="nombre" value="" placeholder="Ingrese la Calle" title="Nombre de la empresa"/>
                          </div>
                          <div class="col-sm-1">
                            <a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Nombre de la empresa">
                              <span class="fa fa-info-circle"></span>
                            </a>
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="col-sm-4 control-label">Colonia *</label>
                          <div class="col-sm-6">
                            <input type="text" class="form-control" id="nombre" name="nombre" value="" placeholder="Colonia" title="Nombre de la empresa"/>
                          </div>
                          <div class="col-sm-1">
                            <a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Nombre de la empresa">
                              <span class="fa fa-info-circle"></span>
                            </a>
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="col-sm-4 control-label">C.P.*</label>
                          <div class="col-sm-6">
                            <input type="text" class="form-control" id="dir" name="dir" value="" placeholder="Ingrese el código postal" title="Ingrese el código postal" tabindex="3" />
                          </div>
                          <div class="col-sm-1">
                            <a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Ingrese el código postal">
                              <span class="fa fa-info-circle"></span>
                            </a>
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="col-sm-4 control-label">Delegación o Municipio*</label>
                          <div class="col-sm-6">
                            <input type="text" class="form-control" id="cp" name="cp" value="" placeholder="Ingrese  delegación o municipio" title="Ingrese el código postal" tabindex="9" required />
                          </div>
                          <div class="col-sm-1">
                            <a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Ingrese el código postal">
                              <span class="fa fa-info-circle"></span>
                            </a>
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="col-sm-4 control-label">Sexo*</label>
                          <div class="col-sm-6">
                            <div class="radio-inline">
                              <label>
                                <input type="radio" name="sexoRadios" id="optionsRadios1" value="option1" >Hombre
                              </label>
                            </div>
                            <div class="radio-inline">
                              <label>
                                <input type="radio" name="sexoRadios" id="optionsRadios2" value="option2">Mujer
                              </label>
                            </div>
                          </div>
                          <div class="col-sm-1">
                            <a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Selecciona tu sexo">
                              <span class="fa fa-info-circle"></span>
                            </a>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="col-sm-4 control-label">Edad*</label>
                          <div class="col-sm-6">
                            <input type="number" class="form-control" id="edad" value="" placeholder="Ingrese su edad" title="Ingrese su edad" min="18" tabindex="8" required/>
                          </div>
                          <div class="col-sm-1">
                            <a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Ingrese su edad">
                              <span class="fa fa-info-circle"></span>
                            </a>
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="col-sm-4 control-label">N.S.S.*</label>
                          <div class="col-sm-6">
                            <input type="text" class="form-control" id="nss" name="nss" value="" placeholder="Número de seguridad social" title="Ingrese télefono del contacto" tabindex="8" onchange="validarNss()" required/>
                          </div>
                          <div class="col-sm-1">
                            <a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Ingrese numero de seguridad social (11 digitos)">
                              <span class="fa fa-info-circle"></span>
                            </a>
                          </div>
                          <label id="res_nss"></label>
                        </div>
                        <div class="form-group">
                          <label class="col-sm-4 control-label">RFC*</label>
                          <div class="col-sm-6">
                            <input type="text" class="form-control" id="rfc" name="rfc" value="" placeholder="Ingrese el RFC" title="Ingrese el RFC" tabindex="2" required onchange="validarRfc()"/>
                          </div>
                          <div class="col-sm-1">
                            <a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Ingrese el RFC(10 dig sin homoclave, 13 con homoclave)">
                              <span class="fa fa-info-circle"></span>
                            </a>
                          </div>
                          <label id="res_rfc"></label>
                        </div>
                        <div class="form-group">
                          <label class="col-sm-4 control-label">CURP*</label>
                          <div class="col-sm-6">
                            <input type="text" class="form-control" id="curp" name="curp" value="" placeholder="Ingrese su CURP" title="Ingrese su CURP" tabindex="9" onchange="validarCurp()" required />
                          </div>
                          <div class="col-sm-1">
                            <a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Ingrese su CURP">
                              <span class="fa fa-info-circle"></span>
                            </a>
                          </div>
                          <label id="res_curp"></label>
                        </div>
                        <div class="form-group">
                          <label class="col-sm-4 control-label">Estado civil*</label>
                          <div class="col-sm-6">
                            <select class="form-control" id="estado" name="estado" tabindex="12" required />
                              <option selected disabled>Seleccione una Opción</option>
                              <option value="1" >Soltero</option>
                              <option value="2" >Casado</option>
                              <option value="2" >Divorciado</option>
                            </select>
                          </div>
                          <div class="col-sm-1">
                            <a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Seleccione el status de la promoción">
                              <span class="fa  fa-info-circle"></span>
                            </a>
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="col-sm-4 control-label">Celular personal*</label>
                          <div class="col-sm-6">
                            <input type="text" class="form-control" id="tel_cel" name="tel_cel" value="" placeholder="Ingrese su numero de celular" title="Ingrese su numero de celular" tabindex="9" required onchange="validarTel('#tel_cel', '#res_cel')"/>
                          </div>
                          <div class="col-sm-1">
                            <a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Ingrese su numero de celular (10 digitos)">
                              <span class="fa fa-info-circle"></span>
                            </a>
                          </div>
                          <label id="res_cel"></label>
                        </div>
                        <div class="form-group">
                          <label class="col-sm-4 control-label">Telefono particular*</label>
                          <div class="col-sm-6">
                            <input type="text" class="form-control" id="tel_casa" name="tel_casa" value="" placeholder="Ingrese su telefono personal" title="Ingrese el código postal" tabindex="9" required onchange="validarTel('#tel_casa', '#res_tel')"/>
                          </div>
                          <div class="col-sm-1">
                            <a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Ingrese su telefono personal (10 digitos)">
                              <span class="fa fa-info-circle"></span>
                            </a>
                          </div>
                          <label id="res_tel"></label>
                        </div>
                        <div class="form-group">
                          <label class="col-sm-4 control-label">No. Int y Ext.*</label>
                          <div class="col-sm-6">
                            <input type="text" class="form-control" id="cp" name="cp" value="" placeholder="Numero interior y/o exterior" title="Numero interior y/o exterior" tabindex="9" required />
                          </div>
                          <a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Numero interior y/o exterior">
                            <span class="fa fa-info-circle"></span>
                          </a>
                        </div>
                        <div class="form-group">
                          <label class="col-sm-4 control-label">Talla*</label>
                          <div class="col-sm-6">
                            <input type="text" class="form-control" id="cp" name="cp" value="" placeholder="Ingrese su talla" title="Ingrese su talla" tabindex="9" required />
                          </div>
                          <a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Ingrese su talla">
                            <span class="fa fa-info-circle"></span>
                          </a>
                        </div>
                        <div class="form-group">
                          <label class="col-sm-4 control-label">¿Tienes hijos?*</label>
                          <div class="col-sm-6">
                            <div class="radio-inline">
                              <label>
                                <input type="radio" name="hijosRadios" id="optionsRadios1" value="option1" >Si
                              </label>
                            </div>
                            <div class="radio-inline">
                              <label>
                                <input type="radio" name="hijosRadios" id="optionsRadios2" value="option2">No
                              </label>
                            </div>
                          </div>
                          <a href="#" data-toggle="tooltip" data-placement="top" data-original-title="¿Tiene hijos?">
                            <span class="fa fa-info-circle"></span>
                          </a>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="panel panel-midnightblue"> <!-- Datos Cotización Personal -->
                  <div class="panel-heading">
                    <h4>
                      Estudios Generales
                    </h4>
                    <div class="options">
                      <a href="javascript:;"><i class="fa fa-cog"></i></a>
                      <!--a href="javascript:;" onclick="()"><i class="fa fa-refresh"></i></a-->
                      <a href="javascript:;" class="panel-collapse"><i class="fa fa-chevron-down"></i></a>
                    </div>
                  </div>
                  <div class="panel-body collapse in">
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="col-sm-4 control-label">Ultimo Grado de estudios*</label>
                          <div class="col-sm-6">
                            <select class="form-control" id="estado" name="estado" tabindex="12" required />
                              <option selected disabled>Seleccione una Opción</option>
                              <option value="1" >Primaria</option>
                              <option value="2" >Secundaria</option>
                              <option value="2" >Preparatoria</option>
                            </select>
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="col-sm-4 control-label">Escuela*</label>
                          <div class="col-sm-6">
                            <input type="text" class="form-control" id="gradoEstudios" name="gradoEstudios" value="" placeholder="Ingrese el nombre de la escuela" title="Nombre del candidato"/>
                          </div>
                          <a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Nombre de la escuela del ultimo grado de estudios">
                            <span class="fa fa-info-circle"></span>
                          </a>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="col-sm-4 control-label">Periodo*</label>
                          <div class="col-sm-6">
                            <input type="text" class="form-control" id="gradoEstudios" name="gradoEstudios" value="" placeholder="Ingrese el periodo" title="Nombre del candidato"/>
                          </div>
                          <a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Nombre del candidato">
                            <span class="fa fa-info-circle"></span>
                          </a>
                        </div>
                        <div class="form-group">
                          <label class="col-sm-4 control-label">Título obtenido*</label>
                          <div class="col-sm-6">
                            <input type="text" class="form-control" id="gradoEstudios" name="gradoEstudios" value="" placeholder="Ingrese el titulo obtenido" title="Ingrese el titulo obtenido"/>
                          </div>
                          <a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Ingrese el titulo obtenido">
                            <span class="fa fa-info-circle"></span>
                          </a>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="panel panel-midnightblue"> <!-- Prima Dominical -->
                  <div class="panel-heading">
                    <h4>
                      Otros conocimientos
                    </h4>
                    <div class="options">
                      <a href="javascript:;"><i class="fa fa-cog"></i></a>
                      <!--a href="javascript:;" onclick="()"><i class="fa fa-refresh"></i></a-->
                      <a href="javascript:;" class="panel-collapse"><i class="fa fa-chevron-down"></i></a>
                    </div>
                  </div>
                  <div class="panel-body collapse in">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="col-sm-4 control-label">Software que manejas</label>
                        <div class="col-sm-6">
                          <input type="text" class="form-control" id="cp" name="cp" value="" placeholder="Ingrese el software que maneja" title="Ingrese el software que maneja" tabindex="9" required />
                        </div>
                        <a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Ingrese el software que maneja">
                          <span class="fa fa-info-circle"></span>
                        </a>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="panel panel-midnightblue"> <!-- Prestaciones Integrales -->
                  <div class="panel-heading">
                    <h4>
                      Referencias Personales
                    </h4>
                    <div class="options">
                      <a href="javascript:;"><i class="fa fa-cog"></i></a>
                      <a href="javascript:;" onclick=""><i class="fa fa-times"></i></a>
                      <a href="javascript:;" class="panel-collapse"><i class="fa fa-chevron-down"></i></a>
                    </div>
                  </div>
                  <div class="panel-body collapse in">
                    <div class="col-md-4">
                      <div class="form-group">
                        <label class="col-sm-4 control-label">Nombre*</label>
                        <div class="col-sm-6">
                          <input type="text" class="form-control" id="cp" name="cp" value="" placeholder="Ingrese Nombre" title="Ingrese Nombre" tabindex="9" required />
                        </div>
                        <a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Ingrese el nombre">
                          <span class="fa fa-info-circle"></span>
                        </a>
                      </div>
                      <div class="form-group">
                        <label class="col-sm-4 control-label">Nombre*</label>
                        <div class="col-sm-6">
                          <input type="text" class="form-control" id="cp" name="cp" value="" placeholder="Ingrese Nombre" title="Ingrese Nombre" tabindex="9" required />
                        </div>
                        <a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Ingrese el nombre">
                          <span class="fa fa-info-circle"></span>
                        </a>
                      </div>
                      <div class="form-group">
                        <label class="col-sm-4 control-label">Nombre*</label>
                        <div class="col-sm-6">
                          <input type="text" class="form-control" id="cp" name="cp" value="" placeholder="Ingrese Nombre" title="Ingrese Nombre" tabindex="9" required />
                        </div>
                        <a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Ingrese el nombre">
                          <span class="fa fa-info-circle"></span>
                        </a>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label class="col-sm-4 control-label">Telefono*</label>
                        <div class="col-sm-6">
                          <input type="text" class="form-control" id="cp" name="cp" value="" placeholder="Ingrese telefono" title="Ingrese el  telefono" tabindex="9" required />
                        </div>
                        <a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Ingrese el telefono">
                          <span class="fa fa-info-circle"></span>
                        </a>
                      </div>
                      <div class="form-group">
                        <label class="col-sm-4 control-label">Telefono*</label>
                        <div class="col-sm-6">
                          <input type="text" class="form-control" id="cp" name="cp" value="" placeholder="Ingrese telefono" title="Ingrese el  telefono" tabindex="9" required />
                        </div>
                        <a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Ingrese el telefono">
                          <span class="fa fa-info-circle"></span>
                        </a>
                      </div>
                      <div class="form-group">
                        <label class="col-sm-4 control-label">Telefono*</label>
                        <div class="col-sm-6">
                          <input type="text" class="form-control" id="cp" name="cp" value="" placeholder="Ingrese telefono" title="Ingrese el  telefono" tabindex="9" required />
                        </div>
                        <a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Ingrese el telefono">
                          <span class="fa fa-info-circle"></span>
                        </a>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label class="col-sm-4 control-label">Parentesco*</label>
                        <div class="col-sm-6">
                          <input type="text" class="form-control" id="cp" name="cp" value="" placeholder="Ingrese su parentesco" title="Ingrese el código postal" tabindex="9" required />
                        </div>
                        <a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Ingrese su parentesco">
                          <span class="fa fa-info-circle"></span>
                        </a>
                      </div>
                      <div class="form-group">
                        <label class="col-sm-4 control-label">Parentesco*</label>
                        <div class="col-sm-6">
                          <input type="text" class="form-control" id="cp" name="cp" value="" placeholder="Ingrese su parentesco" title="Ingrese el código postal" tabindex="9" required />
                        </div>
                        <a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Ingrese su parentesco">
                          <span class="fa fa-info-circle"></span>
                        </a>
                      </div>
                      <div class="form-group">
                        <label class="col-sm-4 control-label">Parentesco*</label>
                        <div class="col-sm-6">
                          <input type="text" class="form-control" id="cp" name="cp" value="" placeholder="Ingrese su parentesco" title="Ingrese el código postal" tabindex="9" required />
                        </div>
                        <a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Ingrese su parentesco">
                          <span class="fa fa-info-circle"></span>
                        </a>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="panel panel-midnightblue">
                <div class="panel-heading">
                  <h4>
                    Empleos Anteriores
                  </h4>
                  <div class="options">
                    <a href="javascript:;"><i class="fa fa-cog"></i></a>
                    <!--a href="javascript:;" onclick="()"><i class="fa fa-refresh"></i></a-->
                    <a href="javascript:;" class="panel-collapse"><i class="fa fa-chevron-down"></i></a>
                  </div>
                </div>
                <div class="panel-body collapse in">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="col-sm-4 control-label">Empresa</label>
                      <div class="col-sm-6">
                        <input type="text" class="form-control" id="nombre" name="nombre" value="" placeholder="Ingrese nombre de la empresa" title="Ingrese nombre de la empresa"/>
                      </div>
                      <a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Nombre del candidato">
                        <span class="fa fa-info-circle"></span>
                      </a>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-4 control-label">Fecha de ingreso</label>
                      <div class="col-sm-6">
                        <div class="input-group date datepicker">
                          <input type="text" class="form-control" id="fecha" name="fecha" placeholder="Seleccione la fecha de ingreso" title="Seleccione la fecha" value="" tabindex="1" required />
                          <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                        </div>
                      </div>
                      <a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Seleccione la fecha">
                        <span class="fa fa-info-circle"></span>
                      </a>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-4 control-label">Puesto</label>
                      <div class="col-sm-6">
                        <input type="text" class="form-control" id="nombre" name="nombre" value="" placeholder="Ingrese puesto" title="Ingrese puesto"/>
                      </div>
                      <a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Ingrese puesto">
                        <span class="fa fa-info-circle"></span>
                      </a>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-4 control-label">Nombre de Jefe inmediato</label>
                      <div class="col-sm-6">
                        <input type="text" class="form-control" id="nombre" name="nombre" value="" placeholder="Ingrese nombre del jefe inmediato" title="Ingrese nombre del jefe inmediato"/>
                      </div>
                      <a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Ingrese nombre del jefe inmediato">
                        <span class="fa fa-info-circle"></span>
                      </a>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="col-sm-4 control-label">Telefono*</label>
                      <div class="col-sm-6">
                        <input type="text" class="form-control" id="telefono" name="telefono" value="" placeholder="Ingrese télefono " title="Ingrese télefono " tabindex="8" required/>
                      </div>
                      <a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Ingrese su edad">
                        <span class="fa fa-info-circle"></span>
                      </a>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-4 control-label">Fecha de Salida</label>
                      <div class="col-sm-6">
                        <div class="input-group date datepicker">
                          <input type="text" class="form-control" id="fecha" name="fecha" placeholder="Seleccione la fecha de salida" title="Seleccione la fecha e salida" value="" tabindex="1" required />
                          <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                        </div>
                      </div>
                      <a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Seleccione la fecha de salida">
                        <span class="fa fa-info-circle"></span>
                      </a>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-4 control-label">Motivo de salida</label>
                      <div class="col-sm-6">
                        <input type="text" class="form-control" id="valor" name="valor" value="" placeholder="Ingrese motivo de salida" title="Ingrese el RFC" tabindex="2" required />
                      </div>
                      <a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Ingrese el RFC">
                        <span class="fa fa-info-circle"></span>
                      </a>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-4 control-label">Puesto del Jefe inmediato*</label>
                      <div class="col-sm-6">
                        <input type="text" class="form-control" id="cp" name="cp" value="" placeholder="Ingrese nombre del jefe inmediato" title="Ingrese nombre del jefe inmediato" tabindex="9" required />
                      </div>
                      <a href="#" data-toggle="tooltip" data-placement="top" data-original-title="Ingrese nombre del jefe inmediato">
                        <span class="fa fa-info-circle"></span>
                      </a>
                    </div>
                  </div>
                </div>
                <div class="panel-footer">
                  <div class="row">
                    <div class="col-sm-6 col-sm-offset-3">
                      <div class="btn-toolbar">
                        <button type="submit" class="btn-primary btn btn-label" id="saveButton" tabindex="13"><i class="fa fa-save"></i> Guardar</button>
                        <button type="button" class="btn-default btn" onclick="window.location = 'cot01_cotizaciones_listado.php'" tabindex="14">Cancelar</button>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="alert alert-info" style="margin-top:15px">
                  <center>
                    <strong>Aviso de privacidad.</strong></br>
                    Sustentado en los artículos 15 y 16 de  la Ley Federal de Protección de Datos Personales en Posesión de Particulares hacemos de su conocimiento que TOPMKT, S.A. DE C.V. es responsable de recabar sus datos personales, del uso que se les da a los mismos y de su protección. Es importante informarle que usted tiene derecho al Acceso, Rectificación y Cancelación de sus datos personales, a Oponerse al tratamiento de los mismos o a revocar el consentimiento que para dicho fin nos haya otorgado. Para ello, es necesario que envié la solicitud en los términos que marca la Ley en su Art. 29 al LETICIA PEREZ VENEGAS, responsable de nuestro departamento de protección de Datos Personales, ubicado en HALLEY No.3 COL. ANZURES DEL. MIGUEL HIDALGO C.P.11590 HALLEY, MEXICO D.F., o bien, se comunique  al teléfono  5591126192 o vía correo electrónico a leticia.perez@topmkt.com.mx, el cual solicitamos confirme vía telefónica para garantizar su correcta recepción. En caso de que no obtengamos su oposición expresa para que sus datos personales sean transferidos en la forma y términos antes descrita, entenderemos que ha otorgado su consentimiento en forma táctica para ello.
                  </center>
                </div>
              </form>
            </div>
          </div>
        </div> <!-- container -->
      </div> <!--wrap -->
      <footer role="contentinfo">
        <div class="clearfix">
          <ul class="list-unstyled list-inline pull-left">
            <li>Top MKT &copy; 2018</li>
          </ul>
          <button class="pull-right btn btn-inverse-alt btn-xs hidden-print" id="back-to-top"><i class="fa fa-arrow-up"></i></button>
        </div>
      </footer>
    </div> <!-- page-container -->
    <script type='text/javascript' src='assets/js/jquery-1.10.2.min.js'></script>
    <script type='text/javascript' src='assets/js/jqueryui-1.10.3.min.js'></script>
    <script type='text/javascript' src='assets/js/bootstrap.min.js'></script>
    <script type='text/javascript' src='assets/js/enquire.js'></script>
    <script type='text/javascript' src='assets/js/jquery.cookie.js'></script>
    <script type='text/javascript' src='assets/js/jquery.nicescroll.min.js'></script>
    <script type='text/javascript' src='assets/plugins/codeprettifier/prettify.js'></script>
    <script type='text/javascript' src='assets/plugins/sparklines/jquery.sparklines.min.js'></script>
    <script type='text/javascript' src='assets/plugins/form-toggle/toggle.min.js'></script>
    <script type='text/javascript' src='assets/plugins/form-select2/select2.min.js'></script>
    <script type='text/javascript' src='assets/plugins/form-daterangepicker/daterangepicker.min.js'></script>
    <script type='text/javascript' src='assets/plugins/form-datepicker/js/bootstrap-datepicker.js'></script>
    <script type='text/javascript' src='assets/js/placeholdr.js'></script>
    <script type='text/javascript' src='assets/js/application.js'></script>
    <script type='text/javascript' src='assets/demo/demo.js'></script>
    <script src="assets/js/noty/js/noty/packaged/jquery.noty.packaged.min.js" type="text/javascript"></script>
    <script type='text/javascript' src='assets/plugins/progress-skylo/skylo.js'></script>
    <script type='text/javascript' src='assets/js/pages/rh02_curriculum.js'></script>
  </body>
</html>
