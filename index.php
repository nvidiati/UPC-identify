<html>
<head>
	<title>Busqueda por UPC</title>
	<link rel='stylesheet' href='style/style.css' type='text/css'>
	<link rel="shortcut icon" href="favicon.ico" type="image/x-icon"/>
	<meta name="author" content="Cristobal B.">
</head>
<body>
<div class="caja1">
	<h1>Identificador de Productos Mediante UPC</h1>
	<p>Lo que este pequeño script hace es que mediante los codigos de barras de articulos electronicos ingresados en los campos disponibles debajo, hace una busqueda en una base de datos mediante los servicios de <a href="http://www.upcitemdb.com" target="_blank">UPCitemDB</a> y trae el nombre y rango de precios en que se vende dicho articulo.</p>



	<div class="unodos">

		<h3>IDENTIFICACION DE 1 O 2 PRODUCTOS</h3>
		<p>introducir en estos campos el o los codigos de barras (UPC) <br><em>Ej: 681131103015</em></p>
		
		<form name="form" action="" method="POST">
			<b>UPC #1</b><input type="text" name="text1" required placeholder="Escribir UPC"></input><br/>
			<b>UPC #1</b><input type="text" name="text2"  placeholder="Escribir UPC"></input><br/><br/>
			<input type="submit" value="Buscar"></input>
		</form>
	</div>

	<div class="separador"></div>
	<div class="archivo">
		<h3>IDENTIFICACION DE VARIOS PRODUCTOS</h3>
		<p>Subir un documento .txt con una lista de codigos de barras (UPC)</p>

		<form action="" method="post" enctype="multipart/form-data">
  		  <input type="file" name="txtfile"><br/><br/>
 		  <input type="submit" value="Cargar archivo" name="submit">
		</form>
	</div>


<?php

/******** RESULTADO DE BUSQUEDA PEQUEÑA *******/

if(isset($_POST["text1"])){
	$input1=$_POST["text1"];
	$input2=$_POST["text2"];

$bc1 = $input1;
$bc2 = $input2;

$resultado = file_get_contents("http://www.upcitemdb.com/upc/".$bc1."%2c".$bc2);

$string = $resultado;


if (  preg_match_all("'<div class=\"rImage\">(.*?)</div>'si", $string, $matches))
{


    foreach($matches[1] as $val)
    {
        echo $val;
        echo "------------------------------<br />";
    }

} 
	else
	{
   	 echo '<b style="color:#791c0d">No encontrados</b>'.'<br /><br />';
	}


}
/********* FIN BUSQUEDA PEQUEÑA **********/

else{
/********* COMIENZO BUSQUEDA GRANDE **********/	
	if(isset($_FILES['txtfile']) && ($_FILES["txtfile"]["type"] == "text/plain")){

		$lines=array();
		$fp=fopen($_FILES['txtfile']['tmp_name'], 'r');
		while (!feof($fp))
			{
    				$line=fgets($fp);
   				$line=trim($line);
  				$lines[]=$line;

			}
		fclose($fp);
	$contar = 1;

for($i=0;$i<count($lines);$i++) 
{
	$bc1 = $lines[$i];
	$bc2 = $lines[++$i];
	$bc3 = $lines[++$i];
	$bc4 = $lines[++$i];
	$bc5 = $lines[++$i];
	$bc6 = $lines[++$i];
	$bc7 = $lines[++$i];
	$bc8 = $lines[++$i];
	$bc9 = $lines[++$i];
	$bc10 = $lines[++$i];


$resultado = file_get_contents("http://www.upcitemdb.com/upc/".$bc1."%2c".$bc2."%2c".$bc3."%2c".$bc4."%2c".$bc5."%2c".$bc6."%2c".$bc7."%2c".$bc8."%2c".$bc9."%2c".$bc10);

$string = $resultado;


if (preg_match_all("'<div class=\"rImage\">(.*?)</div>'si", $string, $matches))
{
    foreach($matches[1] as $val)
    {

//        $resUpc = str_replace('o','',$val);
//        $resUpc = str_replace('>','',$resUpc);
//        $resUpc = str_replace(' ','',$resUpc);
//        $resUpc = substr_replace($val,"",0,58);
//        $resUpc = substr_replace($resUpc,"<div id='barcode'>",0,58);
//        $resUpc = substr_replace($resUpc,"</div>",31,-1);
//        $resUpc = str_replace('p','',$resUpc);
//        $resUpc = preg_match_all('!\d+!', $val, $resUpc);
//        $resUpc = substr_replace($resUpc,"<br/>",0,0);
//        $resUpc = intval(preg_replace('/[^0-9]+/', '', $val), 12);
//        $resUpc = substr_replace($resUpc,"<div id='barcode'>",0,0);
//        $resUpc = substr_replace($resUpc,"</div>",-1,0);
//        echo $resUpc;

        $val = str_replace('</span></p>','',$val);
       $val = str_replace('</a><p>',' ** ',$val);
        echo "<div id='resultado'>".$contar++ . " => " .str_replace('<br><span class="text-success">Price range: ',' ** ',$val)."</div>";
    }

/*
    foreach ( $matches[1] as $key => $match )
    {
        $newmatch = preg_replace("/<.*?>/", "", $match);
        echo $contar++ . ' => ' . htmlentities ( $newmatch ) . '<br />';

    }
*/  	        
}

	
}

/********* FINAL BUSQUEDA GRANDE **********/	

	}

}



?>
</div>
</body>
</html>