<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "felix1";

// Criar conexão
$conn = new mysqli($servername, $username, $password);

// Checar conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Criar banco de dados "felix1' se não existir
$sqlCreateDB = "CREATE DATABASE IF NOT EXISTS $dbname";
if ($conn->query($sqlCreateDB) === false) {
    die("Erro ao criar banco de dados: " . $conn->error);
}

// Selecionar o banco de dados "felix1'
$conn->select_db($dbname);

// Verificar conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Criação das tabelas
$sqlCreateTables = "
    CREATE TABLE IF NOT EXISTS pessoas (
        id INT NOT NULL AUTO_INCREMENT,
        nome VARCHAR(255) NOT NULL,
        idade INT NOT NULL,
        PRIMARY KEY (id)
    );

    CREATE TABLE IF NOT EXISTS enderecos (
        id INT NOT NULL AUTO_INCREMENT,
        pessoa_id INT NOT NULL,
        rua VARCHAR(255) NOT NULL,
        cidade VARCHAR(255) NOT NULL,
        PRIMARY KEY (id),
        FOREIGN KEY (pessoa_id) REFERENCES pessoas (id)
    );

    CREATE TABLE IF NOT EXISTS telefones (
        id INT NOT NULL AUTO_INCREMENT,
        pessoa_id INT NOT NULL,
        numero VARCHAR(255) NOT NULL,
        PRIMARY KEY (id),
        FOREIGN KEY (pessoa_id) REFERENCES pessoas (id)
    );

    CREATE TABLE IF NOT EXISTS pedidos (
        id INT NOT NULL AUTO_INCREMENT,
        pessoa_id INT NOT NULL,
        valor DECIMAL(10,2) NOT NULL,
        data DATE NOT NULL,
        PRIMARY KEY (id),
        FOREIGN KEY (pessoa_id) REFERENCES pessoas (id)
    );
";

// Executar criação de tabelas
if ($conn->multi_query($sqlCreateTables) === false) {
    die("Erro ao criar tabelas: " . $conn->error);
}

// Fechar conexão para evitar problemas com multi-query
$conn->close();

// Reabrir conexão para inserção de dados
$conn = new mysqli($servername, $username, $password, $dbname);

// Inserção de dados para Gabriel e Aline (em consultas separadas)
$sqlInsertGabriel = "INSERT INTO pessoas (nome, idade) VALUES ('Gabriel', 18)";
if ($conn->query($sqlInsertGabriel) === false) {
    die("Erro ao inserir dados de Gabriel: " . $conn->error);
}

$Gabriel_id = $conn->insert_id;

$sqlInsertEnderecoGabriel = "INSERT INTO enderecos (pessoa_id, rua, cidade) VALUES ('$Gabriel_id', 'Antonio Borges de Araujo', 'Uberaba')";
$sqlInsertTelefoneGabriel = "INSERT INTO telefones (pessoa_id, numero) VALUES ('$Gabriel_id', '537')";
$sqlInsertPedidoGabriel = "INSERT INTO pedidos (pessoa_id, valor, data) VALUES ('$Gabriel_id', 13.50, CURDATE())";

if ($conn->query($sqlInsertEnderecoGabriel) === false || $conn->query($sqlInsertTelefoneGabriel) === false || $conn->query($sqlInsertPedidoGabriel) === false) {
    die("Erro ao inserir dados de Gabriel: " . $conn->error);
}

$sqlInsertAline = "INSERT INTO pessoas (nome, idade) VALUES ('Aline', 16)";
if ($conn->query($sqlInsertAline) === false) {
    die("Erro ao inserir dados de Aline: " . $conn->error);
}

$Aline_id = $conn->insert_id;

$sqlInsertEnderecoAline = "INSERT INTO enderecos (pessoa_id, rua, cidade) VALUES ('$Aline_id', 'Jose Magnino', 'Uberaba')";
$sqlInsertTelefoneAline = "INSERT INTO telefones (pessoa_id, numero) VALUES ('$Aline_id', '343')";
$sqlInsertPedidoAline = "INSERT INTO pedidos (pessoa_id, valor, data) VALUES ('$Aline_id', 15.00, CURDATE())";

if ($conn->query($sqlInsertEnderecoAline) === false || $conn->query($sqlInsertTelefoneAline) === false || $conn->query($sqlInsertPedidoAline) === false) {
    die("Erro ao inserir dados de Aline: " . $conn->error);
}

$conn->close();
?>