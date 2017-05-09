<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ProductRequest; //added by vijay
use App\Http\Requests\product_arttributeRequest; // added by vijay
use App\Http\Requests\product_attribute_pricesRequest; //added by vijay for price 
use Activity;
use Illuminate\Support\Facades\Auth;
use DB;
use App\product;
use App\product_attribute;
use App\product_attribute_price;
use App\product_attribute_price_history;
use App\category;

class ProductController extends Controller {

    public $menu = 'Product';

    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        //Auth::user()->can('all Operation')

        if (Auth::user()->hasRole(['agent', 'admin', 'woner'])) {
            Activity::log('user at product list page', Auth::id());
            $menu = $this->menu;
            $categories = DB::table('categories')
                    ->where('status', '=', '1')
                    ->select('category_name', 'id')
                    ->get();
            return view('products.allProducts', compact('menu', 'categories'));
        } else
            return redirect()->route('backhome')->with("message", 'You Don\'t have permission');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        //
        if (Auth::user()->hasRole('admin') || Auth::user()->hasRole('owner') || Auth::user()->can('add_product')) {
            $menu = $this->menu;
            Activity::log('Adding product', Auth::id());
            $product_attribute = new product_attribute;
            $uom = $product_attribute::getPossibleEnumValues('uom');
            $categories = category::get(['id', 'category_name']);
            return view('products.addproduct', compact('uom', 'categories', 'menu'));
        } else
            return redirect()->route('backhome')->with("message", 'You Don\'t have permission to add product');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $prodcutrequest, product_arttributeRequest $arttributeRequest, product_attribute_pricesRequest $priceRequest) {
        //dd($prodcutrequest);

        if (Auth::user()->hasRole('admin')) {
            $menu = $this->menu;
            Activity::log('saving product', Auth::id());
            $prod = new product;
            $prod->product_name = $prodcutrequest->input('product_name');
            $prod->category_id = $prodcutrequest->input('category_id');
            $prod->save();

            $product_id = DB::getPdo()->lastInsertId();



            $attributes = $arttributeRequest->input('attribute');
            print_r($attributes);

            for ($i = 0; $i < sizeof($attributes['attribute_name']); $i++) {
                $product_attribute = new product_attribute;
                $product_attribute->attribute_name = $attributes['attribute_name'][$i];
                $product_attribute->uom = $attributes['uom'][$i];
                $product_attribute->product_id = $product_id;
                $product_attribute->save();

                $attribute_id = $product_attribute->id;
                $product_price = new product_attribute_price;
                $product_price->price = $attributes['price'][$i];
                $product_price->sale_price = $attributes['sale_price'][$i];
                $product_price->edited_by = ''; //yet to handle
                $product_price->product_id = $product_id;
                $product_price->attribute_id = $attribute_id;
                $product_price->save();
            }

            return redirect()->route('product.index')->with("message", 'Item has added succesfully');
        }
    }

    /**
     * Display the specified resource.
     * @vijay We are use show functionality for delete purpose for product 
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {

        if (Auth::user()->hasRole('admin') || Auth::user()->hasRole('owner') || Auth::user()->can('delete_product')) {
            Activity::log("deleteing product atrribute " . $id . " ", Auth::id());
            $attribute_ids = product_attribute::where('product_id', '=', $id)->select('id')->get();
            foreach ($attribute_ids as $attribute_id) {
                product_attribute_price::where('attribute_id', '=', $attribute_id->id)->delete();
            }
            product_attribute::where('product_id', '=', $id)->delete();
            product::where('id', '=', $id)->delete();
            return redirect()->route('product.index')->with("message", 'product Deleted succesfully');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        if (Auth::user()->hasRole('admin') || Auth::user()->hasRole('woner') || Auth::user()->can('edit_product')) {
            Activity::log("Editing product" . $id . " ", Auth::id());
            $products = DB::table('products')
                    ->join('product_attributes', 'product_attributes.product_id', ' =', 'products.id')
                    ->join('product_attribute_prices', 'product_attribute_prices.attribute_id', '=', 'product_attributes.id')
                    ->where('products.id', $id)
                    ->select('products.*', 'product_attributes.*', 'product_attribute_prices.*')
                    ->get();
            $product_attribute = new product_attribute;
            $uom = $product_attribute::getPossibleEnumValues('uom');
            $menu = $this->menu;
            $categories = DB::table('categories')->get();
            //dd($products);
            return view('products.editproduct', compact('products', 'uom', 'menu', 'categories'));
        } else
            return redirect()->route('backhome')->with("message", 'You Don\'t have permission to Edit product');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(product_arttributeRequest $arttributeRequest, product_attribute_pricesRequest $priceRequest, $id) {
        $id = $arttributeRequest->input('attribute_id');
        if (Auth::user()->hasRole('admin')) {
            //echo $arttributeRequest->input('uom'); exit;
            Activity::log("updateing product" . $id . " ", Auth::id());



            /* we taking backup of old price of product attribute */

            $attribute = product_attribute::where('id', '=', $id)->select('id', 'product_id')->get();
            $attribute_price = product_attribute_price::where('attribute_id', '=', $id)->select('price', 'sale_price')->get();
            $attribute_id;
            $product_id;
            $price;
            $saleprice;
            foreach ($attribute as $attributevalue) {
                $attribute_id = $attributevalue->id;
                $product_id = $attributevalue->product_id;
            }
            foreach ($attribute_price as $attribute_pricevalue) {
                $price = $attribute_pricevalue->price;
                $saleprice = $attribute_pricevalue->sale_price;
            }
            $product_attribute_price_history = new product_attribute_price_history;
            $product_attribute_price_history->price = $price;
            $product_attribute_price_history->sale_price = $saleprice;
            $product_attribute_price_history->attribute_id = $attribute_id;
            $product_attribute_price_history->edited_by = Auth::id();
            $product_attribute_price_history->save();
            /* end here */


            product_attribute::where('id', '=', $id)->update(['attribute_name' => $arttributeRequest->input('attribute_name'), 'uom' => $arttributeRequest->input('uom')]);

            product_attribute_price::where('attribute_id', '=', $id)->update(['price' => $priceRequest->input('price'), 'sale_price' => $priceRequest->input('sale_price')]);

            //dd( $id);
            //return redirect()->route('product.index')->with('message', 'succesfully Update product attribute');
            return redirect()->route('product.edit', $product_id)->with('message', 'succesfully Update product attribute');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        if (Auth::user()->hasRole('admin') || Auth::user()->hasRole('owner') || Auth::user()->can('delete_product_attribute')) {
            Activity::log("deleteing product atrribute " . $id . " ", Auth::id());
            product_attribute::where('id', '=', $id)->delete();
            product_attribute_price::where('attribute_id', '=', $id)->delete();
            Session::flash('message', 'succesfully Delete attributes of Product !');
        } else
            return redirect()->route('backhome')->with("message", 'You Don\'t have permission to Edit product');
    }

}
