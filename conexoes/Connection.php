<?php
class Connection{ #declara classe
    public static $con; #atributo do tipo estático
    #cria objeto PDO padrão singleton garante que o objeto sera criado apenas uma vez
    public static function connection(){
        if(!isset(self::$con)){
            #criação das variaveis
            $srvr = 'localhost';
            $user = 'root';
            $pass = '';
            $db   = 'system';
            try{#o que faz o try
                #pega atributo con cria um novo objeto do tipo pdo
                self::$con = new PDO("mysql:host=$srvr;dbname=$db",$user,$pass); //basta alterar o mysql para pgsql
                self::$con->exec('SET CHARSET utf8');#charset utf8
            }catch(Exception $e){#caso aconteca erro executa o que esta dentro
                echo $e->getMessage();
            }
        }

        return self::$con;
    }
}