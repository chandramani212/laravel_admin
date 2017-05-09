<?php

use Illuminate\Database\Seeder;

use App\Customer;
use App\User;
use App\Address;
use App\Order;
use App\OrderDetail;
use App\Stock;
use App\StockHistory;
use App\StockWastage;
use App\State;
use App\City;
use App\Locality;
use App\product as Product;
use App\product_attribute as ProductAttribute;
use App\product_attribute_price as ProductAttributePrice;


class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(CustomerTableSeeder::class);
        $this->call(AddressTableSeeder::class);
        $this->call(UserTableSeeder::class);
        $this->call(OrderTableSeeder::class);
        $this->call(OrderDetailTableSeeder::class);
        $this->call(StockTableSeeder::class);
        $this->call(StockHistoryTableSeeder::class);
        $this->call(StockWastageTableSeeder::class);
        $this->call(StateTableSeeder::class);
        $this->call(CityTableSeeder::class);
        $this->call(LocalityTableSeeder::class);
        $this->call(ProductTableSeeder::class);
        $this->call(ProductAttributeTableSeeder::class);
        $this->call(ProductAttributePriceTableSeeder::class);
    }
}


class CustomerTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('customers')->delete();
         //$this->call(CustomerTableSeeder::class);
         Customer::create(['first_name' => 'chandramani','last_name' => 'singh','email' => 'chandrmani@gmail.com','contact_no' => '9930387351','introduce_by' => '1','manage_by' => '1','added_by' => '1','updated_by' => '1']);
    }
}


class AddressTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('address')->delete();
         //$this->call(CustomerTableSeeder::class);
        Address::create(['address_line1' => 'room no 1, Ganesh chawl','address_line2' => 'Poisar,Kajupada','street' => 'Goandevi Road','pin_code' => '400101','customer_id' => '1','locality_id' => '1','city_id' => '1','state_id' => '1', 'status' => '1']);

        Address::create(['address_line1' => 'room no 5, Ganesh chawl','address_line2' => 'Poisar,Kajupada','street' => 'Goandevi Road','pin_code' => '400101','customer_id' => '1','locality_id' => '1','city_id' => '1','state_id' => '1' , 'status' => '1']);
    }
}


class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //$this->call(CustomerTableSeeder::class);
         DB::table('users')->delete();
        User::create(['name' => 'Rocky','email' => 'chand@gmail.com','password' => 'Rocky']);
        User::create(['name' => 'Balboa','email' => 'test@gmail.com','password' => 'Rocky']);
    }
}

class OrderTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //$this->call(CustomerTableSeeder::class);
        DB::table('orders')->delete();
        Order::create(['created_by' => '1','confirm_by' => '1','customer_id' => '1','order_total'=>'16.00','address_id' => '1','sub_total' => '16.00','delivery_charge' => '0.00','order_stag' =>'CREATED']);
    }
}


class OrderDetailTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //$this->call(CustomerTableSeeder::class);
        DB::table('order_details')->delete();
        OrderDetail::create(['order_id'=>'1','qty'=> '1','actual_mrp' => '12.00','actual_attribute_name' => '1','actual_uom' => 'Bundle','product_id' => '1','attribute_id' => '1','product_name' => 'Product1','product_total' => '12.00']);
    }
}

class StockTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         DB::table('stocks')->delete();
         //$this->call(CustomerTableSeeder::class);
         Stock::create(['total_qty_in_hand' => '5','updated_by' => '1','added_by' => '1','product_id' => '1','attribute_id' => '1']);
         Stock::create(['total_qty_in_hand' => '5','updated_by' => '1','product_id' => '1','attribute_id' => '2']);
        Stock::create(['total_qty_in_hand' => '5','updated_by' => '1','added_by' => '1','product_id' => '1','attribute_id' => '1']);
         Stock::create(['total_qty_in_hand' => '4','updated_by' => '1','product_id' => '1','attribute_id' => '3']);
    }
}


class StockHistoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         DB::table('stock_history')->delete();
         //$this->call(CustomerTableSeeder::class);
         StockHistory::create(['basic_qty' => '6','basic_mrp' => '12.00','stock_id' => '1','updated_by' => '1']);
    }
}

class StockWastageTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         DB::table('stock_wastage')->delete();
         //$this->call(CustomerTableSeeder::class);
         StockWastage::create(['basic_qty' => '1','basic_mrp' => '12.00','stock_id' => '1','updated_by' => '1','added_by' => '1','reason'=>'This stock is got waste because of expiry']);
    }
}


class StateTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         DB::table('state')->delete();
         //$this->call(CustomerTableSeeder::class);
         State::create(['state_name' => 'Maharashtra','status' => '1']);
    }
}

class CityTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         DB::table('city')->delete();
         //$this->call(CustomerTableSeeder::class);
         City::create(['city_name' => 'Mumbai','state_id'=>'1','status' => '1']);
    }
}


class LocalityTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         DB::table('locality')->delete();
         //$this->call(CustomerTableSeeder::class);
         Locality::create(['locality_name' => 'Andheri','city_id'=>'1','status' => '1']);
    }
}

class ProductTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         DB::table('products')->delete();
         //$this->call(CustomerTableSeeder::class);
         Product::create(['product_name' => 'Product1','category_id'=>'1','order_by' => '1','status' => '1']);
    }
}

class ProductAttributeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         DB::table('product_attributes')->delete();
         //$this->call(CustomerTableSeeder::class);
         ProductAttribute::create(['attribute_name' => '1','uom'=>'Bundle','product_id' => '1','status' => '1']);
        ProductAttribute::create(['attribute_name' => '2','uom'=>'Bundle','product_id' => '1','status' => '1']);
        ProductAttribute::create(['attribute_name' => '3','uom'=>'Bundle','product_id' => '1','status' => '1']);
    }
}

class ProductAttributePriceTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         DB::table('product_attribute_prices')->delete();
         //$this->call(CustomerTableSeeder::class);
         ProductAttributePrice::create(['price' => '12.00','sale_price'=>'16.00','product_id' => '1','status' => '1','attribute_id' => '1']);
         ProductAttributePrice::create(['price' => '13.00','sale_price'=>'15.00','product_id' => '1','status' => '1','attribute_id' => '2']);
         ProductAttributePrice::create(['price' => '16.00','sale_price'=>'20.00','product_id' => '1','status' => '1','attribute_id' => '3']);
    }
}

