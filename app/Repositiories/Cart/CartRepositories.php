<?php
namespace App\Repositiories\Cart;

use App\Models\Product;

interface CartRepositories
{
    public function get();

    public function add(Product $product,$quantity=1);

    public function update($id,$quantity);

    public function empty();

    public function delete($id);

    public function total();


}