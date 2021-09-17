<?php

if(!isset($_GET["id"]) && !isset($_GET["image"]))
{
    header("location: index.php");
}

if(file_exists("data.json"))
{
    $actors = json_decode(file_get_contents("data.json"), true);
}

$id = $_GET["id"];

if($_REQUEST)
{
    if(isset($_POST["submit"]))
    {
        if($_FILES["file"]["error"] === UPLOAD_ERR_OK)
        {
            $rand = uniqid();
            $file = $_FILES["file"]["tmp_name"];
            $image = $rand . "." . pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION);
            move_uploaded_file($file, "images/" . $image);
            unlink("images/" . $_GET["image"]);
        }
        else
        {
            $image = $_GET["image"];
        }
        $id = $id;
        $name = $_POST["name"];
        $surname = $_POST["surname"];
        $email = $_POST["email"];
        $tel = $_POST["tel"];

        $actors[$id] = [
            "name" => $name,
            "surname" => $surname,
            "email" => $email,
            "tel" => $tel,
            "image" => $image
        ];
        file_put_contents("data.json", json_encode($actors, JSON_PRETTY_PRINT));
        header("location: index.php");
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actors</title>
    <!---->
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body>
    <!---->
    <section>
        <div class="container">
            <br>
            <div class="row">
                <div class="col-12 col-md-6 offset-md-3 col-lg-4 offset-lg-4">
                    <div class="card shadow">
                        <div class="card-body">
                            <form method="POST" enctype="multipart/form-data">
                                <div>
                                    <label class="form-label">Name</label>
                                    <input type="text" class="form-control" name="name" value="<?php echo $actors[$id]["name"]; ?>" required>
                                </div>
                                <br>
                                <div>
                                    <label class="form-label">Surname</label>
                                    <input type="text" class="form-control" name="surname" value="<?php echo $actors[$id]["surname"]; ?>" required>
                                </div>
                                <br>
                                <div>
                                    <label class="form-label">Email</label>
                                    <input type="email" class="form-control" name="email" value="<?php echo $actors[$id]["email"]; ?>" required>
                                </div>
                                <br>
                                <div>
                                    <label class="form-label">Tel</label>
                                    <input type="tel" class="form-control" name="tel" value="<?php echo $actors[$id]["tel"]; ?>">
                                </div>
                                <br>
                                <input type="file" class="form-control" name="file">
                                <br>
                                <div class="text-end">
                                    <button type="submit" class="btn btn-dark" name="submit">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>
</html>