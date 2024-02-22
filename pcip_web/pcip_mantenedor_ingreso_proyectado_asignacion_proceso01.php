<? 
include("../principal/conectar_pcip_web.php");
include("funciones/pcip_funciones.php");

switch($Opcion)
{
	case "N":
	       if ($CmbDatos=='1')
		   {
				$MensajeExiste=false;
				$Consulta= " select cod_producto,cod_proveedor,VPorden from pcip_inp_asignacion  where dato='".$CmbDatos."' and cod_producto='".$CmbProducto."' and cod_proveedor='".$CmbProveedores."' and VPorden='".$CmbOrden."'";
				//echo $Consulta;
				$Resp = mysql_query($Consulta);
				if(!$Fila=mysql_fetch_array($Resp))
				{		
					if($CmbOrdenRel=='-1')
						$CmbOrdenRel=0;
					if($TxtMaterial=='')
						$TxtMaterial=0;
					if($TxtVptipinv=='')
						$TxtVptipinv=0;
					if($TxtVPtm=='')
						$TxtVPtm=0;
					if($TxtVPOrdes=='')
						$TxtVPOrdes='';
					$Mensaje1=false;
					$Insertar="insert into pcip_inp_asignacion (dato,cod_producto,cod_proveedor,VPorden,VPtm,VPmaterial,Vptipinv,VPordenrel,VPordes) values ";
					$Insertar.="('".$CmbDatos."','".$CmbProducto."','".$CmbProveedores."','".$CmbOrden."','".$TxtVPtm."','".$TxtMaterial."','".$TxtVptipinv."','".$CmbOrdenRel."','".$TxtVPOrdes."')";
					//echo $Insertar."<br>";
					mysql_query($Insertar);
					$Mensaje1=true;			
					$Cod=$CmbDatos."~".$CmbProducto."~".$CmbProveedores."~".$CmbOrden;
				}
				else
				{
				 $MensajeExiste=true;
				}
				$Cod=$CmbDatos."~".$CmbProducto."~".$CmbProveedores."~".$CmbOrden;
			}
			else
			{
				$MensajeExiste=false;
				$Consulta= " select * from pcip_inp_asignacion  where dato='".$CmbDatos."' and cod_producto='".$CmbProducto."' and cod_proveedor='".$CmbProveedores."' and VPorden='".$CmbProd."' and VPtm='".$CmbAsig."' and VPmaterial='".$CmbNegocio."' and VPtipinv='".$CmbTitulo."'";
				//echo $Consulta;
				$Resp = mysql_query($Consulta);
				if(!$Fila=mysql_fetch_array($Resp))
				{		
					$Mensaje1=false;
					$Insertar="insert into pcip_inp_asignacion (dato,cod_producto,cod_proveedor,VPorden,VPtm,VPmaterial,Vptipinv,VPordenrel,VPordes) values ";
					$Insertar.="('".$CmbDatos."','".$CmbProducto."','".$CmbProveedores."','".$CmbProd."','".$CmbAsig."','".$CmbNegocio."','".$CmbTitulo."',0,0)";
					//echo "Inserta Datos PPC    ".$Insertar."<br>";
					mysql_query($Insertar);
					$Mensaje1=true;			
					$Cod=$CmbDatos."~".$CmbProducto."~".$CmbProveedores."~".$CmbProd."~".$CmbAsig."~".$CmbNegocio."~".$CmbTitulo;
				}
				else
				{
				 $MensajeExiste=true;
				}
				$Cod=$CmbDatos."~".$CmbProducto."~".$CmbProveedores."~".$CmbProd."~".$CmbAsig."~".$CmbNegocio."~".$CmbTitulo;
			}				
			header('location:pcip_mantenedor_ingreso_proyectado_asignacion_proceso.php?Opcion=M&Codigos='.$Cod.'&Mensaje1='.$Mensaje1.'&MensajeExiste='.$MensajeExiste);
	break;
	case "M":	        
			$Cod=explode('~',$Codigos);
			if($Cod[0]=='1')
			{
					if($CmbOrdenRel=='-1')
						$CmbOrdenRel=0;
					if($TxtMaterial=='')
						$TxtMaterial=0;
					if($TxtVptipinv=='')
						$TxtVptipinv=0;
					if($TxtVPtm=='')
						$TxtVPtm=0;
					if($TxtVPOrdes=='')
						$TxtVPOrdes='';
				$Mensaje2=false;
				$Actualizar="UPDATE pcip_inp_asignacion set VPtm='".$TxtVPtm."',VPmaterial='".$TxtMaterial."',Vptipinv='".$TxtVptipinv."',VPordenrel='".$CmbOrdenRel."',VPordes='".$TxtVPOrdes."' ";
				$Actualizar.=" where dato='".$Cod[0]."' and cod_producto='".$Cod[1]."' and cod_proveedor='".$Cod[2]."' and VPorden='".$Cod[3]."'";	
				//echo $Actualizar."<br>";
				mysql_query($Actualizar);
				$Mensaje2=true;
				$Codigos=$Cod[0]."~".$Cod[1]."~".$Cod[2]."~".$Cod[3];
			}
			else
			{
				$Mensaje2=false;
				$Actualizar="UPDATE pcip_inp_asignacion set VPorden='".$CmbProd."',VPtm='".$CmbAsig."',VPmaterial='".$CmbNegocio."',Vptipinv='".$CmbTitulo."',VPordenrel=0,VPordes=0 ";
				$Actualizar.=" where dato='".$Cod[0]."' and cod_producto='".$Cod[1]."' and cod_proveedor='".$Cod[2]."' and VPorden='".$Cod[3]."' and VPtm='".$Cod[4]."' and VPmaterial='".$Cod[5]."' and Vptipinv='".$Cod[6]."'";	
				//echo $Actualizar."<br>";
				mysql_query($Actualizar);
				$Mensaje2=true;
				$Codigos=$Cod[0]."~".$Cod[1]."~".$Cod[2]."~".$CmbProd."~".$CmbAsig."~".$CmbNegocio."~".$CmbTitulo;
				//echo $Codigos."<br>";
			}
			header('location:pcip_mantenedor_ingreso_proyectado_asignacion_proceso.php?Opcion=M&Codigos='.$Codigos.'&Mensaje2='.$Mensaje2);
	break;
	case "E":
		$Mensaje='1';
		$Datos = explode("//",$Valores);
		while (list($clave,$Codigo)=each($Datos))
		{				
		   //echo $Codigo."<br>";
			$Cod=explode('~',$Codigo);
			if($Cod[0]=='1')
			{
				$Eliminar="delete from pcip_inp_asignacion where dato='".$Cod[0]."' and  cod_producto='".$Cod[1]."' and  cod_proveedor='".$Cod[2]."' and VPorden='".$Cod[3]."'";	
				mysql_query($Eliminar);
			}
			else
			{
				$Eliminar="delete from pcip_inp_asignacion where dato='".$Cod[0]."' and cod_producto='".$Cod[1]."' and  cod_proveedor='".$Cod[2]."' and VPorden='".$Cod[3]."' and VPtm='".$Cod[4]."' and VPmaterial='".$Cod[5]."' and Vptipinv='".$Cod[6]."'";	
				mysql_query($Eliminar);
				//echo $Eliminar."<br>";
			}
		}
		header("location:pcip_mantenedor_ingreso_proyectado_asignacion.php?Mensaje=".$Mensaje."&Buscar=S&CmbProducto=-1&CmbProveedores=-1&CmbOrden=-1");
	break;
}

?>