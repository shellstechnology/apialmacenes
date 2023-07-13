<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ingresar paquetes</title>
</head>
<body>
@include("encabezado");

<form action="/IngresarUnPaquete" method="post">
    @csrf 
    Nombre <input type="text" name="nombre" id=""> <br>
    Estado <input type="number" name="estado" id=""> <br>
    volumen en litros <input type="number" name="volumenEnL" id=""> <br>
    peso en kilogramos <input type="number" name="pesoEnKg" id=""> <br>
    Tipo de paquete <input type="number" name="tipoDePaquete" id=""> <br>
    nombre del destinatario<input type="text" name="nombreDelDestinatario" id=""> <br>
    nombre del remitente <input type="text" name="nombreDelRemitente" id=""> <br>
    fecha de entrega <input type="date" name="fechaDeEntrega" id=""> <br>
    <input type="submit" value="Enviar">

</form>

@isset($creado)
    <b>Persona creada</b>
@endisset
</body>
</html>