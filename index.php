<?php
try {
    $pdo = new PDO("mysql:dbname=projeto_comentarios;host=localhost", "root", "");
} catch (PDOException $ex) {
    echo "Erro: " . $ex->getMessage();
    exit;
}
if(!empty($_POST['nome'])){
    $nome = addslashes($_POST['nome']);
    $msg = addslashes($_POST['mensagem']);
    $sql = $pdo->prepare("INSERT INTO mensagens SET nome = :nome, msg = :msg, data_msg=NOW()");
    $sql->bindValue(":nome", $nome);
    $sql->bindValue(":msg", $msg);
    
    if($sql->execute()){
        header("Location: index.php");
    }
}


?>
<fieldset>
    <form method="POST">
        Nome:<br><input type="text" required name="nome" autofocus><br><br>
        Mensagem:<br><textarea name="mensagem" required></textarea><br><br>
        <input type="submit" value="Enviar Mensagem">
    </form>
</fieldset>
<br><br>
<?php
$sql = "SELECT * FROM mensagens ORDER BY data_msg DESC";
$sql = $pdo->query($sql);
if ($sql->rowCount() > 0) {
    foreach ($sql->fetchAll() as $mensagem){
        ?>
        <strong><?php echo $mensagem['nome']."</strong> às ".date('d/m/Y H:i',strtotime($mensagem['data_msg']));?><br>
        <?php echo $mensagem['msg'];?><br>
        <hr>
    <?php
    }
}else{
    echo "<p>Nenhuma mensagem cadastrada ainda!</p>";
}
?>
