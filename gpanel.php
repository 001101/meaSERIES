<?php

echo '<a href="./index.php"><img class="logo" src="logo.png"></a></br>';
echo '<form action="./search.php" method="post"><input type="text" class="menu" placeholder="rechercher..." name="query" value=""> <input id="submit" type="submit" name="submit" value="Go"></form></br>';

echo '<b>Séries</b><hr>';
echo '<a href="./titles.php">par titre</a></br>';
echo '<a href="./years.php">par année</a></br>';

echo '</br></br>';
echo '<b>meaSERIES</b></br>';
echo 'version 1.1.0</br>';
echo '&copy; Angelscry</br>';
?>
