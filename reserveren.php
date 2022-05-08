<?php
include_once 'database.php';

// Connection made
$db = new DB('localhost', 'root', '', 'oefenexamen', 'utf8mb4'); //hier zet je de waardes($..) constructor

$kamers = $db->getKamers();

$reserveren = $db->showKlantReservering();

if(isset($_POST["submit"])){
    print_r($_POST);
    //fieldnames - input fields
    $fieldnames = ['naam', 'adres', 'plaats', 'postcode', 'telefoon', 'kamernummer', 'start_datum', 'eind_datum'];

    //Var boolean
    $err = false;

    
    //Looping
    foreach ($fieldnames as $fieldname) {
        //if fieldname is empty -> $err = true
        if (empty($_POST[$fieldname])) {
            $err = true;
        }
    }



    if ($err) {
        echo "All fields are required!";
    } else {
        
        $db->reserveren($_POST['naam'], $_POST['adres'], $_POST['plaats'], $_POST['postcode'], $_POST['telefoon'], $_POST['kamernummer'], $_POST['start_datum'], $_POST['eind_datum']);
    }
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
    <title>Reserveren</title>
</head>
<body>
<nav class="navbar navbar-expand-sm bg-dark navbar-dark">
  <!-- Brand/logo -->
  <a class="navbar-brand" href="index.php">
    <img src="hotel.jpg" alt="logo" style="width:40px;">
  </a>
  
  <!-- Links -->
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" href="reserveren.php">Reserveer hier!</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="medewerkers/loginMedewerkers.php">Inloggen medewerkers</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="contact.php">Contactpagina</a>
    </li>
  </ul>
</nav>

  <div id="horizontal">
    <div class="bar">
  </div>
  <form method="post">

<div class="mb-3" style="width: 15%;">
    <input type="text" name="naam" class="form-control-sm" placeholder="Naam" required>
</div>

<div class="mb-3" style="width: 15%;">
    <input type="text" name="adres" class="form-control-sm" placeholder="Adres" required>
</div>

<div class="mb-3" style="width: 15%;">
    <input type="text" name="plaats" class="form-control-sm" placeholder="Plaats" required>
</div>

<div class="mb-3" style="width: 15%;">
    <input type="text" name="postcode" class="form-control-sm" placeholder="Postcode"required>
</div>

<div class="mb-3" style="width: 15%;">
    <input type="text" name="telefoon" class="form-control-sm" placeholder="Telefoon nummer" required>
</div>

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

<button type="submit" name="submit" class="btn btn-primary">Reserveren</button>
</form>
</body>
</html>