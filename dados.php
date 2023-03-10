<!DOCTYPE html>
<html><body>
<?php
$servername = "localhost";
$dbname = "id17192650_estacaometeoro";
$username = "id17192650_estagiometeoro";
$password = "E5{V!%s<6_6#]9V8";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$sql = "SELECT DataHora, Estacao, Tar, URar, Pressao, Rad, Prec, Wd, Ws, TPO, IC, DPV, Bateria, Extra1, Extra2, Extra3, Extra4, Status FROM tabela ORDER BY Timestamp DESC LIMIT 2000";
//$sql = "SELECT DataHora, DC, DP, HI, PA, PR1HS, RH, SR, TA, WD1HA, WS1HA, codigo FROM info_esta ORDER BY DataHora DESC LIMIT 2000";

echo '<table cellspacing="5" cellpadding="5">
      <tr> 
        <td>DataHora</td> 
        <td>Estação</td> 
        <td>Tar(°C)</td> 
        <td>URar(%)</td> 
        <td>Pressão(hPa)</td>
        <td>Chuva(mm)</td> 
        <td>Rad(W/m²)</td> 
        <td>Dir.Vento(°)</td> 
        <td>Vel.Vento(m/seg)</td> 
        <td>TPO(°C)</td> 
        <td>IC(°C)</td> 
        <td>DPV(hPa)</td> 
        <td>Bat(V)</td> 
        <td>Extra1</td> 
        <td>Extra2</td> 
        <td>Extra3</td> 
        <td>Extra4</td> 
        <td>Status</td> 
      </tr>';
 
if ($result = $conn->query($sql)) {
    while ($row = $result->fetch_assoc()) {
        $row_1 = $row["DataHora"];
        $row_2 = $row["Estacao"];
        $row_3 = $row["Tar"];
        $row_4 = $row["URar"];
        $row_5 = $row["Pressao"];
        $row_6 = $row["Prec"];
        $row_7 = $row["Rad"];
        $row_8 = $row["Wd"];
        $row_9 = $row["Ws"];
        $row_10 = $row["TPO"];
        $row_11 = $row["IC"];
        $row_12 = $row["DPV"];
        $row_13 = $row["Bateria"];
        $row_14 = $row["Extra1"];
        $row_15 = $row["Extra2"];
        $row_16 = $row["Extra3"];
        $row_17 = $row["Extra4"];
        $row_18 = $row["Status"];

        // Uncomment to set timezone to - 1 hour (you can change 1 to any number)
        //$row_reading_time = date("Y-m-d H:i:s", strtotime("$row_reading_time - 1 hours"));
      
        // Uncomment to set timezone to + 4 hours (you can change 4 to any number)
        //$row_reading_time = date("Y-m-d H:i:s", strtotime("$row_reading_time + 4 hours"));
      
        echo '<tr> 
                <td>' . $row_1 . '</td> 
                <td>' . $row_2 . '</td> 
                <td>' . $row_3 . '</td> 
                <td>' . $row_4 . '</td> 
                <td>' . $row_5 . '</td> 
                <td>' . $row_6 . '</td> 
                <td>' . $row_7 . '</td> 
                <td>' . $row_8 . '</td> 
                <td>' . $row_9 . '</td> 
                <td>' . $row_10 . '</td> 
                <td>' . $row_11 . '</td> 
                <td>' . $row_12 . '</td>
                <td>' . $row_13 . '</td>
                <td>' . $row_14 . '</td>
                <td>' . $row_15 . '</td>
                <td>' . $row_16 . '</td>
                <td>' . $row_17 . '</td>
                <td>' . $row_18 . '</td>
              </tr>';
    }
    $result->free();
}

$conn->close();
?> 
</table>
</body>
</html>