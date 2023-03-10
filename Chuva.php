<?php
  $dbname = "id17192650_estacaometeoro";
  $username = "id17192650_estagiometeoro";
  $password = "E5{V!%s<6_6#]9V8";
  
  $conn = new mysqli("localhost", $username, $password, $dbname);
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }
  
// Consulta para obter os últimos 2000 dados da tabela "info_esta"
$query = "SELECT * FROM info_esta ORDER BY DataHora DESC LIMIT 2000";
$result = mysqli_query($conn, $query);

// Verifica se a consulta foi executada com sucesso
if (!$result) {
    die("Falha ao executar a consulta: " . mysqli_error($conn));
}

  $data = array();
  while ($row = mysqli_fetch_array($result)) {
    $data[] = array(
      'DataHora' => $row['DataHora'],
      'PR1HS' => $row['PR1HS'],
      'TA' => $row['TA'],
      'codigo' => $row['codigo']
    );
  }

  $unique_codes = array_unique(array_column($data, 'codigo'));
  sort($unique_codes);
  
  $grouped_data = array();
  foreach ($unique_codes as $code) {
    $grouped_data[$code] = array_filter($data, function ($element) use ($code) {
      return $element['codigo'] == $code;
    });
  }
  
  $conn->close();
?>

<html>
  <head>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawPR1HSChart);
      google.charts.setOnLoadCallback(drawTAChart);
      
      function drawPR1HSChart() {
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'DataHora');
        data.addColumn('number', 'PR1HS');
        data.addRows([
          <?php
            foreach ($grouped_data[$_GET['codigo'] ? $_GET['codigo'] : $unique_codes[0]] as $row) {
              echo "['" . $row['DataHora'] . "', " . $row['PR1HS'] . "],";
            }
          ?>
        ]);
        
        var options = {
          title: 'PR1HS x DataHora',
          hAxis: {
            title: 'DataHora'
          },
          vAxis: {
            title: 'PR1HS'
          },
          legend: 'none'
        };
        
       
