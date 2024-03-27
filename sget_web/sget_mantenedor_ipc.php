<?
include("../principal/conectar_sget_web.php");
include("funciones/sget_funciones.php");
?>
<html>
<head>
<title>Ingreso de IPC Acumulado</title>
<script language="javascript" src="funciones/sget_funciones.js"></script>
<script language="javascript">
var popup=0;
function Proceso(Opc)
{
	var f=document.FrmPrincipal;
	var Valor="";
	var Datos="";
	switch(Opc)
	{
	case "C":
			f.action="sget_mantenedor_ipc.php?&Buscar=S";
			f.submit();
		break;
		case "N":
			URL="sget_mantenedor_ipc_proceso.php?Opc="+Opc;
			opciones='top=30,toolbar=0,resizable=1,menubar=0,status=1,width=850,height=400,scrollbars=1';
			verificar_popup(popup);
			popup=window.open(URL,"",opciones);
			popup.focus();
			popup.moveTo((screen.width - 640)/2,0);sget_mantenedor_mutuales_proceso.php
		break;
		case "M":
			if(SoloUnElemento(f.name,'CheckTipoDoc','M'))
			{
				Datos=Recuperar(f.name,'CheckTipoDoc');
				
				URL="sget_mantenedor_ipc_proceso.php?Opc="+Opc+"&Valores="+Datos;
				opciones='top=30,toolbar=0,resizable=1,menubar=0,status=1,width=850,height=400,scrollbars=1';
				verificar_popup(popup);
				popup=window.open(URL,"",opciones);
				popup.focus();
				popup.moveTo((screen.width - 640)/2,0);
			}	
		break;
		case "E":
			if(SoloUnElemento(f.name,'CheckTipoDoc','E'))
			{
				mensaje=confirm("�Esta Seguro de Eliminar estos Registros?");
				if(mensaje==true)
				{
					Datos=Recuperar(f.name,'CheckTipoDoc');
					f.action='sget_mantenedor_ipc01.php?Opcion=E&Valor='+ Datos; //Datos; //+"&Pagina="+f.Pagina.value;
					f.submit();
				}
			}	
		break;
		case "S":
				window.location="../principal/sistemas_usuario.php?CodSistema=30&Nivel=1&CodPantalla=1";
		break;
	}	
}

</script>
<link href="estilos/css_sget_web.css" rel="stylesheet" type="text/css">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<form name="FrmPrincipal" method="post" action="">
<?
 $IP_SERV = $HTTP_HOST;
 EncabezadoPagina($IP_SERV,'mant_ipc.png')
 ?>  <table width="950" align="center"  border="0" cellpadding="0"  cellspacing="0" class="TablaPricipalColor">
  <tr>
      <td width="15" height="15"><img src="archivos/images/interior/esq1em.png" width="15" height="15" /></td>
      <td width="920" height="15"background="archivos/images/interior/form_arriba.png"><img src="archivos/images/interior/transparent.gif" width="4" height="15" /></td>
      <td width="15" height="15"><img src="archivos/images/interior/esq2em.png" width="15" height="15" /></td>
    </tr>
    <tr>
      <td width="15" background="archivos/images/interior/form_izq3.png">&nbsp;</td>
      <td>
		<table width="100%" cellpadding="2" cellspacing="0">
		  <tr>
				<td colspan="3" align="left" class='formulario2'><img src="archivos/images/interior/t_buscadorGlobal4.png">
				  <!--<a href="JavaScript:Proceso('Prov')"><img src="archivos/btn_carga.gif" border="0"></a> -->			    </td>
	     <td width="47%" align="right" class='formulario2' >	<a href="JavaScript:Proceso('C')"><img src="archivos/Find2.png"   alt="Buscar"  border="0" align="absmiddle" /></a>    
					<a href="JavaScript:Proceso('N')"><img src="archivos/nuevo2.png"  border="0"  alt="Nuevo" align="absmiddle" /></a> 
				<a href="JavaScript:Proceso('M')"><img src="archivos/btn_modificar3.png" border="0" alt="Modificar" align="absmiddle"></a> 
				<a href="JavaScript:Proceso('E')"><img src="archivos/elim_hito2.png"  alt="Eliminar" align="absmiddle" border="0"></a>
				 <a href="JavaScript:Proceso('S')"><img src="archivos/volver2.png"  border="0"  alt=" Volver " align="absmiddle"></a>		</td>
		  </tr>
		  	  <tr>
		  	    <td width="10%" align="left" class='formulario2'>A&ntilde;o</td>
		  	    <td colspan="3" class='formulario2' ><SELECT name="CmbAno" id="CmbAno" >
      	<option  value ='T'>Todos</option>   <?
		for ($i=date("Y")-3;$i<=date("Y")+1;$i++)
	{
		if (isset($CmbAno))
		{
			if ($i==$CmbAno)
			{
				echo "<option SELECTed value ='$i'>$i</option>";
			}
			else	
			{
				echo "<option value='".$i."'>".$i."</option>";
			}
		}
		else
		{
			if ($i==date("Y"))
			{
				echo "<option SELECTed value ='$i'>$i</option>";
			}
			else	
			{
				echo "<option value='".$i."'>".$i."</option>";
			}
		}
	}
		?>
        </SELECT></td>
  	      </tr>
		</table>   
	</td>
      <td width="15" background="archivos/images/interior/form_der.png">&nbsp;</td>
    </tr>
    <tr>
      <td width="15" height="15"><img src="archivos/images/interior/esq3em.png" width="15" height="15" /></td>
      <td height="15" background="archivos/images/interior/form_abajo.png"><img src="archivos/images/interior/transparent.gif" width="4" height="15" /></td>
      <td width="15" height="15"><img src="archivos/images/interior/esq4em.png" width="15" height="15" /></td>
    </tr>
  </table>
  <br>	
<table width="950" align="center"  border="0" cellpadding="0"  cellspacing="0" class="TablaPricipalColor">
 <tr>
	  <td><img src="archivos/images/interior/esq1em.gif" width="15" /></td>
	  <td width="920" background="archivos/images/interior/form_arriba.gif"><img src="archivos/images/interior/transparent.gif" width="4" /></td>
	  <td ><img src="archivos/images/interior/esq2em.gif" width="15" /></td>
</tr>
  <tr>
   <td background="archivos/images/interior/form_izq.gif">&nbsp;</td>
   <td align="center"> 
	<table width="100%" border="1" cellpadding="4" cellspacing="0" >
     
	  <tr align="center">
        <td width="6%" class="TituloTablaVerde"><input class='SinBorde' type="checkbox" name="ChkTodos" value="" onClick="CheckearTodo(this.form,'CheckTipoDoc','ChkTodos');"></td>
        <td width="7%" class="TituloTablaVerde">A�o</td>
		<td width="7%" class="TituloTablaVerde">Enero</td>
		<td width="7%" class="TituloTablaVerde">Febrero</td>
		<td width="7%" class="TituloTablaVerde">Marzo</td>
		<td width="7%" class="TituloTablaVerde">Abril</td>
		<td width="7%" class="TituloTablaVerde">Mayo</td>
		<td width="7%" class="TituloTablaVerde">Junio</td>
		<td width="7%" class="TituloTablaVerde">Julio</td>
		<td width="7%" class="TituloTablaVerde">Agosto</td>
		<td width="7%" class="TituloTablaVerde">Septiembre</td>
		<td width="7%" class="TituloTablaVerde">Octubre</td>
		<td width="7%" class="TituloTablaVerde">Noviembre</td>
		<td width="7%" class="TituloTablaVerde">Diciembre</td>
      </tr>
<?
if($Buscar=='S')
{
	$Consulta = "SELECT distinct ano ";
	$Consulta.= " from sget_ipc ";
	if($CmbAno!='T')
	$Consulta.= " where ano='".$CmbAno."'";
	$Consulta.= " order by ano desc";
	$Resp = mysqli_query($link, $Consulta);
	echo "<input name='CheckTipoDoc' type='hidden'  value=''>";
	while ($Fila=mysql_fetch_array($Resp))
	{
		echo "<tr>";
		echo "<td align='center'><input name='CheckTipoDoc' class='SinBorde' type='checkbox'  value='".$Fila["ano"]."'></td>";
		echo "<td align='center' class='formulario'>".$Fila["ano"]."</td>";
		$Consulta="SELECT * from sget_ipc where ano = '".$Fila["ano"]."' order by mes";
		$RespMes=mysqli_query($link, $Consulta);
		while($FilaMes=mysql_fetch_array($RespMes))
		{	
			echo "<td align='right'>".$FilaMes["valor"]."</td>";
		}
		echo "</tr>";
	}
}
?>			
    </table></td>
 </td>
  <td width="1" background="archivos/images/interior/form_der.gif">&nbsp;</td>
  </tr>
   <tr>
      <td width="15"><img src="archivos/images/interior/esq3em.gif" width="15" height="15" /></td>
      <td height="1"background="archivos/images/interior/form_abajo.gif"><img src="archivos/images/interior/transparent.gif" width="4" height="15" /></td>
      <td width="15"><img src="archivos/images/interior/esq4em.gif" width="15" height="15" /></td>
    </tr>
  </table>
  <?
CierreEncabezado()
?>	
</form>
<script language="javascript">
/*alert("No se pueden Eliminar, Tiene Requerimientos Asociados")*/
</script>
