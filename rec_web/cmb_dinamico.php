<?php 
include("../principal/conectar_principal.php");
$Consulta = "SELECT cod_subproducto, descripcion, ";
$Consulta.= " case when length(cod_subproducto)<2 then concat('0',cod_subproducto) else cod_subproducto end as orden ";
$Consulta.= " from proyecto_modernizacion.subproducto ";
$Consulta.= " where cod_producto='1' ";
$Consulta.= " order by orden ";

$Consulta2 = "SELECT distinct RUTPRV_A,NOMPRV_A,cod_subproducto from rec_web.proved t1 inner join age_web.relaciones t2 ";
$Consulta2.= " on t1.rutprv_a=t2.rut_proveedor ";
$Consulta2.= " order by t1.nomprv_a";

?> 
<form method="post" name="main" action=""> 
Nombre :<input type="text" name="nombre"> 
Edad :<input type="text" name="nombre"> 
    <SELECT name="cat" onchange="incluir(this.form.cat[SELECTedIndex].value);"> 
        <?php 
            $query=mysqli_query($link, $Consulta); 
            while($row=mysqli_fetch_array($query)){ 
                echo "<option value=".$row["cod_producto"].">".$row["descripcion"]."</option>"; 
            }             
        ?> 
    </SELECT> 
    <SELECT name="sub"> 
    </SELECT> 
    <input type="submit" name="send" value="Enviar"> 
</form> 
<script lang="jscript">
var mimatriz0 = '';
var mimatriz = '';
function valores(campo1,campo2){ 
    this.campo1=campo1; 
    this.campo2=campo2; 
} 
<?php 
$query_s=mysqli_query($link, $Consulta); 
$indice=0; 
$cat=0; 
while($row=mysqli_fetch_array($query_s)){ 
    if($cat!=$row["cod_producto"]){ 
        $indice=0; 
        $cat=$row["cod_producto"]; 
        echo "var mimatriz".$cat."= new Array();\n"; 
    } 
    echo "mimatriz".$cat."[".$indice."]=new valores('".$row["descripcion"]."','".$row["cod_producto"]."');\n"; 
} 
?> 
var i; 
function incluir(array){ 
    clear(); 
    array=eval("mimatriz" + array); 
    for(i=0; i<array.length; i++){ 
        var objeto=new Option(array[i].campo1, array[i].campo2); 
        main.sub.options[i]=objeto; 
    } 
    main.sub.disabled=false; 
    main.sub.focus(); 
} 
function clear(){ 
    main.sub.length=0; 
} 
main.sub.disabled=true; 
</script> 
