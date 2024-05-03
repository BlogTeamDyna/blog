<?php

require_once __DIR__.'/vendor/autoload.php';



use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Article;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\Config\FileLocator;


$dbParams = array(
    'driver'   => 'pdo_mysql',
    'host'     => 'localhost',
    'dbname'   => 'votre_base_de_donnees',
    'user'     => 'votre_utilisateur',
    'password' => 'votre_mot_de_passe',
);

$containerBuilder = new ContainerBuilder();

// Charger les services nécessaires depuis le conteneur Symfony
$loader = new YamlFileLoader($containerBuilder, new FileLocator(__DIR__));

try {
    $loader->load('services.yaml');
} catch (Exception $e) {
} // Chargez votre fichier de configuration des services Symfony si nécessaire

// Récupérer l'EntityManager depuis le conteneur de services
$entityManager = $containerBuilder->get(EntityManagerInterface::class);

// Récupérer le terme de recherche depuis la requête GET
$searchTerm = $_GET['search'] ?? '';

$articleRepository = $entityManager->getRepository(Article::class);

$articles = $articleRepository->createQueryBuilder('a')
    ->where('a.title LIKE :searchTerm OR a.description LIKE :searchTerm')
    ->setParameter('searchTerm', '%'. $searchTerm . '%')
    ->getQuery()
    ->getResult();

$response = [
    'reponse' => $articles
];

header("Access-Control-Allow-Origin: *");

// Autoriser les méthodes de requête spécifiques (GET dans ce cas)
header("Access-Control-Allow-Methods: GET");

// Autoriser certains en-têtes HTTP
header("Access-Control-Allow-Headers: Content-Type");

// Indiquer que la réponse est au format JSON
header("Content-Type: application/json");

// Renvoyer les résultats au format JSON
echo json_encode($response);