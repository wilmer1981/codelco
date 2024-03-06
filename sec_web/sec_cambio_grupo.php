<?php 	
	include("../principal/conectar_principal.php");

  // NumI=4580&NumF=4590&MesI=D&Valores=D//4580//2022-04-02//c&CodigoLote=D&NumeroLote=4580&Ano=2022

$NumI        = $_REQUEST["NumI"];
$NumF        = $_REQUEST["NumF"];
$MesI        = $_REQUEST["MesI"];
//$MesF        = $_REQUEST["MesF"];
$Valores     = $_REQUEST["Valores"];
$CodigoLote  = $_REQUEST["CodigoLote"];
$NumeroLote  = $_REQUEST["NumeroLote"];
$Ano         = $_REQUEST["Ano"];


$meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");	
?>
<html>
<head>
<script language="JavaScript">
function Grabar()
{
	var Frm=document.FrmProceso;
	Frm.action="sec_conf_inicial_lotes_proceso01.php?Proceso=CambioGrupo&CmbGrupo="+Frm.CmbGrupo.value;
	Frm.submit();
	
}
function Salir()
{
	window.close();
}
</script>
<title>Proceso</title>
<link href="../principal/estilos/css_cal_web.css" type="text/css" rel="stylesheet">
<body  background="../principal/imagenes/fondo3.gif" leftmargin="3" topmargin="5" marginwidth="0" marginheight="0">
<form name="FrmProceso" method="post" action="">
<input name="ValoresAux" type="hidden" value="<?php echo $Valores  ?>">
<input name="CodLote" type="hidden" value="<?php echo $CodigoLote  ?>">
<input name="NumLote" type="hidden" value="<?php echo $NumeroLote ?>">
<input name="AnoAux" type="hidden" value="<?php echo $Ano  ?>">
<input name="MesIAux" type="hidden" value="<?php echo $MesI ?>">
<input name="NumIAux" type="hidden" value="<?php echo $NumI  ?>">
<input name="NumFAux" type="hidden" value="<?php echo $NumF ?>">
  <table width="151" height="74" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal" left="5">
    <tr>
    <td width="395"><table width="141" border="0" >
          <tr> 
            <td width="45">Grupo</td>
            <td width="86" align="right"><div align="left"> 
                <select name="CmbGrupo">
                  <?php
                  $Consulta="SELECT * from sec_web.grupo_electrolitico order by cod_grupo";
                  $Respuesta=mysqli_query($link, $Consulta);
                  while($Fila=mysqli_fetch_array($Respuesta))
                  {
                    if ($CmbGrupo==$Fila["cod_grupo"])
                    {
                      echo "<option value='".$Fila["cod_grupo"]."' selected>Grupo&nbsp;".$Fila["cod_grupo"]."</option>";
                    }
                    else
                    {
                      echo "<option value='".$Fila["cod_grupo"]."'>Grupo&nbsp;".$Fila["cod_grupo"]."</option>";
                    }
                  }
                  ?>
                </select>
                &nbsp;&nbsp;&nbsp;</div></td>
          </tr>
        </table>
        <br>
        <table width="138" border="0">
          <tr> 
            <td  align="center" width="132"><input type="button" name="BtnGrabar" value="Grabar" style="width:60" onClick="Grabar('')">
              <input type="button" name="BtnSalir" value="Salir" style="width:60" onClick="Salir();">
              &nbsp; </td>
          </tr>
        </table> </td>
  </tr>
</table>
  </form>
</body>
</html>
