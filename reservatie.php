<?php

include_once 'database.php';


// Connection made
$db = new DB('localhost', 'root', '', 'oefenexamen', 'utf8mb4'); //hier zet je de waardes($..) constructor

$klanten = $db->showKlantReservering();


//     // User not loggedin
//     header('Location: overzicht_artikelen.php');
//     print "niet ingelogd";
// }


//Looping through array `users`
// foreach ($users as $user) {
//     echo $user["name"];
// }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

    <!-- JQuery Datatables Plugin  -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.6.4/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">
</head>
<body>
    <main>
    <main class="container mt-4 mb-4">
        <a class="btn btn-warning mr-2 btn-sm" href="logout.php">Log out</a>
        <table class="table">
        <thead>
            <tr>
                <th scope="col">reserveringsnummer</th>
                <th scope="col">kamernummer</th>
                <th scope="col">klantnummer</th>
                <th scope="col">naam</th>
                <th scope="col">adres</th>
                <th scope="col">plaats</th>
                <th scope="col">postcode</th>
                <th scope="col">telefoon</th>
                <th scope="col">Start datum </th>
                <th scope="col">Eind datum</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($klanten as $klant):
 
 
                ?>
            <tr>
                <th scope="row"><?php echo $klant["reserveringID"];?></th>
                <td><?php echo $klant["kamerID_rs"];?></td>
                <td><?php echo $klant["klantID_rs"];?></td>
                <td><?php echo $klant["naam"];?></td>
                <td><?php echo $klant["adres"];?></td>
                <td><?php echo $klant["plaats"];?></td>
                <td><?php echo $klant["postcode"];?></td>
                <td><?php echo $klant["telefoon"];?></td>
                <td><?php echo $klant["start_datum"];?></td>
                <td><?php echo $klant["eind_datum"];?></td>
                <td><a class="btn btn-primary" href="edit.php?klantID_rs=<?php echo $klant["klantID_rs"]; ?>">Edit</button></td>
                <td><a class="btn btn-danger" href="delete.php?klantID_rs=<?php echo $klant["klantID_rs"];  ?>">Delete</button></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    </main>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>

<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>

    <script>
        $('#overzicht').DataTable( {
        dom: 'Bfrtip',
        buttons: [
            'print'
        ]
    } );
    </script>
</body>
</html>