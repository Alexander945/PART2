<?php

require_once("ProductClass.php");
require_once("TerminalClass.php");
$conn = mysqli_connect('localhost', 'root','','shop');

//1) Set pricing

$product = new Product("A", "Apple", 2.0, 4, 7.0);
Product::insertProduct($conn, $product);
$product = new Product("B", "Pineapple", 12.0, 0, 0);
Product::insertProduct($conn, $product);
$product = new Product( "C", "Peach", 1.25, 6, 6.0);
Product::insertProduct($conn, $product);
$product = new Product("D", "Nut", 0.15, 0, 0);
Product::insertProduct($conn, $product);

//2) Scan items
$codes1 = "ABCDABAA"; //$32.40
$codes2 = "CCCCCCC";  //$7.25
$codes3 = "ABCD";     //$15.40
$test_input = [$codes1, $codes2, $codes3];

// 3) Total price
foreach($test_input as $item)
{
  $shopping_list = Terminal::productScanner($conn, $item);

  echo  "<br>|||||||||| Cheque ||||||||||<br>";
  $cheque = Terminal::getCheque($conn, $shopping_list);
  Terminal::printCheque($cheque);

  $total_price = Terminal::calculateTotalPrice($cheque);
  echo "Total price: ".number_format($total_price, 2, '.', '')."<br>";
}
?>