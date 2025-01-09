<?php
include('conectar_ori.php');
$TxtDescripcion='';
?>
<html>
<head>
<script language="javascript" src="funciones/funciones_java.js"></script>
<script language="javascript">
function AgregarPeligro(Proceso)
{
	Frm=document.MantenedorPel;
	Frm.action='mantenedor_peligros.php?&Proceso=AP&DivProc=visible';
	Frm.submit();
	
}
function ModificarPeligro(Proceso)
{
	Frm=document.MantenedorPel;
	
	if(SoloUnElemento(Frm.name,'CheckCon','M'))
	{
		Datos=Recuperar(Frm.name,'CheckCon');
		AgregarPeligros.style.visibility='visible';
		//Frm.Proc.value='M';
		//Frm.Datos.value=Datos;
		var cont=Frm.CmbCONTACTO.value;
		Frm.CmbCONTACTO.value=cont;
		Frm.action='mantenedor_peligros.php?Codigo='+Datos+'&Proceso=MP&DivProc=visible&Buscar=S';
		Frm.submit();	
	}	
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
		Frm.TxtDescripcion.focus;
		return;
	}
	//if(Frm.CodSel[1].value=='X')
		Frm.action='mantenedor_peligros01.php?Proceso='+Proceso+'&CodConta='+Frm.CodPel.value;
	//else
		//Frm.action='mantenedor_peligros01.php?Proceso='+Proceso+'&CodConta='+Frm.CodSel[1].value;
	Frm.submit();	

}
function EliminarPeligro(CodPel)
{
	Frm=document.MantenedorPel;
	if(SoloUnElemento(Frm.name,'CheckCon','E'))
	{
		mensaje=confirm("¿Esta Seguro de Eliminar estos Registros?");
		if(mensaje==true)
		{		
			//URL='proceso_elimina_dato.php?Proceso=EP&Parent='+CodSel+'&Dato=EMP';//ELIMINA MANTENEDOR PELIGRO
			//window.open(URL,"","top=30,left=30,width=500,height=300,status=yes,menubar=yes,resizable=yes,scrollbars=yes");
			ObsElimina.style.visibility = 'visible';
			Transparente.style.visibility = 'visible';
			//Frm.action='mantenedor_peligros01.php?Proceso=EP&CodConta='+Frm.CodSel[1].value;
			//Frm.submit();	
		}
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
		alert('Debe Ingresar Observación de Eliminación');
		f.ObsEli.focus();
		return;
	}
	var DatosUni=Recuperar(f.name,'CheckCon');
	f.action='mantenedor_peligros01.php?Proceso=EP&CodConta='+DatosUni;
	f.submit();
}
function Buscar()
{
	Frm=document.MantenedorPel;	
	Frm.action='mantenedor_peligros.php?Buscar=S';
	Frm.submit();
	
}
function Volver(CodPadre)
{
	Frm=document.MantenedorPel;
	
	Frm.action='mantenedor_peligros.php?CodPadre='+CodPadre;
	Frm.submit();
	
}
function Salir()
{
	window.location="../principal/sistemas_usuario.php?CodSistema=29&Nivel=1&CodPantalla=6";
}
</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Mantenedor Contactos/Peligros</title>
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
              <td align="center" class="TituloCabecera2">Mantenedor de Contactos</td>
			  <td colspan="2" align="right">
			  <a href="JavaScript:Buscar('C')"><img src="imagenes/Btn_buscar.gif"   alt="Buscar" width="25" height="20"  border="0" align="absmiddle" /></a>
			  <a href="javascript:AgregarPeligro('AP')"><img src="imagenes/btn_agregar.png" alt='Agregar Contacto/Peligro' border="0" align="absmiddle" /></a>
			  <a href="javascript:ModificarPeligro('MP')"><img src='imagenes/btn_modificar.png' alt='Modificar Contacto/Peligro' border='0' width='25' align='absmiddle' /></a>
			  <a href="javascript:EliminarPeligro('EP')"><img src='imagenes/btn_eliminar2.png' alt='Eliminar Contacto/Peligro' border='0' width='25' align='absmiddle' /></a>
			  <a href="JavaScript:Salir('S')"><img src="imagenes/btn_volver2.png"  alt=" Volver " width="25" height="25"  border="0" align="absmiddle"></a>
			  </td>
            </tr>
               <td colspan="3" align="right">&nbsp;</td>
            </tr>
			</table>
			<table width="80%" border="0" cellpadding="0" cellspacing="0">
            <tr>
               <td align="left" class="TituloCabecera2"><font size="2">Contactos</font></td>
               <td colspan="2" align="right">
			  <select name="CmbCONTACTO"> 
			  <option value="T" selected="NoSelect">Todos</option>
			  <?php
				$Consulta="select CCONTACTO,NCONTACTO from sgrs_codcontactos where MOPCIONAL<>'0' order by CCONTACTO";
				//echo $Consulta;
				$Resultado=mysqli_query($link,$Consulta);
				while($Fila=mysqli_fetch_array($Resultado))
				{
					if($CmbCONTACTO==$Fila[CCONTACTO])
						echo "<option value=".$Fila[CCONTACTO]." selected>".$Fila[CCONTACTO]." - ".$Fila[NCONTACTO]."</option>";
					else
						echo "<option value=".$Fila[CCONTACTO].">".$Fila[CCONTACTO]." - ".$Fila[NCONTACTO]."</option>";	
				}
			  ?>
			  </select>
			   </td>
            </tr>
            <tr>
              <td width="8%" colspan="3" align="center">&nbsp;</td>
			</tr>
			</table>
			<table width="100%" border="1" cellpadding="0" cellspacing="0">
            <tr>
              <td width="5%" align="center" class="TituloCabecera"><input class='SinBorde' type="checkbox" name="ChkTodos" value="" onClick="CheckearTodo(this.form,'CheckCon','ChkTodos');"></td>
              <td width="5%" align="center" class="TituloCabecera">Código</td>
              <td width="60%" align="center" class="TituloCabecera">Descripción de peligros </td>
              <td width="5%" align="center" class="TituloCabecera">P</td>
              <td width="5%" align="center" class="TituloCabecera">C</td>
              <td width="20%" align="center" class="TituloCabecera">Definición de peligros</td>
            </tr>
			 <?php
/*				if(!isset($CodPadre)||$CodPadre=='X')
					$Filtro="length(CCONTACTO)=1 ";
				else
				{
					$Largo=intval(strlen($CodPadre))+1;
					$Filtro="CCONTACTO = '".$CodPadre."' or (CCONTACTO like '".$CodPadre."%' and length(CCONTACTO)=".$Largo.")"; 
				}
*/				
				if($Buscar=='S')
				{
					$Consulta="select NCONTACTO,CCONTACTO,MOPCIONAL,QPROBHIST,QCONSECHIST,OBS from sgrs_codcontactos where CCONTACTO <> '-' and MOPCIONAL<>'0'";
					if($CmbCONTACTO!='T')
						$Consulta.=" and CCONTACTO='".$CmbCONTACTO."'";
					$Consulta.=" order by CCONTACTO";
					//echo $Consulta."<br>";
					$Resultado=mysqli_query($link,$Consulta);echo "<input name='CheckCon' type='hidden'  value=''>";
					while ($Fila=mysqli_fetch_array($Resultado))
					{					
						echo "<td align='center'><input name='CheckCon' class='SinBorde' type='checkbox'  value='".$Fila["CCONTACTO"]."'></td>";
						echo "<td align='center'>".$Fila[CCONTACTO]."</td>";
						echo "<td align='left'>".$Fila[NCONTACTO]."</td>";
						echo "<td align='CENTER'>".$Fila[QPROBHIST]."</td>";
						echo "<td align='CENTER'>".$Fila[QCONSECHIST]."</td>";
						echo "<td align='left'><textarea cols='50' readonly>".$Fila[OBS]."</textarea>&nbsp;</td>";
						echo "</tr>";
					}
				}
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
<?php 
if(!isset($DivProc))
	$DivProc='hidden';
	
if($Proceso=='MP')
{
	$Consulta="select * from sgrs_codcontactos where CCONTACTO='".$Codigo."'";
	//echo $Consulta;
	$Resultado=mysqli_query($link,$Consulta);
	if($Fila=mysqli_fetch_array($Resultado))
	{
		$CCONTACTO1=$Fila[CCONTACTO];
		$TxtDescripcion=$Fila[NCONTACTO];
		$CmbProbH=$Fila[QPROBHIST];
		$CmbConsH=$Fila[QCONSECHIST];
		if($Fila[MVIGENTE]==1)
			$CheckVigVis='checked';
		else
			$CheckVigVis='';
		if($Fila[MOPCIONAL]==1)
			$CheckSelVis='checked';
		else
			$CheckSelVis='';
		$OBS=$Fila[OBS];		
	}

}
if($Proceso=='AP')
{
	$CheckVigVis='checked';
	$CheckSelVis='';
	$OBS='';
}	
?>
  <div id='AgregarPeligros'  style='FILTER: alpha(opacity=100); overflow:auto; VISIBILITY:<?php echo $DivProc;?>; WIDTH: 662px; height:300px; POSITION: absolute; moz-opacity: .75; opacity: .75;  left: 298px; top: 25px;'>
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
              <td><p align="left" class="titulo_azul"><img src="imagenes/vineta.gif" border="0" /><span class="Estilo7">Contacto/Peligros </span></p>
                <p class="titulo_azul">&nbsp;</p></td>
              <td align="right" ><a href=JavaScript:Grabar('<?php echo $Proceso;?>')><img src="imagenes/btn_guardar.png" width="29" height="26" border="0"></a>&nbsp;<a href="JavaScript:Cerrar()"><img src="imagenes/cerrar1.png" width="25" height="25" border="0" alt="Cerrar" align="absmiddle" /></a> </td>
            </tr>
            <tr>
              <td colspan="2" align='center' ></td>
            </tr>
            
            
          </table>
          <table width="618" border="0" cellpadding="2">
            <tr>
              <td width="129" class="formulario">Codigo:</td>
              <td width="182">
			  <?php
			  if($Proceso=='AP')
			  {
				$Consulta = "select max(ceiling(CCONTACTO) +1) as mayor from sgrs_codcontactos"; 
				$Respuesta=mysqli_query($link,$Consulta);
				$Fila=mysqli_fetch_array($Respuesta);
				$Mayor=$Fila[mayor];			
			  ?>
			  <input name='CodPel' type='text' value='<?php echo $Mayor;?>' readonly="true" size="6">
			  <?php
			  }
			  else
			  {
			  ?>
			  <input name='CodPel' type='text' value='<?php echo $CCONTACTO1;?>' readonly="true" size="6">
			  
			  <?php
			  }
			  ?>
			  </td>
              <td width="144">&nbsp;</td>
			  <td width="145">&nbsp;</td>
            </tr>

            <tr>
              <td width="129" class="formulario">Descripci&oacute;n:</td>
              <td colspan="3"><input name="TxtDescripcion" type="text"  value="<?php echo $TxtDescripcion;?>" size="100"></td>
            </tr>
            <tr>
			  <?php
			  if($Proceso=='AP')
			  {
			  ?>
              <td><span class="formulario">Seleccionable:</span></td>
              <td><input type="checkbox" name="CheckSel" value="checkbox" class="SinBorde" <?php echo $CheckSelVis;?>></td>
              <td><span class="formulario">Vigente:
              <input type="checkbox" name="CheckVig" value="checkbox" class="SinBorde" <?php echo $CheckVigVis;?>>
              </span></td>
			  <?php
			  }
			  else
			  {
			  ?>	
              <td><span class="formulario">Vigente:</span></td>
              <td><input type="checkbox" name="CheckVig" value="checkbox" class="SinBorde" <?php echo $CheckVigVis;?>>			
              </td>
			  <?php
			  }
			  ?>
			  <td >&nbsp;</td>
            </tr>
            <tr>
              <td><span class="formulario">Probabilidad Hist&oacute;rica:</span></td>
              <td><select name="CmbProbH">
              <?php
			  		switch($CmbProbH)
					{
						case "1":
							echo "<option value='1' selected>1</option>";
							echo "<option value='4'>4</option>";
							echo "<option value='8'>8</option>";
							echo "<option value='16'>16</option>";
							echo "<option value='32'>32</option>";
						break;
						case "4":
							echo "<option value='1'>1</option>";
							echo "<option value='4' selected>4</option>";
							echo "<option value='8'>8</option>";
							echo "<option value='16'>16</option>";
							echo "<option value='32'>32</option>";
						break;
						case "8":
							echo "<option value='1'>1</option>";
							echo "<option value='4'>4</option>";
							echo "<option value='8' selected>8</option>";
							echo "<option value='16'>16</option>";
							echo "<option value='32'>32</option>";						
						break;
						case "16":
							echo "<option value='1'>1</option>";
							echo "<option value='4'>4</option>";
							echo "<option value='8'>8</option>";
							echo "<option value='16' selected>16</option>";
							echo "<option value='32'>32</option>";						
						break;
						case "32":
							echo "<option value='1'>1</option>";
							echo "<option value='4'>4</option>";
							echo "<option value='8'>8</option>";
							echo "<option value='16'>16</option>";
							echo "<option value='32' selected>32</option>";						
						break;
						default:
							echo "<option value='1' selected>1</option>";
							echo "<option value='4'>4</option>";
							echo "<option value='8'>8</option>";
							echo "<option value='16'>16</option>";
							echo "<option value='32'>32</option>";
						break;
						
					}
			  
			  ?>
              </select></td>
              <td><span class="formulario">Consecuencia Hist&oacute;rica :</span></td>
			  <td><select name="CmbConsH">
                <?php
			  		switch($CmbConsH)
					{
						case "1":
							echo "<option value='1' selected>1</option>";
							echo "<option value='4'>4</option>";
							echo "<option value='8'>8</option>";
							echo "<option value='16'>16</option>";
							echo "<option value='32'>32</option>";
						break;
						case "4":
							echo "<option value='1'>1</option>";
							echo "<option value='4' selected>4</option>";
							echo "<option value='8'>8</option>";
							echo "<option value='16'>16</option>";
							echo "<option value='32'>32</option>";
						break;
						case "8":
							echo "<option value='1'>1</option>";
							echo "<option value='4'>4</option>";
							echo "<option value='8' selected>8</option>";
							echo "<option value='16'>16</option>";
							echo "<option value='32'>32</option>";						
						break;
						case "16":
							echo "<option value='1'>1</option>";
							echo "<option value='4'>4</option>";
							echo "<option value='8'>8</option>";
							echo "<option value='16' selected>16</option>";
							echo "<option value='32'>32</option>";						
						break;
						case "32":
							echo "<option value='1'>1</option>";
							echo "<option value='4'>4</option>";
							echo "<option value='8'>8</option>";
							echo "<option value='16'>16</option>";
							echo "<option value='32' selected>32</option>";						
						break;
						default:
							echo "<option value='1' selected>1</option>";
							echo "<option value='4'>4</option>";
							echo "<option value='8'>8</option>";
							echo "<option value='16'>16</option>";
							echo "<option value='32'>32</option>";
						break;
						
					}

			  ?>
              </select></td>
            </tr>
            <tr>
              <td><span class="formulario">Observación</span></td>
              <td><textarea name='OBS' cols="80" rows="3"><?php echo $OBS;?></textarea></td>
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
 <?php
include('div_obs_elimina_mantenedor.php');
?> 
</form>
</body>
</html>
<?php
	echo "<script languaje='JavaScript'>";
	if($Mensaje!='')
		echo "alert('".$Mensaje."');";
	echo "</script>";

?>