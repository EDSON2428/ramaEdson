<?php
// Iniciar almacenamiento en búfer de salida
ob_start();

session_start();
require_once("../../conexion.php");
require_once("../../libreria_menu.php");

// Inicializar la sesión de empleados si no está configurada
if (!isset($_SESSION['empleados'])) {
    $_SESSION['empleados'] = [];
}

echo "<html> 
       <head>
         <link rel='stylesheet' href='../../css/estilos.css' type='text/css'>
         <meta http-equiv='Content-type' content='text/html;charset=utf-8' />
         <style>
            .center-button {
                display: flex;
                justify-content: center;
                margin-top: 30px;
                padding: 15px 60px 25px 1px;
            }
            .button-style,
            .button-save {
                display: inline-block; /* Permite que el botón tenga un ancho específico */
                text-align: center; /* Alinea el texto horizontalmente al centro */
                cursor: pointer;
                border-radius: 10px;
                padding: 10px 20px; /* Ajusta el padding para centrar el texto mejor */
                background-color: white;
                color: black;
                border: 2px solid #007bff;
                font-weight: bold;
                transition: background-color 0.3s, color 0.3s;
                line-height: normal; /* Asegura que el texto no se desplace verticalmente */
            }
            .button-style:hover,
            .button-save:hover {
                background-color: #007bff;
                color: white;
            }
            .button-save {
                padding: 15px 10px 25px 5px; /* Ajusta el padding: arriba, derecha, abajo, izquierda */
                background-color: #28a745;
                border: none;
                text-align: left; /* Alinea el texto a la izquierda */
                display: block; /* Asegura que el botón respete el ancho y el texto se alinee correctamente */
            }
            .button-save:hover {
                background-color: #218838;
            }
            /* Estilos para alinear los inputs dentro del formulario de modificación */
            .form-modificar {
                display: flex;
                flex-direction: column;
                align-items: flex-start; /* Alinea los elementos a la izquierda */
                margin-top: 700px;
                padding: 10px;
                gap: 10px; /* Espacio entre los elementos del formulario */
                background-color: #f0f0f0; /* Fondo claro para destacar los inputs */
                border-radius: 8px;
                width: fit-content; /* Ajusta el ancho del contenedor */
                position: absolute; /* Posiciona el formulario de manera absoluta */
                top: 50%; /* Centra verticalmente */
                left: 50%; /* Centra horizontalmente */
                transform: translate(-50%, -50%); /* Ajusta el formulario al centro de la pantalla */
            }
            /* Estilo para los inputs dentro del formulario de modificación */
            .form-modificar label {
                display: flex;
                flex-direction: column; /* Coloca los inputs debajo de sus etiquetas */
                font-weight: bold;
                margin-bottom: 5px; /* Espacio entre el texto y el input */
            }
            .form-modificar input[type='text'] {
                padding: 5px 10px;
                border: 1px solid #ccc;
                border-radius: 5px;
                width: 250px; /* Ajusta el ancho del input */
                box-sizing: border-box; /* Asegura que el padding no aumente el ancho total */
            }
         </style>
       </head>
       <body>
       <p>&nbsp;</p>
       <center>
           <h1>LISTADO DE EMPLEADOS (JSONPlaceholder)</h1>
       </center>
       <!-- Contenedor para centrar el botón -->
       <div class='center-button'>
           <!-- Botón para redirigir a la API de empleados -->
           <form action='' method='get'>
               <input type='submit' name='ver_empleados' value='Ver Empleados API' class='button-style'>
           </form>
       </div>
       <br>";

// Cargar los empleados desde la API si se presiona el botón "Ver Empleados API"
if (isset($_GET['ver_empleados'])) {
    // URL de la API de JSONPlaceholder para obtener los empleados
    $url = 'https://jsonplaceholder.typicode.com/users';

    // Inicializar cURL
    $ch = curl_init($url);

    // Configurar opciones de cURL
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json'
    ]);
    // Desactivar la verificación de SSL
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

    // Ejecutar la petición y obtener la respuesta
    $response = curl_exec($ch);

    // Verificar errores en cURL
    if (curl_errno($ch)) {
        echo 'Error en la solicitud: ' . curl_error($ch);
        exit;
    }

    // Cerrar cURL
    curl_close($ch);

    // Convertir la respuesta JSON a un array PHP
    $empleados = json_decode($response, true);

    // Guardar los datos en la sesión para simular cambios
    $_SESSION['empleados'] = $empleados;
}

// Mostrar la tabla de empleados si hay datos en la sesión
if (!empty($_SESSION['empleados'])) {
    echo '<center>';
    echo '<table border="1" class="listado">';
    echo '<tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Email</th>
            <th>Compañía</th>
            <th>Modificar</th>
            <th>Eliminar</th>
          </tr>';

    foreach ($_SESSION['empleados'] as $index => $empleado) {
        echo '<tr>
                <td align="center">' . htmlspecialchars($empleado['id']) . '</td>
                <td>' . htmlspecialchars($empleado['name']) . '</td>
                <td>' . htmlspecialchars($empleado['email']) . '</td>
                <td>' . htmlspecialchars($empleado['company']['name']) . '</td>
                <td align="center">
                    <form method="post" action="">
                        <input type="hidden" name="index" value="' . $index . '">
                        <input type="submit" name="modificar" value="Modificar >>" class="button-style">
                    </form>
                </td>
                <td align="center">
                    <form method="post" action="">
                        <input type="hidden" name="index" value="' . $index . '">
                        <input type="submit" name="eliminar" value="Eliminar >>" class="button-style" onclick="return confirm(\'¿Desea realmente eliminar al empleado?\')">
                    </form>
                </td>
              </tr>';
    }

    echo '</table>';
    echo '</center>';
} else {
    echo "<p>No se encontraron empleados para mostrar.</p>";
}

// Simular eliminación de un empleado
if (isset($_POST['eliminar'])) {
    $index = $_POST['index'];
    unset($_SESSION['empleados'][$index]); // Elimina el empleado de la sesión
    $_SESSION['empleados'] = array_values($_SESSION['empleados']); // Reindexar el array
    header('Location: empleados_api.php'); // Recargar la página
    exit;
}

// Simular modificación de un empleado
if (isset($_POST['modificar'])) {
    $index = $_POST['index'];
    $empleado = $_SESSION['empleados'][$index];
    echo "<div class='form-modificar'>
            <form method='post' action=''>
                <input type='hidden' name='index' value='$index'>
                <label>Nombre: <input type='text' name='name' value='" . htmlspecialchars($empleado['name']) . "'></label>
                <label>Email: <input type='text' name='email' value='" . htmlspecialchars($empleado['email']) . "'></label>
                <label>Compañía: <input type='text' name='company' value='" . htmlspecialchars($empleado['company']['name']) . "'></label>
                <input type='submit' name='guardar_cambios' value='Guardar Cambios' class='button-save'>
            </form>
          </div>";
}

// Guardar cambios simulados de un empleado
if (isset($_POST['guardar_cambios'])) {
    $index = $_POST['index'];
    $_SESSION['empleados'][$index]['name'] = $_POST['name'];
    $_SESSION['empleados'][$index]['email'] = $_POST['email'];
    $_SESSION['empleados'][$index]['company']['name'] = $_POST['company'];
    header('Location: empleados_api.php'); // Recargar la página para aplicar los cambios
    exit;
}

echo "<a href='http://localhost/proyecto/SistemaWeb/listado_tablas.php'>
        <input type='button' style='cursor:pointer;border-radius:20px;margin-top:70px;font-weight:bold;height: 45px;' value='<<=Volver'></input>
      </a>";

echo "</body></html>";

// Enviar el búfer de salida y cerrar
ob_end_flush();
?>
