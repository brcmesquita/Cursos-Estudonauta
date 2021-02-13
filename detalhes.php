<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Estudonauta</title>
  <link rel="stylesheet" href="estilos/estilo.css">
</head>
<body>
    <?php
      require_once "includes/banco.php";
      require_once "includes/funcoes.php";
    ?>
  <div id="corpo">
    <?php
      $id = $_GET['id'] ?? 0;
      $busca = $banco->query("SELECT * FROM jogos WHERE id='$id'");
      
    ?>
    <h1>Detalhes do Jogo</h1>
    <table class='detalhes'>
      <?php
      if (!$busca) {
        echo "<tr><td>Busca falhou! $banco->error";
      } else {
        if ($busca->num_rows == 1){
          $reg = $busca->fetch_object();
          echo "<tr><td rowspan='3'><img src='fotos/$reg->capa' /></td>";
          echo "<td><h2>$reg->nome</h2>";
          echo "<tr><td>$reg->descricao";
          echo "<tr><td>Adm</td></tr>";
        } else {
          echo "<tr><td>Nenhum jogo encontrado.</td></tr>"; 
        } 
      }
      ?>
  </div>
</body>
</html>