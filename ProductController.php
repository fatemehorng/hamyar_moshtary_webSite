<?php

namespace App\Http\Controllers\Admin;

use App\Filters\ProductFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Products\StoreProductsRequest;
use App\Repositories\CategoryFeature\CategoryFeatureRepositoryInterface;
use App\Repositories\Feature\FeatureRepositoryInterface;
use App\Repositories\ProductFeature\ProductFeatureRepositoryInterface;
use App\Repositories\ProductImage\ProductImageRepositoryInterface;
use App\Http\Requests\Admin\Products\UpdateProductsRequest;
use App\Repositories\Product\ProductRepositoryInterface;
use App\Repositories\ProductCategory\ProductCategoryRepositoryInterface;
use App\Repositories\Set\SetRepositoryInterface;
use Illuminate\Http\Request;


class ProductController extends Controller
{

    public function __construct(readonly private ProductImageRepositoryInterface $productImageRepository,
                                readonly private ProductRepositoryInterface $productRepository,
                                readonly private ProductCategoryRepositoryInterface $categoryRepository,
                                readonly private FeatureRepositoryInterface $featureRepository,
                                readonly private ProductFeatureRepositoryInterface $productFeatureRepository,
                                readonly private CategoryFeatureRepositoryInterface $categoryFeatureRepository,
                                readonly private SetRepositoryInterface $setRepository){}

public
function index(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
{
    $productFeatures = $this->productFeatureRepository->all();
    $features = $this->featureRepository->all();
    $categories = $this->categoryRepository->all();
    $sets = $this->setRepository->all();
    $products = $this->productRepository->getProductsByFilters();
    return view('admin.products.index', compact('products', 'categories', 'features', 'productFeatures', 'sets'));

}

public
function create(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
{
    $productFeature = null;
    $categories = $this->categoryRepository->all();
    $sets = $this->setRepository->all();
    return view('admin.products.create', compact('categories',  'sets', 'productFeature'))->with('enumSeason');
}

public
function store(StoreProductsRequest $request): \Illuminate\Database\Eloquent\Model
{

    //create thumbnail main product`s image\

    $request->merge([
        'image' => explode('/|\\', $request->image)[0],
        'thumbnail' => getThumb(explode('/|\\', $request->image)[0])
    ]);

    $product = $this->productRepository->create($request->except('images', 'feature_id', 'value', 'size', 'price', 'color', 'count'));

    //store other images in product_images table
    $this->productRepository->createProductImages($product, $request->all());
    //end store images

    //store features in product_features table
    $this->productRepository->addProductFeatures($product, $request->all());
    //end store features

    //store size in product_sizes table
    $this->productRepository->addProductSizes($product, $request->all());
    //end store features

    return $product;
}

public
function edit($id): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
{

    $sets = $this->setRepository->all();
    $productFeatures = $this->productFeatureRepository->getProductFeatureByProductId($id);
    $product = $this->productRepository->find($id);
    $features = $this->categoryFeatureRepository->getByCategoryId($product->category_id);
    $images = $this->productImageRepository->where('product_id', $id)->pluck('thumbnail', 'images')->toArray();
    $categories = $this->categoryRepository->all();
    return view('admin.products.edit', compact('categories', 'images', 'product', 'features', 'productFeatures', 'sets'));

}

public
function update(UpdateProductsRequest $request, $id): \Illuminate\Database\Eloquent\Model|bool
{

    $product = $this->productRepository->find($id);

    if ($request['feature_id'] != null) {
        $this->productRepository->addProductFeatures($product, $request->all());
    }
    $request->merge([
        'image' => explode('/|\\', $request->image)[0],
        'thumbnail' => getThumb(explode('/|\\', $request->image)[0])
    ]);

    $this->productRepository->createProductImages($product, $request->all());

    //store size in product_sizes table
    $this->productRepository->addProductSizes($product, $request->all());
    //end store features

    return $this->productRepository->update($request->except('feature_id', 'value', 'images', 'product_id'), $id);

}


public
function inActivate($id, Request $request): \Illuminate\Database\Eloquent\Model|bool
{
    return $this->productRepository->update($request->only('status'), $id);
}

public
function featuresSelect(Request $request): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
{
    $productFeature = null;
    $features = $this->categoryRepository->getFeaturesByCategoryId($request->category_id);
    return view('admin.products.featureSelected', compact('features', 'productFeature'));
}

}
