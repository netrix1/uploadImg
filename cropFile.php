<?php
require_once('config.php');
if (empty($_POST))
    exit(header('Location: ../recorte_de_imagens/'));
else {
    sleep(1);
    $fileType = $_POST['imgType'];
    $imgName  = $_POST['imgName'];
    define('OUTPUT', PASTA_UP_FOTO_REC. '/thumb-' . $imgName);
    if ($fileType == 'image/png')
        $img = imagecreatefrompng(PASTA_UP_FOTO.'/Original-' . $imgName);
    else
        $img = imagecreatefromjpeg(PASTA_UP_FOTO.'/Original-' . $imgName);
    
    $imgWidth  = imagesx($img);
    $imgHeight = imagesy($img);
    
    $newImage = imagecreatetruecolor(160, 160);
    imagecopyresampled($newImage, $img, 0, 0, $_POST['x'], $_POST['y'], 160, 160, $_POST['w'], $_POST['h']);
    if ($fileType == 'image/png')
        $finalImage = imagepng($newImage, OUTPUT);
    else
        $finalImage = imagejpeg($newImage, OUTPUT);
    if ($finalImage)
        echo 'Imagem criada com sucesso<img id="thumbnail" src="' . OUTPUT . '" />';
    else
        echo 'Ocorreu um erro ao tentar criar a nova imagem';
}
?>