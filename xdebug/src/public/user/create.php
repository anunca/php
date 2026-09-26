<?php

include_once __DIR__."/../menu.html";

require_once __DIR__."/../../bootstrap.php";

use App\Entity\User;

$newUserName = 'test';

$user = new User();
$user->setName($newUserName);

$entityManager->persist($user);
$entityManager->flush();

$id = $user->getId();

echo "Created User with ID " . $id . "\n";
