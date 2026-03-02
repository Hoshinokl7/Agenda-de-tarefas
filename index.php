<?php
$arquivo = "tarefas.json";


if (!file_exists($arquivo)) {
    file_put_contents($arquivo, json_encode([]));
}


$tarefas = json_decode(file_get_contents($arquivo), true);


if (isset($_POST["tarefa"]) && $_POST["tarefa"] != "") {
    $nova = [
        "texto" => $_POST["tarefa"],
        "criada_em" => date("d/m/Y H:i"),
        "prazo" => $_POST["prazo"],
        "concluida" => false
    ];

    $tarefas[] = $nova;
    file_put_contents($arquivo, json_encode($tarefas, JSON_PRETTY_PRINT));
}


if (isset($_GET["done"])) {
    $id = $_GET["done"];
    $tarefas[$id]["concluida"] = !$tarefas[$id]["concluida"]; // alternar
    file_put_contents($arquivo, json_encode($tarefas, JSON_PRETTY_PRINT));
    header("Location: index.php");
    exit;
}


if (isset($_GET["apagar"])) {
    $id = $_GET["apagar"];
    unset($tarefas[$id]);
    $tarefas = array_values($tarefas); // reorganiza índices
    file_put_contents($arquivo, json_encode($tarefas, JSON_PRETTY_PRINT));
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Agenda de Tarefas</title>

    <link rel="stylesheet" href="style.css">
</head>
<body>

<button id="tema-btn" class="icon-btn">
    <span id="tema-icone">🌙</span>
</button>

<div class="container">
    <h1>Agenda de Tarefas</h1>

    <form method="POST">
        <input type="text" name="tarefa" placeholder="Digite uma tarefa..." required>

  <div class="campo-prazo">
    <label for="prazo">Prazo da tarefa:</label>
    <input type="date" id="prazo" name="prazo" required>
</div>

        <button type="submit">Adicionar</button>
    </form>

    <h2>Lista de Tarefas</h2>

    <ul>
        <?php foreach ($tarefas as $id => $t): ?>
            <li class="<?= $t['concluida'] ? 'done' : '' ?>">
                <div class="info">
                    <strong><?= htmlspecialchars($t["texto"]) ?></strong>
                    <span>Criada: <?= $t["criada_em"] ?></span>
                    <span>Prazo: <?= date("d/m/Y", strtotime($t["prazo"])) ?></span>
                </div>

                <div class="acoes">
                    <input type="checkbox" onclick="window.location='?done=<?= $id ?>'"
                        <?= $t['concluida'] ? 'checked' : '' ?>>

                    <a class="delete" href="?apagar=<?= $id ?>">X</a>
                </div>
            </li>
        <?php endforeach; ?>
    </ul>
</div>

<script src="script.js"></script>
</body>
</html>