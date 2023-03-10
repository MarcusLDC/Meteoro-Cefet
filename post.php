<?php
$servername = "localhost";
$dbname = "id17192650_estacaometeoro";
$username = "id17192650_estagiometeoro";
$password = "E5{V!%s<6_6#]9V8";
$api_key_value = "almir";
$api_key=$linha=""; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $api_key = test_input($_POST["key"]);
    if($api_key == $api_key_value) {
		$linha = test_input($_POST["msg"]);
        
		$l = explode(";", $linha);	
        $tam = sizeof($l);//pega a quantidade de variaveis do arquivo	
		//if ($tam == 12) { 
		for($k=1;$k<$tam;$k++){//para o tamanho da linha
          if($l[$k]=='///'||$l[$k]=="///"||$l[$k]=="")//dados com /// se tornam nulos
            $l[$k]='null';
            }		
        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }         
	$sql = "INSERT IGNORE INTO tabela VALUES";
	$sql .="('NULL',current_timestamp(),'$l[0]','$l[1]','$l[2]','$l[3]','$l[4]','$l[5]','$l[6]','$l[7]','$l[8]','$l[9]','$l[10]','$l[11]','$l[12]','$l[13]','$l[14]','$l[15]','$l[16]','$l[17]')";

        if ($conn->query($sql) === TRUE) {
            echo "Dados salvos";
        }
        else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }    
        $conn->close();
		//}
    }
    else {
        echo " API Key errada!";
    }
}
else {
    echo "No data posted with HTTP POST.";
}

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}