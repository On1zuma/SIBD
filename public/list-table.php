<?php

include('navbar.php');

if (empty($_SESSION['id'])) {
    header('Location: /');
}

$tables = ["Horse", "House", "Cars", "Race","other"];

?>

<div class="mx-auto" style="width: 70vw; margin-top: 2rem;">
  <ul class="list-group">
  <?php  foreach ($tables as $table) {
      echo "<li class='list-group-item'><a href='/data-list.php?table=".$table."'>".$table."</a></li>";
  }
?>
  </ul>
</div>

</body>
</html>

