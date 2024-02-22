<? 	
	include("../principal/conectar_principal.php");
	switch($Proceso)
	{
		case "N":
			break;
		case "M":
			$Datos=explode('//',$Valores);
			$TxtCodigo=$Datos[0];
			$Consulta = "SELECT * from proyecto_modernizacion.funcionarios t1 inner join proyecto_modernizacion.sistemas_por_usuario t2 on t1.rut=t2.rut";
			$Consulta.=" inner join proyecto_modernizacion.niveles_por_sistema t3 on t2.cod_sistema=t3.cod_sistema and t2.nivel=t3.nivel";
			$Consulta.=" where t2.cod_sistema='29' and t1.rut='".$TxtCodigo."' order by apellido_paterno";
			//echo $Consulta."<br>";
			$Respuesta=mysql_query($Consulta);
			$Fila=mysql_fetch_array($Respuesta);
			$CmbCCosto2=substr($Fila["cod_centro_costo"],3);
			$CmbCCosto2=str_replace('.','',$CmbCCosto2);
			$TxtCodigo=$Fila["rut"];
			$TxtNombres=$Fila["apellido_paterno"]." ".$Fila["apellido_paterno"]." ".$Fila["nombres"];
			$TxtApePaterno=$Fila["apellido_paterno"];
			$TxtApeMaterno=$Fila["apellido_materno"];
			$CmbNivel3=$Fila["nivel"];
			//echo $CmbRut."<br>";
			break;	
	}	
?>
<html>
<head>
<script language="JavaScript">
function Grabar(Proceso,Valores)
{
	var Frm=document.FrmProceso;
	Frm.action="ingreso_funcionarios_proceso01.php?Proceso="+Proceso+"&TxtCodigo="+Valores;
	Frm.submit();
}
function Recarga(Proceso)
{
	var Frm=document.FrmProceso;
	
	Frm.action="ingreso_funcionarios_proceso.php?Proceso="+Proceso;
	Frm.submit();
	
}

function Salir()
{
	window.close();
	
}
</script>
<title>Proceso</title>
<link href="estilos/siper_style.css" rel="stylesheet" type="text/css">
<?
	echo "<body leftmargin='3' topmargin='5' marginwidth='0' marginheight='0'>";
?>

<form name="FrmProceso" method="post" action="">
  <table width="55%" align="center"  border="0" cellpadding="0"  cellspacing="0">
    <tr>
      <td height="1%"><img src="imagenes/interior2/esq1.gif" width="15" height="15" /></td>
      <td width="98%" height="15" background="imagenes/interior2/form_arriba.gif"><img src="imagenes/interior2/transparent.gif" width="4" height="15" /></td>
      <td height="1%"><img src="imagenes/interior2/esq2.gif" width="15" height="15" /></td>
    </tr>
    <tr>
      <td width="1%" background="imagenes/interior2/form_izq.gif"></td>
      <td align="center"><table width="100%" height="157" border="0" cellpadding="0" cellspacing="0" class="TablaPricipalColor" align="center">
          <tr>
            <td width="554" align="center"><table width="100%" border="1" cellpadding="0" cellspacing="0" class="TablaInterior">
				<tr>
				  <td width="96" class='TituloCabecera' colspan="2">Ingreso&nbsp;de&nbsp;Usuario</td>
				</tr>
                <tr>
                  <td width="96" class="formulario">Rut</td>
                  <td width="336"><?
			  if($Proceso=='M')
					echo $TxtCodigo;	
			  else
			  {
					$Consulta="SELECT distinct t1.rut,t1.apellido_paterno,t1.apellido_materno,t1.nombres from proyecto_modernizacion.funcionarios t1 inner join sistemas_por_usuario t2 on t1.rut=t2.rut where t2.cod_sistema='29' order by apellido_paterno";
					$Resultado=mysql_query($Consulta);
					while ($Fila=mysql_fetch_array($Resultado))
						$In=$In."'".$Fila["rut"]."',";
					 if($In !='')
							$In=substr($In,0,strlen($In)-1);						
					echo "<SELECT name='CmbRut' style='width:320'>";
					echo "<option value='-1'>SELECCIONAR</option>";
					//$Consulta1="SELECT distinct t1.rut,t1.apellido_paterno,t1.apellido_materno,t1.nombres from proyecto_modernizacion.funcionarios t1 inner join sistemas_por_usuario t2 on t1.rut=t2.rut ";
					//$Consulta1.="where t2.cod_sistema<>'29' and t1.rut not in($In) order by apellido_paterno";
					$Consulta1="SELECT distinct t1.rut,t1.apellido_paterno,t1.apellido_materno,t1.nombres from proyecto_modernizacion.funcionarios t1 ";
					$Consulta1.="where t1.rut not in($In) order by t1.apellido_paterno";
					
					$Resultado1=mysql_query($Consulta1);
					while ($Fila1=mysql_fetch_array($Resultado1))
					{
						if(strlen($Fila1["rut"])==9)
							$Rut='0'.$Fila1["rut"];	
						else
							$Rut=$Fila1["rut"];				
						$Nombre=$Fila1["apellido_paterno"]." ".$Fila1["apellido_materno"]." ".$Fila1["nombres"];
						if ($CmbRut==$Fila1["rut"])			
							echo "<option value='$Fila1["rut"]."' SELECTed>".$Rut."-".strtoupper($Nombre)."</option>";
						else
							echo "<option value='$Fila1["rut"]."'>".$Rut."-".strtoupper($Nombre)."</option>";
					}
					echo "</SELECT>";  
			  }		
  			  ?>                  </td>
                </tr>
                <?
			 if($Proceso=='M')
			{		  
		  ?>
                <tr>
                  <td class="formulario">Nombres</td>
                  <td><? echo $TxtNombres;?></td>
                </tr>
                <?
		  	}
		  ?>
                <tr>
                  <td class="formulario">Perfil</td>
                  <td><?
			echo "<SELECT name='CmbNivel3' style='width:200'>";
			echo "<option value='-1'>SELECCIONAR</option>";
			$Consulta1="SELECT nivel,descripcion from proyecto_modernizacion.niveles_por_sistema ";
			$Consulta1.=" where cod_sistema='29' order by nivel";			
			$Resultado1=mysql_query($Consulta1);
			while ($Fila1=mysql_fetch_array($Resultado1))
			{
				if ($CmbNivel3==$Fila1["nivel"])			
					echo "<option value=".$Fila1["nivel"]." SELECTed>".$Fila1["nivel"]."-".strtoupper($Fila1["descripcion"])."</option>";
				else
					echo "<option value=".$Fila1[nivel].">".$Fila1[nivel]."-".strtoupper($Fila1["descripcion"])."</option>";
			}
			echo "</SELECT>";
			?>
                  </td>
                </tr>
              </table>
                <br />
                <table width="100%" border="1" cellpadding="0" cellspacing="0" class="TablaInterior">
                  <tr>
                    <td  align="center" width="465"><a href="JavaScript:Grabar('<? echo $Proceso;?>','<? echo $Valores;?>')"><img src="imagenes/btn_guardar.png" width="29" height="26" border="0" /></a>&nbsp; <a href="JavaScript:Salir()"><img src="imagenes/cerrar1.png" width="25" height="25" border="0" alt="Cerrar" align="absmiddle" /></a> &nbsp; </td>
                  </tr>
              </table></td>
          </tr>
      </table></td>
      <td width="1%" background="imagenes/interior2/form_der.gif"></td>
    </tr>
    <tr>
      <td width="1%" height="15"><img src="imagenes/interior2/esq3.gif" width="15" height="15" /></td>
      <td height="15" background="imagenes/interior2/form_abajo.gif"><img src="imagenes/interior2/transparent.gif" width="4" height="15" /></td>
      <td width="1%" height="15"><img src="imagenes/interior2/esq4.gif" width="15" height="15" /></td>
    </tr>
  </table>
</form>
</body>
</html>
<?
	if (isset($EncontroCoincidencia))
	{
		if ($EncontroCoincidencia==true)
		{
			echo "<script languaje='javascript'>";
			echo "var Frm=document.FrmProceso;";
			echo "alert('Codigo ya fue Ingresado');";
			echo "Frm.TxtCodigo.focus();";
			echo "</script>";
		}
	}
?>
