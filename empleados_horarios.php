<<?php
session_start();
require_once("../../conexion.php");
require_once("../../libreria_menu.php");
// $db->debug=true;
echo "<html> 
       <head>
          <link rel='stylesheet' href='../../css/estilos.css' type='text/css'>
          <script>
            
            
                function redirigirReporteTortas() {
                ventanaCalendario = window.open('reportes33.php', 'calendario', 'width=400, height=550,left=100,top=100,scrollbars=yes,menubars=no,statusbar=NO,status=NO,resizable=YES,location=NO');
            }
          
                
          </script>
        </head>
        <body>
        <p></p>
        <h1 style='color:white;'>REPORTES ESTADISTICOS GRAFICOS</h1>
        <form method='post' name='formu'>
        <center>
          <table>
          <tr>
            <th style='border: black 1px solid; background-color:blue; color:white'>
              <h2>Seleccione el Reporte Estadistico</h2>
            </th>
          </tr>
          <tr>
            <th style='border: black 1px solid; color:white'>
              <div style='text-align: center;'>
                
                
                <br><br>
                <input style= 'margin-left:-47px;' type='radio' name='reporte33' value='3' onclick='redirigirReporteTortas()'> Reporte : 3d columna interactiva EMPLEADOS CON HORARIOS 
                 <br><br>
                
             
              </div>
            </th>
          </tr>
          </table>
        </center>
        </form>
        </body>
        </html>";
?>
