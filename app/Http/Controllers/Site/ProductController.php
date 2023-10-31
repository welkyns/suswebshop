<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Contracts\ProductContract;
use App\Contracts\AttributeContract;

class ProductController extends Controller
{
    protected $productRepository;
    protected $attributeRepository;

    public function __construct(ProductContract $productRepository, AttributeContract $attributeRepository)
    {
        $this->productRepository = $productRepository;
        $this->attributeRepository = $attributeRepository;
    }

    public function show($slug)
    {
        $product = $this->productRepository->findProductBySlug($slug);

        dd($product);
    }

    public function addToCart(Request $request)
    {
        dd($request->all());
    }
}
