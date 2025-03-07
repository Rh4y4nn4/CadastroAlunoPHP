<?php

// Classe que representa um aluno
class Aluno {
    private $nome;
    private $matricula;
    private $curso;

    // Construtor para iniciar os dados do aluno
    public function __construct($nome, $matricula, $curso) {
        $this->nome = $nome;
        $this->matricula = $matricula;
        $this->curso = $curso;
    }

    // Métodos para pegar os dados do aluno
    public function getNome() {
        return $this->nome;
    }

    public function getMatricula() {
        return $this->matricula;
    }

    public function getCurso() {
        return $this->curso;
    }
}

// Classe que gerencia o cadastro de alunos
class CadastroAlunos {
    private $alunos = []; // Lista de alunos
    private $arquivo = 'alunos.txt'; // Arquivo onde os alunos ficam salvos

    // Construtor que carrega os alunos do arquivo assim que a classe é chamada
    public function __construct() {
        $this->carregarAlunos();
    }

    // Adiciona um novo aluno na lista e salva no arquivo
    public function cadastrarAluno($aluno) {
        $this->alunos[] = $aluno;
        $this->salvarAlunos();
    }

    // Mostra a lista de alunos cadastrados
    public function listarAlunos() {
        if (empty($this->alunos)) {
            echo "<p>Nenhum aluno cadastrado.</p>";
            return;
        }
        
        echo "<ul>";
        foreach ($this->alunos as $aluno) {
            echo "<li>" . $aluno->getNome() . " - Matrícula: " . $aluno->getMatricula() . " - Curso: " . $aluno->getCurso() . "</li>";
        }
        echo "</ul>";
    }

    // Salva os alunos no arquivo para que fiquem registrados
    private function salvarAlunos() {
        $dados = "";
        foreach ($this->alunos as $aluno) {
            $dados .= $aluno->getNome() . "," . $aluno->getMatricula() . "," . $aluno->getCurso() . "\n";
        }
        file_put_contents($this->arquivo, $dados);
    }

    // Lê os alunos do arquivo e carrega na lista
    private function carregarAlunos() {
        if (!file_exists($this->arquivo)) return;
        
        $linhas = file($this->arquivo, FILE_IGNORE_NEW_LINES);
        foreach ($linhas as $linha) {
            list($nome, $matricula, $curso) = explode(',', $linha);
            $this->alunos[] = new Aluno($nome, $matricula, $curso);
        }
    }
}

$cadastro = new CadastroAlunos();

// Se o formulário foi enviado, cadastra o aluno
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['nome'], $_POST['matricula'], $_POST['curso'])) {
    $aluno = new Aluno($_POST['nome'], $_POST['matricula'], $_POST['curso']);
    $cadastro->cadastrarAluno($aluno);
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Cadastro de Alunos</title>
</head>
<body>
    <h2>Cadastro de Alunos</h2>
    <form method="POST">
        Nome: <input type="text" name="nome" required>
        Matrícula: <input type="text" name="matricula" required>
        Curso: <input type="text" name="curso" required>
        <button type="submit">Cadastrar</button>
    </form>
    
    <h2>Lista de Alunos</h2>
    <?php $cadastro->listarAlunos(); ?>
</body>
</html>
