<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BillManagement extends Controller
{
    public function index()
    {
        $products = DB::table('products')->get();
        $customer = DB::table('customers')->get();
        $product_details = DB::select( DB::raw("SELECT i.*, ip.Id AS inventory_product_id, ip.Qty, ip.Discount AS product_discount, ip.Qty AS product_quantity, ip.Rate AS product_rate, p.Name AS product_name, c.Name AS customer_name, p.id AS product_id, c.id AS customer_id  FROM inventories i 
        LEFT JOIN inventory_products ip ON i.ID = ip.InventoryId
        LEFT JOIN products p ON ip.ProductId = p.Id
        LEFT JOIN customers c ON i.CustomerId = c.Id") );

        $data = array(
            'products' => $products,
            'customers' => $customer,
            'product_details' => $product_details
        );
        return view('welcome',compact('data'));
    }

    public function product_details($bill_no)
    {
        $data = DB::select( DB::raw("SELECT i.*, ip.Id AS inventory_product_id, ip.Qty, ip.Discount AS product_discount, ip.Qty AS product_quantity, ip.Rate AS product_rate, p.Name AS product_name, c.Name AS customer_name, p.id AS product_id, c.id AS customer_id  FROM inventories i 
        LEFT JOIN inventory_products ip ON i.ID = ip.InventoryId
        LEFT JOIN products p ON ip.ProductId = p.Id
        LEFT JOIN customers c ON i.CustomerId = c.Id
        WHERE BillNo = '$bill_no'") );
        return response()->json($data);
    }

    public function update_product_details(Request $req)
    {
        $id = $req->s_pd_id;
        $inventory_product_id = $req->s_ipd_id;
        $data_for_inventory = array(
            'TotalBillAmount' => $req->s_total_amount,
            'TotalDiscount' =>$req->s_total_discount_amount,
        );
        $data_for_inventory_product = array(
            'Qty' => $req->s_qty
        );
        DB::table('inventories')
            ->where('id', $id)
            ->update($data_for_inventory); 
       $success =  DB::table('inventory_products')
            ->where('id', $inventory_product_id)
            ->update($data_for_inventory_product); 

        if($success){
            return redirect()->back()->with('success', 'Data udated successfully');
        }
    }

    public function edit_bill_details()
    {

    }
}
