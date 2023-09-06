<?php

include_once('conexao/conexao.php');

$db = new Database();

class Crud{
    private $conn;
    private $table_name = "pets";

    public function __construct($db){
        $this->conn = $db;
    }

    //função para (C)riar meu registros

public function create($postValues){
    $especie = $postValues['especie'];//Este é um método chamado create na classe "Crud" que é responsável por criar um novo registro na tabela "carros" do banco de dados com base nos valores passados no array $postValues
    $comportamento = $postValues['comportamento'];// Estas linhas estão extraindo os valores das chaves do array $postValues e armazenando-os em variáveis locais. Os valores são provavelmente aqueles que foram enviados através de um formulário HTML usando o método POST.
    $locomocao = $postValues['locomocao'];
    $sexo = $postValues['sexo'];
    $ducha = $postValues['ducha'];

    $query = "INSERT INTO ". $this->table_name . " (especie, comportamento, locomocao, sexo, ducha) VALUES (?,?,?,?,?)";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(1,$especie);
    $stmt->bindParam(2,$comportamento);
    $stmt->bindParam(3,$locomocao);
    $stmt->bindParam(4,$sexo);
    $stmt->bindParam(5,$ducha);

    $rows = $this->read();
    if($stmt->execute()){
        print "<script>alert('Cadastro Ok!')</script>";
        print "<script> location.href='?action=read'; </script>";
        return true;
    }else{
        return false;
    }
}

//função para ler os registros

public function read(){
    $query = "SELECT * FROM ". $this->table_name;
    $stmt = $this->conn->prepare($query);
    $stmt->execute();
    return $stmt;
}

//funcao atualizar registros
public function update($postValues){
    $id = $postValues['id'];
    $especie = $postValues['especie'];
    $comportamento = $postValues['comportamento'];
    $locomocao = $postValues['locomocao'];
    $sexo = $postValues['sexo'];
    $ducha = $postValues['ducha'];

    if(empty($id) || empty($especie) || empty($comportamento) || empty($locomocao) || empty($sexo) || empty($ducha)){
        return false;
    }

    $query = "UPDATE ". $this->table_name . " SET especie = ?, comportamento = ?, locomocao = ?, sexo = ?, ducha = ? WHERE id = ?";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(1,$especie);
    $stmt->bindParam(2,$comportamento);
    $stmt->bindParam(3,$locomocao);
    $stmt->bindParam(4,$sexo);
    $stmt->bindParam(5,$ducha);
    $stmt->bindParam(6,$id);
    if($stmt->execute()){
        return true;
    }else{
        return false;
    }

    //funcao para pegar os registros do banco e inserir no formulario
}
    public function readOne($id){
        $query = "SELECT * FROM ". $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    //funcao para apagar os registros 
    public function delete($id){
        $query = "DELETE FROM ". $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1,$id);
        if($stmt->execute()){
                return true;
        }else{
            return false;
        }
    }

}


?>