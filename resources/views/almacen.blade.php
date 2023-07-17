<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de paquetes</title>
</head>
<body>
    
    @include("encabezado");

    <table>
        <tr>
            <td>
                ID
            </td>
            <td>
                Nombre
            </td>
            <td>
                nombre del destinatario
            </td>
            <td>
                Fecha Creación
            </td>
            <td>
                Fecha Modificación
            </td>
        </tr>
      
        @foreach($Paquetes as $p)
            <tr>
                <td>
                    {{ $p -> id }}
                </td>
                <td>
                    {{ $p -> nombre }}
                </td>
                <td>
                    {{ $p -> nombre_del_remitente }}
                </td>
                <td>
                    {{ $p -> created_at }}
                </td>
                <td>
                    {{ $p -> updated_at }}
                </td>

                <td>
                      <form action="{{ url('/eliminar',$p->id) }}" method="POST">
                      {{method_field('DELETE')}}
                      @csrf
                      <button type="submit" class="btn btn-outline-danger">borrar</button>
                      </form>
                </td>

            </tr>
        @endforeach


    </table>

</body>
</html>