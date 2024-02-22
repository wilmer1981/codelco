<?
include('conectar_ori.php');
include('funciones/siper_funciones.php');
if($Proceso=='EC')
{

}
if(isset($Pantalla))
	acceso($CookieRut,$Pantalla);
?>
<html>
<head>
<script language="javascript" src="funciones/funciones_java.js"></script>
<script language="javascript">
function AgregarControl(Proceso)
{
	Frm=document.MantenedorPel;
	
	/*if(Frm.CodSel[1].value=='')
	{
		alert('Debe Seleccionar Item Para Agregar');
		return;
	}*/

	Frm.action='mantenedor_controles.php?&Proceso=AC&DivProc=visible';
	Frm.submit();
	
}
function ModificarControl(Proceso)
{
	Frm=document.MantenedorPel;
	
	if(SoloUnElemento(Frm.name,'CheckCon','M'))
	{
		Datos=Recuperar(Frm.name,'CheckCon');
		AgregarPeligros.style.visibility='visible';
		Frm.action='mantenedor_controles.php?Buscar=S&CmbControl='+Datos+'&CmbControl1='+Datos+'&Proceso=MC&DivProc=visible';
		Frm.submit();	
	}
}
function Cerrar()
{
	BloqueaIzq.style.visibility = 'hidden';
	BloqueaDer.style.visibility = 'hidden';
	AgregarPeligros.style.visibility = 'hidden';
	Transparente2.style.visibility = 'hidden';
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
	Frm.action='mantenedor_controles01.php?Proceso='+Proceso+'&CodConta='+Frm.CodPel.value;
	Frm.submit();	

}
function EliminarControl(CodPel)
{
	Frm=document.MantenedorPel;
	if(SoloUnElemento(Frm.name,'CheckCon','E'))
	{
		mensaje=confirm("�Esta Seguro de Eliminar estos Registros?");
		if(mensaje==true)
		{		
			ObsElimina.style.visibility = 'visible';
			Transparente.style.visibility = 'visible';
			//URL='proceso_elimina_dato.php?Proceso=EC&Parent='+CodSel+'&Dato=EMC';//ELIMINA CONTROLES
			//window.open(URL,"","top=30,left=30,width=500,height=300,status=yes,menubar=yes,resizable=yes,scrollbars=yes");
			//Frm.action='mantenedor_controles01.php?Proceso=EC&CodConta='+Frm.CodSel[1].value;
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
		alert('Debe Ingresar Observaci�n de Eliminaci�n');
		f.ObsEli.focus();
		return;
	}
	var DatosUni=Recuperar(f.name,'CheckCon');
	f.action='mantenedor_controles01.php?&Proceso=EC&CodConta='+DatosUni;
	f.submit();	
}
function Buscar()
{
	Frm=document.MantenedorPel;	
	Frm.action='mantenedor_controles.php?Buscar=S';
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
<title>SASSO - Mantenedor Controles</title>
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
			  <a href="JavaScript:Buscar('C')"><img src="imagenes/Btn_buscar.gif"   alt="Buscar" width="25" height="20"  border="0" align="absmiddle" /></a>
			  <a href="javascript:AgregarControl('AC')"><img src="imagenes/btn_agregar.png" alt='Agregar Controles' border="0" align="absmiddle" /></a>
			  <a href="javascript:ModificarControl('MC')"><img src='imagenes/btn_modificar.png' alt='Modificar Controles' border='0' width='25' align='absmiddle' /></a>
			  <a href="javascript:EliminarControl('EC')"><img src='imagenes/btn_eliminar2.png' alt='Eliminar Controles' border='0' width='25' align='absmiddle' /></a>
			  <a href="JavaScript:Salir('S')"><img src="imagenes/btn_volver2.png"  alt=" Volver " width="25" height="25"  border="0" align="absmiddle"></a>
			  </td>
            </tr>
               <td colspan="3" align="right">&nbsp;</td>
            </tr>
			</table>
			<table width="80%" border="0" cellpadding="0" cellspacing="0">
            <tr>
               <td align="left" class="TituloCabecera2"><font size="2">Controles</font></td>
               <td colspan="2" align="left">
			  <SELECT name="CmbControl"> 
			  <option value="T" SELECTed="NoSelect">Todos</option>
			  <?
				$Consulta="SELECT CCONTROL,NCONTROL from sgrs_codcontroles where CCONTROL<>'' order by NCONTROL";				
				$Resultado=mysql_query($Consulta);
				while($Fila=mysql_fetch_array($Resultado))
				{
					if($CmbControl==$Fila[CCONTROL])
						echo "<option value=".$Fila[CCONTROL]." SELECTed>".$Fila[NCONTROL]."</option>";
					else
						echo "<option value=".$Fila[CCONTROL].">".$Fila[NCONTROL]."</option>";	
				}
			  ?>
			  </SELECT><? //echo $Consulta;?>
			   </td>
            </tr>
            <tr>
              <td width="8%" colspan="3" align="center">&nbsp;</td>
			</tr>
			</table>
			<table width="80%" border="1" cellpadding="0" cellspacing="0">
            <tr>
              <td width="8%" align="center" class="TituloCabecera"><input class='SinBorde' type="checkbox" name="ChkTodos" value="" onClick="CheckearTodo(this.form,'CheckCon','ChkTodos');"></td>
              <td width="4%" align="center" class="TituloCabecera">C�digo</td>
              <td width="48%" align="center" class="TituloCabecera">Familia de Controles </td>
			  <td width="28%" align="center" class="TituloCabecera">Descripci�n del control</td>
            </tr>
			 <?
				if($Buscar=='S')
				{
					$Consulta="SELECT * from sgrs_codcontroles where CCONTROL<>''";
					if($CmbControl!='T')
						$Consulta.=" and CCONTROL='".$CmbControl."'";
					//$Consulta.=" and QPESOESP>='0'";	
					$Consulta.=" order by NCONTROL";
					$Resultado=mysql_query($Consulta);echo "<input name='CheckCon' type='hidden'  value=''>";
					while ($Fila=mysql_fetch_array($Resultado))
					{		
						if($MPROBCONSEC==1)
							$Tipo='P';
						else
							$Tipo='C';	
						echo "<tr>";			
						echo "<td align='center'><input name='CheckCon' class='SinBorde' type='checkbox'  value='".$Fila["CCONTROL"]."'></td>";
						echo "<td align='center'>".$Fila[CCONTROL]."</td>";
						echo "<td align='left'>".$Fila[NCONTROL]."</td>";
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
<? 
if(!isset($DivProc))
{
	$DivProc='hidden';
	$DivTrans='hidden';
}	
if($Proceso=='MC')
{
	$Consulta="SELECT * from sgrs_codcontroles where CCONTROL='".$CmbControl1."'";
	//echo $Consulta;
	$Resultado=mysql_query($Consulta);
	if($Fila=mysql_fetch_array($Resultado))
	{
		$TxtDescripcion=$Fila[NCONTROL];
		$CmbProbConsec=$Fila[MPROBCONSEC];
		if($Fila[MVIGENTE]==1)
			$CheckVigVis='checked';
		else
			$CheckVigVis='';
		$TxtPESOESP=$Fila[QPESOESP];	
		$OBS=$Fila[OBS];	
	}

}
if($Proceso=='AC')
{
	$CheckVigVis='checked';
	$Consulta="SELECT MPROBCONSEC from sgrs_codcontroles where CCONTROL = '".$CmbControl1."'";
	//echo $Consulta."<br>";
	$Result=mysql_query($Consulta);
	$Fila2=mysql_fetch_array($Result);
	$CmbProbConsec=$Fila2[MPROBCONSEC];	
	
	$OBS='';	
}	
?>
<style>
.trans2{
  background-color:#CCCCCC;
  color:#CC0000;
  position:absolute;
  text-align:center;
  top:0px;
  left:10px;
  padding:65px;
  font-size:25px;
  font-weight:bold;
  width:300px;
}
</style>
<div class="trans2" id="Transparente2" align="center" style='FILTER: alpha(opacity=10); overflow:auto; VISIBILITY:<? echo $DivTrans;?>; WIDTH: 100%; height:80%; POSITION: absolute; moz-opacity: .60; opacity: .60;'>
 </div>
  <div id='AgregarPeligros'  style='FILTER: alpha(opacity=100); overflow:auto; VISIBILITY:<? echo $DivProc;?>; WIDTH: 662px; height:300px; POSITION: absolute; moz-opacity: .75; opacity: .75;  left: 298px; top: 90px;'>
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
				$Consulta = "SELECT max(ceiling(CCONTROL) +1) as mayor from sgrs_codcontroles"; 
				$Respuesta=mysql_query($Consulta);
				$Fila=mysql_fetch_array($Respuesta);
				$Mayor=$Fila["mayor"];			
			  ?>
			  
			  <input name='CodPel' type='text' value='<? echo $Mayor;?>' readonly="true" size="6" onKeyDown="SoloNumeros(true,this)" >
			  <?
			  }
			  else
			  {
			  ?>
			  <input name='CodPel' type='text' value='<? echo $CmbControl1;?>' readonly="true" size="6">
			  
			  <?
			  }
			  ?>			  </td>
              <td width="144">&nbsp;</td>
			  <td width="145">&nbsp;</td>
            </tr>

            <tr>
              <td width="129" class="formulario">Nombre:</td>
              <td colspan="3"><input name="TxtDescripcion" type="text"  value="<? echo $TxtDescripcion;?> " size="100"></td>
            </tr>
            <tr>
              <td><span class="formulario">Vigente:</span></td>
              <td> <input type="checkbox" name="CheckVig" value="checkbox" class="SinBorde" <? echo $CheckVigVis;?>>
              <td>
               
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
              <td><span class="formulario">Descripci�n</span></td>
              <td><textarea name='OBS' cols="80" rows="3"><? echo $OBS;?></textarea></td>
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
	if($Msj!=''&&$Msj!='S')
	{
		$Dato=explode('~',$Msj);
		while(list($c,$v)=each($Dato))
		{
			$Consulta="SELECT NCONTROL,QPESOESP from sgrs_codcontroles where CCONTROL='".$v."'";
			$Resp=mysql_query($Consulta);
			$Fila=mysql_fetch_array($Resp);
			$NOMCONTROL=$NOMCONTROL.$v."-".$Fila[NCONTROL].", ";
			
		}		
		$NOMCONTROL=substr($NOMCONTROL,0,strlen($NOMCONTROL)-2);
		echo "alert('Controles: ".$NOMCONTROL.", no se pueden eliminar estan Relacionados a Peligros');";	
	}	
	if($Msj=='S')
		echo "alert('Control(es) Eliminado(s) Exitosamente');";	
	echo "</script>";

?>