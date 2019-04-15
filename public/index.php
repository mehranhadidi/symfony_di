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

// Can a user read post? true
dump($accessManager->decide(PostVoter::READ, $post, $user));

// Can an admin read post? true
dump($accessManager->decide(PostVoter::READ, $post, $admin));

// Can a user write post? false
dump($accessManager->decide(PostVoter::WRITE, $post, $user));

// Can an admin write post? true
dump($accessManager->decide(PostVoter::WRITE, $post, $admin));