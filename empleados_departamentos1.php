<?php
session_start();
require_once("../../conexion.php");

//$db->debug=true;

$nombre1= $_REQUEST["tipo"];
$fecha=date("Y-m-d H:i:s");

if ($nombre1 == "tds"){
    $sql = $db->Prepare("SELECT CONCAT_WS(' ', emp.ap, emp.nombre) as empleado,dp.nom_dpto as departamento
                        FROM empleados_departamentos emp_dp
                        INNER JOIN empleados as emp ON emp.ID_empleado=emp_dp.ID_empleado
                        INNER JOIN departamentos as dp ON dp.id_departamento=emp_dp.id_departamento
                        WHERE emp.estado <> 'X'
                        AND dp.estado <> 'X'
                        AND emp_dp.estado <> 'X'
                      ");
    $rs = $db->GetAll($sql);      
               
}else {
    $sql = $db->Prepare("SELECT CONCAT_WS(' ', emp.ap, emp.nombre) as empleado,
                        CASE
                        WHEN dp.nom_dpto = 'Ventas' THEN 'VENTAS'
                        WHEN dp.nom_dpto = 'Recursos Humanos' THEN 'RECURSOS HUMANOS'
                        WHEN dp.nom_dpto = 'Administracion' THEN 'ADMINISTRACION'
                        WHEN dp.nom_dpto = 'Soporte Tecnico' THEN 'SOPORTE TECNICO'
                        WHEN dp.nom_dpto = 'Marketing' THEN 'MARKETING'
                        WHEN dp.nom_dpto = 'Contabilidad' THEN 'CONTABILIDAD'
                        WHEN dp.nom_dpto = 'Diseño' THEN 'DISEÑO'
                        WHEN dp.nom_dpto = 'Ingenieria' THEN 'INGENIERIA'
                        WHEN dp.nom_dpto = 'Recepcion' THEN 'RECEPCION'
                            ELSE 'no'
                        END AS departamento
                        FROM empleados_departamentos emp_dp
                        INNER JOIN empleados as emp ON emp.ID_empleado=emp_dp.ID_empleado
                        INNER JOIN departamentos as dp ON dp.id_departamento=emp_dp.id_departamento
                        WHERE dp.nom_dpto = ?
                        
                        AND emp.estado <> 'X'
                        AND dp.estado <> 'X'
                        AND emp_dp.estado <> 'X'
                       ");
    $rs = $db->GetAll($sql, array($nombre1));                       
}

$sql1 = $db->Prepare("SELECT *
                      FROM empresa
                      WHERE ID_empresa = 1
                      AND estado <> 'X'
                   ");
$rs1 = $db->GetAll($sql1);  

$nombre = $rs1[0]["nom_empresa"];
$logo = $rs1[0]["logo"];

echo "<html>
    <head>
        <script type='text/javascript'>
            var ventanaCalendario=false
            function imprimir() {
                if (confirm(' Desea Imprimir ?')){
                    window.print();
                }
            }
        </script>
    </head>
    <body style='cursor:pointer;cursor:hand' onClick='imprimir();'>";
    
    if ($rs) {
        echo "<table width='100%' border='0'>
            <tr>
                <td><img src='../../uploads/" . htmlspecialchars($logo, ENT_QUOTES, 'UTF-8') . "' width='150px'></td>
                <td align='center' width='80%'><h1>REPORTES DE CLIENTES CON TIPOS</h1></td>
            </tr>
        </table>";
    
    echo "
    <center>
        <table border='1' cellspacing='0'>
            <tr>
                <th>Nro</th><th>EMPLEADO</th><th>DEPARTAMENTO</th>
            </tr>";

            $b=1;
            foreach ($rs as $k => $fila) {
            echo "<tr>
                    <td align='center'>".$b."</td>
                    <td>".$fila['empleado']."</td> 
                    <td><i>".$fila['departamento']."</i></td> 
                 </tr>";
                $b=$b+1;
            }
            echo "</table><br>
             <b>Fecha :</b>".$fecha."</b></center>";
    }
             echo "</body>
             </html> ";
             
?>