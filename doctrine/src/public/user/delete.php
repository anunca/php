<?php

include_once __DIR__."/../menu.html";

require_once __DIR__."/../../bootstrap.php";

use App\Entity\User;

$userRepository = $entityManager->getRepository(User::class);

$user = $userRepository->findOneByName('test');

$id = $user->getId();

$entityManager->remove($user);
$entityManager->flush();

$user = $userRepository->find($id);

if(!$user){
  ?> <span> User removed</span> <?php
} else {
  ?> <span> User not removed</span> <?php
}
