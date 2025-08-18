@extends('admin.layouts.adminlayout')
@section('content')
<!-- .page-content -->
@include('admin.LandEntryManagement.nav')

<div>{!! Session::get('message')!!}</div>

<div class="panel panel-primary  toggle panelMove panelClose panelRefresh">
    <div class="panel-heading">
        <h4 class="panel-title">Audit List</h4>
    </div>
    <div class="panel-body">
        <table class="table table-striped">
            <thead>
                <tr>                                     
                    <th class="text-center">Description</th>
                    <th class="text-center">Date</th>
                    <th class="text-center">Verified</th>
                    <th class="text-center">Remarks</th>
                    <th class="text-center">Audited By</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($masterData as $key => $value) {
                    $masterid = $value['id'];
                    ?>
                    <tr>
                        <td  class="text-center">
                            <?= $value['description'] ?>
                        </td>
                        <td class="text-center">
                            <?php if (isset($audit_data['data'][$masterid]['audit_date'])) { ?>
                                <?= date('d/m/Y', strtotime($audit_data['data'][$masterid]['audit_date'])) ?>
                            <?php } else { ?>

                            <?php } ?>

                        </td>
                        <td class="text-center">
                            <?php if (isset($audit_data['data'][$masterid]['verified'])) { ?>
                                <?= $audit_data['data'][$masterid]['verified'] == 'Y' ? 'Yes' : 'No'; ?>
                            <?php } else { ?>

                            <?php } ?>

                        </td>
                        <td class="text-center"> 
                            <?php if (isset($audit_data['data'][$masterid]['remarks'])) { ?>
                                <?= $audit_data['data'][$masterid]['remarks']; ?>
                            <?php } else { ?>

                            <?php } ?>

                        </td>
                        <td class="text-center"> 
                            <?php if (isset($audit_data['data'][$masterid]['crt_id'])) { ?>
                                <?= $name = App\Models\user\UserModel::where(['id' => $audit_data['data'][$masterid]['crt_id']])->value('user_name'); ?>
                            <?php } else { ?>

                            <?php } ?>

                        </td>

                    </tr>
                <?php } ?>

            </tbody>
        </table>

    </div>
</div>


@endsection
