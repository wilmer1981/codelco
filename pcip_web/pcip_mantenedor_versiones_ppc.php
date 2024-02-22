
<? include("../principal/conectar_pcip_web.php");

if(!isset($Ano))
	$Ano=date('Y');
if(!isset($Opc))
	$Opc='G';

$Consulta = "select ifnull(max(version)+1,1) as nueva_version from pcip_ppc_version where ano='".$Ano."'";			
$Resp = mysql_query($Consulta);
//echo $Consulta;
if($Fila=mysql_fetch_array($Resp))
	$TxtVersion=$Fila[nueva_version];
if(!isset($CmbUltVersion))
	$CmbUltVersion='S';
	
if($Opc=='M')
 {
   $Consulta="select version,ano,fecha_creacion,mes,descripcion,ult_version from pcip_ppc_version where version='".$Cod."' and ano='".$Ano."'";
   //echo $Consulta;
   $Resp=mysql_query($Consulta);
   if($Fila=mysql_fetch_array($Resp))
	{
	$TxtVersion=$Fila["version"];
	$Ano=$Fila["ano"];
	$FCreacion=$Fila["fecha_creacion"];
	$Mes=$Fila["mes"];
	$TxtDescripcion=$Fila["descripcion"];
	$CmbUltVersion=$Fila["ult_version"];
	}
 }

?>
<html>
<head>
<title>Mantenedor de Versiones</title> 
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="javascript" src="../pcip_web/funciones/pcip_funciones.js"></script>
<script language="JavaScript">

function Guardar(Opc)
{
	var f= document.FrmPopupProceso;
		f.action = "pcip_mantenedor_versiones_ppc_proceso01.php?Opc="+Opc;
		f.submit();
	
}
function Eliminar(Cod,Ano)
{
	var f= document.FrmPopupProceso;
	if(confirm('Esta Seguro de Eliminar el Registro'))
	{
		f.action = "pcip_mantenedor_versiones_ppc_proceso01.php?Opc=E&Cod="+Cod+'&Ano='+Ano;
		f.submit();
	}
}
function Duplicar(Cod,Ano,Mes)
{
	var f= document.FrmPopupProceso;
	if(confirm('Esta Seguro de Duplicar esta Versión'))
	{
		f.action = "pcip_mantenedor_versiones_ppc_proceso01.php?Opc=D&Cod="+Cod+'&Ano='+Ano+'&Mes='+Mes;
		f.submit();
	}
}
function Modificar(Cod,Ano)
{   
	var f= document.FrmPopupProceso;
		f.action = "pcip_mantenedor_versiones_ppc.php?Opc=M&Cod="+Cod;
		f.submit();
}
function Recarga()
{
    f=document.FrmPopupProceso;
	f.action = "pcip_mantenedor_versiones_ppc.php";
	f.submit();
}
function Salir()
{
	window.close();
}
</script>
</head>
<link href="../pcip_web/estilos/css_pcip_web.css" rel="stylesheet" type="text/css">
<form name="FrmPopupProceso" method="post" action="">
<input type="hidden" name="Pagina" value="<? echo $Pagina;?>">
<?
if($Opc=='M')
{
?>
<input type="hidden" name="FCreacion" value="<? echo $FCreacion;?>">
<?
}
?>
<table width="88%" align="center"  border="0" cellpadding="0"  cellspacing="0" class="TablaPricipalColor">
  <tr>
	<td height="15%"><img src="../pcip_web/archivos/images/interior/esq1.gif" width="15" height="15"></td>
	<td width="1052" height="15"background="../pcip_web/archivos/images/interior/form_arriba.gif"><img src="../sget_web/archivos/images/interior/transparent.gif" width="4" height="15"></td>
	<td height="15%"><img src="../pcip_web/archivos/images/interior/esq2.gif" width="15" height="15"></td>
  </tr>
  <tr>
   <td background="../pcip_web/archivos/images/interior/form_izq.gif">&nbsp;</td>
   <td><table width="100%" border="0" cellpadding="0" cellspacing="0">
     <tr>
       <td width="74%" align="left"><img src="../pcip_web/archivos/sub_tit_versiones.png"></td>
       <td align="right"><a href="JavaScript:Guardar('<? echo $Opc;?>')"><img src="../pcip_web/archivos/btn_guardar.png" alt="Guardar"  border="0" align="absmiddle" /></a> <a href="JavaScript:Salir()"><img src="../pcip_web/archivos/close.png"  alt="Cerrar " align="absmiddle" border="0"></a> </td>
     </tr>
   </table>
   <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
     <tr>
       <td colspan="3"align="center" class="TituloTablaVerde"></td>
     </tr>
     <tr>
       <td width="1%" align="center" class="TituloTablaVerde"></td>
       <td align="center">
	   <table width="100%" border="0" cellpadding="3" cellspacing="0" >
		 <tr>
           <td width="14%" class="formulario2" align="justify">A&ntilde;o</td>
           <td width="86%" class="formulario2" >
		   <?
			if($Opc!='M')
			 {
		   ?>
			   <select name="Ano" onChange="Recarga()">
				 <?
				 if(!isset($Ano))
					$Ano=date('Y');
				for ($i=date("Y")-3;$i<=date("Y")+1;$i++)
				{
					if ($i==$Ano)
						echo "<option selected value=\"".$i."\">".$i."</option>\n";
					else
						echo "<option value=\"".$i."\">".$i."</option>\n";
				}
				?>
           </select>
		   <?
		   	}
			else
			{
			 //echo $Ano."<br>";
			   echo "<input type='txt' readonly='true' size='10' name='Ano' value='".$Ano."'>";
			}  
		   ?></td>
		 </tr>
		 <tr>
           <td width="14%" class="formulario2" align="justify">N&ordm; Versi&oacute;n</td>
           <td width="86%" class="formulario2" ><input name="TxtVersion" value="<? echo $TxtVersion;?>" size="3" readonly="true">&nbsp;</td>
		 </tr>
		 <tr>
           <td width="14%" class="formulario2" align="justify">Mes</td>
           <td width="86%" class="formulario2" ><select name="Mes" id="Mes">
             <?
				for ($i=1;$i<=12;$i++)
				{
					if ($i==$Mes)
						echo "<option selected value=\"".$i."\">".$Meses[$i-1]."</option>\n";
					else
						echo "<option value=\"".$i."\">".$Meses[$i-1]."</option>\n";
				}
			 ?>
           </select></td>
		 </tr>
		 <tr>
           <td width="14%" class="formulario2" align="justify">Descripción</td>
           <td width="86%" class="formulario2" ><textarea name="TxtDescripcion" cols="90" rows="4"><? echo $TxtDescripcion?></textarea></td>
		 </tr>
		 <tr>
           <td width="14%" class="formulario2" align="justify">Ultima Versi&ograve;n </td>
           <td width="86%" class="formulario2" ><span class="formulariosimple">
             <select name="CmbUltVersion" >
               <option value="-1" class="NoSelec">Seleccionar</option>
               <?
				$Consulta = "select cod_subclase,nombre_subclase from proyecto_modernizacion.sub_clase where cod_clase='31007' ";			
				$Resp=mysql_query($Consulta);
				while ($FilaTC=mysql_fetch_array($Resp))
				{
					if ($CmbUltVersion==$FilaTC["nombre_subclase"])
						echo "<option selected value='".$FilaTC["nombre_subclase"]."'>".ucfirst($FilaTC["nombre_subclase"])."</option>\n";
					else
						echo "<option value='".$FilaTC["nombre_subclase"]."'>".ucfirst($FilaTC["nombre_subclase"])."</option>\n";
				}
			   ?>
             </select>
           </span></td>
		 </tr>

          <tr>
           <td colspan="2" class="formulario2"><table width="100%" border="1" cellpadding="4" cellspacing="0" >
             <tr align="center">
               <td width="8%" class="TituloTablaVerde">Elim.</td>
			   <td width="8%" class="TituloTablaVerde">Dupli.</td>
			   <td width="8%" class="TituloTablaVerde">Modif.</td>
               <td width="12%" class="TituloTablaVerde">N&ordm; Versión </td>
               <td width="10%" class="TituloTablaVerde">Año</td>
			   <td width="10%" class="TituloTablaVerde">Mes</td>
			   <td width="15%" class="TituloTablaVerde">Fecha Creación</td>
			   <td width="35%" class="TituloTablaVerde">Descripción</td>
			   <td width="15%" class="TituloTablaVerde">Ult.Versión</td>
             </tr>
             <?
		
				$Consulta = "select * from pcip_ppc_version where ano='".$Ano."'order by version";			
				$Resp = mysql_query($Consulta);
				//echo $Consulta;
				    while ($Fila=mysql_fetch_array($Resp))
				    {
				
					$Cod=$Fila["version"];
					$Ano=$Fila["ano"];
					$Mes=$Fila["mes"];
					$Fecha=$Fila["fecha_creacion"];
					$Descrip=$Fila["descripcion"];
					$Ult=$Fila["ult_version"];
					
			 ?>
             <tr class="FilaAbeja">
               <td align="center"><a href="JavaScript:Eliminar('<? echo $Cod;?>','<? echo $Ano;?>')"><img src="../pcip_web/archivos/elim_hito.png"  border="0"  alt=" Eliminar " align="absmiddle"></a></td>
               <td align="center"><a href="JavaScript:Duplicar('<? echo $Cod;?>','<? echo $Ano;?>','<? echo $Mes;?>')"><img src="../pcip_web/archivos/duplicar2.png"  border="0"  alt=" Duplicar Versión " align="absmiddle"></a></td>
               <td align="center"><a href="JavaScript:Modificar('<? echo $Cod;?>','<? echo $Ano;?>')"><img src="../pcip_web/archivos/btn_modificar.png"  border="0"  alt=" Modificar " align="absmiddle"></a></td>
			   <td align="center"><? echo $Cod; ?></td>
               <td align="center"><? echo $Ano; ?></td>
			   <td align="center"><? echo $Meses[$Mes-1]; ?></td>
			   <td align="center"><? echo $Fecha; ?></td>
			   <td align="left"><? echo $Descrip; ?>&nbsp;</td>
			   <td align="center"><? echo $Ult; ?>&nbsp;</td>
             </tr>
             <?
			          
					}
			
         	 ?>
           </table></td>
          </tr>
       </table></td>
       <td width="0%" align="center" class="TituloTablaVerde"></td>
     </tr>
     <tr>
       <td colspan="3"align="center" class="TituloTablaVerde"></td>
     </tr>
   </table>
   </td>
   <td width="16" background="../pcip_web/archivos/images/interior/form_der.gif">&nbsp;</td>
  </tr>
  <tr>
    <td width="15" height="15"><img src="../pcip_web/archivos/images/interior/esq3.gif" width="15" height="15" /></td>
    <td height="15" background="../pcip_web/archivos/images/interior/form_abajo.gif"><img src="../pcip_web/archivos/images/interior/transparent.gif" width="4" height="15" /></td>
    <td width="16" height="15"><img src="../pcip_web/archivos/images/interior/esq4.gif" width="15" height="15" /></td>
  </tr>
  </table>			
</form>
</body>
</html>
<? 
	echo "<script languaje='JavaScript'>";
	if ($Mensaje!='')
	{
		echo "alert('".$Mensaje."');";
		echo "Recarga();";
	}
	echo "</script>";
?>