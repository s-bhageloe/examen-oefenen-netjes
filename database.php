<?php
    class DB{
        private $host;
        private $user;
        private $pass;
        private $db;
        private $charset;
        private $pdo;

        public function __construct($host, $user, $pass, $db, $charset){
            $this->host = $host;
            $this->user = $user;
            $this->pass = $pass;
            $this->db = $db;
            $this->charset = $charset; 
            
        

            try{
                $dsn = 'mysql:host='. $this->host.';dbname='.$this->db.';charset='.$this->charset;
                $this->pdo = new PDO($dsn, $this->user, $this->pass);
                $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                return $this->pdo;
            }
            catch(\PDOException $e){
                echo "Connection Failed: ".$e->getMessage();
            }
        
        }

        //medewerker inloggen functie
        public function loginMedewerker($gebruikersnaam, $wachtwoord){
            $sql="SELECT * FROM medewerkers WHERE gebruikersnaam = :gebruikersnaam";
    
            $stmt = $this->pdo->prepare($sql); 
            $stmt->execute(['gebruikersnaam'=>$gebruikersnaam]); 
    
            $result = $stmt->fetch(PDO::FETCH_ASSOC); 
    
            if($result){
                echo 'account gevonden';
                if ($wachtwoord == $result["wachtwoord"]) {
                    echo 'ww komt overeen';
                    // Start the session
                    SESSION_START();
                    
                    $_SESSION['gebruikersnaam'] = $result;
    
                    print_r($_SESSION['gebruikersnaam']);
    
                    header("location: reserverings_overzicht.php");
                } else {
                    echo "Invalid Password!";
                }
            } else {
                echo "Invalid Login";
            }
    
        }

        //Het overzicht op de website krijgen
        public function showReservering(){
            try {
                // SELECT * FROM "OVERZICHT" JOIN "tabel klant" ON "tabel.placeholder/foreignkey" = "tabel.primarykey"";
                $query = "SELECT * FROM reservering JOIN klant ON reservering.klantID_rs = klant.klantID";
                
                $prep = $this->pdo->prepare($query);
    
                $prep->execute();
    
                $rows = $prep->fetchAll(PDO::FETCH_ASSOC);
                
                return $rows;
            } catch (\Throwable $th) {
                throw $th;
            }
        }

        //laat alle kamers in het overzicht zien
        function getKamers(){

            $sql = "SELECT * FROM kamer";
 
            $statement = $this->pdo->prepare($sql);

            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);

            return $result;

        }
        
        //hier reserveer je
        function reserveren($naam, $adres, $plaats, $postcode, $telefoon, $kamernummer, $start_datum, $eind_datum){
                    $sql = "INSERT INTO klant(klantID, naam, adres, plaats, postcode, telefoon) VALUES (:klantID, :naam, :adres, :plaats, :postcode, :telefoon);";



                    $stmt = $this->pdo->prepare($sql);

                    $stmt->execute([
                        'klantID'=>NULL,
                        'naam'=>$naam,
                        'adres'=>$adres,
                        'plaats'=>$plaats,
                        'postcode'=>$postcode,
                        'telefoon'=>$telefoon
                    ]);

                    $klantID = $this->pdo->lastInsertId();

                    $sql = "INSERT INTO reservering(reserveringID, kamerID_rs, klantID_rs, start_datum, eind_datum) VALUES (:reserveringID, :kamerID_rs, :klantID_rs, :start_datum, :eind_datum)";

                    $stmt = $this->pdo->prepare($sql);

                    $stmt->execute([
                        'reserveringID'=>NULL,
                        'kamerID_rs'=>$kamernummer,
                        'klantID_rs'=>$klantID,
                        'start_datum'=>$start_datum,
                        'eind_datum'=>$eind_datum
                    ]);

                    header("location: reservatie.php");
                }

                public function showKlantReservering(){
                    try {
                        // SELECT * FROM "OVERZICHT" JOIN "tabel klant" ON "tabel.placeholder/foreignkey" = "tabel.primarykey"";
                        $query = "SELECT * FROM reservering JOIN klant ON reservering.klantID_rs = klant.klantID ORDER BY reserveringID DESC LIMIT 1";
                        
                        $prep = $this->pdo->prepare($query);
            
                        $prep->execute();
            
                        $rows = $prep->fetchAll(PDO::FETCH_ASSOC);
                        
                        return $rows;
                    } catch (\Throwable $th) {
                        throw $th;
                    }
                }

                public function showKamer(){
                    try {

                        $query = "SELECT * FROM kamer";
                        
                        $prep = $this->pdo->prepare($query);
            
                        $prep->execute();
            
                        $rows = $prep->fetchAll(PDO::FETCH_ASSOC);
                        
                        return $rows;
                    } catch (\Throwable $th) {
                        throw $th;
                    }
                }

                public function selectSpecificKlant($reserveringklantid){
                    try {
                        $query = "SELECT * FROM reservering WHERE klantID_rs = :klantID_rs";
            
                        $prep = $this->pdo->prepare($query);
            
                        $prep->execute([
                            'klantID_rs' => $reserveringklantid
                        ]);
            
                        $row = $prep->fetch(PDO::FETCH_ASSOC);
                    
                        return $row;
                    } catch (\Throwable $th) {
                        throw $th;
                    }
                }

                
                function updateKlant($klantID_rs, $kamernummer, $start_datum, $eind_datum){
                    $query = "UPDATE reservering SET kamerID_rs = :kamerID_rs, start_datum = :start_datum, eind_datum = :eind_datum WHERE klantID_rs = :klantID_rs;";

                    $prep = $this->pdo->prepare($query);

                    $prep->execute([
                        'klantID_rs' => $klantID_rs,
                        'kamerID_rs' => $kamernummer,
                        'start_datum' => $start_datum,
                        'eind_datum' => $eind_datum
                    ]);

                    header("Location: reserverings_overzicht.php");

                    }

                    public function deleteReservering($reserveer){
                        try {
                            $query = $this->pdo->prepare(
                                "DELETE FROM reservering
                                 WHERE klantID_rs = :klantID_rs;"
                            );
                
                            $query->execute([
                                'klantID_rs' => $reserveer
                            ]);
                
                            header("Location: reserverings_overzicht.php");
                        } catch (\PDOException $e) {
                            throw $e;
                        }
                    }
     }


    
    
?>