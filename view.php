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

//$sql = "SELECT id, DataHora, tar, ur, value2, value3, reading_time FROM tabela ORDER BY id DESC";
$sql = "SELECT DataHora, DC, DP, HI, PA, PR1HS, RH, SR, TA, WD1HA, WS1HA, codigo FROM info_esta ORDER BY DataHora DESC LIMIT 2000";

echo '<table cellspacing="5" cellpadding="5">
      <tr> 
        <td>DataHora</td> 
        <td>DC(V)</td> 
        <td>DP(°C)</td> 
        <td>HI</td> 
        <td>PA(hPa)</td>
        <td>PR1HS(mm)</td> 
        <td>RH(%)</td> 
        <td>SR(W/m²)</td> 
        <td>Tar(°C)</td> 
        <td>WD(°)</td> 
        <td>Ws(m/seg)</td> 
        <td>Estação</td> 
      </tr>';
 
if ($result = $conn->query($sql)) {
    while ($row = $result->fetch_assoc()) {
        $row_1 = $row["DataHora"];
        $row_2 = $row["DC"];
        $row_3 = $row["DP"];
        $row_4 = $row["HI"];
        $row_5 = $row["PA"];
        $row_6 = $row["PR1HS"];
        $row_7 = $row["RH"];
        $row_8 = $row["SR"];
        $row_9 = $row["TA"];
        $row_10 = $row["WD1HA"];
        $row_11 = $row["WS1HA"];
        $row_12 = $row["codigo"];

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
              </tr>';
    }
    $result->free();
}

$conn->close();
?> 
</table>
</body>
</html>
