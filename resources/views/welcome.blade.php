<!DOCTYPE html>
<html>
<head>
    <title>Sypply Chain - Procurement</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
    <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>  
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
</head>
<style>
    .container{
        margin-left: 0px !important;
        margin-right: 0px !important;
    }
    .row{
        margin-left: 0px !important;
        margin-right: 0px !important;
    }
</style>
<body>
    
<div class="container-fluid">
    <div class="row table-responsive">
        <div class="container">
            <div class="row">
                <h1>All Orders</h1>
                <table class="table table-bordered data-table">
                    <thead>
                        <tr>
                            <th>SL</th>
                            <th>DeliveryDate</th>
                            <th>EstimatedAmount</th>
                            <th>EstimatedCost</th>
                            <th>EstimatedTotalCost</th>
                            <th>ItemId</th>
                            <th>OrderDate</th>
                            <th>OrderedItemCost</th>
                            <th>OrderedQuantity</th>
                            <th>OrderedTotalCost</th>
                            <th>POApprovedBy</th>
                            <th>POApprovedDate</th>
                            <th>PONo</th>
                            <th>PORequestedBy</th>
                            <th>PORequestedDate</th>
                            <th>POStatus</th>
                            <th>PRApprovedBy</th>
                            <th>PRApprovedDate</th>
                            <th>PRNo</th>
                            <th>PRPurpose</th>
                            <th>PRRequestDate</th>
                            <th>PRRequestedBy</th>
                            <th>PRStatus</th>
                            <th>SupplierAddress</th>
                            <th>SupplierId</th>
                            <th width="100px">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        //echo '<pre>';print_r($allData);die;
                            $i=1;
                            foreach ($allData as $value) {
                        ?>
                            <tr>
                                <td>{{ $i++ }}</td>
                                <td>{{ $value['DeliveryDate'] }}</td>
                                <td>{{ $value['EstimatedAmount'] }}</td>
                                <td>{{ $value['EstimatedCost'] }}</td>
                                <td>{{ $value['EstimatedTotalCost'] }}</td>
                                <td>{{ $value['ItemId'] }}</td>
                                <td>{{ $value['OrderDate'] }}</td>
                                <td>{{ $value['OrderedItemCost'] }}</td>
                                <td>{{ $value['OrderedQuantity'] }}</td>
                                <td>{{ $value['OrderedTotalCost'] }}</td>
                                <td>{{ $value['POApprovedBy'] }}</td>
                                <td>{{ $value['POApprovedDate'] }}</td>
                                <td>{{ $value['PONo'] }}</td>
                                <td>{{ $value['PORequestedBy'] }}</td>
                                <td>{{ $value['PORequestedDate'] }}</td>
                                <td>{{ $value['POStatus'] }}</td>
                                <td>{{ $value['PRApprovedBy'] }}</td>
                                <td>{{ $value['PRApprovedDate'] }}</td>
                                <td>{{ $value['PRNo'] }}</td>
                                <td>{{ $value['PRPurpose'] }}</td>
                                <td>{{ $value['PRRequestDate'] }}</td>
                                <td>{{ $value['PRRequestedBy'] }}</td>
                                <td>{{ $value['PRStatus'] }}</td>
                                <td>{{ $value['SupplierAddress'] }}</td>
                                <td>{{ $value['SupplierId'] }}</td>
                                <td></td>
                            </tr>
                        <?php
                                
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
   
</body>
   
<script type="text/javascript">
  $(function () {
    
    var table = $('.data-table').DataTable();
    
  });
</script>
</html>