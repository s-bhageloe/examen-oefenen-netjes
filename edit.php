<?php
include_once 'database.php';

// Connection made
$db = new DB('localhost', 'root', '', 'oefenexamen', 'utf8mb4'); //hier zet je de waardes($..) constructor

$reserveringklantid = $db->selectSpecificKlant($_GET['klantID_rs']);
$kamers = $db->showKamer();

if(isset($_POST["submit"])){
    print_r($_POST);
    //fieldnames - input fields
    $fieldnames = ['kamernummer', 'start_datum', 'eind_datum'];

    //Var boolean
    $err = false;

    
    //Looping
    foreach ($fieldnames as $fieldname) {
        //if fieldname is empty -> $err = true
        if (empty($_POST[$fieldname])) {
            $err = true;
        }
    }



    if (!$err) {
        
        $db->updateKlant($reserveringklantid['klantID_rs'],  $_POST['kamernummer'], $_POST['start_datum'], $_POST['eind_datum']);
        
        header("Location: reserverings_overzicht.php");
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit reservering</title>
</head>
<body>
<form method="post">
        <div class="mb-3" style="width: 15%;">
            <select class="mb-3" name="kamernummer">
                <option selected>Kies een Kamer</option>
                <?php
                foreach($kamers as $kamer) { ?>
                <option value="<?php echo $kamer["kamerID"]?>"><?php echo $kamer["kamerID"]?></option>
                <?php }?>
            </select>
        </div>

        <div class="mb-3" style="width: 15%;">
            <input type="date" name="start_datum" class="form-control-sm" placeholder="Start datum" required>
        </div>

        <div class="mb-3" style="width: 15%;">
            <input type="date" name="eind_datum" class="form-control-sm" placeholder="Eind datum" required>
        </div>

        <button type="submit" name="submit" class="btn btn-primary">Edit</button>
    </form>
</body>
</html>