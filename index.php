<?php include('inc/head.php'); ?>

<?php

if(isset($_POST['contenu'])){
        $fichier = $_POST['fichier'];
        $nouveauFichier = fopen($fichier, "w");
        fwrite($nouveauFichier, $_POST['contenu']);
        fclose($nouveauFichier);
}

if(isset($_GET['delete'])){
    if (is_dir($_GET['delete'])){
        rmdir($_GET['delete']);
    }elseif (is_file($_GET['delete'])){
        unlink($_GET['delete']);
    }
}

$dir  = new RecursiveDirectoryIterator('files/');
$tree = new RecursiveTreeIterator($dir);
foreach ($tree as $item){
    if (substr($item, -2) <> '/.'){
        if (substr($item, -3) <> '/..') {
            echo $item . '<a href="?delete=' . ltrim($item, "| -\\") . '">  Delete  </a>';
            if ((mime_content_type(ltrim($item, "| -\\")) == 'text/html') or (mime_content_type(ltrim($item, "| -\\")) == 'text/plain')){
                echo '<a href="?edit=' . ltrim($item, "| -\\") . '">Edit</a><br/>';
            }else{
                echo '<br/>';
            }
        }
    }
}

if(isset($_GET['edit'])) {
    $fichier = ltrim($_GET['edit'], "| -\\");
    $contenu = file_get_contents($fichier);
?>

<form method="POST" action="index.php">
    <textarea name="contenu" style="width: 100%; height: 200px;"><?php echo $contenu; ?></textarea>
    <input type="hidden" name="fichier" value="<?php echo $_GET['edit'] ?>">
    <input type="submit" value="sauvegarder"/>
</form>

<?php
}
?>

<?php include('inc/foot.php'); ?>