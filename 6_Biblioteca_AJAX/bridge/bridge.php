<?php

    require_once("../../proj_biblioteca/vendor/autoload.php");
    use Instances\instance_controller;
    use Classes\controller;

    //echo __DIR__; die();

    header('Content-Type: application/json');

    //PRIMEIRO CARREGAMENTO DA PÁGINA //LISTAGEM DOS LIVROS
    if(isset($_POST['load_table']) && ($_POST['load_table'] == "books" || $_POST['load_table'] == "students" || $_POST['load_table'] == "areas" || $_POST['load_table'] == "loans")){

        $obj = instance_controller::getInstance();

        //Recebe um array com a tabela string
        if($_POST['load_table'] == "books"){
            $str_tb = $obj->showBooks();
        }else if($_POST['load_table'] == "students"){
            $str_tb = $obj->showStudents();
        }else if($_POST['load_table'] == "areas"){
            $str_tb = $obj->showAreas();
        }else if($_POST['load_table'] == "loans"){
            $str_tb = $obj->showLoans();
        }

        //Sessão será de "livros"
        $_SESSION['actual_table'] = $_POST['load_table']; 

        //Retorna para o Ajax os dados, em formato Json
        echo json_encode($str_tb);

    }

    //LISTAGEM DE LIVROS A PARTIR DA SELEÇÃO NO MENU
    if(isset($_POST['all_books'])){

        $obj = instance_controller::getInstance();

        //Recebe um array com a tabela string
        $str_tb = $obj->showBooks();

        //Sessão será de "livros"
        $_SESSION['actual_table'] = "livros"; 

        //Retorna para o Ajax os dados, em formato Json
        echo json_encode($str_tb);


    }

    //LISTAGEM DE ÁREAS A PARTIR DA SELEÇÃO NO MENU
    if(isset($_POST['all_areas'])){

        $obj = instance_controller::getInstance();

        //Recebe um array com a tabela string
        $str_tb = $obj->showAreas();
        //echo $str_tb; die();

        //Sessão será de "livros"
        $_SESSION['actual_table'] = "areas"; 

        //Retorna para o Ajax os dados, em formato Json
        echo json_encode($str_tb);

    }

    //LISTAGEM DE ALUNOS A PARTIR DA SELEÇÃO NO MENU
    if(isset($_POST['all_students'])){

        $obj = instance_controller::getInstance();

        //Recebe um array com a tabela string
        $str_tb = $obj->showStudents();
        //echo $str_tb; die();

        //Sessão será de "livros"
        $_SESSION['actual_table'] = "alunos"; 

        //Retorna para o Ajax os dados, em formato Json
        echo json_encode($str_tb);


    }

    //LISTAGEM DE RESERVAS A PARTIR DA SELEÇÃO NO MENU
    if(isset($_POST['all_loans'])){

        $obj = instance_controller::getInstance();

        //Recebe um array com a tabela string
        $str_tb = $obj->showLoans(null,null);
        //echo $str_tb; die();

        //Sessão será de "livros"
        $_SESSION['actual_table'] = "reservas"; 

        //Retorna para o Ajax os dados, em formato Json
        echo json_encode($str_tb);


    }

    //GERAR FORMULÁRIO PARA CADASTRAR NOVO LIVRO 
    if(isset($_POST['book_new_form'])){

        if(!empty($_POST['book_new_form']) &&  $_POST['book_new_form'] == "new_book"){
            //echo $_POST['book_new_form']; die();

            $type_form = $_POST['book_new_form'];
 
             //Instanciação da classe controller
             $obj = instance_controller::getInstance();
 
             $form_book = $obj->loadForm($type_form);
 
             echo json_encode($form_book);
 
         }


    }

    //GERAR FORMULÁRIO PARA CADASTRAR NOVO LIVRO 
    if(isset($_POST['book_edit_form'])){

        if(!empty($_POST['book_edit_form']) && $_POST['book_edit_form'] == "edit_book"){
            
            $type_form = $_POST['book_edit_form'];
 
            //Instanciação da classe controller
            $obj = instance_controller::getInstance();
 
            $form_book = $obj->loadForm($type_form);
 
            echo json_encode($form_book);
 
         }


    }

    //GERAR FORMULÁRIO PARA REALIZAR EMPRÉSTIMO
    if(isset($_POST['book_loan_form'])){

        if(!empty($_POST['book_loan_form']) && $_POST['book_loan_form'] == "loan_book"){
            
            $type_form = $_POST['book_loan_form'];
 
            //Instanciação da classe controller
            $obj = instance_controller::getInstance();
 
            $form_book = $obj->loadForm($type_form);
 
            echo json_encode($form_book);
 
         }


    }

    /* EXECUÇÃO DAS OPERAÇÕES DOS FORMULÁRIOS ---------------------------------------------------------*/

    //CADASTRAR LIVRO
    if(isset($_POST['new_book'])){

        if(!empty($_POST['new_book'])){
           //print_r($_POST['new_book']); die();

            $title = $_POST['new_book']['title'];
            $author = $_POST['new_book']['author'];
            $area = $_POST['new_book']['area'];
            //echo "$id, $title, $author, $area"; die();

            //Instanciação da classe controller
            $obj = instance_controller::getInstance();

            $register = $obj->newBook($title,$author,$area);

            echo json_encode($register);

        }
        
    }

    //EDITAR LIVRO
    if(isset($_POST['edit_book'])){

        if(!empty($_POST['edit_book'])){
           //print_r($_POST['edit_book']); die();

            $id = $_POST['edit_book']['id'];
            $title = $_POST['edit_book']['title'];
            $author = $_POST['edit_book']['author'];
            $area = $_POST['edit_book']['area'];
            //echo "$id, $title, $author, $area"; die();

            //Instanciação da classe controller
            $obj = instance_controller::getInstance();

            $register = $obj->updateBook($id,$title,$author,$area);

            echo json_encode($register);

        }
        
    }

    //CADASTRAR NOVO ALUNO
    if(isset($_POST['new_student'])){

        if(!empty($_POST['new_student'])){
           //print_r($_POST['new_student']); die();

            $name = $_POST['new_student']['name'];
            $email = $_POST['new_student']['email'];
            $cpf = $_POST['new_student']['cpf'];
            $data = $_POST['new_student']['date'];
            //echo "$name, $email, $cpf, $data"; die();

            //Instanciação da classe controller
            $obj = instance_controller::getInstance();

            $register = $obj->newStudent($name,$email,$cpf,$data);

            echo json_encode($register);

        }
        
    }

    //EDITAR ALUNO
    if(isset($_POST['edit_student'])){

        if(!empty($_POST['edit_student'])){
           //print_r($_POST['edit_student']); die();

            $id = $_POST['edit_student']['matricula'];
            $name = $_POST['edit_student']['name'];
            $email = $_POST['edit_student']['email'];
            $cpf = $_POST['edit_student']['cpf'];
            $data = $_POST['edit_student']['date'];
            //echo "$name, $email, $cpf, $data"; die();

            //Instanciação da classe controller
            $obj = instance_controller::getInstance();

            $register = $obj->editStudent($id,$name,$email,$cpf,$data);

            echo json_encode($register);

        }
        
    }

    //CADASTRAR ÁREA
    if(isset($_POST['new_area'])){

        if(!empty($_POST['new_area'])){
            //echo $_POST['new_area']; die();

            $area_name = $_POST['new_area'];

            //Instanciação da classe controller
            $obj = instance_controller::getInstance();

            $register = $obj->newArea($area_name);

            echo json_encode($register);

        }
        
    }

    //EDITAR ÁREA
    if(isset($_POST['edit_area'])){

        if(!empty($_POST['edit_area'])){

            $area_id = $_POST['edit_area']['area_id'];
            $area_name = $_POST['edit_area']['area_name'];

            //Instanciação da classe controller
            $obj = instance_controller::getInstance();

            $edit_area = $obj->editArea($area_id,$area_name);

            echo json_encode($edit_area);

        }
        
    }

    //EXCLUIR LIVRO
    if(isset($_POST['delete_book'])){

        if(!empty($_POST['delete_book'])){

            $book_id = $_POST['delete_book'];

            //Instanciação da classe controller
            $obj = instance_controller::getInstance();

            $register = $obj->delBook($book_id);

            echo json_encode($register);

        }
        
    }

    //EXCLUIR ALUNO
    if(isset($_POST['delete_student'])){

        if(!empty($_POST['delete_student'])){

            $student_id = $_POST['delete_student'];

            //Instanciação da classe controller
            $obj = instance_controller::getInstance();

            $register = $obj->delStudent($student_id);

            echo json_encode($register);

        }
        
    }

    //EXCLUIR ÁREA
    if(isset($_POST['delete_area'])){

        if(!empty($_POST['delete_area'])){

            $area_id = $_POST['delete_area'];

            //Instanciação da classe controller
            $obj = instance_controller::getInstance();

            $register = $obj->delArea($area_id);

            echo json_encode($register);

        }
        
    }

    //REALIZAR EMPRÉSTIMO
    if(isset($_POST['new_loan'])){

        if(!empty($_POST['new_loan'])){
           //print_r($_POST['new_loan']); die();

            $book = $_POST['new_loan']['book'];
            $student = $_POST['new_loan']['student'];
            $date = $_POST['new_loan']['date'];
            //echo "$name, $email, $cpf, $data"; die();

            //Instanciação da classe controller
            $obj = instance_controller::getInstance();

            $register = $obj->newLoan($book,$student,$date);

            echo json_encode($register);

        }
        
    }

    //REALIZAR DEVOLUÇÃO
    if(isset($_POST['devolution'])){

        if(!empty($_POST['devolution'])){
           //print_r($_POST['new_loan']); die();

            $loan_id = $_POST['devolution']['dev_loan_id'];
            $book_id = $_POST['devolution']['dev_book_id'];

            //Instanciação da classe controller
            $obj = instance_controller::getInstance();

            $devolution = $obj->doDevolution($loan_id, $book_id);

            echo json_encode($devolution);

        }
        
    }

    //PESQUISA NO INPUT DE PESQUISA //RECUPERA O VALOR DA SESSION
    if(isset($_POST['do_search']) && isset($_SESSION['actual_table'])){

        if(!empty($_POST['do_search'])){

            //Recuperação da sessão atual
            $search_table = $_SESSION['actual_table'];

            //Primeira filtragem dos dados, seja o que for
            $dsearch = filter_input(INPUT_POST, "do_search", FILTER_SANITIZE_STRING);
        
            //Segunda filtragem dos dados, seja o que for
            $dsearchf = strip_tags($dsearch);

            //Terceira filtragem dos dados, seja o que for
            $dsearchff = trim($dsearchf);

            //Instanciação da classe controller
            $obj = instance_controller::getInstance();

            //A depender do tipo da sessão, mudarão as circunstâncias da pesquisa
            switch($search_table){

                case "books": //Neste caso a pesquisa será por livros

                    //Especificação da pesquisa 
                    $where = "WHERE titulo LIKE '%:pesquisa%' OR autor LIKE '%:pesquisa%'";
                    $params = array(":pesquisa"=>$dsearchff);

                    //Recebe um array com a tabela e o input de pesquisa, ambos string
                    $str_tb = $obj->showBooks($where,$params);

                    echo json_encode($str_tb);
                
                break;

                case "areas": //Neste caso a pesquisa será por áreas

                    //Especificação da pesquisa 
                    $where = "WHERE nome_area LIKE '%:pesquisa%'";
                    $params = array(":pesquisa"=>$dsearchff);

                    //Recebe um array com a tabela e o input de pesquisa, ambos string
                    $str_tb = $obj->showAreas($where,$params);
                    //echo $str_tb; die();

                    echo json_encode($str_tb);

                break;

                case "students":

                    //Especificação da pesquisa //Por matrícula, nome exato ou aproximado
                    $where = "WHERE matricula LIKE '%:pesquisa%' OR nome LIKE '%:pesquisa%'";
                    $params = array(":pesquisa"=>$dsearchff);

                    //Recebe um array com a tabela e o input de pesquisa, ambos string
                    $str_tb = $obj->showStudents($where,$params);
                    //echo $str_tb; die();

                    echo json_encode($str_tb);

                break;
            }
        }

    }

?>