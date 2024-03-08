
@extends('admin.layouts.adminlayout')
@section('content')
<!-- .page-content -->

<div class="row">
    <div>{!! Session::get('message')!!}</div>
    <div class="col-lg-12">
        <!-- col-lg-12 start here -->
        
        <div class="panel panel-primary">
            <!-- Start .panel -->
            <div class="panel-heading">
                <h4 class="panel-title">User Lists</h4>
            </div>
            <div class="panel-body">
                <table id="tabletools" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>User Name</th>
                            <th></th>
                        </tr>
                    </thead>
                    
                    <tbody>
                        <?php
                        if ($userLists) {
                            foreach ($userLists as $key => $value) {
                                ?>
                                <tr>
                                    <td><?= $value['user_name'] ?></td>
                                    <td><div class="action-buttons">
                                            <a title="Audit Log" href="<?= url('user-management/user/log?user=' . $value['id']) ?>">
                                                <i class="ace-icon fa fa-eye bigger-130"></i>
                                            </a>
                                        </div>
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
       
        <!-- End .panel -->
    </div>
</div>


@endsection
