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

// Create an empty container builder
$containerBuilder = new ContainerBuilder();

$user = new User();
$user->setUsername('user');

$admin = new User();
$admin->setUsername('admin');
$admin->addRole(User::ROLE_ADMIN);

$post = new Post();

$accessManager = new AccessManager([new PostVoter()]);

dump($accessManager->decide(PostVoter::READ, $post, $user));
dump($accessManager->decide(PostVoter::READ, $post, $admin));

dump($accessManager->decide(PostVoter::WRITE, $post, $user));
dump($accessManager->decide(PostVoter::WRITE, $post, $admin));