@extends('admin.layouts.adminlayout')
@section('content')
<!-- .page-content -->
@include('admin.LandEntryManagement.nav')

<div>{!! Session::get('message')!!}</div>
<?php if ($conversion_to_parent_company_details) { ?>
    <div class="panel panel-primary  toggle panelMove panelClose panelRefresh">
        <div class="panel-heading">
            <h4 class="panel-title">Conversion To Parent Company</h4>
        </div>
        <div class="panel-body">
            <table  class="table table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th  class="text-center">Transaction ID</th>                                                                                                                             
                        <th  class="text-center">Transaction Date</th>                             
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($conversion_to_parent_company_details) {
                        foreach ($conversion_to_parent_company_details as $key => $value) {
                            ?>
                            <tr>
                                <td  class="text-center"><a href="javascript:void(0)" onclick="populateTransactionDetails('<?= $value['old_reg_id'] ?>', 'conversion-parent')"><?= $value['transaction_id'] ?></a>
                                    &nbsp; <i class="fa fa-spinner fa-spin" id="<?= $value['old_reg_id'] ?>" style="font-size:24px;visibility: hidden"></i>
                                </td>      

                                <td  class="text-center">
                                    <?php
                                    $transaction_date = new \DateTime($value['created_at']);
                                    echo $transaction_date->format('d/m/Y');
                                    ?>
                                </td>   

                            </tr>
                            <?php
                        }
                    }
                    ?>

                </tbody>
            </table>
        </div>
    </div>
<?php } ?>
<?php if ($disputes) { ?>
    <div class="panel panel-primary  toggle panelMove panelClose panelRefresh">
        <div class="panel-heading">
            <h4 class="panel-title">Disputes</h4>
        </div>
        <div class="panel-body">
            <table  class="table table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th  class="text-center">Transaction ID</th>                                                                                                                             
                        <th  class="text-center">Transaction Date</th>                             
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($disputes) {
                        foreach ($disputes as $key => $value) {
                            ?>
                            <tr>
                                <td  class="text-center"><a href="javascript:void(0)" onclick="populateTransactionDetails('<?= $value['id'] ?>', 'disputes')"><?= $value['id'] ?></a>
                                    &nbsp; <i class="fa fa-spinner fa-spin" id="<?= $value['id'] ?>" style="font-size:24px;visibility: hidden"></i>
                                </td>      

                                <td  class="text-center">
                                    <?php
                                    $transaction_date = new \DateTime($value['created_at']);
                                    echo $transaction_date->format('d/m/Y');
                                    ?>
                                </td>   

                            </tr>
                            <?php
                        }
                    }
                    ?>

                </tbody>
            </table>
        </div>
    </div>
<?php } ?>
<?php if ($ceilings) { ?>
    <div class="panel panel-primary  toggle panelMove panelClose panelRefresh">
        <div class="panel-heading">
            <h4 class="panel-title">Land Ceiling</h4>
        </div>
        <div class="panel-body">
            <table  class="table table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th  class="text-center">Transaction ID</th>
                        <th  class="text-center">Transaction Type</th>                      
                        <th  class="text-center">Transaction Date</th>                       
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($ceilings) {
                        foreach ($ceilings as $key => $value) {
                            ?>
                            <tr>
                                <td  class="text-center"><a href="javascript:void(0)" onclick="populateTransactionDetails('<?= $value['id'] ?>', 'ceiling')"><?= $value['id'] ?></a>
                                    &nbsp; <i class="fa fa-spinner fa-spin" id="<?= $value['id'] ?>" style="font-size:24px;visibility: hidden"></i>
                                </td>
                                <td  class="text-center"><?= ($value['trxn_type'] == 'Y') ? '37-A Applied' : '37-A Obtained' ?></td>
                                <td  class="text-center">
                                    <?php
                                    $transaction_date = new \DateTime($value['created_at']);
                                    echo $transaction_date->format('d/m/Y');
                                    ?>
                                </td>                               
                            </tr>
                            <?php
                        }
                    }
                    ?>

                </tbody>
            </table>



        </div>
    </div>
<?php } ?>

<?php if ($conversions) { ?>
    <div class="panel panel-primary  toggle panelMove panelClose panelRefresh">
        <div class="panel-heading">
            <h4 class="panel-title">Land Conversion</h4>
        </div>
        <div class="panel-body">
            <table  class="table table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th  class="text-center">Transaction ID</th>
                        <th  class="text-center">Transaction Type</th>
                        <th  class="text-center">Transaction Date</th>                       
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($conversions) {
                        foreach ($conversions as $key => $value) {
                            ?>
                            <tr>
                                <td  class="text-center"><a href="javascript:void(0)" onclick="populateTransactionDetails('<?= $value['id'] ?>', 'conversion')"><?= $value['id'] ?></a>
                                    &nbsp; <i class="fa fa-spinner fa-spin" id="<?= $value['id'] ?>" style="font-size:24px;visibility: hidden"></i>
                                </td>       
                                <td  class="text-center"><?= ($value['trxn_type'] == 'Y') ? 'Applied' : 'Obtained' ?></td>
                                <td  class="text-center">
                                    <?php
                                    $transaction_date = new \DateTime($value['created_at']);
                                    echo $transaction_date->format('d/m/Y');
                                    ?>
                                </td>                               
                            </tr>
                            <?php
                        }
                    }
                    ?>

                </tbody>
            </table>



        </div>
    </div>
<?php } ?>
<?php if ($exchanges) { ?>
    <div class="panel panel-primary  toggle panelMove panelClose panelRefresh">
        <div class="panel-heading">
            <h4 class="panel-title">Land Exchange</h4>
        </div>
        <div class="panel-body">
            <table  class="table table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th  class="text-center">Transaction ID</th>
                        <th  class="text-center">Transaction Date</th>                       
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($exchanges) {
                        foreach ($exchanges as $key => $value) {
                            ?>
                            <tr>
                                <td  class="text-center"><a href="javascript:void(0)" onclick="populateTransactionDetails('<?= $value['id'] ?>', 'exchange')"><?= $value['id'] ?></a>
                                    &nbsp; <i class="fa fa-spinner fa-spin" id="<?= $value['id'] ?>" style="font-size:24px;visibility: hidden"></i>
                                </td>      

                                <td  class="text-center">
                                    <?php
                                    $transaction_date = new \DateTime($value['created_at']);
                                    echo $transaction_date->format('d/m/Y');
                                    ?>
                                </td>                               
                            </tr>
                            <?php
                        }
                    }
                    ?>

                </tbody>
            </table>



        </div>
    </div>
<?php } ?>
<?php if ($inspection_details) { ?>
    <div class="panel panel-primary  toggle panelMove panelClose panelRefresh">
        <div class="panel-heading">
            <h4 class="panel-title">Land Inspection</h4>
        </div>
        <div class="panel-body">
            <table  class="table table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th  class="text-center">Transaction ID</th>                                                                                                                             
                        <th  class="text-center">Transaction Date</th>      
                        <th  class="text-center">Uploaded Docs</th>      

                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($inspection_details) {
                        foreach ($inspection_details as $key => $value) {
                            ?>
                            <tr>
                                <td  class="text-center"><a href="javascript:void(0)" onclick="populateTransactionDetails('<?= $value['id'] ?>', 'inspection')"><?= $value['id'] ?></a>
                                    &nbsp; <i class="fa fa-spinner fa-spin" id="<?= $value['id'] ?>" style="font-size:24px;visibility: hidden"></i>
                                </td>      

                                <td  class="text-center">
                                    <?php
                                    $transaction_date = new \DateTime($value['created_at']);
                                    echo $transaction_date->format('d/m/Y');
                                    ?>
                                </td>   
                                <td class="text-center"> <a href="javascript:void(0);" onclick="populateMultipleDocs('<?= $value['id'] ?>')">View Docs</a>
                                    &nbsp; <i class="fa fa-spinner fa-spin" id="<?= $value['id'] ?>_docs" style="font-size:24px;visibility: hidden"></i>
                                </td>
                            </tr>
                            <?php
                        }
                    }
                    ?>

                </tbody>
            </table>



        </div>
    </div>
<?php } ?>
<?php if ($reservations) { ?>
    <div class="panel panel-primary  toggle panelMove panelClose panelRefresh">
        <div class="panel-heading">
            <h4 class="panel-title">Land Reservations</h4>
        </div>
        <div class="panel-body">
            <table  class="table table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th  class="text-center">Transaction ID</th>
                        <th  class="text-center">Transaction Type</th>                      
                        <th  class="text-center">Transaction Date</th>                       
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($reservations) {
                        foreach ($reservations as $key => $value) {
                            ?>
                            <tr>
                                <td  class="text-center"><a href="javascript:void(0)" onclick="populateTransactionDetails('<?= $value['id'] ?>', 'reservation')"><?= $value['id'] ?></a>
                                    &nbsp; <i class="fa fa-spinner fa-spin" id="<?= $value['id'] ?>" style="font-size:24px;visibility: hidden"></i>
                                </td>
                                <td  class="text-center"><?= ($value['trxn_type'] == 'Y') ? 'Reserved' : 'Dereserved' ?></td>
                                <td  class="text-center">
                                    <?php
                                    $transaction_date = new \DateTime($value['created_at']);
                                    echo $transaction_date->format('d/m/Y');
                                    ?>
                                </td>                               
                            </tr>
                            <?php
                        }
                    }
                    ?>

                </tbody>
            </table>



        </div>
    </div>
<?php } ?>
<?php if ($minings) { ?>
    <div class="panel panel-primary  toggle panelMove panelClose panelRefresh">
        <div class="panel-heading">
            <h4 class="panel-title">Mining Lease</h4>
        </div>
        <div class="panel-body">
            <table  class="table table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th  class="text-center">Transaction ID</th>
                        <th  class="text-center">Transaction Type</th>                      
                        <th  class="text-center">Transaction Date</th>                       
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($minings) {
                        foreach ($minings as $key => $value) {
                            ?>
                            <tr>
                                <td  class="text-center"><a href="javascript:void(0)" onclick="populateTransactionDetails('<?= $value['id'] ?>', 'mining')"><?= $value['id'] ?></a>
                                    &nbsp; <i class="fa fa-spinner fa-spin" id="<?= $value['id'] ?>" style="font-size:24px;visibility: hidden"></i>
                                </td>
                                <td  class="text-center"><?= ($value['trxn_type'] == 'Y') ? 'Applied' : 'Obtained' ?></td>
                                <td  class="text-center">
                                    <?php
                                    $transaction_date = new \DateTime($value['created_at']);
                                    echo $transaction_date->format('d/m/Y');
                                    ?>
                                </td>                               
                            </tr>
                            <?php
                        }
                    }
                    ?>

                </tbody>
            </table>



        </div>
    </div>
<?php } ?>
<?php if ($mutations) { ?>
    <div class="panel panel-primary  toggle panelMove panelClose panelRefresh">
        <div class="panel-heading">
            <h4 class="panel-title">Mutation</h4>
        </div>
        <div class="panel-body">
            <table  class="table table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th  class="text-center">Transaction ID</th>                                                                                                                             
                        <th  class="text-center">Transaction Date</th>                             
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($mutations) {
                        foreach ($mutations as $key => $value) {
                            ?>
                            <tr>
                                <td  class="text-center"><a href="javascript:void(0)" onclick="populateTransactionDetails('<?= $value['id'] ?>', 'mutation')"><?= $value['id'] ?></a>
                                    &nbsp; <i class="fa fa-spinner fa-spin" id="<?= $value['id'] ?>" style="font-size:24px;visibility: hidden"></i>
                                </td>      

                                <td  class="text-center">
                                    <?php
                                    $transaction_date = new \DateTime($value['created_at']);
                                    echo $transaction_date->format('d/m/Y');
                                    ?>
                                </td>   

                            </tr>
                            <?php
                        }
                    }
                    ?>

                </tbody>
            </table>
        </div>
    </div>
<?php } ?>
<?php if ($operation_details) { ?>
    <div class="panel panel-primary  toggle panelMove panelClose panelRefresh">
        <div class="panel-heading">
            <h4 class="panel-title">Under Operation</h4>
        </div>
        <div class="panel-body">
            <table  class="table table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th  class="text-center">Transaction ID</th>                                                                                                                             
                        <th  class="text-center">Transaction Date</th>                             
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($operation_details) {
                        foreach ($operation_details as $key => $value) {
                            ?>
                            <tr>
                                <td  class="text-center"><a href="javascript:void(0)" onclick="populateTransactionDetails('<?= $value['id'] ?>', 'operation')"><?= $value['id'] ?></a>
                                    &nbsp; <i class="fa fa-spinner fa-spin" id="<?= $value['id'] ?>" style="font-size:24px;visibility: hidden"></i>
                                </td>      

                                <td  class="text-center">
                                    <?php
                                    $transaction_date = new \DateTime($value['created_at']);
                                    echo $transaction_date->format('d/m/Y');
                                    ?>
                                </td>   

                            </tr>
                            <?php
                        }
                    }
                    ?>

                </tbody>
            </table>
        </div>
    </div>
<?php } ?>
<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" id="displaySurveyDetailsModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
                </button>
                <h4 class="modal-title" id="mySmallModalLabel"></h4>
            </div>
            <div class="modal-body" id="displaySurveyDetails">

            </div>
            <div class="modal-footer" style="margin-top:65px;">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" id="multiple_docs_modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
                </button>
                <!--                        <h4 class="modal-title" id="mySmallModalLabel"></h4>-->
            </div>
            <div class="modal-body" id="multiple_docs">

            </div>
            <div class="modal-footer" style="margin-top:65px;">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!--<div class="panel panel-primary  toggle panelMove panelClose panelRefresh modal_box" style="visibility: hidden">
    <div class="panel-body">
        <div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" id="displaySurveyDetailsModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">
                            <span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
                        </button>
                        <h4 class="modal-title" id="mySmallModalLabel"></h4>
                    </div>
                    <div class="modal-body" id="displaySurveyDetails">

                    </div>
                    <div class="modal-footer" style="margin-top:65px;">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>-->
<!--<div class="panel panel-primary  toggle panelMove panelClose panelRefresh modal_box_multiple_docs"  style="visibility: hidden">
    <div class="panel-body">
        <div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" id="multiple_docs_modal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">
                            <span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
                        </button>
                                                <h4 class="modal-title" id="mySmallModalLabel"></h4>
                    </div>
                    <div class="modal-body" id="multiple_docs">

                    </div>
                    <div class="modal-footer" style="margin-top:65px;">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>-->
@endsection

