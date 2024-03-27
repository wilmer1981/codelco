<?
include('conectar_ori.php');
?>
<html>
<head>
<script language="javascript">
function AgregarControl(Proceso)
{
	Frm=document.MantenedorPel;
	
	/*if(Frm.CodSel[1].value=='')
	{
		alert('Debe Seleccionar Item Para Agregar');
		return;
	}*/

	Frm.action='mantenedor_controles.php?CodPadre='+Frm.CodSel[1].value+'&Proceso=AC&DivProc=visible';
	Frm.submit();
	
}
function ModificarControl(Proceso)
{
	Frm=document.MantenedorPel;
	
	if(Frm.CodSel[1].value=='')
	{
		alert('Debe Seleccionar Item Para Modificar');
		return;
	}
	Frm.action='mantenedor_controles.php?CodPadre='+Frm.CodSel[1].value+'&Proceso=MC&DivProc=visible';
	Frm.submit();	
}
function Cerrar()
{
	BloqueaIzq.style.visibility = 'hidden';
	BloqueaDer.style.visibility = 'hidden';
	AgregarPeligros.style.visibility = 'hidden';
	
}
function Grabar(Proceso)
{
	Frm=document.MantenedorPel;
	
	if(Frm.TxtDescripcion.value=='')
	{
		alert('Debe Ingresar Descripcion');
		return;
	}
	//alert(Frm.CodSel[1].value);
	Frm.action='mantenedor_controles01.php?Proceso='+Proceso+'&CodConta='+Frm.CodSel[1].value;
	Frm.submit();	

}
function EliminarControl(CodPel)
{
	Frm=document.MantenedorPel;
	if(Frm.CodSel[1].value=='')
	{
		alert('Debe Seleccionar Item Para Eliminar');
		return;
	}
	var CodSel=Frm.CodSel[1].value;
	if(confirm('Esta Seguro de Eliminar el Registro Seleccionado'))
	{
		ObsElimina.style.visibility = 'visible';
		Transparente.style.visibility = 'visible';
		//URL='proceso_elimina_dato.php?Proceso=EC&Parent='+CodSel+'&Dato=EMC';//ELIMINA CONTROLES
		//window.open(URL,"","top=30,left=30,width=500,height=300,status=yes,menubar=yes,resizable=yes,scrollbars=yes");
		//Frm.action='mantenedor_controles01.php?Proceso=EC&CodConta='+Frm.CodSel[1].value;
		//Frm.submit();	
	}	
}
function CerrarDiv()
{
	ObsElimina.style.visibility = 'hidden';
	Transparente.style.visibility = 'hidden';
}
function ConfirmaEliminar()
{
	var f=document.MantenedorPel;
	if(f.ObsEli.value=='')
	{
		alert('Debe Ingresar Observaci�n de Eliminaci�n');
		f.ObsEli.focus();
		return;
	}
	var CodSel=Frm.CodSel[1].value;
	f.action='mantenedor_controles01.php?Proceso=EC&CodConta='+CodSel;
	f.submit();
}
function BuscaHijos(CodPadre)
{
	Frm=document.MantenedorPel;
	
	Frm.action='mantenedor_controles.php?CodPadre='+CodPadre;
	Frm.submit();
	
}
function Volver(CodPadre)
{
	Frm=document.MantenedorPel;
	
	Frm.action='mantenedor_controles.php?CodPadre='+CodPadre;
	Frm.submit();
	
}
function Salir()
{
	window.location="../principal/sistemas_usuario.php?CodSistema=29&Nivel=1&CodPantalla=6";
}
</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Mantenedor Controles</title>
<style type="text/css">
<!--
.Estilo7 {font-size: 12px}
-->
</style>
</head>
<link href="estilos/siper_style.css" rel="stylesheet" type="text/css">
<body>
<form name="MantenedorPel" method="post">
  <table width="100%" border="0" cellpadding="0"cellspacing="0">
<tr>
	<td align="center">
      <table width="867" height="87" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="1%"><img src="imagenes/interior2/esq1.gif" width="15" height="15"></td>
          <td width="820" height="15" background="imagenes/interior2/form_arriba.gif"><img src="archivos/images/interior/transparent.gif" width="4" ></td>
          <td width="1%"><img src="imagenes/interior2/esq2.gif" width="15" height="15"></td>
        </tr>
        <tr>
           <td width="15" height="56" background="imagenes/interior2/form_izq.gif"></td>
          <td align="center">
		  
		  <table width="80%" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td align="center" class="TituloCabecera2">Mantenedor de Controles</td>
			  <td colspan="2" align="right">
			  <a href="javascript:AgregarControl('AC')"><img src="imagenes/btn_agregar.png" alt='Agregar Controles' border="0" align="absmiddle" /></a>
			  <a href="javascript:ModificarControl('MC')"><img src='imagenes/btn_modificar.png' alt='Modificar Controles' border='0' width='25' align='absmiddle' /></a>
			  <a href="javascript:EliminarControl('EC')"><img src='imagenes/btn_eliminar2.png' alt='Eliminar Controles' border='0' width='25' align='absmiddle' /></a>
			  <a href="JavaScript:Salir('S')"><img src="imagenes/btn_volver2.png"  alt=" Volver " width="25" height="25"  border="0" align="absmiddle"></a>
			  </td>
            </tr>
               <td colspan="3" align="right">&nbsp;</td>
            </tr>
			</table>
			<table width="80%" border="1" cellpadding="0" cellspacing="0">
            <tr>
              <td width="8%" align="center" class="TituloCabecera">Selec</td>
              <td width="4%" align="center" class="TituloCabecera">C�digo</td>
			   <td width="8%" align="center" class="TituloCabecera">Tipo</td>
              <td width="58%" align="center" class="TituloCabecera">Descripci�n Controles </td>
			  <td width="18%" align="center" class="TituloCabecera">Peso Espec�fico</td>
            </tr>
			 <?
				if(!isset($CodPadre))
					$Filtro="length(CCONTROL)=2 ";
				else
				{
					$Largo=intval(strlen($CodPadre))+2;
					$Filtro="CCONTROL = '".$CodPadre."' or (CCONTROL like '".$CodPadre."%' and length(CCONTROL)=".$Largo.")"; 
				}
				$Consulta="SELECT NCONTROL,CCONTROL,MPROBCONSEC from sgrs_codcontroles where ".$Filtro." and NCONTROL <> '' and CCONTROL <> '--' order by MPROBCONSEC desc,CCONTROL asc";
				//echo $Consulta;
				$Resultado=mysqli_query($link, $Consulta);echo "<input name='CodSel' type='hidden'>";$TOTAL=0;$Entrar='S';$Sel='N';$MostrarSubT='S';$Cont=0;
				while ($Fila=mysql_fetch_array($Resultado))
				{
					if($MostrarSubT=='S'&&$Fila[MPROBCONSEC]=='0'&&$Entrar=='S')
					{
						echo "<tr class='TituloTablaAmarilla'>";
						echo "<td align='right' width='18%' colspan='4'><b>TOTAL</b></td>";
						echo "<td align='right' width='18%'><b>".number_format($TOTAL,3,',','.')."</b></td>";
						echo "</tr>";
						$Entrar='N';$TOTAL=0;
					}
					
					if($CodPadre==$Fila[CCONTROL]&&strlen($CodPadre)==strlen($Fila[CCONTROL]))
					{
						$CCONTROL=$Fila[CCONTROL];$Sel='S';$MostrarSubT='N';
						echo "<tr class='TituloTablaNaranja'>";
						$Img="btn_flecha_volver.gif";
						$Msj="Volver";
						echo "<td align='center'><a href=javascript:Volver('".substr($CodPadre,0,strlen($CodPadre)-2)."')><img src='imagenes/".$Img."' alt='".$Msj."' border='0' align='absmiddle'></a><input name='CodSel' type='hidden' value='".$CCONTROL."'></td>";											
					}
					else
					{
						echo "<tr>";$Sel='N';
						$Img="btn_flecha.gif";
						$Msj="Seleccionar";
						echo "<td align='center'><a href=javascript:BuscaHijos('".$Fila[CCONTROL]."')><img src='imagenes/".$Img."' alt='".$Msj."' border='0' align='absmiddle'></a><input name='CodSel' type='hidden' value=''></td>";						
					}
					echo "<td align='center'>".$Fila[CCONTROL]."</td>";
					if($Fila[MPROBCONSEC]==1)
						echo "<td align='center'>P</td>";
					else
						echo "<td align='center'>C</td>";
					if($Fila[MOPCIONAL]==0)
						echo "<td align='left' class='titulo_azul'>".$Fila[CCONTROL]." ".$Fila[NCONTROL]."</td>";
					else
						echo "<td align='left' width='58%'>".$Fila[CCONTROL]." ".$Fila[NCONTROL]."</td>";
					$Consulta="SELECT ifnull(sum(QPESOESP),0) as PESO_ESP from sgrs_codcontroles where CCONTROL like '".$Fila[CCONTROL]."%'";
					//echo $Consulta."<br>";
					$Result=mysqli_query($link, $Consulta);
					$Fila2=mysql_fetch_array($Result);
					$QPESOESP=$Fila2[PESO_ESP];	
					echo "<td align='right' width='18%'>".$QPESOESP."</td>";
					echo "</tr>";
					if($Sel=='N')
						$TOTAL=$TOTAL+$QPESOESP;
					$Cont++;	
					
				}
				echo "<tr class='TituloTablaAmarilla'>";
				echo "<td align='right' width='18%' colspan='4'>TOTAL</td>";
				if($Cont=='1')
					echo "<td align='right' width='18%'>".number_format($QPESOESP,3,',','.')."</td>";
				else
					echo "<td align='right' width='18%'>".number_format($TOTAL,3,',','.')."</td>";	
				echo "</tr>";
			 ?>
          </table></td>
          <td width="15" background="imagenes/interior2/form_der.gif"></td>
        </tr>
        <tr>
          <td height="1%"><img src="imagenes/interior2/esq3.gif" width="15" height="15"></td>
          <td height="15" background="imagenes/interior2/form_abajo.gif"><img src="imagenes/interior2/transparent.gif" width="4" height="15"></td>
          <td><img src="imagenes/interior2/esq4.gif" width="15" height="15"></td>
        </tr>
      </table>
      <table width="100%" border="1" cellpadding="0" cellspacing="0">
	    </table>
	</td>
	
</tr>
</table>
<? 
if(!isset($DivProc))
	$DivProc='hidden';
if($Proceso=='MC')
{
	$Consulta="SELECT * from sgrs_codcontroles where CCONTROL='".$CCONTROL."'";
	//echo $Consulta;
	$Resultado=mysqli_query($link, $Consulta);
	if($Fila=mysql_fetch_array($Resultado))
	{
		$TxtDescripcion=$Fila[NCONTROL];
		$CmbProbConsec=$Fila[MPROBCONSEC];
		if($Fila[MVIGENTE]==1)
			$CheckVigVis='checked';
		else
			$CheckVigVis='';
		$TxtPESOESP=$Fila[QPESOESP];	
	}

}
if($Proceso=='AC')
{
	$CheckVigVis='checked';
	$Consulta="SELECT MPROBCONSEC from sgrs_codcontroles where CCONTROL = '".$CCONTROL."'";
	//echo $Consulta."<br>";
	$Result=mysqli_query($link, $Consulta);
	$Fila2=mysql_fetch_array($Result);
	$CmbProbConsec=$Fila2[MPROBCONSEC];	
	
}	
?>
  <div id='AgregarPeligros'  style='FILTER: alpha(opacity=100); overflow:auto; VISIBILITY:<? echo $DivProc;?>; WIDTH: 662px; height:300px; POSITION: absolute; moz-opacity: .75; opacity: .75;  left: 298px; top: 25px;'>
    <table width="100%" height="85%" align="center"  border="0" cellpadding="0"  cellspacing="0" class="TablaPricipalColor">
      <tr>
        <td width="1%" height="1%"><img src="imagenes/interior/esq1.gif"></td>
        <td width="97%" height="1%" background="imagenes/interior/form_arriba.gif"><img src="imagenes/interior/transparent.gif"></td>
        <td width="1%" height="1%"><img src="imagenes/interior/esq2.gif" /></td>
      </tr>
      <tr>
        <td width="1%" height="99%" background="imagenes/interior/form_izq.gif"></td>
        <td width="97%" height="99%" valign="top" align="center"><table width="98%" height="31" border="0" align="center" cellpadding="2" cellspacing="0" >
            <tr>
              <td><p align="left" class="titulo_azul"><img src="imagenes/vineta.gif" border="0" /><span class="Estilo7">Controles</span></p>
                <p class="titulo_azul">&nbsp;</p></td>
              <td align="right" ><a href=JavaScript:Grabar('<? echo $Proceso;?>')><img src="imagenes/btn_guardar.png" width="29" height="26" border="0"></a>&nbsp;<a href="JavaScript:Cerrar()"><img src="imagenes/cerrar1.png" width="25" height="25" border="0" alt="Cerrar" align="absmiddle" /></a> </td>
            </tr>
            <tr>
              <td colspan="2" align='center' ></td>
            </tr>
            
            
          </table>
          <table width="618" border="0" cellpadding="2">
            <tr>
              <td width="129" class="formulario">Codigo:</td>
              <td width="182">
			  <?
			  if($Proceso=='AC')
			  {
	  			$Inicio=1;
				if($CCONTROL!='')
				{
					$Inicio=0;
			  ?>
			  
			  <input name='CodPel' type='text' value='<? echo $CCONTROL;?>' readonly="true" size="6">
			  <?
			  }
			  ?>
			  
			  <SELECT name="CmbCod"> 
			  <?
			  		$Codigos='';
					for($i=$Inicio;$i<=9;$i++)
					{
						$Codigo=$CCONTROL."0".$i;
						$Consulta="SELECT CCONTROL from sgrs_codcontroles where CCONTROL='".$Codigo."'";
						//echo $Consulta;
						$Resultado=mysqli_query($link, $Consulta);
						if(!$Fila=mysql_fetch_array($Resultado))
						{
							echo "<option value='0".$i."'>0".$i."</option>";
						}
					}
			  
			  ?>
			  </SELECT>
			  <?
			  }
			  else
			  {
			  ?>
			  <input name='CodPel' type='text' value='<? echo $CCONTROL;?>' readonly="true" size="6">
			  
			  <?
			  }
			  ?>			  </td>
              <td width="144">&nbsp;</td>
			  <td width="145">&nbsp;</td>
            </tr>

            <tr>
              <td width="129" class="formulario">Descripci&oacute;n:</td>
              <td colspan="3"><input name="TxtDescripcion" type="text"  value="<? echo $TxtDescripcion;?> " size="100"></td>
            </tr>
            <tr>
              <td><span class="formulario">Probabilidad/Consec:</span></td>
			 <?
			  if(strlen($CCONTROL)==2&&$Proceso!='AC'||!isset($CCONTROL))
			  {
			 ?>
              <td><SELECT name="CmbProbConsec">
                <?
			  		switch($CmbProbConsec)
					{
						case "0":
							echo "<option value='0' SELECTed>CONSECUENCIA</option>";
							echo "<option value='1'>PROBABILIDAD</option>";
						break;
						case "1":
							echo "<option value='0'>CONSECUENCIA</option>";
							echo "<option value='1' SELECTed>PROBABILIDAD</option>";
						break;
						default:
							echo "<option value='0' SELECTed>CONSECUENCIA</option>";
							echo "<option value='1'>PROBABILIDAD</option>";
						break;
						
					}
			  
			  ?>
              </SELECT></td>
			  <?
			  }
			  else
			  {
				echo "<td>";
				switch($CmbProbConsec)
				{
					case "0":
						echo "CONSECUENCIA";
					break;
					case "1":
						echo "PROBABILIDAD";
					break;
				}	
	  			echo "</td>";
			  }
			  ?>
              <td><span class="formulario">Vigente:
                <input type="checkbox" name="CheckVig" value="checkbox" class="SinBorde" <? echo $CheckVigVis;?>>
              </span></td>
			  <td >&nbsp;</td>
            </tr>
			<?
			if(($CCONTROL!=''&&strlen($CCONTROL)>2)||(strlen($CCONTROL)==2&&$Proceso=='AC'))
			{
			?>
            <tr>
              <td><span class="formulario">Peso Espec&iacute;fico:</span></td>
              <td><input name='TxtPESOESP' type='text' value='<? echo $TxtPESOESP;?>' size="10"></td>
              <td>&nbsp;</td>
			  <td>&nbsp;</td>
            </tr>
			<?
			}
			?>
            <tr>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
          </table>
        </td>
        <td width="1%" height="99%" background="imagenes/interior/form_der.gif"></td>
      </tr>
      <tr>
        <td width="1%" height="1%"><img src="imagenes/interior/esq3.gif"></td>
        <td width="1%" height="1%" background="imagenes/interior/form_abajo.gif"><img src="imagenes/interior/transparent.gif"></td>
        <td width="1%" height="1%"><img src="imagenes/interior/esq4.gif"></td>
      </tr>
    </table>
  </div>
  <div id='BloqueaIzq'  style='FILTER: alpha(opacity=50); overflow:auto; VISIBILITY: hidden; WIDTH: 100px; height:450px; POSITION:absolute; moz-opacity: .75; opacity: .75;  left: 50px; top: 50px;'>
  <table border="0" width="100%" height="80%">
  <tr><td></td></tr>
  </table>
  </div>	   
  <div id='BloqueaDer'  style='FILTER: alpha(opacity=50); overflow:auto; VISIBILITY: hidden; WIDTH: 100px; height:450px; POSITION:absolute; moz-opacity: .75; opacity: .75;  left: 800px; top: 50px;'>
  <table border="0" width="100%" height="80%">
  <tr><td></td></tr>
  </table>
  </div>
 <?
include('div_obs_elimina_mantenedor.php');
?>
</form>
</body>
</html>
<?
	echo "<script languaje='JavaScript'>";
	if($Mensaje!='')
		echo "alert('".$Mensaje."');";
	echo "</script>";

?>