<?php
  // ** Zone de connexion
  echo "<div class='data'>...database connexion..."; 

  /** 
   * Paramètres de connexion Data Source Name (dsn)
  */
  $host = "localhost";
  $dbname = "battleship";
  $charset   = "utf8mb4";


  /**
   * Paramètres de connexion à la base de données
   */
  $dsn = "mysql:host=$host;dbname=$dbname;charset=$charset";
  $user = "root";
  $pass = "";
  $options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, 
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ];

  
  /**
   *  Tentative de connexion
  */  
  try{
    $pdo = new PDO($dsn, $user, $pass, $options);
    echo "...connected !</div>";
  }catch(PDOException $e){
    die('...error : ' . $e->getMessage());
  }


?> 