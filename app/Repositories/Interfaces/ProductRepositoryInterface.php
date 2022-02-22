<?php

namespace App\Repositories\Interfaces;

use App\Models\Product;
use App\Http\Controllers\ProductController;
use Illuminate\support\Collection;

interface ProductRepositoryInterface
{
    public function getAllProduct(): Collection;

    public function create(array $data): Product;

    public function show($id): Product;

    public function update(array $data, $id): Product;

    public function destroy($id);

    public function search($name): Product;
}
?>