<?php
// Je vérifie que le formulaire est soumis, comme pour tout traitement de formulaire.
$errors = array();
if($_SERVER['REQUEST_METHOD'] === "POST"){ 
    $uploadDir = 'uploads/';
    $uploadFile = $uploadDir . basename($_FILES['avatar']['name']);
    $extension = pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION);
    $authorizedExtensions = ['jpg','jpeg','png','gif'];
    $maxFileSize = 2000000;
    $username = "Homer";
    $fileName = $username.'-'.date("Y-m-d_H-i-s");
    
    if( (!in_array($extension, $authorizedExtensions))){
        $errors[] = 'Veuillez sélectionner une image de type Jpg ou Jpeg ou Png ou Gif !';
    }

    if( file_exists($_FILES['avatar']['tmp_name']) && filesize($_FILES['avatar']['tmp_name']) > $maxFileSize)
    {
    $errors[] = "Votre fichier doit faire moins de 2M !";
    }

    if(empty($errors)){
        // le nom de fichier sur le serveur est celui du nom d'origine du fichier sur le poste du client (mais d'autres stratégies de nommage sont possibles)
        $uploadFile = $uploadDir . basename($fileName).'.'.$extension;
        // on déplace le fichier temporaire vers le nouvel emplacement sur le serveur. Ça y est, le fichier est uploadé
        move_uploaded_file($_FILES['avatar']['tmp_name'], $uploadFile);
    }     

}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php foreach ($errors as $error) : ?>
        <p><?= $error ?></p>
    <?php endforeach; ?>
    <form method="post" enctype="multipart/form-data">
        <label for="imageUpload">Upload an profile image</label>
        <input type="file" name="avatar" id="imageUpload" accept=".jpg, .jpeg, .png, .gif"/>
        <button name="send">Send</button>
    </form>

</body>

</html>

