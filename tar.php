<?php
$dbname = "id17192650_estacaometeoro";
$username = "id17192650_estagiometeoro";
$password = "E5{V!%s<6_6#]9V8";
$tablename = "tabela";
$date_column = "Timestamp";
$column_name = "Tar";

// Conectando ao banco de dados
$conn = mysqli_connect("localhost", $username, $password, $dbname);

// Verificando a conexão
if (!$conn) {
    die("Conexão falhou: " . mysqli_connect_error());
}

// Consulta SQL para recuperar os dados da tabela
$sql = "SELECT * FROM $tablename WHERE `Estacao` = 4 ORDER BY $date_column DESC LIMIT 1000";
$result = mysqli_query($conn, $sql);

// Array para armazenar os dados recuperados
$data = array();

// Loop para popular o array com os dados
while ($row = mysqli_fetch_array($result)) {
    $data[] = array(
        "codigo" => $row["Estacao"],
        "DataHora" => $row["DataHora"],
        "TA" => $row["Tar"]
    );
}

// Fechando a conexão com o banco de dados
mysqli_close($conn);
?>

<html>
  <head>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'DataHora');
        data.addColumn('number', 'TA');
        data.addRows([
          <?php
          foreach ($data as $row) {
              echo "['" . $row["DataHora"] . "', " . $row["TA"] . "],";
          }
          ?>
        ]);

        var options = {
          title: 'Grafico da Temperatura do ar',
          curveType: 'function',
          legend: { position: 'bottom' }
        };

        var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));

        chart.draw(data, options);
      }
    </script>
  </head>
  <body>
    <div id="curve_chart" style="width: 1500px; height: 500px"></div>
  </body>
</html>
