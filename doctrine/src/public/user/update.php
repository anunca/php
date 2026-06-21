<?php

include_once __DIR__."/../menu.html";

require_once __DIR__."/../../bootstrap.php";

use App\Entity\User;

$userRepository = $entityManager->getRepository(User::class);

$user = $userRepository->findOneByName('test');

$id = $user->getId();
?>

<ul>
  <li><?php echo $user->getId() ?></li>
  <li><?php print $user->getName() ?></li>
</ul>

<?php

$user->setName('retest');

$entityManager->flush();

$user = $userRepository->find($id);
?>

<ul>
  <li><?php echo $user->getId() ?></li>
  <li><?php print $user->getName() ?></li>
</ul>
