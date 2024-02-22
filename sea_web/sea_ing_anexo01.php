 <?php
 //Genera un Archivo ANEXO.SEA para el ENABAL.
 
    include("funciones.php");//llama a las funcion de Stock

    //Llena Tabla Stock con datos
   // Genera_Stock($mes,$ano);   

	$Archivo = fopen("anexo.sea","w+");
	
//FLUJOS		
	$consulta = "SELECT distinct flujo FROM relacion_prod_flujo_nodo WHERE cod_proceso in (1,2,3,4) ORDER BY flujo";
    include("../principal/conectar_principal.php");
    $rs = mysqli_query($link, $consulta);

	Flujos($rs,$mes,$ano);

	
//NODOS
   	$consulta = "SELECT distinct nodo FROM relacion_prod_flujo_nodo WHERE cod_proceso in (1,2,3,4) ORDER BY nodo";
    include("../principal/conectar_principal.php");
    $rs = mysqli_query($link, $consulta);

	Nodos($rs,$mes,$ano);


//Funcion Genera los datos para la Tabla Stock
function Genera_Stock($mes, $ano)
{

   $fecha_ini = $ano.'-'.$mes.'-01';
   $fecha_ter = $ano.'-'.$mes.'-31';
   
   //Consulto las hornadas del MES
   $consulta = "SELECT distinct hornada, cod_producto, cod_subproducto, flujo FROM movimientos 
                WHERE fecha_movimiento BETWEEN '$fecha_ini' AND '$fecha_ter'"; 
   include("../principal/conectar_sea_web.php");
   $rs = mysqli_query($link, $consulta);

   while($row = mysqli_fetch_array($rs))
   {
        $hornada = $row[hornada];
		$producto = $row["cod_producto"];
		$subproducto = $row["cod_subproducto"];  
		$flujo = $row["flujo"]; 
		$unidades = StockActual($hornada,$producto,$subproducto);
        
        
		//Consulto el peso para las Unidades de cada Hornada
		$consulta = "SELECT * FROM hornadas WHERE hornada_ventana = $hornada AND cod_producto = $producto AND cod_subproducto = $subproducto";
		$rs2 = mysqli_query($link, $consulta);
        
		if($row2 = mysqli_fetch_array($rs2))
		{
			$peso_prom = $row2[peso_unidades] / $row2["unidades"];
			$peso = number_format(($unidades * $peso_prom),0,'','');
		}
		 
		 //consulto peso en piso de Raf
		 $consulta = "SELECT * FROM stock_piso_raf WHERE fecha BETWEEN '$fecha_ini' AND '$fecha_ter'  AND hornada = $hornada 
		              AND cod_producto = $producto AND cod_subproducto = $subproducto";
		 $rs3 = mysqli_query($link, $consulta);		 
		 
         if($row3 = mysqli_fetch_array($rs3))
		 {
		  	$peso = $peso + number_format($row3["peso"],0,'',''); 
			$unidades = $unidades + + number_format($row3["unidades"],0,'',''); 
		 }

         //Consulto datos ya ingresados a la tabla 
		 $consulta = "SELECT * FROM stock WHERE mes = $mes AND ano = $ano AND hornada = $hornada AND cod_producto = $producto 
		              AND cod_subproducto = $subproducto AND flujo = $flujo";
		 $rs4 = mysqli_query($link, $consulta);
		 
		 if($row4 = mysqli_fetch_array($rs4))//si encuentra datos actualiza
		 {
			 $Actualizar = "UPDATE stock SET peso = $peso, unidades = $unidades WHERE mes = $mes AND ano = $ano AND hornada = $hornada 
			                AND cod_producto = $producto AND cod_subproducto = $subproducto AND flujo = $flujo";
			 include("../principal/conectar_sea_web.php");
			 mysqli_query($link, $Actualizar);
	     }		 		  
		 else//sino inserta nuevos datos
		 {
			 $Insertar = "INSERT INTO stock (mes,ano,hornada,cod_producto,cod_subproducto,flujo,unidades,peso)";
			 $Insertar = "$Insertar VALUES ($mes,$ano,$hornada,$producto,$subproducto,$flujo,$unidades,$peso)";
			 include("../principal/conectar_sea_web.php");
			 mysqli_query($link, $Insertar); 
	     }

   } 

}
 


//Funcion FLUJOS
function Flujos($rs,$mes,$ano)
{
	    $Archivo = fopen("anexo.sea","a+");

		while($row = mysqli_fetch_array($rs))
		{
/******  Recepcion ******/
            if($row["flujo"] != 0)
			{
				$peso = 0;
				$CU = 0;
				$AG = 0;
				$AU = 0; 
              
				$consulta = "SELECT cod_producto, cod_subproducto, hornada, peso FROM stock WHERE flujo = $row["flujo"] AND mes = $mes AND ano = $ano";
				include("../principal/conectar_sea_web.php");               
				$rs2 = mysqli_query($link, $consulta);
	
				while($row2 = mysqli_fetch_array($rs2))
				{			        
					$peso = $peso + number_format($row2["peso"],0,'','');
					   
				   //FINO CU
				   $consulta1 = "SELECT valor FROM leyes_por_hornada WHERE cod_producto = $row2["cod_producto"] AND cod_subproducto = $row2["cod_subproducto"] AND hornada = $row2[hornada] AND cod_leyes = 2";	
				   include("../principal/conectar_sea_web.php");
				   $result1 = mysqli_query($link, $consulta1);

				  if($fila1 = mysqli_fetch_array($result1))
				   {
					  $CU = $CU + number_format(($row2["peso"] * $fila1["valor"]),0,'','');
				   }			              

				   //FINO AG
				   $consulta2 = "SELECT valor FROM leyes_por_hornada WHERE cod_producto = $row2["cod_producto"] AND cod_subproducto = $row2["cod_subproducto"] AND hornada = $row2[hornada] AND cod_leyes = 4";	
				   include("../principal/conectar_sea_web.php");
				   $result2 = mysqli_query($link, $consulta2);

				  if($fila2 = mysqli_fetch_array($result2))
				   {
					  $AG = $AG + number_format(($row2["peso"] * $fila2["valor"]),0,'','');
				   }			              

				   //FINO AU
				   $consulta3 = "SELECT valor FROM leyes_por_hornada WHERE cod_producto = $row2["cod_producto"] AND cod_subproducto = $row2["cod_subproducto"] AND hornada = $row2[hornada] AND cod_leyes = 5";	
				   include("../principal/conectar_sea_web.php");
				   $result3 = mysqli_query($link, $consulta3);

				  if($fila3 = mysqli_fetch_array($result3))
				   {
					  $AU = $AU + number_format(($row2["peso"] * $fila3["valor"]),0,'','');
				   }			              
														
		 	    } 

			 }
				 
			
				$reg = 2;
				$nro = $row["flujo"];				
				$peso_seco = $peso;
				$fino_CU = $CU;
				$fino_AG = $AG;
				$fino_AU = $AU;	

				//llena con 0 si es menor el string a 3
				if(($valor_nro = strlen($nro)) < 3)
				{
				   $valor_nro = 3 - $valor_nro;  
				 
				   for($i = 1; $i <= $valor_nro ; $i++) 
				   {
					 $nro = '0'.$nro;
				   }	
				}
			
				//llena con 0 si es menor el string a 9
				if(($valor_peso = strlen($peso_seco)) < 9)
				{
				   $valor_peso = 9 - $valor_peso;  
				 
				   for($i = 1; $i <= $valor_peso ; $i++) 
				   {
					 $peso_seco = '0'.$peso_seco;
				   }	
				}
			
				//llena con 0 si es menor el string a 9
				if(($valor_CU = strlen($fino_CU)) < 9)
				{
				   $valor_CU = 9 - $valor_CU;  
				 
				   for($i = 1; $i <= $valor_CU ; $i++) 
				   {
					 $fino_CU = '0'.$fino_CU;
				   }	
				}
			
				//llena con 0 si es menor el string a 9
				if(($valor_AG = strlen($fino_AG)) < 9)
				{
				   $valor_AG = 9 - $valor_AG;  
				 
				   for($i = 1; $i <= $valor_AG ; $i++) 
				   {
					 $fino_AG = '0'.$fino_AG;
				   }	
				}
			
				//llena con 0 si es menor el string a 9
				if(($valor_AU = strlen($fino_AU)) < 9)
				{
				   $valor_AU = 9 - $valor_AU;  
				 
				   for($i = 1; $i <= $valor_AU ; $i++) 
				   {
					 $fino_AU = '0'.$fino_AU;
				   }	
				}
			
			   
				//Genera la linea para escribir en el Archivo 
				$Linea = $reg.$nro.$peso_seco.$fino_CU.$fino_AG.$fino_AU.chr(10);
				//Escribe Linea
				if($nro != 0)
				fwrite($Archivo,$Linea);
	          
				
		
		}	

			
        //Cierra Archivo  
		fclose($Archivo);

}

//Funcion NODOS
function Nodos($rs,$mes,$ano)
{
    $Archivo = fopen("anexo.sea","a+");
		
while($row = mysqli_fetch_array($rs))			
{
    	$peso = 0;
		$CU = 0;
		$AG = 0;
		$AU = 0;
				
		$consulta = "SELECT distinct flujo FROM relacion_prod_flujo_nodo WHERE nodo = $row[nodo] ORDER BY flujo";
		include("../principal/conectar_principal.php");
		$rs1 = mysqli_query($link, $consulta);


		while($row1 = mysqli_fetch_array($rs1))
		{
            if($row1["flujo"] != 0)
			{
              
				$consulta = "SELECT cod_producto, cod_subproducto, hornada, peso FROM stock WHERE flujo = $row1["flujo"] AND mes = $mes AND ano = $ano";
				include("../principal/conectar_sea_web.php");               
				$rs2 = mysqli_query($link, $consulta);
	
				while($row2 = mysqli_fetch_array($rs2))
				{			        
					$peso = $peso + number_format($row2["peso"],0,'','');
					   
				   //FINO CU
				   $consulta1 = "SELECT valor FROM leyes_por_hornada WHERE cod_producto = $row2["cod_producto"] AND cod_subproducto = $row2["cod_subproducto"] AND hornada = $row2[hornada] AND cod_leyes = 2";	
				   include("../principal/conectar_sea_web.php");
				   $result1 = mysqli_query($link, $consulta1);

				  if($fila1 = mysqli_fetch_array($result1))
				   {
					  $CU = $CU + number_format(($row2["peso"] * $fila1["valor"]),0,'','');
				   }			              

				   //FINO AG
				   $consulta2 = "SELECT valor FROM leyes_por_hornada WHERE cod_producto = $row2["cod_producto"] AND cod_subproducto = $row2["cod_subproducto"] AND hornada = $row2[hornada] AND cod_leyes = 4";	
				   include("../principal/conectar_sea_web.php");
				   $result2 = mysqli_query($link, $consulta2);

				  if($fila2 = mysqli_fetch_array($result2))
				   {
					  $AG = $AG + number_format(($row2["peso"] * $fila2["valor"]),0,'','');
				   }			              

				   //FINO AU
				   $consulta3 = "SELECT valor FROM leyes_por_hornada WHERE cod_producto = $row2["cod_producto"] AND cod_subproducto = $row2["cod_subproducto"] AND hornada = $row2[hornada] AND cod_leyes = 5";	
				   include("../principal/conectar_sea_web.php");
				   $result3 = mysqli_query($link, $consulta3);

				  if($fila3 = mysqli_fetch_array($result3))
				   {
					  $AU = $AU + number_format(($row2["peso"] * $fila3["valor"]),0,'','');
				   }			              
														
		 	    } 

			 }
        
		}

				$reg = 3;
				$nro = $row[nodo];
				$peso_seco = $peso;
				$fino_CU = $CU;
				$fino_AG = $AG;
				$fino_AU = $AU;	
			
				//llena con 0 si es menor el string a 3
				if(($valor_nro = strlen($nro)) < 3)
				{
				   $valor_nro = 3 - $valor_nro;  
				 
				   for($i = 1; $i <= $valor_nro ; $i++) 
				   {
					 $nro = '0'.$nro;
				   }	
				}
			
				//llena con 0 si es menor el string a 9
				if(($valor_peso = strlen($peso_seco)) < 9)
				{
				   $valor_peso = 9 - $valor_peso;  
				 
				   for($i = 1; $i <= $valor_peso ; $i++) 
				   {
					 $peso_seco = '0'.$peso_seco;
				   }	
				}
			
				//llena con 0 si es menor el string a 9
				if(($valor_CU = strlen($fino_CU)) < 9)
				{
				   $valor_CU = 9 - $valor_CU;  
				 
				   for($i = 1; $i <= $valor_CU ; $i++) 
				   {
					 $fino_CU = '0'.$fino_CU;
				   }	
				}
			
				//llena con 0 si es menor el string a 9
				if(($valor_AG = strlen($fino_AG)) < 9)
				{
				   $valor_AG = 9 - $valor_AG;  
				 
				   for($i = 1; $i <= $valor_AG ; $i++) 
  				   {
					 $fino_AG = '0'.$fino_AG;
				   }	
				}
			
				//llena con 0 si es menor el string a 9
				if(($valor_AU = strlen($fino_AU)) < 9)
				{
				   $valor_AU = 9 - $valor_AU;  
				 
				   for($i = 1; $i <= $valor_AU ; $i++) 
				   {
					 $fino_AU = '0'.$fino_AU;
				   }	
				}
			
			   
				//Genera la linea para escribir en el Archivo 
				$Linea = $reg.$nro.$peso_seco.$fino_CU.$fino_AG.$fino_AU.chr(10);
			
				//Escribe Linea
				if($nro != 0)
				fwrite($Archivo,$Linea);
	
		
}	
        //Cierra Archivo  
		fclose($Archivo);
	
}
		
     echo'<script>
	      alert("Anexo Generado");
          JavaScript:window.location = "sea_ing_anexo.php";
	      </script>';
    
?>