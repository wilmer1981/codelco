<?php 	
	include("../principal/conectar_sec_web.php");	
	//echo $Valores."<br>"; 
	$Valores  = isset($_REQUEST["Valores"])?$_REQUEST["Valores"]:"";
	$Cierra         = isset($_REQUEST["Cierra"])?$_REQUEST["Cierra"]:"";

	$Datos=explode('//',$Valores);
	$CodLote = "";
	$NumLote = "";

	foreach($Datos as $Clave => $Valor)
	{
		$Datos2=explode('~~',$Valor);
		$IE=$Datos2[0];
		$NombreProducto=$Datos2[1];
		$NombreSubProducto=$Datos2[2];
		$CodProducto    = $Datos2[3];
		$CodSubProducto = $Datos2[4];
		$Peso    = $Datos2[5];
		$TipoIE  = $Datos2[6];
		$CodLote = $Datos2[8];
		$NumLote = $Datos2[9];
		$PesoPreparado=$Datos2[7];
		$Marca=$Datos2[10];

		if ($PesoPreparado=='')
		{
			$PesoPreparado=0;
		}
	}
 

	if (($CodLote == "") || ($NumLote == ""))
	{
		if($Cierra=='Avance')
		{
			$Msj="";

             $Consulta="select * from sec_web.programa_codelco where corr_codelco ='".$IE."'  ";
             $Resp=mysqli_query($link, $Consulta);
             if($Fila2=mysqli_fetch_array($Resp))
             {
						if($Fila2["estado2"]=='T' && 	$Fila2["estado1"]=='R')
						{
							$Actualizar="UPDATE sec_web.programa_codelco set estado2='',estado1='' where corr_codelco=".$IE;
							mysqli_query($link, $Actualizar);
							//echo $Actualizar."<br>";
							$Encontro=true;
						}
              }
			else
             {
				$Msj='La IE No Existe ';
			     header("location:sec_programa_adm_loteo.php?TipoIE=Completas&Msj=".$Msj);
		    }



		header("location:sec_programa_adm_loteo.php?TipoIE=Normal");
		}
     }
   else
    {
     $Msj='La IE Tiene Lote Asociado';
	 header("location:sec_programa_adm_loteo.php?TipoIE=Completas&Msj=".$Msj);

  
	}	
 


?>	
