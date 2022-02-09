<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte {{$mesLiteral.' '.$gestion}}</title>
    <link rel="stylesheet" href="{{ public_path('css/bootstrap.css') }}">
    <link href="{{ public_path('css/estilos.css') }}" rel="stylesheet">
</head>
<body>
    <div class="content-fluid">
        <div class="row" style="font-family: 'Calibri';">
            <div class="col-4 text-center">
                <span>Universidad Mayor de San Andres</span> <br>
                <span>Facultad de Ingeniería</span> <br>
                <span>Ingeniería Eléctronica</span> 
            </div>
            <div class="col-8" style="float: right;">
                <img src="{{ public_path('logos/logoETN.jpg') }}" class="rounded float-right img-fluid" alt="Responsive image" style="width: 5rem;">
            </div>
        </div>
        <div class="my-2 text-center text-uppercase">
            <span class="h5 font-weight-bold">REPORTE DE ACTIVIDADES DOCENTE</span>
        </div>

        <div class="row my-2 small">
            <div class="col-7">
                <div>
                    <span class="font-weight-bold">ASIGNATURA:</span>
                    &nbsp;&nbsp;
                    <span class="font-weight-normal">{{$asignaturas->grupos->materias->nombreMat.' ('.$asignaturas->grupos->materias->sigla.')'}}</span>
                </div> 
                <div>
                    <span>
                        <span class="font-weight-bold">ACTIVIDAD:</span>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <span class="font-weight-normal">{{$asignaturas->actividades->actividad}}</span>    
                    </span>
                    &nbsp;&nbsp;&nbsp;  
                    <span>
                        <span class="font-weight-bold">GRUPO:</span>
                        &nbsp;&nbsp;&nbsp;
                        <span class="font-weight-normal">{{ $asignaturas->grupos->grupo}} </span>
                    </span>
                </div>
                <div>
                    <span class="font-weight-bold text-uppercase">DOCENTE:</span>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <span class="font-weight-normal">{{ $usuarios->titulos->tituloAbrev.' '.$usuarios->name.' '.$usuarios->apPaterno.' '.$usuarios->apMaterno}}</span>    
                </div>
            </div>
            <div class="col-5" style="float: right;">
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
                    &nbsp;&nbsp;
                    <span class="font-weight-normal text-capitalize">{{$mesLiteral.' '.$gestion}}</span>    
                </div>                
            </div>
        </div>
        <div class="table-responsive-sm mx-0 mb-0 small">
            <table class="table table-bordered table-sm">
                <thead class="text-center">
                    <tr class="bg-light">
                        <th class="align-middle" style="border: black 1px solid; width: 10%;" scope="col">FECHA</th>
                        <th class="align-middle" style="border: black 1px solid; width: 17%;" scope="col">ACTIVIDAD</th>
                        <th class="align-middle" style="border: black 1px solid;" scope="col">DESCRIPCIÓN</th>
                        <th class="align-middle" style="border: black 1px solid; width: 12%;" scope="col">AULA</th>
                        <th class="align-middle" style="border: black 1px solid; width: 8%;" scope="col">INICIO</th>
                        <th class="align-middle" style="border: black 1px solid; width: 8%;" scope="col">FINAL</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($eventos as $valor)
                    <tr>
                        <td class="text-center" style="border: black 1px solid;">{{ $valor->fecha->format('d/m/Y') }}</td>
                        <td class="text-center" style="border: black 1px solid;">{{ $valor->actividades->actividad }}</td>
                        <td style="border: black 1px solid;">{{ $valor->descripcion }}</td>
                        <td class="text-center" style="border: black 1px solid;">{{ $valor->aulas->aula }}</td>
                        <td class="text-center" style="border: black 1px solid;">{{ $valor->horaInicio->format('G:i') }}</td>
                        <td class="text-center" style="border: black 1px solid;">{{ $valor->horaFinal->format('G:i') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <br><br><br>
        <div class="text-center row">
            <div class="col-6" style="position: fixed; bottom: 20px; left: 0px; right: 0px; height: 50px; line-height: 35px;">
                <div class="font-weight-normal">{{ $usuarios->titulos->tituloAbrev.' '.$usuarios->name.' '.$usuarios->apPaterno.' '.$usuarios->apMaterno}}</div>
                <div class="font-weight-normal text-uppercase" style="line-height: 110%;">{{ $usuarios->niveles->nivel}}</div>
            </div> 
            <div class="col-6" style="float: right; position: fixed; bottom: 20px; left: 0px; right: 0px; height: 50px; line-height: 35px;">
                <span class="font-weight-normal">Vo.Bo. Director de carrera</span>
                &nbsp;
            </div>           
        </div>
    </div>
    <p class="align-top small my-0" style="position: fixed; bottom: -50px; left: 0px; right: 0px; height: 50px; line-height: 35px;">© 2021 (FmCr) - Sistema Organizador, Ingeniería Electrónica UMSA</p>
    <script src="{{ public_path('js/bootstrap.js') }}"></script>
</body>
</html>