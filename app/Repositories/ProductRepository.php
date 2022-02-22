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
        $product = new Product();
        $product->setAttribute('name', $data['name']);
        $product->setAttribute('slug', $data['slug']);
        $product->setAttribute('description', $data['description']);
        $product->setAttribute('price', $data['price']);
        $product->save();

        return $product;
    }

    public function show($id): Product
    {
        return Product::find($id);
    }

    public function update(array $data, $id): Product
    {
        $product = new Product();
        $product->setAttribute('name', $data['name']);
        $product->setAttribute('slug', $data['slug']);
        $product->setAttribute('description', $data['description']);
        $product->setAttribute('price', $data['price']);
        $product->save();

        return $product;
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
