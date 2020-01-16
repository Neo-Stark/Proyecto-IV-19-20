<html>
<head>
  <link rel="stylesheet" href="css/reset.css">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>

<body>
  <?php
  if (!is_null($datos)) {
    $array = json_decode($datos);
    echo '<table class="table table-dark table-striped table-borderless">';
    echo '<thead class="thead-light"> <tr>';
    foreach ($array[0] as $cabecera => $valor) {
      echo '<th>' . $cabecera . '</th>';
    }
    echo '</tr> </thead>';
    echo  '<tbody>';
    foreach ($array as $tupla) {
      echo '<tr>';
      foreach ($tupla as $valor) {
        echo '<td>' . $valor . '</td>';
      }
      echo '</tr>';
    }
    echo '</tbody> </table>';
  }
  ?>
</body>

</html>