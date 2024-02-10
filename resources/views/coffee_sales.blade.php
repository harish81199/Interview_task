<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
<link href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css" rel="stylesheet">
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('New ☕️ Sales') }}
        </h2>
    </x-slot>
<style>
    .form-control{
        width:80%;
        padding: 0.375rem 0.75rem;
        border-radius: var(--bs-border-radius);
    }
    label{
        font-weight:600;
    }
    .btn-secondary{
        background-color:#6c757d !important;
    }
    .error{
        color: red;
    }
</style>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form id="coffeeSales" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-md-3 col-10">
                                <div class="form-group">
                                    <label for="product">Product</label>
                                    <select name="product" class="form-control input-sm" id="product">
                                        <option value="gold-coffee">Gold Coffee</option>
                                        <option value="arabic-coffee">Arabic Coffee</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2 col-10">
                                <div class="form-group">
                                    <label for="quantity">Quantity</label>
                                    <input type="number" name="quantity" class="form-control input-sm quantity" id="quantity">
                                </div>
                            </div>
                            <div class="col-md-3 col-10">
                                <div class="form-group">
                                    <label for="unit_cost">Unit Cost</label>
                                    <input type="text" name="unit_cost" class="form-control input-sm unit_cost" id="unit_cost">
                                </div>
                            </div>
                            <div class="col-md-2 col-10">
                                <div class="form-group">
                                    <label for="selling_price">Selling Price</label>
                                    <p class="selling_price"></p>
                                    <input type="hidden" name="selling_price" class="form-control input-sm" id="inputSm">
                                </div>
                            </div>
                            <div class="col-md-2 col-10">
                                <div class="form-group">
                                    <button type="button" class="btn btn-secondary mt-3" id="saveRecord"> Record Sale </button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <br>
                    <h3 style="font-size:1.5rem;font-weight:600;">Previous Sales</h3>
                    <table id="example" class="display" style="width:100%">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Quantity</th>
                                <th>Unit Cost</th>
                                <th>Selling Price</th>
                                <th>Sold Out</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"> </script>  
    <script>
            var myTable =  $('#example').dataTable({
                "processing": true,
                "serverSide": true,
                "deferLoading": 0, // here
                "bPaginate": false,
                "searching": false,
                "ajax": {
                    "url": "/coffee-sales",
                    "type": "GET",
                    "dataFilter": function(data){
                        var json = jQuery.parseJSON( data );
                        json.recordsTotal = json.total;
                        json.recordsFiltered = json.total;
                        json.length = json.total;
                        json.data = json.data;
            
                        return JSON.stringify( json ); // return JSON string
                    }
                },
                "columns": [
                    { "data": "product" },
                    { "data": "quantity" },
                    { "data": "unit_cost" },
                    { "data": "selling_price" },
                    { "data": "sold_on" }
                ]
            });
        $('#example').DataTable().draw();
        $('#unit_cost').keyup(function(){
            var quantity = $('input[name="quantity"]').val();
            var unit_cost = $(this).val();
            if(unit_cost && quantity){
                var cost = quantity * unit_cost;
                var margin = 0;
                if($('#product :selected').val() == 'gold-coffee'){
                    margin = 0.25;
                }else{
                    margin = 0.15;
                }
                var sellingPrice = (cost/(1-margin))+10;
                $('input[name="selling_price"]').val(sellingPrice.toFixed(2));
                $('.selling_price').html('£'+sellingPrice.toFixed(2));
            }
        });
        $('#quantity').keyup(function(){
            var unit_cost = $('input[name="unit_cost"]').val();
            var quantity = $(this).val();
            if(unit_cost && quantity){
                var cost = quantity * unit_cost;
                var margin = 0;
                if($('#product :selected').val() == 'gold-coffee'){
                    margin = 0.25;
                }else{
                    margin = 0.15;
                }
                var sellingPrice = (cost/(1-margin))+10;
                $('input[name="selling_price"]').val(sellingPrice.toFixed(2));
                $('.selling_price').html('£'+sellingPrice.toFixed(2));
            }
        });

        $('#product').change(function(){
            var unit_cost = $('input[name="unit_cost"]').val();
            var quantity = $('input[name="quantity"]').val();
            if(unit_cost && quantity){
                var cost = quantity * unit_cost;
                var margin = 0;
                if($('#product :selected').val() == 'gold-coffee'){
                    margin = 0.25;
                }else{
                    margin = 0.15;
                }
                var sellingPrice = (cost/(1-margin))+10;
                $('input[name="selling_price"]').val(sellingPrice.toFixed(2));
                $('.selling_price').html('£'+sellingPrice.toFixed(2));
            }
        });
        $('#saveRecord').click(function(){
            
           var unit_cost = $('input[name="unit_cost"]').val();
           var quantity = $('input[name="quantity"]').val();
           
           if($('#coffeeSales').valid()){
                var form = $('#coffeeSales');
                $.ajax({
                   url: "/coffee-sales",
                   type: "POST",
                   dataType:"JSON",
                   data: form.serialize(),
                   success:function(data){
                        //data = JSON.stringify(data);
                        console.log(data);
                        alert(data.msg);
                        $('#example').DataTable().draw();
                        $('#unit_cost').val('');
                        $('#quantity').val('');
                   },error:function(data){
                        
                    $.each(data.responseJSON.msg, function(key,valueObj){
                        alert(key + "/" + valueObj );
                    });
                   } 
                });
           }
        });
        $("#coffeeSales").validate({
            rules: {
                quantity: {
                    required: true,
                    number: true
                },
                unit_cost: {
                    required: true
                }
            }
        });
    </script>
</x-app-layout>
