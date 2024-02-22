<?
include("../principal/conectar_pcip_web.php");
include("funciones/pcip_funciones.php");
?>
<html>
<head>
<title>Precios Metales </title>
<script language="javascript" src="../pcip_web/funciones/pcip_funciones.js"></script>
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
		     var Checkeado='';
		     if(f.Kg.checked==true)
			 {
			  Checkeado='checked';
			 }
			f.action="pcip_mantenedor_facturas_compras_precios.php?&Buscar=S&Checkeado="+Checkeado;
			f.submit();
		break;
		case "N":
			URL="pcip_mantenedor_facturas_compras_precios_proceso.php?Opc="+Opc;
			opciones='top=30,toolbar=0,resizable=0,menubar=0,status=1,width=660,height=400,scrollbars=1';
			verificar_popup(popup);
			popup=window.open(URL,"",opciones);
			popup.focus();
			popup.moveTo((screen.width - 640)/2,0);
		break;
		case "M":
			if(SoloUnElemento(f.name,'CheckTipoDoc','M'))
			{
				Datos=Recuperar(f.name,'CheckTipoDoc');
				URL="pcip_mantenedor_facturas_compras_precios_proceso.php?Opc="+Opc+"&Valores="+Datos;
				opciones='top=30,toolbar=0,resizable=0,menubar=0,status=1,width=660,height=400,scrollbars=1';
				verificar_popup(popup);
				popup=window.open(URL,"",opciones);
				popup.focus();
				popup.moveTo((screen.width - 640)/2,0);
			}	
		break;
		case "EX"://GENERA EXCEL
			URL='pcip_mantenedor_facturas_compras_precios_excel.php?CmbFino='+f.CmbFino.value+'&Ano='+f.Ano.value+'&Mes='+f.Mes.value;
			window.open(URL,"","top=30,left=30,width=1000,height=550,status=yes,menubar=yes,resizable=yes,scrollbars=yes");
		break;		
		case "E":
			if(SoloUnElemento(f.name,'CheckTipoDoc','E'))
			{
				mensaje=confirm("¿Esta Seguro de Eliminar estos Registros?");
				if(mensaje==true)
				{
					Datos=Recuperar(f.name,'CheckTipoDoc');
					f.action='pcip_mantenedor_facturas_compras_precios_proceso01.php?Opcion=E&Valor='+ Datos; //Datos; //+"&Pagina="+f.Pagina.value;
					f.submit();
				}
			}	
		break;
		case "R":
			f.action = "pcip_mantenedor_facturas_compras_precios.php";
			f.submit();
		break;		
		case "S":
				window.location="../principal/sistemas_usuario.php?CodSistema=31&Nivel=1&CodPantalla=10";
		break;
	}	
}

</script>
<link href="../pcip_web/estilos/css_pcip_web.css" rel="stylesheet" type="text/css">
<form name="FrmPrincipal" method="post" action="">
<?
 $IP_SERV = $HTTP_HOST;
 EncabezadoPagina($IP_SERV,'mant_precios_metales.png')
 ?>
   <table width="950" align="center"  border="0" cellpadding="0"  cellspacing="0" class="TablaPricipalColor">
      <tr>
      <td width="15" height="15"><img src="../pcip_web/archivos/images/interior/esq1em.png" width="15" height="15" /></td>
      <td width="920" height="15"background="../pcip_web/archivos/images/interior/form_arriba.png"><img src="../pcip_web/archivos/images/interior/transparent.gif" width="4" height="15" /></td>
      <td width="15" height="15"><img src="../pcip_web/archivos/images/interior/esq2em.png" width="15" height="15" /></td>
      </tr>
    <tr>
      <td width="15" background="../pcip_web/archivos/images/interior/form_izq3.png">&nbsp;</td>
      <td>
		<table width="100%" cellpadding="2" cellspacing="0">
		  <tr>
				<td width="168" align="left" class='formulario2'><img src="../pcip_web/archivos/images/interior/t_buscadorGlobal4.png"></td>
	            <td align="right" class='formulario2' colspan="4">
				<!--<a href="JavaScript:Proceso('Prov')"><img src="archivos/btn_carga.gif" border="0"></a> -->
				<a href="JavaScript:Proceso('C')"><img src="../pcip_web/archivos/Find2.png"   alt="Buscar"  border="0" align="absmiddle" /></a>    
			    <a href="JavaScript:Proceso('N')"><img src="../pcip_web/archivos/nuevo2.png"  border="0"  alt="Nuevo" align="absmiddle" /></a> 
				<a href="JavaScript:Proceso('M')"><img src="../pcip_web/archivos/btn_modificar3.png" border="0" alt="Modificar" align="absmiddle"></a> 
				<a href="JavaScript:Proceso('EX')"><img src="archivos/ico_excel5.jpg"   alt="Excel"  border="0" align="absmiddle" /></a>&nbsp;
				<a href="JavaScript:Proceso('E')"><img src="../pcip_web/archivos/elim_hito2.png"  alt="Eliminar" align="absmiddle" border="0"></a>
				<a href="JavaScript:Proceso('S')"><img src="../pcip_web/archivos/volver2.png"  border="0"  alt=" Volver " align="absmiddle"></a>		    </td>
		  </tr>
	  <tr>
		<td height="17" class='formulario2'>Fino &nbsp;&nbsp;&nbsp;
		  <select name="CmbFino" onChange="Proceso('R')">
            <option value="T" class="NoSelec" >Todos</option>
            <?
				$Consulta = "select distinct(cod_subclase),nombre_subclase from proyecto_modernizacion.sub_clase t1 inner join pcip_fac_compra_precios t2  where cod_clase='31012' and t1.cod_subclase=t2.cod_fino";			
				$Resp=mysql_query($Consulta);
				while ($FilaTC=mysql_fetch_array($Resp))
				{
					if ($CmbFino==$FilaTC["cod_subclase"])
						echo "<option selected value='".$FilaTC["cod_subclase"]."'>".ucfirst($FilaTC["nombre_subclase"])."</option>\n";
					else
						echo "<option value='".$FilaTC["cod_subclase"]."'>".ucfirst($FilaTC["nombre_subclase"])."</option>\n";
				}
			   ?>
          </select></td>
		<td colspan="4" class='formulario2'>&nbsp;</td>
	  </tr>
	  <tr>
		<td height="17" class='formulario2'>A&ntilde;o &nbsp;&nbsp;&nbsp; 		  
			  <select name="Ano" id="Ano">
			  <option value="T" selected="selected">Todos</option>	  
			  <?
				for ($i=2003;$i<=date("Y");$i++)
				{
					if ($i==$Ano)
						echo "<option selected value=\"".$i."\">".$i."</option>\n";
					else
						echo "<option value=\"".$i."\">".$i."</option>\n";
				}
			  ?>
			</select>        </td>
		<td width="44" class='formulario2'>Mes    
		<td width="120" class='formulario2'>
			  <select name="Mes" id="Mes">
			  <option value="T" selected="selected">Todos</option>
				<?
				for ($i=1;$i<=12;$i++)
				{
				if ($i==$Mes)
					echo "<option selected value=\"".$i."\">".$Meses[$i-1]."</option>\n";
				else
					echo "<option value=\"".$i."\">".$Meses[$i-1]."</option>\n";
				}
				?>
		      </select>		    </td> 
		  <td width="570" class='formulario2'>Mostrar En Kg 
		    <label>
			<?
			 if($Checkeado!='')
			 	$Checkeado='checked';
			?>
		    <input type="checkbox" class="SinBorde" name="Kg" value="checkbox" <? echo $Checkeado;?>>
		    </label></td>
	  </tr> 	  	 
	   </table>   
	</td>
      <td width="15" background="../pcip_web/archivos/images/interior/form_der.png">&nbsp;</td>
    </tr>
    <tr>
      <td width="15" height="15"><img src="../pcip_web/archivos/images/interior/esq3em.png" width="15" height="15" /></td>
      <td height="15" background="../pcip_web/archivos/images/interior/form_abajo.png"><img src="../pcip_web/archivos/images/interior/transparent.gif" width="4" height="15" /></td>
      <td width="15" height="15"><img src="../pcip_web/archivos/images/interior/esq4em.png" width="15" height="15" /></td>
    </tr>
  </table>	
  <br>	
<table width="950" align="center"  border="0" cellpadding="0"  cellspacing="0" class="TablaPricipalColor">
   <tr>
  <td><img src="../pcip_web/archivos/images/interior/esq1em.gif" width="15" /></td>
  <td width="920" background="../pcip_web/archivos/images/interior/form_arriba.gif"><img src="../pcip_web/archivos/images/interior/transparent.gif" width="4" /></td>
  <td ><img src="../pcip_web/archivos/images/interior/esq2em.gif" width="15" /></td>
   	</tr>
      <tr>
       <td background="../pcip_web/archivos/images/interior/form_izq.gif">&nbsp;</td>
        <td align="center">  
	    <table width="930" border="1" cellpadding="4" cellspacing="0" >
     
	  <tr align="center">
          <td width="7%" class="TituloTablaVerde"><input class='SinBorde' type="checkbox" name="ChkTodos" value="" onClick="CheckearTodo(this.form,'CheckTipoDoc','ChkTodos');"></td>
          <td width="11%" class="TituloTablaVerde">Año</td>
          <td width="11%" class="TituloTablaVerde">Mes</td>
		  <td width="34%" class="TituloTablaVerde">Fino</td>
		  <td width="25%" class="TituloTablaVerde">Valor</td>
		  <td width="12%" class="TituloTablaVerde">Unidad</td>
		<?
		 if($Checkeado!='') 
		 {
			?>
			 <td width="25%" class="TituloTablaVerde">Valor</td>
			 <td width="12%" class="TituloTablaVerde">Unidad</td>
			<? 
		 } 
		?>  
	  </tr>

<?
if($Buscar=='S')
{
	$Consulta = "select t1.cod_fino,t1.ano,t1.mes,t2.nombre_subclase as nom_fino,t1.valor,t3.cod_subclase as cod_moneda,t3.nombre_subclase as nom_moneda";
	$Consulta.= " from pcip_fac_compra_precios t1 inner join proyecto_modernizacion.sub_clase t2 on";
	$Consulta.= " t2.cod_clase='31012' and t1.cod_fino=t2.cod_subclase";
	$Consulta.= " inner join proyecto_modernizacion.sub_clase t3 on t3.cod_clase='31001' and t1.cod_moneda=t3.cod_subclase";
	$Consulta.=" where t1.ano<>''";
		if($CmbFino!='T')
			$Consulta.=" and t1.cod_fino='".$CmbFino."'";									  
		if($Ano!='T')
			$Consulta.=" and t1.ano='".$Ano."'";
		if($Mes!='T')
			$Consulta.=" and t1.mes='".$Mes."'";
	$Consulta.= " order by t1.ano,t1.mes ";
	$Resp = mysql_query($Consulta);
	//echo $Consulta;
	echo "<input name='CheckTipoDoc' type='hidden'  value=''>";
	
	while ($Fila=mysql_fetch_array($Resp))
	{
		$Ano =$Fila["ano"];
		$Mes =$Meses[$Fila[mes]-1];
		$Fino =$Fila["nom_fino"];
		$Valor =$Fila["valor"];	
		$CodMoneda=	$Fila["cod_moneda"];
		$Moneda =$Fila["nom_moneda"];
		$Clave =$Fila["ano"]."~".$Fila["mes"]."~".$Fila["cod_fino"];	
	    if($Checkeado!='')
	    {
			if($CodMoneda=='2')
		   {
			$ValorUS=($Valor/31.103477)*1000; 
			$MonedaUS="US$/Kg";
						
		   }
			if($CodMoneda=='1')//CODIGO DE LA TONELADA
		   {
			$ValorUS=$Valor*1000; 
			$MonedaUS="US$/Kg";			
		   }
	    }
?>	
      	<tr>
        <td  align="center"><? echo "<input name='CheckTipoDoc' class='SinBorde' type='checkbox'  value='".$Clave."'>" ?></td>
		<td align="center"><? echo $Ano; ?></td>
        <td align="center">&nbsp;<? echo $Mes; ?></td>
        <td >&nbsp;<? echo $Fino; ?></td>
        <td align="right">&nbsp;<? echo number_format($Valor,3,',','.');?></td>
        <td align="center">&nbsp;<? echo $Moneda; ?></td>
		<?
		 if($Checkeado!='') 
		 {
		  if($CodMoneda=='2' || $CodMoneda=='1')
		  {
		  	echo"<td>".number_format($ValorUS,3,',','.')."</td>";
		  	echo"<td>".$MonedaUS."</td>";
		  }	
		  else
		  {
		  	echo"<td>".number_format($Valor,3,',','.')."</td>";
			echo"<td>".$Moneda."</td>";
		  }
		 }
		?>
        </tr>
<?
	}
}	
?>			
     </table>
	</td>
 </td>
   <td width="10" background="../pcip_web/archivos/images/interior/form_der.gif">&nbsp;</td>
   </tr>
    <tr>
      <td width="15"><img src="../pcip_web/archivos/images/interior/esq3em.gif" width="15" height="15" /></td>
      <td height="1"background="../pcip_web/archivos/images/interior/form_abajo.gif"><img src="../pcip_web/archivos/images/interior/transparent.gif" width="4" height="15" /></td>
      <td width="15"><img src="../pcip_web/archivos/images/interior/esq4em.gif" width="15" height="15" /></td>
    </tr>
  </table>	
</form>
<?
CierreEncabezado()
?>
</body>
</html>
<?
	if($Mensaje=='S')
   {
?>
	<script language="javascript">
	alert("No se pueden Eliminar el dato, existen relaciones ")
	</script>
<? }?>
