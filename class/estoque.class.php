<?php

class Estoque {
    private $pdo;

    public function __construct(PDO $conexao) {
        $this->pdo = $conexao;
    }

    public function atualizarEstoque($json) {
        $produtos = json_decode($json, true);

        if (!$produtos) {
            throw new Exception("Erro ao decodificar JSON");
        }

        $this->pdo->beginTransaction();

        try {
            foreach ($produtos as $item) {
                $produto = $item['produto'];
                $cor = $item['cor'];
                $tamanho = $item['tamanho'];
                $deposito = $item['deposito'];
                $data_disponibilidade = $item['data_disponibilidade'];
                $quantidade = $item['quantidade'];

                if($produto == null or $cor == null or $tamanho == null or $deposito == null or $data_disponibilidade == null or $quantidade == null){
                    echo "Erro ao atualizar o estoque dados incompletos Produto:".$produto.' Cor:'.$cor.' Tamanho:'.$tamanho.' Deposito:'.$deposito.' Data disponibilidade:'.$data_disponibilidade.' Quantidade:'. $quantidade.'<br>';
                } 
               else{
                $stmt = $this->pdo->prepare(
                    "SELECT * FROM estoque 
                    WHERE produto = ? 
                    and cor = ? 
                    and tamanho = ? 
                    and deposito =? 
                    and data_disponibilidade = ? ");
                $stmt->execute([$produto,$cor,$tamanho,$deposito,$data_disponibilidade]);
                $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($resultado){
                    $stmt = $this->pdo->prepare(
                        "UPDATE estoque 
                        SET quantidade = quantidade + ? 
                        WHERE produto = ? 
                        and cor = ? 
                        and tamanho = ? 
                        and deposito =? 
                        and data_disponibilidade = ? ");
                    $stmt->execute([$quantidade,$produto,$cor,$tamanho,$deposito,$data_disponibilidade]);
                } else {
                    $stmt = $this->pdo->prepare(
                        "INSERT INTO estoque 
                        (produto,cor,tamanho,deposito,data_disponibilidade,quantidade) 
                        VALUES (?, ?, ?, ?, ?, ?)");
                    $stmt->execute([$produto,$cor,$tamanho,$deposito,$data_disponibilidade,$quantidade]);
                }
               }
            }

            $this->pdo->commit();
            echo "Estoque atualizado com sucesso!";
        } catch (PDOException $e) {
            $this->pdo->rollBack();
            echo "Erro ao atualizar o estoque: " . $e->getMessage();
        }
    }
    
}

