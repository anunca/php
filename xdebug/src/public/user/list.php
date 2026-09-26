<?php

include_once __DIR__."/../menu.html";

require_once __DIR__."/../../bootstrap.php";

use App\Entity\User;

$users = $entityManager->getRepository(User::class)
->findAll();

// $users = $entityManager->getRepository(User::class)
// ->findByName('test');

// $users = $entityManager->getRepository(User::class)
// ->findById(1);
?>

<div>Found: <em><?php echo count($users) ?></em></div>
<br>

<table>
  <thead>
    <tr>
      <th>Id</th>
      <th>Name</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach($users as $user){ ?>
    <tr>
      <td><?php echo $user->getId() ?></td>
      <td><?php print $user->getName() ?></td>
    </tr>
    <?php } ?>
  </tbody>
</table>
