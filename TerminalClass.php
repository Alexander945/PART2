<?php

class Terminal
{
    public static function productScanner($conn, $codes)
    {
        
        $unique_codes = "";
        for($i = 0; $i < strlen($codes); $i++)
        {
            if(substr_count($unique_codes, $codes[$i]) === 0)
            {
                $unique_codes.=$codes[$i];
            }
        }

        $product_arr = [];
        for($i = 0; $i < strlen($unique_codes); $i++)
        {
            $product_arr[] =[$unique_codes[$i], substr_count($codes, $codes[$i])];
        }
        return $product_arr;
    }

    public static function getCheque($conn, $list)
    {
        $cheque = [];
        foreach($list as $item)
        {
            $temp_product = Product::readProductFromDB($conn, $item[0]);
            $temp_count = $item[1];
            $cheque[] = [$temp_product, $temp_count];
        }
        return $cheque;
    }

    public static function printCheque($cheque)
    {
        foreach($cheque as $item)
        {
            echo "[".$item[01]."]";
            echo "[#".$item[0]->getCode()."] ";
            echo "[".$item[0]->getName()."] ";
            echo "[".$item[0]->getPrice()."] <br>";
        }
    }

    public static function calculateTotalPrice($cheque)
    {
        $total_price = 0;
        foreach($cheque as $item)
        {
        $vcount = $item[0]->getVolumeCount();
        $vprice = $item[0]->getVolumePrice();
        $price = $item[0]->getPrice();
        $count = $item[1];
        if($vcount !== 0 )
        {
            $remnant = $count % $vcount;
            $integer = ($count - $remnant) / $vcount;
            $sum = $integer * $vprice + $remnant * $price;
        }
        else
        {
            $sum = $count * $price;
        }
        $total_price += $sum;
        }
        return $total_price;
    }
}
?>