<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Models\Product;
use App\Repositories\Interfaces\ProductRepositoryInterface;
use Illuminate\Support\Collection;

class ProductRepository implements ProductRepositoryInterface
{
    public function getAllProduct(): Collection
    {
        return Product::all();
    }

    public function create(array $data): Product
    {
        $prod = new Product();
        $prod->setAttribute('name', $data['name']);
        $prod->setAttribute('slug', $data['slug']);
        $prod->setAttribute('description', $data['description']);
        $prod->setAttribute('price', $data['price']);
        $prod->save();

        return $prod;
    }

    public function show($id): Product
    {
        return Product::find($id);
    }

    public function update(array $data, $id): Product
    {
        $prod = new Product();
        $prod->setAttribute('name', $data['name']);
        $prod->setAttribute('slug', $data['slug']);
        $prod->setAttribute('description', $data['description']);
        $prod->setAttribute('price', $data['price']);
        $prod->save();

        return $prod;
    }

    public function destroy($id): void
    {
        Product::destroy($id);
    }

    public function search($name): Product
    {
        return Product::where('name', 'like', '%'.$name.'%')->get();
    }
}
