<?php
ob_start();
session_start();
require_once("../../conexion.php");

//$db->debug=true;

echo"<html>
           <head>

        </head>

        <body>";

        $sql = $db->Prepare('SELECT * FROM vista_empleado_horario');
        $rs = $db->GetAll($sql);

        $sql1 = $db->Prepare('SELECT * FROM vistas_empresa');
        $rs1 = $db->GetAll($sql1);

        $nom_empresa = $rs1[0]["nom_empresa"];
        $logo = $rs1[0]["logo"];
        $fecha= date("Y-m-d H:i:s");

        if ($rs) { 
           echo $_SERVER['HTTP_HOST'];

           echo"<table border='0' width='100%' >

                <tr>
                
                   
                    <td><img src='../../uploads/" . htmlspecialchars($logo, ENT_QUOTES, 'UTF-8') . "' width='150px'>
                    </td>

                    <td align='center' width='80%'><h1>REPORTES DE EMPLEADOS - HORARIOS</h1></td>
                    </tr>
                   </table>";

            echo"
            <center>
            <table border='1' cellspacing='0' width='100%' >
            <tr>
                <th>Nro</th><th>EMPLEADOS</th><th>HORARIO DE ENTRADA Y SALIDA</th>
            </tr>";
            $b=1;
            foreach ($rs as $k => $fila) {
            echo"<tr>
                    <td align='center'>".$b."</td>
                    <td>".$fila[ 'empleado' ]."</td>
                    <td align='center'><i>".$fila[ 'horario']."</i></td>
                </tr>";
            $b=$b+1;
        }  

        echo"</table><br>
        <b>Fecha :</b>".$fecha."</center>";

    }
echo "</body>
</html> ";

$html=ob_get_clean();
echo $html;

require_once("../dompdf/autoload.inc.php");
use Dompdf\Dompdf;
$dompdf =new Dompdf();