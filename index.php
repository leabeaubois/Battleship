<?php
  // Ouverture de la session
  session_start();

  // Afficher les erreurs
  //signaler tous les types de problèmes
  ini_set('display_errors', 1);
  // afficher les erreurs directement dans la page
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL);


  // Gestion des routes 
  $routes = [
    /**
     * Home
     */
    '' => [
      'file' => 'pages/home.php',
      'title' => 'Accueil'
    ],

    /**
     * Gaming Zone
     */
    'gaming' => [
      'file' => 'pages/gaming.php',
      'title' => 'Gaming',
      'roles' => ['user', 'admin'],
    ],
    'new-game' => [
      'file' => 'pages/new-game.php',
      'title' => 'New Game',
      'roles' => ['user', 'admin'],
    ],
    'history' => [
      'file' => 'pages/history.php',
      'title' => 'History',
      'roles' => ['user', 'admin'],
    ],

    /**
     * Gestion de l'authentification
     */

    'register' => [
      'file' => 'pages/auth/register.php',
      'title' => 'S\'enregistrer',
    ],

    'login' => [
      'file' => 'pages/auth/login.php',
      'title' => 'Se connecter',
    ],

    'logout' => [
      'file' => 'pages/auth/logout.php',
      'title' => 'Se déconnecter',
    ],
  ];

  // Déclaration variable GET -> $page
  $page = $_GET['page'] ?? '';
  $route = $routes[$page] ?? null;

  // Si la route trouvée n'existe pas -> erreur 404
  if ($route === null) {
    $route = [
      'file' => 'pages/errors/not-found.php',
      'title' => "404 not found"
    ];
  }
  
  /**
   * Vérification des autorisations des rôles
   */
  $requiredRoles = $route['roles'] ?? null;
  if ($requiredRoles !== null) {

    if (!isset($_SESSION['user'])) {
      header("Location: index.php?page=login");
      exit;
    }

    if (!in_array($_SESSION['user']['role'], $requiredRoles)) {
      $route = [
        'file' => 'pages/errors/forbidden.php',
        'title' => "403 forbidden"
      ];
    }
  }

  $file = $route["file"];
  $title = $route["title"];


  /**
   * Inclusion
   */
  require_once 'config/database.php';
  require_once 'parts/header.php';
  require_once $file;
  require_once 'parts/footer.php';


?>