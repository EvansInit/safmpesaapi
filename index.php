<?php

require_once 'functions.php';

echo "<h2>M-PESA API TEST<h2>";

echo "The access token generated is ".generateToken()."<br>";

echo "The expected json response from the registerURL function <br>".registerURL()."<br>";

echo "Json from simulateC2B is <br>".simulateC2B(500,'254708374149')."";

?>