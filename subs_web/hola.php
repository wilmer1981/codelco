<html>
<head>
<title>Documento sin t&iacute;tulo</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body>
<form name="hola" action="" method="post">
<table width="730" height="263"  align="center" cellpadding="5" cellspacing="0">
  <tr>
    <td><table width="650" align="center" cellpadding="3" cellspacing="0">
          <tr> 
            <td align="center" width="300">Titulo de la pagina</td>
			<tr> para ti</tr>
            <td align="center">Otro titulo</td>
          </tr>
        </table></td>
  </tr>
</table>
</form>
<?php
//Fecha de inicio, alojada en la BD:
$fecha_inicio=$row_RSusuarios['fecha_subscrip'];
//final: dentro de 90 dias
$fecha_final=strtotime("+90 days", $fecha_inicio);
//¿Cuanto queda?
$quedan_dias=ceil(($fecha_final-time())/86400);
//damos un poco de formato a los dias restantes...
switch($quedan_dias){
  case 0:
    $dias="hoy";
    break;
  case 1:
    $dias="mañana";
    break;
  default:
    $dias="dentro de ".$quedan_dias." días";
}
?> 
</body>
</html>
