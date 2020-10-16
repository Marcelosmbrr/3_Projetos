<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <title>Cadastro</title>
  </head>
  <body>
      <div class = "container">
          <div class = "linha">
              
              <?php
                         
                //Recuperação dos dados do formulário do arquivo cadastro_form
                $nome = isset($_POST["nome"]) ? $_POST["nome"] : null;
                $cpf = isset($_POST["cpf"]) ? $_POST["cpf"] : null;
                $data_nascimento = isset($_POST["data_nascimento"]) ? $_POST["data_nascimento"] : null;
                $sexo = isset($_POST["sexo"]) ? $_POST["sexo"] : null;
                $email = isset($_POST["email"]) ? $_POST["email"] : null;
                $endereco = isset($_POST["endereco"]) ? $_POST["endereco"] : null;
                $cidade = isset($_POST["cidade"]) ? $_POST["cidade"] : null;
                $estado = isset($_POST["estado"]) ? $_POST["estado"] : null;
                $cep = isset($_POST["cep"]) ? $_POST["cep"] : null;
                
                //Declaração dados de conexão
                $username = "root";
                $pass = "";
                $dsn = "mysql:host=localhost;dbname=first_crud";
                
                //Conexão
                if($conn = new PDO($dsn, $username, $pass)){
                
                    //Esta variável contém o comando SQL //O comando não é executado, mas ao invés disto, a função "prepare" retorna um PDOstatment object
                    //Como alternativa, existe a função "query", que executa o comando SQL por si mesma //$stmt->query(comando SQL)
                    $sql = "INSERT INTO `cadastros`(`nome`, `cpf`, `data_nasc`, `sexo`, `email`, `endereco`, `cidade`, `estado`, `cep`) VALUES (:nome, :cpf, :data_nasc, :sexo, :email, :endereco, :cidade, :estado, :cep)";
                    $stmt = $conn->prepare($sql);

                    $stmt->bindParam(":nome", $nome);
                    $stmt->bindParam(":cpf", $cpf);
                    $stmt->bindParam(":data_nasc", $data_nascimento);
                    $stmt->bindParam(":sexo", $sexo);
                    $stmt->bindParam(":email", $email);
                    $stmt->bindParam(":endereco", $endereco);
                    $stmt->bindParam(":cidade", $cidade);
                    $stmt->bindParam(":estado", $estado);
                    $stmt->bindParam(":cep", $cep);

                    //Executamos o statment, que retorna true realizado com sucesso, ou false, no caso de falha
                    if($stmt->execute()){
                        echo "<div class='alert alert-success' role='alert'>
                         Sucesso! Dados enviados e recebidos!
                        </div>";
                        }
                    else{
                        echo "<div class='alert alert-danger' role='alert'>
                          Ops! Ocorreu algum problema no envio dos dados!
                        </div>";    
                    }                  
                }
               
              ?>
              
              <a href="Cadastro_home.html" class = "btn btn-primary">VOLTAR
              </a>
          </div> 
      </div>
      
    

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
  </body>
</html>