<?php
	include('conectar_ori.php');
	include('funciones/siper_funciones.php');
	//1:PESTAÑA PARA AGREGAR, MODIFICAR O ELIMINAR MEDICIONES PERSONALES.
	//2:PESTAÑA PARA AGREGAR, MODIFICAR O ELIMINAR MEDICIONES AMBIENTALES
	//3:PESTAÑA PARA AGREGAR, MODIFICAR O ELIMINAR EXAMENES DE LABORATORIO.
	//4:CONSULTAS.
	$CODAREA=ObtenerCodParent($CodSelTarea);
	$CodNivel=ObtenerNivel($CODAREA);	
	if(!isset($TipoPestana))
		$TipoPestana='1';
	switch($TipoPestana)
	{
		case "1":
			$Fondo1='imagenes/barra_medium_activa.bmp';
			$LinkPestana1='LinkPestanaActiva';
			$Fondo2='imagenes/barra_medium.bmp';
			$LinkPestana2='LinkPestana';
			$Fondo3='imagenes/barra_medium.bmp';
			$LinkPestana3='LinkPestana';
			$Fondo4='imagenes/barra_medium.bmp';
			$LinkPestana4='LinkPestana';				
		break;
		case "2":
			$Fondo1='imagenes/barra_medium.bmp';
			$LinkPestana1='LinkPestana';
			$Fondo2='imagenes/barra_medium_activa.bmp';
			$LinkPestana2='LinkPestanaActiva';
			$Fondo3='imagenes/barra_medium.bmp';
			$LinkPestana3='LinkPestana';	
			$Fondo4='imagenes/barra_medium.bmp';
			$LinkPestana4='LinkPestana';					
		break;
		case "3":
			$Fondo1='imagenes/barra_medium.bmp';
			$LinkPestana1='LinkPestana';
			$Fondo2='imagenes/barra_medium.bmp';
			$LinkPestana2='LinkPestana';
			$Fondo3='imagenes/barra_medium_activa.bmp';
			$LinkPestana3='LinkPestanaActiva';
			$Fondo4='imagenes/barra_medium.bmp';
			$LinkPestana4='LinkPestana';			
		break;
		case "4":
			$Fondo1='imagenes/barra_medium.bmp';
			$LinkPestana1='LinkPestana';
			$Fondo2='imagenes/barra_medium.bmp';
			$LinkPestana2='LinkPestana';
			$Fondo3='imagenes/barra_medium.bmp';
			$LinkPestana3='LinkPestana';
			$Fondo4='imagenes/barra_medium_activa.bmp';
			$LinkPestana4='LinkPestanaActiva';
		break;
	}
$NivelUsua=ObtieneNivelUsuario($CookieRut);	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script  language="JavaScript" src="funciones/siper_funciones.js"></script>
<script language="javascript">
function Salir()
{
	var f=document.Mantenedor;
	
	f.action= "../principal/sistemas_usuario.php?CodSistema=29";
	f.submit();

}
function SeleccionPestana(Opcion)
{
	var f=document.Mantenedor;
	
	f.PestanaActiva.value=Opcion;
	f.Proceso.value='';
	f.action='procesos_hi.php?TipoPestana='+Opcion;
	f.submit();
}
function BuscaHijos(Codigo,Filtro)
{
	var f=document.Mantenedor;
	var Estados='';
	
	f.Navega.value=Codigo;
	f.Estado.value=Codigo;
	if(Filtro!='S')
	  f.SelTarea.value='';
	var EstadoItem='';
	
	EstadoItem=f.Estado.value.split(",");
	for (var i=0;i<EstadoItem.length;i++)
	{
		if(EstadoItem[i]!='')
			Estados=Estados+"A,";
	}
	f.Estado.value=Estados.substr(Estados,Estados.length-2,2);
	f.Estado.value=f.Estado.value+"C";
	
	f.action='procesos_hi.php?TipoPestana='+f.PestanaActiva.value+'&MostrarDivMed=S&MostrarDivOrg=S&Proceso='+f.Proceso.value+'&CambiaOrg=S&Recarga=S';
	f.submit();
}
function ItemSelec(Codigo)
{
	var f=document.Mantenedor;
	
	f.SelTarea.value=Codigo;
	f.action='procesos_hi.php?TipoPestana='+f.PestanaActiva.value+'&MostrarDivMed=S&MostrarDivOrg=S&Proceso='+f.Proceso.value+'&CambiaOrg=S&Recarga=S';
	f.submit();

}
function ValidaDifFecha()
{
		var f=document.Mantenedor;
		var dif=CalculaDias(f.TxtFechaIni.value,f.TxtFechaFin.value)
		if(f.TxtFechaIni.value!=''&&f.TxtFechaFin.value!='')
		{
			dif=(dif)
			if(dif<0)
			{
				alert('Fecha Termino no puede ser Menor a Fecha Inicio');
				f.TxtFechaFin.focus();
			}
			f.DifDia.value=dif;
		}
}
function ValidarHora(Opt)
{
	var f=document.Mantenedor;
	
	//alert(f.TxtHoraIni.value);
	var er_fh = /^(0|00|1|01|2|02|3|03|4|04|5|05|6|06|7|07|8|08|9|09|10|11|12|13|14|15|16|17|18|19|20|21|22|23)\:([0-5]0|[0-5][1-9])$/   

	if(f.PestanaActiva.value!='3')
	{
		switch(Opt)
		{
			case "I":
				if(f.TxtHoraIni.value == "" )   
				{   
						alert("Introduzca la hora.");
						//f.TxtHoraIni.focus(); 
						return false   
				}   
				if (!(er_fh.test(f.TxtHoraIni.value)))    
				{    
						alert("Hora Inicio Inválida (HH:MM)");
						f.TxtHoraIni.value='';
						f.TxtHoraIni.focus();
						return false   
				}
				break;
			case "F":
				if(f.TxtHoraFin.value == "" )   
				{   
						alert("Introduzca la hora.");
						//f.TxtHoraFin.focus();    
						return false   
				}   
				if (!(er_fh.test(f.TxtHoraFin.value)))    
				{    
						alert("Hora Término Inválida (HH:MM)");
						f.TxtHoraFin.value='';
						f.TxtHoraFin.focus();
						return false   
				}
				break;
				
		}
		if(f.TxtHoraIni.value!= ""&&f.TxtHoraFin.value!= "")
		{
			var dif=0;
			var dif=CalculaDias(f.TxtFechaIni.value,f.TxtFechaFin.value)
			f.DifDia.value=dif;			
			
			var HoraMinIni="";
			var HoraMinFin="";
			
			HoraMinIni=f.TxtHoraIni.value.split(':');
			HoraMinFin=f.TxtHoraFin.value.split(':');
			if((f.TxtFechaIni.value!=''&&f.TxtFechaFin.value!='')&&(parseInt(f.DifDia.value)==0))
			{
				
				if(parseInt(HoraMinIni[0])>parseInt(HoraMinFin[0]))
				{
					alert("Hora Término no puede ser menor a Hora Inicio");
					f.TxtHoraFin.value='';
					f.TxtHoraFin.focus();
					return false;   
				}	
				else
				{
					if((parseInt(HoraMinIni[0])==parseInt(HoraMinFin[0]))&&(parseInt(HoraMinIni[1])>parseInt(HoraMinFin[1])))
					{
						alert("Hora Término no puede ser menor a Hora Inicio");
						f.TxtHoraFin.value='';
						f.TxtHoraFin.focus();
						return false;  			
					}
				}	
			}
			var Hrs='';
			var Min='';
			var FecIni=f.TxtFechaIni.value.split('/');
			var FecFin=f.TxtFechaFin.value.split('/');
			var fecha1=new Date(parseInt(FecIni[2]),parseInt(FecIni[1]*1),parseInt(FecIni[0]*1),parseInt(HoraMinIni[0]*1),parseInt(HoraMinIni[1]*1),0);
			var fecha2=new Date(parseInt(FecFin[2]),parseInt(FecFin[1]*1),parseInt(FecFin[0]*1),parseInt(HoraMinFin[0]*1),parseInt(HoraMinFin[1]*1),0);
			var DifTot=(fecha2-fecha1)/3600000
			num = Math.round(DifTot*100)/100;
			pos = num.toString().indexOf(".");
			if(pos>0)
			{
				Hrs=String(num).substring((0), pos);
				Min=String(num).substring((pos+1), num.length);
				if(Min.length==1)
					Min=Min+"0";
				Min=(parseInt(Min)*60)/100;
				Min = Math.round(Min);
			}
			else
			{
				Hrs=num;
				Min=0;
			}
			Hrs=Hrs.toString();
			Min=Min.toString();
			//alert(Hrs.length);
			//alert(Min.length);
			if(Hrs.length==1)
				Hrs="0"+Hrs;
			if(Min.length==1)
				Min="0"+Min;
			f.TxtDuracion.value=Hrs+":"+Min;
		}
	}
	return true;   
}
function Adjunto()
{
	var f=document.Mantenedor;
	var Doc='';
	
	if(f.CmbInformes.value!='S')
	{
		Doc=f.CmbInformes.value.split('~#');
		//alert(f.CmbInformes.value);
		URL="informes/"+Doc[1];
		opciones='top=30,toolbar=1,resizable=0,menubar=1,status=1,width=800,height=600,scrollbars=1';
		popup=window.open(URL,"",opciones);
	}
	else
		alert('Debe Seleccionar Informe para Visualizarlo');	

}
function CalculoMR()
{
	var f=document.Mantenedor;
	
	if(f.LPP.value!=''&&f.TxtMag.value!='')
	{
		var ValorMag=f.TxtMag.value.replace(',','.')*1;
		var ValorLPP=f.LPP.value*1;
		if(f.Unidad.value!='DB')
		{
			num = Math.round((ValorMag/ValorLPP)*1000)/1000;
			f.TxtDosis.value=num;
		}
		if(f.Unidad.value=='DB')
		{
		    if(ValorMag<=82)
			{
				f.MR.value="ACEPTABLE";
				DivSemVerde.style.visibility = 'visible';
				DivSemAmarillo.style.visibility = 'hidden';
				DivSemRojo.style.visibility = 'hidden';
				f.TxtNomAccion.style.visibility = 'hidden';
				f.TxtAccion.style.visibility = 'hidden';
			}
			if(ValorMag>82&&ValorMag<=85)
			{
				f.MR.value="MODERADO";
				DivSemVerde.style.visibility = 'hidden';
				DivSemAmarillo.style.visibility = 'visible';
				DivSemRojo.style.visibility = 'hidden';
				f.TxtNomAccion.style.visibility = 'hidden';
				f.TxtAccion.style.visibility = 'hidden';
			}
			if(ValorMag>85)
			{
				f.MR.value="INACEPTABLE";
				DivSemVerde.style.visibility = 'hidden';
				DivSemAmarillo.style.visibility = 'hidden';
				DivSemRojo.style.visibility = 'visible';
				if(f.NivelUsua.value=='6')
				{
					f.TxtNomAccion.style.visibility = 'visible';
					f.TxtAccion.style.visibility = 'visible';
				}	
			}
		}
		else
		{	
			if(ValorMag<(ValorLPP*0.5))
			{
				f.MR.value="ACEPTABLE";
				DivSemVerde.style.visibility = 'visible';
				DivSemAmarillo.style.visibility = 'hidden';
				DivSemRojo.style.visibility = 'hidden';
				f.TxtNomAccion.style.visibility = 'hidden';
				f.TxtAccion.style.visibility = 'hidden';
			}
			if(ValorMag>=(ValorLPP*0.5)&&ValorMag<=ValorLPP)
			{
				f.MR.value="MODERADO";
				DivSemVerde.style.visibility = 'hidden';
				DivSemAmarillo.style.visibility = 'visible';
				DivSemRojo.style.visibility = 'hidden';
				f.TxtNomAccion.style.visibility = 'hidden';
				f.TxtAccion.style.visibility = 'hidden';
			}
			if(ValorMag>ValorLPP)
			{
				f.MR.value="INACEPTABLE";
				DivSemVerde.style.visibility = 'hidden';
				DivSemAmarillo.style.visibility = 'hidden';
				DivSemRojo.style.visibility = 'visible';
				if(f.NivelUsua.value=='6')
				{
					f.TxtNomAccion.style.visibility = 'visible';
					f.TxtAccion.style.visibility = 'visible';
				}
			}
		}
	}
	else
	{
		f.TxtDosis.value='';
		if(f.TxtMag.value!='')
			alert('Debe Seleccionar Agente para Calcular Magnitud de Riesgos');
	}
}
function CalculoMag()
{
	var f=document.Mantenedor;
	if(f.Unidad.value!='DB'&&f.TxtDosis.value!=''&&f.TxtMag.value=='')
	{
		var ValorDosis=f.TxtDosis.value.replace(',','.')*1;
		var ValorLPP=f.LPP.value*1;
		var ValorMag=Math.round((ValorDosis*ValorLPP)*1000)/1000;
		f.TxtMag.value=ValorMag;
		//alert(ValorMag);
		//alert(ValorLPP*0.5);
		if(ValorMag<(ValorLPP*0.5))
		{
			f.MR.value="ACEPTABLE";
			DivSemVerde.style.visibility = 'visible';
			DivSemAmarillo.style.visibility = 'hidden';
			DivSemRojo.style.visibility = 'hidden';
			f.TxtNomAccion.style.visibility = 'hidden';
			f.TxtAccion.style.visibility = 'hidden';
		}
		if(ValorMag>=(ValorLPP*0.5)&&ValorMag<=ValorLPP)
		{
			f.MR.value="MODERADO";
			DivSemVerde.style.visibility = 'hidden';
			DivSemAmarillo.style.visibility = 'visible';
			DivSemRojo.style.visibility = 'hidden';
			f.TxtNomAccion.style.visibility = 'hidden';
			f.TxtAccion.style.visibility = 'hidden';
		}
		if(ValorMag>ValorLPP)
		{
			f.MR.value="INACEPTABLE";
			DivSemVerde.style.visibility = 'hidden';
			DivSemAmarillo.style.visibility = 'hidden';
			DivSemRojo.style.visibility = 'visible';
			if(f.NivelUsua.value=='6')
			{
				f.TxtNomAccion.style.visibility = 'visible';
				f.TxtAccion.style.visibility = 'visible';
			}
			
		}
	}

}
function Accion()//ACCION A TOMAR PARA PARA EXAMENES DE LABORATORIO
{
	var f=document.Mantenedor;
	
	if(f.CmbEvaluacion.value=='1')
	{
		if(f.NivelUsua.value=='6')
		{
			f.TxtNomAccion.style.visibility = 'visible';
			f.TxtAccion.style.visibility = 'visible';
		}
	}
	else
	{
		f.TxtNomAccion.style.visibility = 'hidden';
		f.TxtAccion.style.visibility = 'hidden';
	}

}

</script>
<link href="estilos/siper_style.css" rel="stylesheet" type="text/css">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Procesos Higiene Industrial</title>
</head>
<body>
<form name='Mantenedor'  method="post" onclick="ValidarHora();">
<input type="hidden" name="Proceso" value="<?php echo $Proceso;?>">
<input type="hidden" name="PestanaActiva"  value="<?php echo $TipoPestana;?>">
<input type="hidden" value="<?php echo $Navega;?>" name="Navega">
<input type="hidden" value="<?php echo $Estado;?>" name="Estado">
<input type="hidden" value="<?php echo $SelTarea;?>" name="SelTarea">
<input type="hidden" value="<?php echo $DifDia;?>" name="DifDia">
<input type="hidden" name="DatosMed"  value="<?php echo $DatosMed;?>">
<input type="hidden" name="NivelUsua"  value="<?php echo $NivelUsua;?>">
  <table width="100%" border="0" cellpadding="0" cellspacing="0">
	  <tr>
		<td colspan="9" align="center"><img src="imagenes/cab_hi.jpg" alt="" height="52" border="0"></td>
		</tr>
		<tr>
		<td colspan="9" background="imagenes/bg_sup.gif" class="BordeTop" align="right">
		<font style="FONT-WEIGHT: bold; FONT-SIZE: 12px; COLOR: #9c3031; FONT-FAMILY: Arial, Helvetica, sans-serif">
		<?php 
		ObtieneUsuario($CookieRut,&$NombreUser);
		echo "Usuario: ".$NombreUser;?>	</font>
		<a href="Manual_Usuario_hi.pdf" target="_blank">
		</font><img src="imagenes/acrobat.png" alt='Manual de Usuario' width="25" height="25" border="0"></a><a href="javascript:Salir();"><img src="imagenes/btn_volver3.png" alt='Salir' width="25" height="25" border="0"></a>&nbsp;&nbsp;</td>
		</tr>
		<tr><td colspan="9">&nbsp;</td></tr>
  </table>
  <table width="100%" border="0" cellpadding="0" cellspacing="0">
	<tr>
	  	  <td width="1%" height="25"><img src="imagenes/tab_slide_hm_next.gif" ></td>
		  <td width="32%" align="center" background="<?php echo $Fondo1;?>"><a href="javascript:SeleccionPestana(1)"><?php echo '<span class="'.$LinkPestana1.'">';?>Mediciones Personales</a></td>
		  <td width="1%" ><img src="imagenes/tab_separator.gif"></td>
		  <td width="32%" align="center" background="<?php echo $Fondo2;?>"><a href="javascript:SeleccionPestana(2)"><?php echo "<span class='".$LinkPestana2."'>";?>Mediciones Ambientales</a></td>
		  <td width="1%" ><img src="imagenes/tab_separator.gif"></td>
		  <td width="32%" align="center" background="<?php echo $Fondo3;?>"><a href="javascript:SeleccionPestana(3)"><?php echo '<span class="'.$LinkPestana3.'">';?>Examenes de Laboratorio</a></td>
	  	  <td width="1%" align="right"><img src="imagenes/tab_separator.gif"></td>
	</tr>
    <tr class="estilos2">
      <td colspan="9" align="center" >
	    <?php
		switch($TipoPestana)
		{
			case "1":
				include('proceso_mediciones_personales.php');
			break;
			case "2":
				include('proceso_mediciones_ambientales.php');
			break;
			case "3":
				include('proceso_examenes_laboratorio.php');
			break;		
			case "4":
				//include('');
			break;	
		}	  
	  ?></td>
    </tr>
	</table>
	<table width="100%" border="0" align="center" cellpadding="0"  cellspacing="0" bgcolor="#EBEBEB">
    <tr class="estilos2">
      <td width="15" background="imagenes/interior/form_izq.gif"></td>
      <td align="center" valign="top"></td>
      <td width="15" align="center" background="imagenes/interior/form_der.gif"></td>
    </tr>
    <tr>
      <td width="15" height="15"><img src="imagenes/interior/esq3.gif" width="15" height="15"></td>
      <td  height="15" background="imagenes/interior/form_abajo.gif"><img src="imagenes/interior/transparent.gif" width="4" height="15"></td>
      <td width="15" height="15"><img src="imagenes/interior/esq4.gif" width="15" height="15"></td>
    </tr>
  </table>
</form>
</body>
</html>
<?php
if($Msj!='')
{
	echo "<script languaje='javascript'>";
	echo "alert('".$Msj."');";
	echo "</script>";
}
?>