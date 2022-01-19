<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FICHA DE ASISTENCIA {{ $mesLiteral.' '.$gestion }}</title>
    <link rel="stylesheet" href="{{ public_path('css/bootstrap.css') }}">
    <link href="{{ public_path('css/estilos.css') }}" rel="stylesheet">
</head>
<body>
    <div class="content-fluid">
        <div class="row">
            <div class="col-3 text-center">
                <span>Universidad Boliviana</span> <br>
                <span>Universidad Mayor de San Andres</span> <br>
                <span>División de becas académicas</span> 
            </div>
        </div>
        <div class="my-2 text-center">
            <span class="h4 font-weight-bold">FICHA DE ASISTENCIA - AUXILIAR ACADÉMICO</span><br>
        </div>

        <div class="row my-2">
            <div class="col-7">
                <div>
                    <span class="font-weight-bold">FACULTAD:</span>
                    &nbsp;&nbsp;
                    <span class="font-weight-normal">Ingeniería</span>
                </div> 
                <div>
                    <span class="font-weight-bold">ASIGNATURA:</span>
                    &nbsp;&nbsp;
                    <span class="font-weight-normal">{{$asignaturas->grupos->materias->nombreMat.' ('.$asignaturas->grupos->materias->sigla.')'}}</span>
                </div>
                <div>
                    <span class="font-weight-bold">NOMBRE DEL DOCENTE:</span>
                    &nbsp;&nbsp;
                    <span class="font-weight-normal">{{$docente[0]->docAbrev}}</span>
                </div> 
                <div>
                    <span class="font-weight-bold text-uppercase">{{ $usuarios->niveles->nivel}}:</span>
                    &nbsp;
                    <span class="font-weight-normal">{{ $usuarios->apPaterno.' '.$usuarios->apMaterno.' '.$usuarios->name}}</span>    
                </div> 
            </div>
            <div class="col-5" style="float: right;">
                <div>
                    <span class="font-weight-bold">CARRERA:</span>
                    &nbsp;&nbsp;
                    <span class="font-weight-normal">Ingeniería Electrónica</span>
                </div>
                <div>
                    <span class="font-weight-bold">GESTIÓN ACADÉMICA:</span>
                    &nbsp;&nbsp;
                    <span class="font-weight-normal">{{ $periodo.' / '.$gestion }}</span>
                </div>
                <div>
                    <span class="font-weight-bold">CARGA HORARIA:</span>
                    &nbsp;&nbsp;
                    <span class="font-weight-normal">{{ $asignaturas->carga.' Hrs.'}}</span>
                    &nbsp;&nbsp;
                    <span class="font-weight-bold">ITEM:</span>
                    &nbsp;&nbsp;
                    <span class="font-weight-normal">_______</span>
                </div>  
                <div>
                    <span class="font-weight-bold">MES TRABAJADO:</span>
                    &nbsp;
                    <span class="font-weight-normal text-capitalize">{{$mesLiteral}}</span>    
                </div>             
            </div>
        </div>
        <div class="table-responsive-sm mx-0 mb-0">
            <table class="table table-bordered table-sm">
                <thead class="small text-center">
                    <tr class="bg-light">
                        <th class="align-middle" style="border: black 1px solid; width: 10%;" rowspan="2" scope="col">FECHA</th>
                        <th class="align-middle" style="border: black 1px solid;" rowspan="2" scope="col">ACTIVIDAD DESARROLLADA</th>
                        <th class="align-middle" style="border: black 1px solid; width: 7%;" rowspan="2" scope="col">NRO ALUMNOS</th>
                        <th class="align-middle" style="border: black 1px solid;" colspan="2" scope="col">HORA</th>
                        <th class="align-middle" style="border: black 1px solid;" rowspan="2" scope="col">NOMBRE <br>DELEGADO ESTUDIANTIL</th>
                        <th class="align-middle" style="border: black 1px solid;" rowspan="2" scope="col">FIRMA<br>DELEGADO ESTUDIANTIL</th>
                        <th class="align-middle" style="border: black 1px solid;" rowspan="2" scope="col">OBS</th>
                    </tr>
                    <tr class="bg-light">
                        <th style="border: black 1px solid; width: 6%;" scope="col">INICIO</th>
                        <th style="border: black 1px solid; width: 6%;" scope="col">FINAL</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($eventos as $valor)
                    <tr>
                        <td class="text-center" style="border: black 1px solid;">{{ $valor->fecha->format('d/m/Y') }}</td>
                        <td style="border: black 1px solid;">{{ $valor->descripcion }}</td>
                        <td class="text-center" style="border: black 1px solid;"></td>
                        <td class="text-center" style="border: black 1px solid;">{{ $valor->horaInicio->format('G:i') }}</td>
                        <td class="text-center" style="border: black 1px solid;">{{ $valor->horaFinal->format('G:i') }}</td>
                        <td class="text-center" style="border: black 1px solid;"></td>
                        <td class="text-center" style="border: black 1px solid;"></td>
                        <td class="text-center" style="border: black 1px solid;"></td>
                    </tr>
                    @endforeach
                </tbody>
                <p class="align-top small mt-0">El Auxiliar Académico, cumplió con las tareas planificadas de acuerdo a la carga horaria asignada</p>
            </table>

        </div>

        <br><br>
        <div class="text-center row" >
            <div class="col-6" style="position: fixed; bottom: 20px; left: 0px; right: 0px; height: 50px; line-height: 35px;">
                <span class="font-weight-normal">NOMBRE Y FIRMA DEL DOCENTE</span><br>
            </div> 
            <div class="col-6" style="float: right; position: fixed; bottom: 20px; left: 0px; right: 0px; height: 50px; line-height: 35px;">
                <span class="font-weight-normal">Vo.Bo. DIRECTOR DE CARRERA</span>
                &nbsp;
            </div>           
        </div>        
    </div>
    <br>
    <p style="position: fixed; bottom: -50px; left: 0px; right: 0px; height: 50px; line-height: 35px;">NOTA: La ficha tiene validez con la firma del señor Docente</p>
    <script src="{{ public_path('js/bootstrap.js') }}"></script>
</body>
</html>