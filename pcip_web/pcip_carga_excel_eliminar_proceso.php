<? 
include("../principal/conectar_pcip_web.php");
include("funciones/pcip_funciones.php");
if(!isset($Ano))
{
	$Ano=date('Y');
	$Mes=date('m');
}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script  language="JavaScript" src="../principal/funciones/funciones_java.js"></script>
<script language="javascript" src="funciones/pcip_funciones.js"></script>
<script language="JavaScript">
function Proceso(Opcion)
{
	switch(Opcion)
	{
	   case "E":	   	
			var f= document.FrmPopupProceso;
			if(confirm('Esta Seguro de Eliminar Los Registros'))
			{
				if(f.CmbExcel.value=='-1')
				{
					alert("Debe Seleccionar Tipo excel");
					f.CmbExcel.focus();
					Res=false;
					return;
				}
				f.action = "pcip_carga_excel_eliminar_proceso01.php?Opcion="+Opcion;
				f.submit();
	   		}
	   break;			
	}	
}
function Recarga(Opt) 
{
	var f=document.FrmPopupProceso;
	f.action='pcip_carga_excel_eliminar_proceso.php?Recarga=S';
	f.submit();
}
function Salir()
{
	window.close();
}
</script>
<style type="text/css">
<!--
body {
	background-image: url();
	background-color: #F9F9F9;
}
.Estilo8 {font-size: 11px}
-->
</style></head>

<link href="estilos/css_pcip_web.css" rel="stylesheet" type="text/css">
<DIV id=popCal style="BORDER-TOP:solid 1px #000000;BORDER-BOTTOM:solid 2px #000000;BORDER-LEFT:solid 1px #000000;
BORDER-RIGHT:solid 2px #000000; VISIBILITY: hidden; POSITION: absolute" onclick=event.cancelBubble=true>
<IFRAME name=popFrame src="archivos/popcjs.htm" frameBorder=0 width=160 scrolling=no height=180></IFRAME></DIV>
<form name="FrmPopupProceso" method="post" action="">
<table width="660"  border="0" align="center" cellpadding="0"  cellspacing="0" class="TablaPricipalColor">
  <tr>
    <td width="15" height="15"><img src="archivos/images/interior/esq1.gif" width="15" height="15"></td>
    <td width="1046" height="15"background="archivos/images/interior/form_arriba.gif"><img src="archivos/images/interior/transparent.gif" width="4" height="15"></td>
    <td height="15"><img src="archivos/images/interior/esq2x.gif" width="15" height="15"></td>
  </tr>
  <tr>
    <td background="archivos/images/interior/form_izq.gif">&nbsp;</td>
    <td><table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="74%" align="left"><img src="archivos/sub_tit_eliminar_excel.png" width="450" height="40"></td>
        <td align="right">
		<a href="JavaScript:Proceso('E')"><img src="archivos/elim_hito.png"  alt="Eliminar " align="absmiddle" border="0"></a>
		<a href="JavaScript:Salir()"><img src="archivos/close.png"  alt="Cerrar " align="absmiddle" border="0"></a>
		</td>
      </tr>
    </table>
        <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
          <tr>
            <td colspan="3"align="center" class="TituloTablaVerde"></td>
          </tr>
          <tr>
            <td width="1%" align="center" class="TituloTablaVerde"></td>
            <td align="center"><table width="100%" border="0" align="center" cellpadding="3" cellspacing="0" class="ColorTabla02" >
                <tr>
                  <td width="49" class="formulario2">Excel</td>
                  <td width="977" class="FilaAbeja2"><span class="formulario2">
                    <select name="CmbExcel" style="width:250" onChange="Recarga();" >
                      <option value="-1" class="NoSelec">Seleccionar</option>
                      <?
						$Consulta = "select * from pcip_lista_excel where vigente='S' order by orden ";
						$Resp=mysqli_query($link, $Consulta);
						while ($FilaTC=mysql_fetch_array($Resp))
						{
							if ($CmbExcel==$FilaTC["cod_excel"])
								echo "<option selected value='".$FilaTC["cod_excel"]."'>".ucfirst($FilaTC["nom_excel"])."</option>\n";
							else
								echo "<option value='".$FilaTC["cod_excel"]."'>".ucfirst($FilaTC["nom_excel"])."</option>\n";
						}
						?>
                    </select>
                  </span></td>
                </tr>
                <tr>
                  <td height="14" colspan="2" class="formulario2">
				  <table width="100%" border="1" cellpadding="0" cellspacing="0" >
                      <tr class="TituloTablaVerde">
                        <td align="center" colspan="2"><span class="Estilo8">Nombre Excel </span></td>
                        <td align="center" width="80"><span class="Estilo8">Tipo Carga </span></td>
                        <td align="center" width="84"><span class="Estilo8">Tipo Excel </span></td>
                      </tr>
                      <?
						$Consulta = "select * from pcip_lista_excel where cod_excel='".$CmbExcel."'order by orden ";
						$Resp=mysqli_query($link, $Consulta);
						while ($Fila=mysql_fetch_array($Resp))
						{
						    $Codigo=$Fila[cod_excel];
							$TipoCarga=$Fila[tipo_carga];
							echo "<tr class='FilaAbeja'>";							
							echo "<td align='center' colspan='2'>".$Fila[nom_excel]."</td>";
							echo "<td align='center'>".$TipoCarga."</td>";
							echo "<td align='center'>".$Fila[tipo_excel]."</td>";
							echo "</tr>";
							echo "<tr class='TextoPestana'>";
							echo "<td align='center' colspan='4'>&nbsp;</td>";
							echo "</tr>";
							
							if($TipoCarga=='A')
							{
							?>
							  <tr>
								<td class='TituloTablaVerde' align="center" colspan="3"><span class="Estilo8">Seleccionar A�o a Eliminar:</span></td>
								 <td width="84">
									<select name="Ano" id="Ano">
									<?
									for ($i=date("Y")-5;$i<=date("Y");$i++)
									{
										if ($i==$Ano)
											echo "<option selected value=\"".$i."\">".$i."</option>\n";
										else
											echo "<option value=\"".$i."\">".$i."</option>\n";
									}
									?>
									</select>
							    </td>
	      		      		</tr>	
							<?	
							}
							else
							{
							?>
							  <tr>
								<td class='TituloTablaVerde' align="center" colspan="3"><span class="Estilo8">Seleccionar A�o a Eliminar:</span></td>
								 <td width="84">
									<select name="Ano" id="Ano">
									<?
									for ($i=date("Y")-5;$i<=date("Y");$i++)
									{
										if ($i==$Ano)
											echo "<option selected value=\"".$i."\">".$i."</option>\n";
										else
											echo "<option value=\"".$i."\">".$i."</option>\n";
									}
									?>
									</select>
							    </td>
							   </tr>	
								  <tr>	
									<td class='TituloTablaVerde' align="center" colspan="3"><span class="Estilo8">Seleccione Mes a Eliminar:</span></td>   
									<td width="81">
									<select name="Mes" id="Mes">
									  <?									   
										for ($i=1;$i<=12;$i++)
										{
											if ($i==$Mes)
												echo "<option selected value=\"".$i."\">".$Meses[$i-1]."</option>\n";
											else
												echo "<option value=\"".$i."\">".$Meses[$i-1]."</option>\n";
										}
									   ?>
									</select>										
							      </td>
				      		    </tr>	
							<?
							}
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
      <br></td>
    <td width="15" background="archivos/images/interior/form_der.gif">&nbsp;</td>
  </tr>
  <tr>
    <td width="15" height="15"><img src="archivos/images/interior/esq3.gif" width="15" height="15" /></td>
    <td height="1" background="archivos/images/interior/form_abajo.gif"><img src="archivos/images/interior/transparent.gif" width="4" height="15" /></td>
    <td width="15" height="15"><img src="archivos/images/interior/esq4.gif" width="15" height="15" /></td>
  </tr>
</table>
</form>
</body>
</html>
