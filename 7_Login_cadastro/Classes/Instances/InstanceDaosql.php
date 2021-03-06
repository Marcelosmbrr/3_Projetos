<?php

    //Esta classe serve para processar e retornar a instância de uma OUTRA classe
    //Neste caso, uma instância da classe mainController

    namespace Instances;
    use Classes\DAOsql;

    class InstanceDAOsql{

        //Serve para a condicional
        private static $instance;

        private function __construct(){}

        public static function getInstance(){

            if(!isset(self::$instance)){
                
                //É criada uma
                try{

                    //A classe DAOsql é instanciada
                    self::$instance = new DAOsql(); 
                    return self::$instance;
                    
                }
                catch(Exception $e){
                    echo "Erro: " .$e->getMesssage();
                } 

            }else{ 
                 //Se existir, a mesma é retornada
                return self::$instance;
            }
        }
    }

?>