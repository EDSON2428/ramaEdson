<?php
session_start();
require_once("../../conexion.php");
require_once("../../libreria_menu.php");
// $db->debug=true;

echo "<html>
<head> 
    <link rel='stylesheet' href='../../css/estilos.css' type='text/css'>
    <script type='text/javascript'>
        function validar() {
            tipo = document.formu.tipo.value;
            if (document.formu.tipo.value == '') {
                alert('Seleccione el tipo');
                document.formu.tipo.focus();
                return;
            }
            ventanaCalendario = window.open('empleados_departamentos1.php?tipo=' + tipo, 'calendario', 'width=600,height=550,left=100,top=100,scrollbars=yes,menubars=no,statusbar=NO,status=NO,resizable=YES,location=NO')
        }
    </script>
</head>
<body>
    <p></p>
    <h1 align='center'>REPORTE DE EMPLEADOS POR DEPARTAMENTOS</h1>
    <form method='post' name='formu'>
        <center>
            <table border='1'>
                <tr>
                    <th><h3>*Seleccione Departamento </h3></th>
                    <th>:</th>
                    <td>
                        <select name='tipo'>
                            <option value=''>Seleccione</option>
                            <option value='tds'>Todos</option>
                            <option value='Ventas'>Ventas</option>
                            <option value='Recursos Humanos'>Recursos Humanos</option>
                            <option value='Administracion'>Administracion</option>
                            <option value='Soporte Tecnico'>Soporte Tecnico</option>
                            <option value='Marketing'>Marketing</option>
                            <option value='Contabilidad'>Contabilidad</option>
                            <option value='Diseño'>Diseño</option>
                            <option value='Ingenieria'>Ingenieria</option>
                            <option value='Recepcion'>Recepcion</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td align='center' colspan='6'>
                        <input type='hidden' name='accion' value=''>
                        <input type='button' value='Aceptar' onclick='validar();' class='boton2'>
                    </td>
                </tr>
            </table>
        </center>
    </form>
</body>
</html>";
?>
