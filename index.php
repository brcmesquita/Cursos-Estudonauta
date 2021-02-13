<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Listagem de Jogos</title>
  <link rel="stylesheet" href="estilos/estilo.css">
</head>
<body>

  <?php 
    require_once "includes/banco.php";
    require_once "includes/funcoes.php";
  ?>

<div id="corpo">
  <h1>Escolha o seu jogo!</h1>
  <table class="listagem">
  <?php 
    $busca = $banco->query("SELECT * FROM jogos");
    if (!$busca) {
      echo "<p>Erro na busca por jogos.</p>";
    } else {
      if ($busca->num_rows == 0) {
        echo "<tr><td>Nenhum registro encontrado.</td></tr>";
      } else {
        while ($reg = $busca->fetch_object()){
          $t = thumb($reg->capa);
          echo "<tr><td><img src='$t' class='mini'/>";
          echo "<td><a href='detalhes.php?id=$reg->id'>$reg->nome</a>";
          echo "<td>Adm";
        }
      }
    }
  ?>

  </table>

  <?php $banco->close(); ?>

</div>
</body>
</html>