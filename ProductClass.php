<?php

class Product
{
    private string $code;
    private string $name;
    private float $price;
    private int $volume_count;
    private int $volume_price;

    public function __construct (string $code, string $name, float $price, int $volume_count, float $volume_price)
    {
        $this->code = $code;
        $this->name = $name;
        $this->price = $price;
        $this->volume_count = $volume_count;
        $this->volume_price = $volume_price;
        //echo "New [#".$this->code."] ".$this->name." - $".$this->price."<br>";
    }

    public function getCode()
    {
        return $this->code;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function getVolumeCount()
    {
        return $this->volume_count;
    }

    public function getVolumePrice()
    {
        return $this->volume_price;
    }

    public static function insertProduct($conn, $product)
    {
        $code = $product->getCode();
        $name = $product->getName();
        $price = $product->getPrice();
        $volume_count = $product->getVolumeCount();
        $volume_price = $product->getVolumePrice();

        $insert = "CALL create_goods('$code', '$name', '$price', '$volume_count', '$volume_price')";
        $run = mysqli_query($conn,$insert);
    }

    public function updateProduct($conn, string $name, float $price, int $volume_count, float $volume_price)
    {
        $code = $this->code;
        $update = "CALL update_goods('$code', '$name', '$price', '$volume_count', '$volume_price')";
        $run = mysqli_query($conn,$update);
    }

    public function deleteProduct($conn)
    {
        $code = $this->code;
        $delete = "CALL delete_goods('$code')";
        $run = mysqli_query($conn,$delete);
    }

    public static function readProductFromDB($conn, string $code)
    {
        $select_goods = "SELECT * FROM goods WHERE code = '$code'";
        $run = mysqli_query($conn,$select_goods);

        if($row = mysqli_fetch_array($run))
        {
        $code = $row["code"];
        $name = $row["name"];
        $price = $row["price"];
        $volume_count = $row["volume_count"];
        $volume_price = $row["volume_price"];

        $product = new Product($code, $name, $price, $volume_count, $volume_price);
        return $product;
        }
        return false;
    }
}
?>