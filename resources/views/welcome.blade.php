<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Bill Management System</title>
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <style>
            table {
              font-family: arial, sans-serif;
              border-collapse: collapse;
              width: 100%;
            }
            th{
                background: #000 !important;
                color: #fff;
            }
            
            td, th {
              border: 1px solid #dddddd;
              text-align: left;
              padding: 8px;
            }
            
            tr:nth-child(even) {
              background-color: #dddddd;
            }
            </style>
    </head>
    <body>
        <div class="container">
            <h5 class="text-success">Input Form</h5>
            @if (\Session::has('success'))
                <div class="alert alert-success">
                    <ul>
                        <li>{!! \Session::get('success') !!}</li>
                    </ul>
                </div>
            @endif
            <hr>
            <div class="searchInput">
                <input type="text" name="bill_no" id="bill_no" class='bill_no' placeholder="Bill No" style='margin-top: 4px;'>
                <button onclick="load_bill_details()" class="btn btn-sm btn-success" style="width:95px !important; margin-left: 20px; color: white">Find</button>
                
            </div>
            <br>
            <div>
                <select name="product_id" id="product_id" style="width: 300px; height: 30px">
                    <option value="">Add Product or Item</option>
                    @foreach ($data['products'] as $product)
                        <option value="{{ $product->Id }}">{{ $product->Name }}</option>
                    @endforeach
                </select>
                <select name="customer_id" id="customer_id" style="width: 250px; height: 30px">
                    <option value="">Select Customer</option>
                    @foreach ($data['customers'] as $customer)
                        <option value="{{ $customer->Id }}">{{ $customer->Name }}</option>
                    @endforeach
                </select>
                <input type="date" id="c_date" name="c_date" value="" style="height: 30px; width: 200px">
                <input type="text" id="cc_date" name="cc_date" value="" style="height: 30px; width: 200px">
            </div>
            <br>
            <form method="post" action="{{url('/update_product_details')}}">
                @csrf
                <div class="details">
                    <table id="mainTable">
                        <tbody>
                        <tr>
                        <th>Product</th>
                        <th>Rate</th>
                        <th>Qty</th>
                        <th>Total Amount</th>
                        <th>Discount(AMT)</th>
                        <th>Net Amount</th>
                        </tr>
                        @php
                            $i = 0;
                        @endphp
                        @foreach ($data['product_details'] as $product_detail)
                        @php
                            $i++;
                        @endphp
                            <tr class="product_details">
                                <td>
                                    <input type="hidden" name="pd_id{{$i}}" id="pd_id{{$i}}" value="{{$product_detail->Id}}">
                                    {{ $product_detail->product_name }}
                                </td>
                                <td>
                                    {{ $product_detail->product_rate }}
                                </td>
                                <td>
                                    <input type="text" name="qty{{$i}}" id="qty{{$i}}" value="{{$product_detail->product_quantity}}">
                                </td>
                                <td>
                                    <input type="text" name="total_amount{{$i}}" id="total_amount{{$i}}" value="{{ $product_detail->TotalBillAmount }}" readonly>
                                    <input type="hidden" name="paid_amount{{$i}}" id="paid_amount{{$i}}" value="{{ $product_detail->PaidAmount }}">
                                    <input type="hidden" name="due_amount{{$i}}" id="due_amount{{$i}}" value="{{ $product_detail->DueAmount }}">
                                    
                                </td>
                                <td>
                                    <input type="text" name="total_discount_amount{{$i}}" id="total_discount_amount{{$i}}" value="{{ $product_detail->TotalDiscount }}">
                                </td>
                                <td>
                                    <input type="text" name="net_amount{{$i}}" id="net_amount{{$i}}" value="{{$product_detail->TotalBillAmount - $product_detail->TotalDiscount }}" readonly>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    </table>
                </div>
                <br>
                <div class="totalCalculation product_details">
                    <div>
                        <label for="net_total">Net Total</label>
                        <input type="text" id="net_total" name="net_total" value="" readonly>
                    </div>
                    <div>
                        <label for="discount_total">Discount Total</label>
                        <input type="text" id="discount_total" name="discount_total" value="" readonly>
                    </div>
                    <div>
                        <label for="paid_amount">Paid Amount</label>
                        <input type="text" id="paid_amount" name="paid_amount" value="" readonly>
                    </div>
                    <div>
                        <label for="due_amount">Due Amount</label>
                        <input type="text" id="due_amount" name="due_amount" value="" readonly>
                    </div>
                </div>
                <br>
                <div >
                    <input class="btn btn-sm btn-success" type="submit" value="Save Change">
                </div>
            </form>
        </div>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js" integrity="sha512-STof4xm1wgkfm7heWqFJVn58Hm3EtS31XFaagaa8VMReCXAkQnJZ+jEy8PCC/iT18dFy95WcExNHFTqLyp72eQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
        <script>

            $(document).ready(function(){
                finalCalculation();
                $('#cc_date').hide();
            });

            function finalCalculation()
            {
                var due_amount = 0;
                var paid_amount = 0;
                var discount_total = 0;
                var net_total = 0;
                for(var i = 1; i <= {{$i}}; i++)
                {
                    var total_amountN = parseInt($('#total_amount'+i).val());
                    net_total = net_total + total_amountN;

                    var total_discount_amountN = parseInt($('#total_discount_amount'+i).val());
                    discount_total = discount_total + total_discount_amountN;

                    var total_discount_amountN = parseInt($('#total_discount_amount'+i).val());
                    discount_total = discount_total + total_discount_amountN;

                   
                    var paid_amountN = parseInt($('#paid_amount'+i).val());
                    paid_amount = paid_amount + paid_amountN;

                    var due_amountN = parseInt($('#due_amount'+i).val());
                    due_amount = due_amount + due_amountN;
                    
                }
                $('#net_total').val(net_total);
                $('#discount_total').val(discount_total);
                $('#paid_amount').val(paid_amount);
                $('#due_amount').val(due_amount);
            }
              

            function load_bill_details()
            {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                    }
                });
     
                var bill_no = $("#bill_no").val();
            
                $.ajax({
                    type:'GET',
                    url: "{{ url('product_details') }}"+'/'+bill_no,
                    success:function(data){
                        $('.product_details').hide();
                        var singleProduct = `
                        
                            <tr class="product_details">
                                
                                <td>
                                    <input type="hidden" name="s_pd_id" id="s_pd_id" value="${data[0].Id}">
                                    <input type="hidden" name="s_ipd_id" id="s_pd_id" value="${data[0].inventory_product_id}">
                                    ${data[0].product_name} 
                                </td>
                                <td>
                                    ${data[0].product_rate}
                                    <input type="hidden" name="s_product_rate" id="s_product_rate" value="${data[0].product_rate}">
                                    <input type="hidden" name="s_product_discount" id="s_product_discount" value="${data[0].product_discount}" readonly>
                                </td>
                                <td>
                                    <input onblur="changedata()" type="text" name="s_qty" id="s_qty" value="${data[0].product_quantity}">
                                </td>
                                <td>
                                    <input type="text" name="s_total_amount" id="s_total_amount" value="${data[0].TotalBillAmount}">
                                    <input type="hidden" name="s_paid_amount" id="s_paid_amount" value="${data[0].PaidAmount}">
                                    <input type="hidden" name="s_due_amount" id="s_due_amount" value="${data[0].DueAmount}">
                                    
                                </td>
                                <td>
                                    <input type="text" name="s_total_discount_amount" id="s_total_discount_amount" value="${data[0].TotalDiscount}" readonly>
                                </td>
                                <td>
                                    <input type="text" name="s_net_amount" id="s_net_amount" value="${parseInt(data[0].TotalBillAmount) - parseInt(data[0].TotalDiscount)}" readonly>
                                </td>
                            </tr>
                        
                        `;
                        $("#product_id").val(data[0].product_id).change();
                        $("#customer_id").val(data[0].customer_id).change();
                        $("#cc_date").val(data[0].Date);
                        $("#c_date").hide();
                        $("#cc_date").show();
                        $('#mainTable > tbody:last-child').append(singleProduct);
                    }
                });
            }

            function changedata()
            {
                var qnt = $('#s_qty').val();
                var pr = $('#s_product_rate').val();
                var pd = $('#s_product_discount').val();
                var newtotalamount = parseInt(pr) * parseInt(qnt);
                var newProductDiscount = (parseInt(pd) * newtotalamount) / 100;
                var newNetAmount = newtotalamount - newProductDiscount;
                
                $('#s_total_amount').val(newtotalamount);
                $('#s_total_discount_amount').val(newProductDiscount);
                $('#s_net_amount').val(newNetAmount);
                
            }
        </script>
       
    </body>
</html>
