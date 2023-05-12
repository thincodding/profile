
<?php

    require 'connection.php';

    $_SESSION['id'] = 1;
    $sessionId = $_SESSION['id'];
    $user = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM tbl_test WHERE id = $sessionId"));

    if(isset($_FILES['image']['name'])){

        $id = $_POST['id'];
        $name = $_POST['name'];

        $imageName = $_FILES['image']['name'];
        $imaegSize = $_FILES['image']['size'];
        $tmpName = $_FILES['image']['tmp_name'];

        $validImageExtension = ['jpg', 'jpeg', 'png'];
        $imageExtension = explode('.', $imageName);
        $imageExtension = strtolower(end($imageExtension));

        if(!in_array($imageExtension, $validImageExtension)){

            echo"
            
            <script>
            
            alert('Invalid image extension')
            document.location.href='../TestProfile';
            </script>
            
            ";
        }elseif($imaegSize > 1200000){

            echo "
            
            <script>
            
            alert('Image size is too large');
            document.location.href='../TestProfile';
            
            </script>

            ";
        }else{

            $newImageName = $name . " - " . date("Y.m.d") . " - " . date('h.i.sa');
            $newImageName .= '.' . $imageExtension;

            $quary = "UPDATE tbl_test SET image = '$newImageName' WHERE id = $id";
            mysqli_query($conn, $quary);
            move_uploaded_file($tmpName, 'img/' . $newImageName); 

            echo "
            
            <script>
            
            document.location.href = '../TestProfile';
            
            </script>
            ";

        }
    }

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="styleSheet" href="style.css"/>
    <title>Profile</title>
</head>
<body>
    <form action="" id="form" enctype="multipart/form-data" method="post">

        <div class="upload">

        <?php
        $id = $user['id'];
        $name = $user['name'];
        $image = $user['image'];
        ?>
        <img src="img/<?php echo $image;?>" width="100px" height="100px" title="<?php echo $image;?>">

            <div class="import_round">
                <input type="hidden" name="id" value="<?php echo $id;?>">
                <input type="hidden" name="name" value="<?php echo $name;?>">
                <input type="file" name="image" accept=".jpg, .jpeg, .png" id="image" value="<?php echo $image;?>">
            </div>
        </div>

    </form>
</body>
<script>
    document.getElementById('image').onchange = function(){
        document.getElementById('form').submit();
    }
</script>
</html>