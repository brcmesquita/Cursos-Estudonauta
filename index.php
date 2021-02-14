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
    // Aqui são os imports
    require_once "includes/banco.php";
    require_once "includes/funcoes.php";

    // Aqui é uma condição, onde, ele vai capturar a ordenação que o
    // usuário colocou. Caso ele não coloque nada, a ordenação default
    // será por nome
    $ordem = $_GET['o'] ?? "n";

    // Agora nós implementamos a barra de busca com o seguinte código
    // Se o visitante não digitar nada, a busca é vazia
    $chave = $_GET['c'] ?? "";
  ?>

<div id="corpo">

  <?php
    // Aqui nós iremos importar o topo (cabeçalho da página)
    // Com este include, ele pega este arquivo e adiciona ao topo
    // Para que ele apareça no topo, basta inserir este import
    // como primeiro na página
    include_once "topo.php";
  ?>

  <!-- Título da página -->
  <h1>Escolha o seu jogo!</h1>

  <!-- Opções de ordenação, e caixa de busca -->
  <form method="get" id="busca" action="index.php">
    Ordenar:
    <a href="index.php?o=n">Nome</a> |
    <a href="index.php?o=p">Produtora</a> |
    <a href="index.php?o=na">Nota Alta</a> |
    <a href="index.php?o=nb">Nota Baixa</a> |
    <a href="index.php">Mostrar todos</a> |
    Buscar: <input type='text' name='c' size='10' maxlength='40' /> <input type="submit" value='OK' />
  </form>

  <!-- Tabela de itens -->
  <table class="listagem">
  
  <?php
    // Aqui nós criamos uma variável que recebe uma string, com o comando SELECT
    // para o Banco de Dados.
    $q = "SELECT j.id, j.nome, g.genero, p.produtora, j.capa FROM jogos j JOIN generos g ON j.genero = g.id JOIN produtoras p ON j.produtora = p.id ";

    // Agora vamos implementar um teste para ver se a busca na barra de busca não vem vazia
    if (!empty($chave)) {
      // para fazer uma busca no banco, nós usamos o Like e com o item
      // a ser buscado entre %% (porcentagem)
      // Pode ser utilizado uma variável, ou uma string.
      $q .= "WHERE j.nome like '%$chave%' OR p.produtora like '%$chave%' OR g.genero like '%$chave%' ";
    }

    // Aqui nós criamos um Switch, para que o usuário possa fazer a ordenação
    // da lista de jogos por: Nome, Produtora, Nota Alta, Nota Baixa.
    // Caso o usuário não ordene, a ordenação será por Nome por default.
    switch ($ordem) {
      case "p":
        $q .= "ORDER BY p.produtora";
        break;

      case "na": 
        $q .= "ORDER BY j.nota DESC";
        break;

      case "nb":
        $q .= "ORDER BY j.nota ASC";
        break;

      default:
        $q .= "ORDER BY j.nome";
        break;     
    }

    // Aqui nós criamos uma variável chamada $busca para receber os dados da query.
    // Essa variável busca está recebendo um SELECT diretamente do banco.
    $busca = $banco->query($q);
    // Aqui nós fazemos uma verificação, para caso dê algum erro na Query.
    if (!$busca) {
      echo "<p>Erro na busca por jogos.</p>";
    } else {
      if ($busca->num_rows == 0) {
        echo "<tr><td>Nenhum registro encontrado.</td></tr>";
      } else {
        // Aqui nós criamos um Objeto chamado $reg, para receber os registros do banco
        // Para acessar o objeto e recuperar os seus dados, basta chamar o objeto, seguido do item
        // Exemplo: $reg->nome ou $reg->capa ou $reg->nota
        while ($reg = $busca->fetch_object()){
          $t = thumb($reg->capa);
          echo "<tr><td><img src='$t' class='mini'/>";
          echo "<td><a href='detalhes.php?id=$reg->id'>$reg->nome</a>";
          echo " [$reg->genero]";
          echo "<br />$reg->produtora";
          echo "<td>Adm";
        }
      }
    }
  ?>

  </table>

  <!-- Aqui nós importamos o rodapé da página que está em um outro arquivo PHP
  Para que ele apareça no final da página, nós colocamos este import por último,
  antes de fecharmos a Tag Body -->
  <?php include_once "rodape.php"; ?>

</div>
</body>
</html>