<?
 $CodigoDeSistema = 30;
 $CodigoDePantalla = 1;
 include("../principal/conectar_sget_web.php");
 include("funciones/sget_funciones.php");
 if(isset($Rut))
 	$TxtRut=$Rut;
?>
<html>
<head>
<title>Comparacion Sueldo</title>
<link href="estilos/css_sget_web.css" rel="stylesheet" type="text/css">
<script  language="JavaScript" src="../principal/funciones/funciones_java.js"></script>
<script  language="JavaScript" src="funciones/sget_funciones.js"></script>
<script language="JavaScript">
function Procesos(TipoProceso)
{
	var f = document.frmPrincipal;
	var Agrupados='N';
	
	switch(TipoProceso)
	{

		case "M":
			var Valores="";
			var contador="";
			for (i=1;i<f.elements.length;i++)
			{
				if (f.elements[i].name=="CheckPers" && f.elements[i].checked==true)
				{
					Valores = Valores + f.elements[i].value + "~~";
					contador=contador+1;
				}	
			}
			if (Valores=="")
			{
				alert("Debe Seleccionar un Elemento para Modificar");
				return;
			}
			else
			{
				if (contador == 1)
				{
					var Largo=Valores.length;
					Valores=Valores.substring(0,Largo-2);
					var URL = "sget_comparacion_sueldo_proceso.php?Proceso=M&Tipo=E&Valores="+Valores;
					window.open(URL,"","top=0,left=30,width=750,height=580,menubar=no,resizable=yes,scrollbars=yes,status=1 ");
				}
				else
					alert("Debe Seleccionar Solo un Elemento");
			}
		    break;
	
		case "I"://IMPRIMIR
			window.print();
			break;				
		case "S"://SALIR
			f.action = "../principal/sistemas_usuario.php?CodSistema=30&Nivel=1&CodPantalla=31";
			f.submit();
			break;
		case 'R'://RECARGA
			f.action='sget_comparacion_sueldo.php?BuscarEmp=S';
			f.submit();
			break;
		case 'B'://BUSCAR
			f.action='sget_comparacion_sueldo.php?Buscar=S';
			f.submit();
			break;
			
	}
	
}
function BuscarEmp()
{
	var f = document.frmPrincipal;
	
	f.TxtRut.value='';
	f.TxtApePat.value='';
	Inactivos='N';
	if(f.CheckInactivos.checked==true)
		Inactivos='S';
	f.action='sget_comparacion_sueldo.php?BuscarEmp=S&CmbEmpresa=S&MostrarInact='+Inactivos;
	f.submit();
}
function BuscarRut()
{
	var f = document.frmPrincipal;
	
	f.CmbEmpresa.value='S';
	f.TxtApePat.value='';
	Inactivos='N';
	if(f.CheckInactivos.checked==true)
		Inactivos='S';
	f.action='sget_comparacion_sueldo.php?BuscarRut=S&MostrarInact='+Inactivos;
	f.submit();
}
function BuscarApePat()
{
	var f = document.frmPrincipal;
	
	f.CmbEmpresa.value='S';
	f.TxtRut.value='';
	Inactivos='N';
	if(f.CheckInactivos.checked==true)
		Inactivos='S';
	f.action='sget_comparacion_sueldo.php?BuscarApePat=S&MostrarInact='+Inactivos;
	f.submit();
}
function Detalle(Rut)
{
	var URL = "sget_detalle_persona.php?Rut="+Rut;
	window.open(URL,"","top=30,left=30,width=680,height=550,menubar=no,resizable=yes,scrollbars=yes");
}
function TarjetaProvisoria(Rut)
{
	var URL = "sget_tarjeta_provisoria.php?Rut="+Rut;
	window.open(URL,"","top=30,left=30,width=450,height=250,menubar=no,resizable=yes,scrollbars=yes");
}

</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"></head>
<body>
<form name="frmPrincipal" action="" method="post">
<?
 $IP_SERV = $HTTP_HOST;
 EncabezadoPagina($IP_SERV,'rpt_becados.png')
 ?>
<table width="950"  border="0" align="center" cellpadding="0"  cellspacing="0" bgcolor="#FFFBFB">
   <tr>
      <td width="15" height="15"><img src="archivos/images/interior/esq1em.png" width="15" height="15" /></td>
      <td width="920" height="15"background="archivos/images/interior/form_arriba.png"><img src="archivos/images/interior/transparent.gif" width="4" height="15" /></td>
      <td width="15" height="15"><img src="archivos/images/interior/esq2em.png" width="15" height="15" /></td>
    </tr>
  <tr>
     <td width="15" background="archivos/images/interior/form_izq3.png">&nbsp;</td>
    <td><table width="100%"  cellspacing="0">
      <tr>
        <td height="35" colspan="4" align="left" class="formulario2"   ><img src="archivos/images/interior/t_buscadorGlobal4.png" /> </td>
        <td colspan="2" align="right" class="formulario2" >
		<a href="JavaScript:Procesos('B')"><img src="archivos/Find2.png"   alt="Buscar"  border="0" align="absmiddle" /></a>
		<a href="JavaScript:Procesos('M')"><img src="archivos/btn_modificar3.png" border="0" alt="Modificar" align="absmiddle"></a>&nbsp; <a href="JavaScript:Procesos('S')"><img src="archivos/volver2.png"  border="0"  alt=" Volver " align="absmiddle"></a> </td>
      </tr>
      <tr>
        <td width="7%" class="formulario2">Rut </td>
        <td width="23%" class="formulario2">
          <input type="text" name="TxtRut" value="<? echo $TxtRut;?>">
          <a href="JavaScript:BuscarRut()"></a></td>
        <td width="46%" class="formulario2">Ape. Paterno&nbsp;&nbsp; 
          <input type="text" name="TxtApePat" value="<? echo $TxtApePat;?>">
          <a href="JavaScript:BuscarApePat()"></a></td>
        <td width="0%" class="formulario2">&nbsp;</td>
        <td width="23%" class="formulario2">&nbsp;</td>
        <td width="1%" class="formulario2">&nbsp;</td>
        <? 
		if($Check=='S')
		{	
			$checked='checked';
		 	$disabled="";
		}
		else
		{	
			$checked="";
			$disabled="";
		 }
		  
		  ?>
      </tr>
      <tr>
        <td class="formulario2">Empresa</td>
        <td colspan="2" class="formulario2">Buscar&nbsp;
            <input name="TxtBuscaEmp" type="text" value="<? echo $TxtBuscaEmp;?>" size="15" maxlength="10">
            <a href="JavaScript:BuscarEmp()"><img src="archivos/btn_aceptar.png"   alt="Buscar"  border="0" align="absmiddle"></a>
            <SELECT name="CmbEmpresa" style="width:300">
                <option value="S" SELECTed>Seleccionar</option>
                <?
				//include("../principal/conectar_ssgc.php");
				$Encontro=false;	
				$Consulta="SELECT * from sget_contratistas where rut_empresa<>''";
				if($BuscarEmp=='S'&&$TxtBuscaEmp!='')
					$Consulta.=" and upper(razon_social) like '%".strtoupper($TxtBuscaEmp)."%'";
				$Consulta.=" order by razon_social";	
				$RespEmp=mysqli_query($link, $Consulta);
				while($FilaEmp=mysql_fetch_array($RespEmp))
				{
					if(strtoupper($FilaEmp[rut_empresa])==strtoupper($CmbEmpresa))
						echo "<option value='".$FilaEmp[rut_empresa]."' SELECTed>".$FilaEmp[razon_social]."</option>";
					else
						echo "<option value='".$FilaEmp[rut_empresa]."'>".$FilaEmp[razon_social]."</option>";
					$Encontro=true;	
				}
			
			?>
              </SELECT>        </td>
        <td colspan="3" class="formulario2">
          <? 
				$EstadoInact='';
				if($MostrarInact=='S')
					$EstadoInact='checked';
			?>
          <input type="hidden" name="CheckInactivos" value="checkbox" <? echo $EstadoInact;?> class="SinBorde"></td>
      </tr>
      <tr>
        <td class="formulario2">Contrato</td>
        <td class="formulario2"><input name="TxtContrato" type="text" id="TxtContrato" value="<? echo $TxtContrato; ?>" size="25"></td>
        <td class="formulario2">Diferencia&nbsp;&nbsp;<SELECT name="CmbDif">
          <option value="T" SELECTed="SELECTed">Todos</option>
          <?
			switch($CmbDif)
			{
				case "S":
					echo "<option value='S' SELECTed>S</option>";
					echo "<option value='N'>N</option>";
				break;
				case "N":
					echo "<option value='S' >S</option>";
					echo "<option value='N' SELECTed>N</option>";
				break;
				default:
					echo "<option value='S'>S</option>";
					echo "<option value='N'>N</option>";
		}
		
		?>
        </SELECT></td>
        <td colspan="3" class="formulario2">&nbsp;</td>
      </tr>
    </table></td>
    <td width="15" background="archivos/images/interior/form_der.png">&nbsp;</td>
  </tr>
  <tr>
      <td width="15" height="15"><img src="archivos/images/interior/esq3em.png" width="15" height="15" /></td>
      <td height="15" background="archivos/images/interior/form_abajo.png"><img src="archivos/images/interior/transparent.gif" width="4" height="15" /></td>
      <td width="15" height="15"><img src="archivos/images/interior/esq4em.png" width="15" height="15" /></td>
    </tr>
</table><br>
<table width="950" align="center"  border="0" cellpadding="0"  cellspacing="0" class="TablaPricipalColor">
  <tr>
  <td><img src="archivos/images/interior/esq1em.gif" width="15" /></td>
  <td width="920" background="archivos/images/interior/form_arriba.gif"><img src="archivos/images/interior/transparent.gif" width="4" /></td>
  <td ><img src="archivos/images/interior/esq2em.gif" width="15" /></td>
</tr>
  <tr>
    <td background="archivos/images/interior/form_izq.gif">&nbsp;</td>
    <td><table width="100%" border="1" align="center" cellpadding="2" cellspacing="0">
          <tr>
            <td width="1%" class="TituloTablaVerde"><input type="checkbox" name="ChkTodos" value="" onClick="CheckearTodo(this.form,'CheckPers','ChkTodos');" class='SinBorde' ></td>
            <td width="5%" align="center" class="TituloTablaVerde">Foto</td>
            <td width="12%" align="center" class="TituloTablaVerde">Rut</td>
            <td width="15%" align="center" class="TituloTablaVerde">Nombre</td>
            <td width="15%" align="center" class="TituloTablaVerde">Apelli.Paterno</td>
			<td width="15%" align="center" class="TituloTablaVerde">Apelli.Materno</td>
			<td width="8%" align="center" class="TituloTablaVerde">Tarjeta</td>
			<td width="30%" align="center" class="TituloTablaVerde">Empresa</td>
			<td width="10%" align="center" class="TituloTablaVerde">Compar.</td>
			<td width="10%" align="center" class="TituloTablaVerde">Dif.</td>
          </tr>
          <?
			if($Buscar=='S')
			{
				$Consulta="SELECT t2.*,t1.rut,t1.nombres,t1.ape_paterno,t1.ape_materno,t1.nro_tarjeta,t1.rut_empresa from sget_personal t1 ";
				$Consulta.=" left join sget_comparacion_sueldo t2 on t1.rut=t2.rut_funcionario where t1.rut<>''";
				if($CmbEmpresa!='S')
					$Consulta.=" and t1.rut_empresa='".$CmbEmpresa."'";
				if($TxtRut!='')
					$Consulta.=" and t1.rut like '".$TxtRut."%'";
				if($TxtApePat!='')
					$Consulta.=" and t1.ape_paterno like '%".$TxtApePat."%'";
				if($TxtContrato!='')
					$Consulta.=" and t1.cod_contrato like '%".$TxtContrato."%'";	
				if($CmbDif!='T')
				{
					if($CmbDif=='N')
						$Consulta.=" and (t2.eco_si=t2.ctto_si and t2.eco_sb=t2.ctto_sb and t2.eco_sl=t2.ctto_sl)";	
					else
						$Consulta.=" and (t2.eco_si<>t2.ctto_si or t2.eco_sb<>t2.ctto_sb and t2.eco_sl<>t2.ctto_sl) ";		
				}
				$Consulta.="order by ape_paterno";
				echo "<input type='hidden' name='CheckPers'>";
				$RespPersona=mysqli_query($link, $Consulta);
				while($FilaPersona=mysql_fetch_array($RespPersona))
				{
					echo "<tr bgcolor='#FFFFFF'>";
					echo "<td align='center' width='30'><input type='checkbox' name='CheckPers' value='".$FilaPersona["rut"]."' class='SinBorde'></td>";
					$Foto="fotos/".$FilaPersona["rut"].".jpg";
					if(is_file($Foto))
						$Imagen=$Foto;
					else
						$Imagen="archivos/usuario.png";
					echo "<td align='center'><a href=javascript:Detalle('".$FilaPersona["rut"]."')><img src=\"$Imagen\" align=\"absmiddle\" border=\"0\" width='20' height='20'></a></td>";
					echo "<td><a href='sget_info_personal.php?run=".$FilaPersona["rut"]."'  target='_blank'><img src='archivos/info2.png'   alt='Informaci�n Personal'  border='0' align='absmiddle' /></a>&nbsp;".$FilaPersona["rut"]."</td>";			
					echo "<td>".FormatearNombre($FilaPersona["nombres"])."</td>";
					echo "<td>".FormatearNombre($FilaPersona[ape_paterno])."</td>";
					echo "<td>".FormatearNombre($FilaPersona[ape_materno])."&nbsp;</td>";
					if($FilaPersona[nro_tarjeta]!='')					
						echo "<td align='center'>".strtoupper($FilaPersona[nro_tarjeta])."&nbsp;</td>";
					else
						echo "<td align='center'><a href=javascript:TarjetaProvisoria('".$FilaPersona["rut"]."')>Tarjeta Provisoria</a></td>";
					//include("../principal/conectar_ssgc.php");
					$Consulta="SELECT * from sget_contratistas where rut_empresa='".$FilaPersona[rut_empresa]."'";
					$RespEmp=mysqli_query($link, $Consulta);
					if($FilaEmp=mysql_fetch_array($RespEmp))
						echo "<td><a href='sget_info_empresa.php?Emp=".$FilaPersona[rut_empresa]."' target='_blank'><img src='archivos/info2.png'  alt='Informaci�n Empresa' border='0' width='23' height='23' align='absmiddle' /></a>&nbsp;".FormatearNombre($FilaEmp[razon_social])."&nbsp;</td>";
					else
						echo "<td>&nbsp;</td>";
						
					if(!is_null($FilaPersona["rut_funcionario"]))	
						echo "<td align='center' > <img src='archivos/btn_activo2.png'   border='0' align='absmiddle'></td>";
					else
						echo "<td align='center' ><img src='archivos/btn_inactivo2.png'   border='0' align='absmiddle'></td>";
					if($FilaPersona[eco_si]==$FilaPersona[ctto_si]&&$FilaPersona[eco_sb]==$FilaPersona[ctto_sb]&&$FilaPersona[eco_sl]==$FilaPersona[ctto_sl])	
						echo "<td align='center' ><strong>N</strong></td>";
					else
						echo "<td align='center' ><strong>S</strong></td>";
					echo "</tr>";
				}
			}	
			?>
      </table></td>
    <td width="15" background="archivos/images/interior/form_der.gif">&nbsp;</td>
  </tr>
   <tr>
      <td width="15"><img src="archivos/images/interior/esq3em.gif" width="15" height="15" /></td>
      <td height="1"background="archivos/images/interior/form_abajo.gif"><img src="archivos/images/interior/transparent.gif" width="4" height="15" /></td>
      <td width="15"><img src="archivos/images/interior/esq4em.gif" width="15" height="15" /></td>
    </tr>
</table>
</td>
</tr>
</table>
<?
CierreEncabezado()
?>
</form>
</body>
</html>