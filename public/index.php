<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require __DIR__ . '/../vendor/autoload.php';

use App\Authorization\AccessManager;
use App\Authorization\Voter\PostVoter;
use App\Entity\Post;
use App\Entity\User;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

// Create an empty container builder
$containerBuilder = new ContainerBuilder();

// Register post voter as a service into container
$containerBuilder->register('post_voter', PostVoter::class)
    // Make this service private, means you cannot get it through the container get
    ->setPublic(false);

// Register access manager as a service into container
$containerBuilder->register('access_manager', AccessManager::class)
    // Explain to container to pass a voter collection to access manager constructor when we need it
    ->addArgument([new Reference('post_voter')])
    // Set this service to be public and accessible via get
    ->setPublic(true);

// Compile and optimize the container
$containerBuilder->compile();

$accessManager = $containerBuilder->get('access_manager');

$user = new User();
$user->setUsername('user');

$admin = new User();
$admin->setUsername('admin');
$admin->addRole(User::ROLE_ADMIN);

$post = new Post();


// Can a user read post? true
dump($accessManager->decide(PostVoter::READ, $post, $user));

// Can an admin read post? true
dump($accessManager->decide(PostVoter::READ, $post, $admin));

// Can a user write post? false
dump($accessManager->decide(PostVoter::WRITE, $post, $user));

// Can an admin write post? true
dump($accessManager->decide(PostVoter::WRITE, $post, $admin));