<?
	include("../principal/conectar_pcip_web.php");
	include("funciones/pcip_funciones.php");

if(!isset($Ano))
 	$Ano=date('Y');
if(!isset($Mes))
 	$Mes=date('m');	
?>
<html>
<head>
<title>Mantenedor Centros Costos</title>
<style type="text/css">
<!--
body {
	background-image: url();
	background-color: #f9f9f9;
}
-->
</style>
<link href="estilos/css_pcip_web.css" rel="stylesheet" type="text/css">
<script language="javascript" src="funciones/pcip_funciones.js"></script>
<script language="JavaScript">
function Procesos(TipoProceso)
{
	var f = document.frmPrincipal;
	var Agrupados='N';
	switch(TipoProceso)
	{
		case 'N'://GRABAR
			var URL = "../pcip_web/pcip_mantenedor_centro_costos_proceso.php?Opcion=N";
			window.open(URL,"","top=30,left=30,width=750,height=550,status=yes,menubar=no,resizable=yes,scrollbars=yes");
			break;
		case "M":
			if(SoloUnElemento(f.name,'CheckCC','M'))
			{
				Valores=Recuperar(f.name,'CheckCC');
				if (Valores=="")
				{
					alert("Debe Seleccionar un Elemento para Eliminar");
					return;
				}
				else
				{
					URL="../pcip_web/pcip_mantenedor_centro_costos_proceso.php?Opcion=M&Corr="+Valores;
					window.open(URL,"","top=30,left=30,width=750,height=550,status=yes,menubar=no,resizable=yes,scrollbars=yes");
				}
			}
			break;
		case "C"://BUSCAR
			f.action = "pcip_mantenedor_centro_costos.php?Buscar=S";
			f.submit();
			break;
		case "E"://ELIMINAR
			var Valores="";
			Valores=Recuperar(f.name,'CheckCC');
			if (Valores=="")
			{
				alert("Debe Seleccionar un Elemento para Eliminar");
				return;
			}
			else
			{
				if (confirm("¿Desea Eliminar los Centro de Costos Seleccionados?"))
				{
					f.action = "pcip_mantenedor_centro_costos_proceso01.php?Opcion=E&Valores="+Valores;
					f.submit();
				}
			}
			break;
		case "I"://IMPRIMIR
			window.print();
			break;			
		case "S":
			window.location="../principal/sistemas_usuario.php?CodSistema=31&Nivel=1&CodPantalla=7";
		break;
	
	}
}
</script>
<DIV id=popCal style="BORDER-TOP:solid 1px #000000;BORDER-BOTTOM:solid 2px #000000;BORDER-LEFT:solid 1px #000000;
BORDER-RIGHT:solid 2px #000000; VISIBILITY: hidden; POSITION: absolute" onclick=event.cancelBubble=true>
<IFRAME name=popFrame src="archivos/popcjs.htm" frameBorder=0 width=160 scrolling=no height=180></IFRAME></DIV>
<body>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"><style type="text/css">
</style></head>
<body>
<form name="frmPrincipal" action="" method="post">
<?
 $IP_SERV = $HTTP_HOST;
 EncabezadoPagina($IP_SERV,'centro_costo.png')
?>
<table width="950" align="center"  border="0" cellpadding="0"  cellspacing="0" class="TablaPricipalColor">
   <tr>
      <td width="15" height="15"><img src="archivos/images/interior/esq1em.png" width="15" height="15" /></td>
      <td width="920" height="15"background="archivos/images/interior/form_arriba.png"><img src="archivos/images/interior/transparent.gif" width="4" height="15" /></td>
      <td width="15" height="15"><img src="archivos/images/interior/esq2em.png" width="15" height="15" /></td>
    </tr>
  <tr>
   <td  width="15" background="archivos/images/interior/form_izq3.png">&nbsp;</td>
   <td>
	<table width="100%" border="0" align="center" cellpadding="2" cellspacing="0" class="ColorTabla02" >
	<tr>
		<td width="81%" align="left" class='formulario2'><img src="archivos/images/interior/t_buscadorGlobal4.png"></td>
	    <td width="19%" align="right" class='formulario2'>
		<a href="JavaScript:Procesos('C')"><span class="formulario2"></span><img src="archivos/Find2.png"   alt="Buscar"  border="0" align="absmiddle" /></a>    
		<a href="JavaScript:Procesos('N')"><img src="archivos/nuevo2.png"  border="0"  alt="Nuevo" align="absmiddle" /></a>&nbsp;
		<a href="JavaScript:Procesos('M')"><img src="archivos/btn_modificar3.png"  alt="Modificar " align="absmiddle" border="0"></a><a href="JavaScript:Procesos('E')"><img src="archivos/elim_hito2.png"  alt="Eliminar " align="absmiddle" border="0"></a>&nbsp;
		<a href="JavaScript:Procesos('S')"><img src="archivos/volver2.png" align="absmiddle" alt="Volver" border="0"></a>		</td>
	</tr>
</table>
<table width="100%" align="center" cellpadding="2" cellspacing="0" class="ColorTabla02">
  <tr>
    <td width="8%" height="17" class='formulario2'>Gerencia</td>
    <td colspan="3" class="formulario2" ><label>
      <select name="CmbGerencias" style="width:250">
	  <option value="T" selected="selected">Todas</option>
	  <?
	  $Consulta = "select cod_gerencia,descrip_gerencias from pcip_eec_gerencias order by descrip_gerencias ";			
		$Resp=mysql_query($Consulta);
		while ($Fila=mysql_fetch_array($Resp))
		{
			if ($CmbGerencias==$Fila["cod_gerencia"])
				echo "<option selected value='".$Fila["cod_gerencia"]."'>".ucfirst($Fila["descrip_gerencias"])."</option>\n";
			else
				echo "<option value='".$Fila["cod_gerencia"]."'>".ucfirst($Fila["descrip_gerencias"])."</option>\n";
		}
			?>
      </select>
    </label>            
    </tr>
  <tr>
    <td height="25" class='formulario2'>C&oacute;digo</td>
    <td width="17%" class='formulario2'><input type="text" name="TxtCC" value="<? echo $TxtCC;?>">
    
    <td width="9%" class='formulario2'>Descripci&oacute;n    
    <td width="66%" class='formulario2'><input type="text" name="TxtDescripcion" size="70" value="<? echo $TxtDescripcion; ?>">    
  </tr>
 </table>  </td>
  <td width="15" background="archivos/images/interior/form_der.png">&nbsp;</td>
    </tr>
    <tr>
      <td width="15" ><img src="archivos/images/interior/esq3em.png" width="15" height="15" /></td>
      <td height="15" background="archivos/images/interior/form_abajo.png"><img src="archivos/images/interior/transparent.gif" width="4" height="15" /></td>
      <td width="15" ><img src="archivos/images/interior/esq4em.png" width="15" height="15" /></td>
    </tr>
  </table>	
    <br>
    <table width="100%" align="center"  border="0" cellpadding="0"  cellspacing="0" class="TablaPricipalColor">
      <tr>
        <td ><img src="archivos/images/interior/esq1em.gif" width="15" /></td>
        <td width="935" background="archivos/images/interior/form_arriba.gif"><img src="archivos/images/interior/transparent.gif" width="4" /></td>
        <td ><img src="archivos/images/interior/esq2em.gif" width="15" /></td>
      </tr>
      <tr>
        <td background="archivos/images/interior/form_izq.gif">&nbsp;</td>
        <td><table width="100%" border="1" cellspacing="0" cellpadding="0">
            <tr>
              <td width="5%" class="TituloTablaVerde">&nbsp;</td>
              <td width="10%" align="center" class="TituloTablaVerde">Codigo </td>
              <td width="25%" align="center" class="TituloTablaVerde">Gerencia</td>
			  <td width="60%" align="center" class="TituloTablaVerde">Descripci&oacute;n</td>
            </tr>
			<?
			echo "<input type='hidden' name='CheckCC'>";
			if($Buscar=='S')
			{
				$Consulta="select t1.cod_area,t1.cod_cc,t1.descrip_area,t2.descrip_gerencias from pcip_eec_centro_costos t1 inner join pcip_eec_gerencias t2 on t1.cod_gerencia=t2.cod_gerencia where cod_cc<>'' ";
				if($CmbGerencias!='T')
					$Consulta.=" and t2.cod_gerencia='".$CmbGerencias."'";
				if($TxtCC!='')
					$Consulta.=" and t1.cod_cc like '%".$TxtCC."%'";	
				if($TxtDescripcion!='')
					$Consulta.=" and t1.descrip_area like '%".$TxtDescripcion."%'";		
				$Consulta.=" order by t1.cod_cc";
				//echo $Consulta;
				$Resp=mysql_query($Consulta);				
				while($Fila=mysql_fetch_array($Resp))
				{
					$Corr=$Fila[cod_area];
					$CodCC=$Fila[cod_cc];
					$NomGer=$Fila[descrip_gerencias];
					$NomCC=$Fila[descrip_area];
					
				?>
				<tr>
				  <td width="5%" align="center"><input name="CheckCC" type="checkbox" class="SinBorde" value="<? echo $Corr;?>"></td>
				  <td width="10%" align="center"><? echo $CodCC;?></td>
				  <td width="45%" align="left"><? echo $NomGer;?></td>
				  <td width="40%" align="left"><? echo $NomCC;?></td>
				</tr>
				<?	
				
				}
			}	
			?>
        </table></td>
        <td width="15" background="archivos/images/interior/form_der.gif">&nbsp;</td>
      </tr>
      <tr>
        <td width="15"><img src="archivos/images/interior/esq3em.gif" width="15" height="15" /></td>
        <td height="15"background="archivos/images/interior/form_abajo.gif"><img src="archivos/images/interior/transparent.gif" width="4" height="15" /></td>
        <td width="15"><img src="archivos/images/interior/esq4em.gif" width="15" height="15" /></td>
      </tr>
    </table></td>
 </tr>
  </table>
	<? include("pie_pagina.php")?>

</form>
</body>
</html>