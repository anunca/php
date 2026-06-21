<?php

include_once __DIR__."/../menu.html";

require_once __DIR__."/../../bootstrap.php";

use App\Entity\User;

$user = $entityManager->find(User::class, 1);

$user = $entityManager->getRepository(User::class)
->findOneBy(array('id' => 1));

$user = $entityManager->getRepository(User::class)
->findOneById(1);
?>

<ul>
  <li><?php echo $user->getId() ?></li>
  <li><?php print $user->getName() ?></li>
</ul>

<?php

$user = $entityManager->getRepository(User::class)
->findOneBy(array('name' => 'test'));

$user = $entityManager->getRepository(User::class)
->findOneByName('test');
?>

<ul>
  <li><?php echo $user->getId() ?></li>
  <li><?php print $user->getName() ?></li>
</ul>
