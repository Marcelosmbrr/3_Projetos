<?php

    namespace Classes;
    use Instances\instance_model;
    use Classes\model;
    use DateTime;

    class controller {

        private $data;

        //Método para mostrar todos os livros, ou apenas algum procurado
        public function showBooks($where=NULL, $params=NULL){

            $model_obj = instance_model::getInstance();

            //Irá receber, em todos os casos, um array associativo
            $data = $model_obj->getBooks($where, $params);

            //Se o retorno da pesquisa não for false
            if($data){

                //É chamado o método para construir a tabela HTML
                //Irá retornar um array com a tabela e o input de pesquisa
                $table = $this->constructTable("livros", $data);
                
                //Retorna a tabela string construída
                return $table;

            }else{

                return false;

            }

        }

        //Método para mostrar todas as areas, ou apenas algum procurado
        public function showAreas($where=NULL, $params=NULL){

            $model_obj = instance_model::getInstance();

            //Irá receber, em todos os casos, um array associativo
            $data = $model_obj->getAreas($where, $params);

            //Se o retorno da pesquisa não for false
            if($data){

                //É chamado o método para construir a tabela HTML
                //Irá retornar um array com a tabela e o input de pesquisa
                $table = $this->constructTable("areas", $data);
                
                //Retorna a tabela string construída
                return $table;

            }else{

                return false;

            }

        }

        //Método para mostrar todos os alunos, ou apenas algum procurado
        public function showStudents($where=NULL, $params=NULL){

            $model_obj = instance_model::getInstance();

            //Irá receber, em todos os casos, um array associativo
            $data = $model_obj->getStudents($where, $params);

            //Se o retorno da pesquisa não for false
            if($data){

                //É chamado o método para construir a tabela HTML
                //Irá retornar um array com a tabela e o input de pesquisa
                $table = $this->constructTable("alunos", $data);
                
                //Retorna a tabela string construída
                return $table;

            }else{

                return false;

            }

        }

        //Método para mostrar todos os empréstimos em andamento
        public function showLoans($where=NULL, $params=NULL){

            $model_obj = instance_model::getInstance();

            //Irá receber, em todos os casos, um array associativo
            $data = $model_obj->getLoans($where, $params);

            //Se o retorno da pesquisa não for false
            if($data){

                //É chamado o método para construir a tabela HTML
                //Irá retornar um array com a tabela e o input de pesquisa
                $table = $this->constructTable("reservas", $data);

                //Retorna a tabela string construída
                return $table;

            }else{

                return false;
                
            }
            
        }

        //Método para construir o formulário de registro, de livro ou aluno
        public function loadForm($type){

            if($type == "new_book"){

                $model_obj = instance_model::getInstance();

                //Irá receber um array associativo da tabela áreas
                $data = $model_obj->getAreas(NULL, NULL);

                //Irá receber um formulário para registro de livro, em formato string
                $form = $this->constructForm($type, $data);

                //Retorna o formulário em formato string
                return $form;

                

            }else if($type == "edit_book"){

                $model_obj = instance_model::getInstance();

                //Irá receber um array associativo da tabela áreas
                $data = $model_obj->getAreas(NULL, NULL);

                //Neste caso, o formulário será apenas construído
                //Pois não depende de dados do banco
                $form = $this->constructForm($type,$data);

                //Retorna o formulário em formato string
                return $form;

            }else if($type == "loan_book"){

                $model_obj = instance_model::getInstance();

                //Irá receber um array associativo da tabela áreas
                $data = $model_obj->getStudents(NULL, NULL);

                //Neste caso, o formulário será apenas construído
                //Pois não depende de dados do banco
                $form = $this->constructForm($type,$data);

                //Retorna o formulário em formato string
                return $form;

                
            }


        }

        //Método para construção da tabela de dados
        public function constructTable($type, $data){

            switch($type){

                case "livros": //Quando os dados forem da tabela de livros

                    //Cabeçalho fixo
                    $table = "
                    <div style = 'width: max-content; padding-bottom: 10px;'><button type='button' class='btn btn-success' id = 'btn-new_book'><i class='fas fa-plus'></i> Novo</button></div>
                    <table class='table table-hover table-light'>
                    <thead>
                    <tr>
                        <th scope='col'>id</th>
                        <th scope='col'>Título</th>
                        <th scope='col'>Autor</th>
                        <th scope='col'>Status</th>
                        <th scope='col'>Área</th>
                        <th scope='col'>Editar/Excluir</th>
                        <th scope='col'>Empréstimo</th>
                    </tr>
                    </thead>
                    <tbody>";

                    //Percorrer o array de dados //$key é a linha, e $value é o array do registro
                    foreach($data as $key => $value){

                        //Abre uma linha
                        $table .= "<tr>";

                        //Percorrer cada registro
                        foreach($value as $key => $item){

                            //Se a chave for 'id' //Será sempre o primeiro item da linha
                            if($key == 'id'){

                                //Adiciona o valor ao table header na linha 
                                $table .= "<th scope='row' value = '{$value['id']}'>$item</th>";
                            
                            //Se não for id_area e nome_area
                            }else{

                                //Adicionar o item, normalmente
                                $table .= "<td value = '{$value['id']}'>$item</td>";

                            }

                        }

                        //Está será a última coluna
                        //Este terá os botões de registro, e cada um terá a classe identificadora do id da linha
                        $table .= "<td>
                            <button type='button' class='btn btn-success btn_edit' value = '{$value['id']}' onclick = 'updateBook(this)'> Editar </button>
                            <button type='button' class='btn btn-danger btn_delete' value = '{$value['id']}' onclick = 'deleteBook(this)'> Excluir </button>
                        </td>";

                        if($value['status'] == "0"){

                                $table .= "<td>
                                <button type='button' class='btn btn-danger btn_loan' value = '{$value['id']}' onclick = 'bookLoan(this)'> Emprestar </button>
                            </td>";

                        }else if($value['status'] == "1"){

                                $table .= "<td>
                                <button type='button' class='btn btn-danger btn_loan' value = '{$value['id']}' disabled> Emprestar </button>
                            </td>";

                        }

                        //Abre uma linha
                        $table .= "</tr>";
                    }

                break;

                case "areas":

                    //Cabeçalho fixo
                    $table = 
                    "
                    <div style = 'width: max-content; padding-bottom: 10px;'><button type='button' class='btn btn-success' id = 'btn_new-area'><i class='fas fa-plus'></i> Novo</button></div>
                    <table class='table table-hover table-light'>
                    <thead>
                    <tr>
                        <th scope='col'>id</th>
                        <th scope='col'>Nome da área</th>
                        <th scope='col'>Ações</th>
                    </tr>
                    </thead>
                    <tbody>";

                    //Percorrer o array de dados //$key é a linha, e $value é o array do registro
                    foreach($data as $key => $value){

                        //Abre uma linha
                        $table .= "<tr>";

                        //Percorrer cada registro
                        foreach($value as $key => $item){

                            //Se a chave for 'id' //Será sempre o primeiro item da linha
                            if($key == 'id'){

                                //Adiciona o valor ao table header na linha 
                                $table .= "<th scope='row' value = '{$value['id']}'>$item</th>";
                            
                            //Se não for id_area e nome_area
                            }else{

                                //Adicionar o item, normalmente
                                $table .= "<td value = '{$value['id']}'>$item</td>";

                            }

                        }

                        //Está será a última coluna
                        //Este terá os botões de registro, e cada um terá a classe identificadora do id da linha
                        $table .= "<td>
                            <button type='button' class='btn btn-success btn_edit' value = '{$value['id']}' onclick = 'updateArea(this)'>Editar</button>
                            <button type='button' class='btn btn-danger btn_delete' value = '{$value['id']}' onclick = 'deleteArea(this)'>Excluir</button>
                        </td>";

                        //Abre uma linha
                        $table .= "</tr>";
                    }

                break;

                case "alunos":

                    //Cabeçalho fixo
                    $table = "
                    <div style = 'width: max-content; padding-bottom: 10px;'><button type='button' class='btn btn-success' id = 'btn-new_student'><i class='fas fa-plus'></i> Novo</button></div>
                    <table class='table table-hover table-light'>
                    <thead>
                    <tr>
                        <th scope='col'>Matrícula</th>
                        <th scope='col'>Nome</th>
                        <th scope='col'>Email</th>
                        <th scope='col'>CPF</th>
                        <th scope='col'>Data Nascimento</th>
                        <th scope='col'>Ações</th>
                    </tr>
                    </thead>
                    <tbody>";

                    //Percorrer o array de dados //$key é a linha, e $value é o array do registro
                    foreach($data as $key => $value){

                        //Abre uma linha
                        $table .= "<tr>";

                        //Percorrer cada registro
                        foreach($value as $key => $item){

                            //Se a chave for 'id' //Será sempre o primeiro item da linha
                            if($key == 'matricula'){

                                //Adiciona o valor ao table header na linha 
                                $table .= "<th scope='row' value = '{$value['matricula']}'>$item</th>";
                            
                            //Se não for id_area e nome_area
                            }else{

                                //Adicionar o item, normalmente
                                $table .= "<td value = '{$value['matricula']}'>$item</td>";

                            }

                        }

                        //Está será a última coluna
                        //Este terá os botões de registro, e cada um terá a classe identificadora do id da linha
                        $table .= "<td>
                            <button type='button' class='btn btn-success btn_edit' value = '{$value['matricula']}' onclick = 'updateStudent(this)'>Editar</button>
                            <button type='button' class='btn btn-danger btn_delete' value = '{$value['matricula']}' onclick = 'deleteStudent(this)'>Excluir</button>
                        </td>";

                        //Fecha a linha atual
                        $table .= "</tr>";
                    }

                break;

                case "reservas":

                    //Cabeçalho fixo
                    $table = "
                    <table class='table table-hover table-light'>
                    <thead>
                    <tr>
                        <th scope='col'>ID do empréstimo</th>
                        <th scope='col'>Livro</th>
                        <th scope='col'>Aluno</th>
                        <th scope='col'>Data Retirada</th>
                        <th scope='col'>Data Devolução</th>
                        <th scope='col'>Devolução</th>
                    </tr>
                    </thead>
                    <tbody>";

                    //Percorrer o array de dados //$key é a linha, e $value é o array do registro
                    foreach($data as $key => $value){

                        //Abre uma linha
                        $table .= "<tr>";

                        //Percorrer cada registro
                        foreach($value as $key => $item){

                            //Se a chave for 'id' //Será sempre o primeiro item da linha
                            if($key == 'id'){

                                //Adiciona o valor ao table header na linha 
                                $table .= "<th scope='row' value = '{$value['id']}'>$item</th>";
                                
                            
                            //Se não for id_area e nome_area
                            }else{

                                //Adicionar o item, normalmente
                                $table .= "<td value = '{$value['id']}'>$item</td>";

                            }

                        }

                        $table .= "<td><button type='button' class='btn btn-danger btn_devo' value = '{$value['id']}' onclick = 'doDevolution(this)'><i class='fas fa-minus'></i> Devolver</button></td>";

                        //Fecha a linha atual
                        $table .= "</tr>";
                    }

                break;

            }

            //Fechamento da tabela
            $table .= "</tbody>
            </table>";

            //Retorna a tabela construída, em formato string
            return $table;

        }

        //Método para construção de formulários
        public function constructForm($type, $data){

            switch($type){

                case "new_book":
                    
                    $form = "<form class = 'form-book_register'>
                    <div class='mb-3'>
                        <h3>Cadastrar novo livro</h3>
                        <label for='title-book_input' class='form-label'>Título</label>
                        <input type='text' class='form-control' id='title-book-new_input' style = 'background: lightgray; box-shadow: none; border: none;'>
                        <label for='author-book_input' class='form-label'>Autor</label>
                        <input type='text' class='form-control' id='author-book-new_input' style = 'background: lightgray; box-shadow: none; border: none;'>
                        <label for='area-book_input' class='form-label'>Área</label>
                        <select class='form-select' aria-label='Default select example' name='area_select' id='area_select'>
                        <option value = ''>Selecione</option>";

                        //Percorrer o array de dados //$key é a linha, e $value é o array do registro
                        for($linha = 0; $linha < count($data); $linha++){

                            foreach($data[$linha] as $key => $value){

                                if($key == "id"){

                                    $form .= "<option value='$value'>";

                                }else{

                                    $form .= "$value</option>";

                                }

                            }
                        }

                        $form .= "
                        </select>
                        </div>
                        <button type='submit' class='btn btn-primary' id = 'btn_register_book'>Cadastrar</button>
                        <button class='btn btn-primary btn_close'>Fechar</button>
                    </form>";
                    
                break;

                case "edit_book":
                    
                    $form = "<form class = 'form-book_register'>
                    <div class='mb-3'>
                        <h3>Editar registro do livro</h3>
                        <label for='id-book_input' class='form-label'>ID do livro</label>
                        <input type='text' class='form-control' id='id-book-edit_input' style = 'background: lightgray; box-shadow: none; border: none;' readonly>
                        <label for='title-book_input' class='form-label'>Título</label>
                        <input type='text' class='form-control' id='title-book-edit_input' style = 'background: lightgray; box-shadow: none; border: none;'>
                        <label for='author-book_input' class='form-label'>Autor</label>
                        <input type='text' class='form-control' id='author-book-edit_input' style = 'background: lightgray; box-shadow: none; border: none;'>
                        <label for='area-book_input' class='form-label'>Área</label>
                        <select class='form-select' aria-label='Default select example' name='area_select' id='area_select'>
                        <option value = ''>Selecione</option>";

                        //Percorrer o array de dados //$key é a linha, e $value é o array do registro
                        for($linha = 0; $linha < count($data); $linha++){

                            foreach($data[$linha] as $key => $value){

                                if($key == "id"){

                                    $form .= "<option value='$value'>";

                                }else{

                                    $form .= "$value</option>";

                                }

                            }
                        }

                        $form .= "
                        </select>
                        </div>
                        <button type='submit' class='btn btn-primary' id = 'btn_edit_book'>Cadastrar</button>
                        <button class='btn btn-primary btn_close'>Fechar</button>
                    </form>";
                    
                break;

                case "loan_book":

                    $form = "<form class = 'form-student_register'>
                    <div class='mb-3'>
                        <h3>Realizar empréstimo</h3>
                        <label for='book-title_loan_input' class='form-label'>ID livro</label>
                        <input type='text' class='form-control' id='book-title_loan_input' style = 'background: lightgray; box-shadow: none; border: none;' readonly required>
                        <label for='student-name_loan_input' class='form-label'>Aluno</label>
                        <select class='form-select' aria-label='Default select example' name='student_select' id='student_select'>
                        <option value = ''>Selecione</option>";

                    //Percorrer o array de dados //$key é a linha, e $value é o array do registro
                    for($linha = 0; $linha < count($data); $linha++){

                        foreach($data[$linha] as $key => $value){

                            if($key == "matricula"){

                                $form .= "<option value='$value'>";

                            }else if($key == "nome"){

                                $form .= "$value</option>";

                            }

                        }
                    }

                    $form .= "
                    </select>
                    <label for='book-date_loan_input' class='form-label'>Data de entrega</label>
                    <input type='date' class='form-control' id='book-date_loan_input' style = 'background: lightgray; box-shadow: none; border: none;' required> 
                    </div>
                    <button type='submit' class='btn btn-primary' id = 'btn_register_loan'>Cadastrar</button>
                    <button class='btn btn-primary btn_close'>Fechar</button>
                    </form>";

                break;

            }

            return $form;

        }

        /* MÉTODOS INSERT **************************************************/
        public function newBook($title,$author,$area){

            $model_obj = instance_model::getInstance();

            //Irá receber, em todos os casos, um array associativo
            $register = $model_obj->setBook($title,$author,$area);

            //Se o retorno da pesquisa não for false
            if($register){

                return true;

            }else{

                return false;
                
            }

        }

        public function newStudent($name,$email,$cpf,$data){

            $model_obj = instance_model::getInstance();

            //Irá receber, em todos os casos, um array associativo
            $register = $model_obj->setStudent($name,$email,$cpf,$data);

            //Se o retorno da pesquisa não for false
            if($register){

                return true;

            }else{

                return false;
                
            }

        }

        public function newArea($area){

            $model_obj = instance_model::getInstance();

            //Irá receber true ou false
            $register = $model_obj->setArea($area);

            //Se o retorno da pesquisa não for false
            if($register){

                return true;

            }else{

                return false;
                
            }

        }

        public function newLoan($book,$student,$date){

            $model_obj = instance_model::getInstance();

            //Irá receber, em todos os casos, um array associativo
            $loan = $model_obj->setLoan($book,$student,$date);

            //Se o retorno da pesquisa não for false
            if($loan){

                return true;

            }else{

                return false;
                
            }
        }

        /*MÉTODOS UPDATE ****************************************************/
        public function updateBook($id,$title,$author,$area){

            $model_obj = instance_model::getInstance();

            //Irá receber, em todos os casos, um array associativo
            $register = $model_obj->updateBook($id,$title,$author,$area);

            //Se o retorno da pesquisa não for false
            if($register){

                return true;

            }else{

                return false;
                
            }

        }

        public function editStudent($id,$name,$email,$cpf,$data){

            $model_obj = instance_model::getInstance();

            //Irá receber, em todos os casos, um array associativo
            $register = $model_obj->updateStudent($id,$name,$email,$cpf,$data);

            //Se o retorno da pesquisa não for false
            if($register){

                return true;

            }else{

                return false;
                
            }

        }

        public function editArea($area,$area_name){

            $model_obj = instance_model::getInstance();

            //Irá receber, em todos os casos, um array associativo
            $edit = $model_obj->updateArea($area,$area_name);

            //Se o retorno da pesquisa não for false
            if($edit){

                return true;

            }else{

                return false;
                
            }

        }

        /*MÉTODOS EXCLUSÃO******************************************************/
        public function delBook($id_book){

            $model_obj = instance_model::getInstance();

            //Irá receber true ou false
            $delete = $model_obj->deleteBook($id_book);

            //Se o retorno da pesquisa não for false
            if($delete){

                return true;

            }else{

                return false;
                
            }
        }

        public function delStudent($id_student){

            $model_obj = instance_model::getInstance();

            //Irá receber true ou false
            $delete = $model_obj->deleteStudent($id_student);

            //Se o retorno da pesquisa não for false
            if($delete){

                return true;

            }else{

                return false;
                
            }
        }

        public function delArea($id_area){

            $model_obj = instance_model::getInstance();

            //Irá receber true ou false
            $delete = $model_obj->deleteArea($id_area);

            //Se o retorno da pesquisa não for false
            if($delete){

                return true;

            }else{

                return false;
                
            }
        }

        public function doDevolution($loan_id, $book_id){

            $model_obj = instance_model::getInstance();

            //Irá receber true ou false
            $devolution = $model_obj->deleteLoan($loan_id, $book_id);

            //Se o retorno da pesquisa não for false
            if($devolution){

                return true;

            }else{

                return false;
                
            }
        }




    }