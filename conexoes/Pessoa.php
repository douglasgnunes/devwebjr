<?php
    include_once('Connection.php');

    class Pessoa{
        private $id;
        private $nome;
        private $idade;
        private $email;
        
        private $connection;

        function __construct(){
            $this->connection = Connection::connection();
        }
        function __get($propriedade){
            return $this->propriedade;
        }
        function __set($propriedade,$valor){
            $this->$propriedade = $valor
        }
        public function salvar(){
            $stmt = $this->connection->prepare("INSERT INTO pessoa(nome,idade,email) VALUES(?,?,?)");
            $stmt->binfParm(1,$this->nome);
            $stmt->binfParm(2,$this->idade);
            $stmt->binfParm(3,$this->email);

            $stmt->execute();
            $this->id = $this->connection->lastInsertId();
        }
        public function retornar($id){
            $rs = $this->connection->query("SELECT * FROM pessoa WHERE id = '$id'");
            $row = $rs->fetch(PDO::FETCH_OBJ);
            if(empty($row)){
                return null;
            }
            $this->id = $row->id;
            $this->nome = $row->nome;
            $this->idade = $row->idade;
            $this->email = $row->email;
        }
        public function listarTodos(){
            $rs = $this->connection->query("SELECT * FROM pessoa");
            $pessoas = null;
            $i = 0;
            while($row = $rs->fetch(PDO::FETCH_OBJ)){
                $pessoa = new Pessoa();
                $pessoa->id = $row->id;
                $pessoa->nome = $row->nome;
                $pessoa->idade = $row->idade;
                $pessoa->email = $row->email;
                $pessoa->connection = null;

                $pessoas[$i] = $pessoa;
                $i++;
            }
            return $pessoas;
        }
        public function atualizar(){
            $stmt = $this->connection->prepare("UPDATE pessoa SET nome = ?, idade = ?, email = ? WHERE id = ?");
            $stmt->bindParam(1,$this->nome);
            $stmt->bindParam(2,$this->idade);
            $stmt->bindParam(3,$this->email);
            $stmt->bindParam(4,$this->id);
            return $stmt->execute();
        }
        public function deletar(){
            $stmt = $this->connection->prepare("DELETE FROM pessoa WHERE id = ?");
            $stmt->bindParam(1,$this->id);
            return $stmt->execute();
        }
    }
?>