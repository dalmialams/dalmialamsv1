
@extends('admin.layouts.adminlayout')
@section('content')
<!-- .page-content -->
@include('admin.PattaEntryManagement.nav')
<div class="row">
    <div>{!! Session::get('message')!!}</div>
    <div class="col-lg-12">
        <!-- col-lg-12 start here -->

        <?php if ($muttation_info) { ?>
            <div class="panel panel-primary">
                <!-- Start .panel -->
                <div class="panel-heading">
                    <h4 class="panel-title">Mutated List</h4>
                </div>
                <div class="panel-body">
                    <table id="tabletools" class="table table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th  class="text-center">Survey No.</th>
                                <th  class="text-center">New Patta No.</th>                               
                                <th  class="text-center">New Patta Owner</th>                               
                                <th  class="text-center">Old Patta No.</th>                               
                                <th  class="text-center">Old Patta Owner</th>                               
                            </tr>
                        </thead>

                        <tbody>

                            <?php
                            if ($muttation_info) {
                                //t($muttation_info);die();
                                foreach ($muttation_info as $key => $value) {
                                    ?>

                                    <?php
                                    $allSurveyId = explode(',', $value['survey_id']);
                                    if ($allSurveyId) {

                                        foreach ($allSurveyId as $val) {
                                            ?>
                                            <tr>
                                                <td><?php echo ($val) ? $survey_name = App\Models\LandDetailsManagement\SurveyModel::where(['id' => "$val"])->value('survey_no') : ''; ?></td>
                                                <td class="text-center"><?= $value['new_patta_no']; ?></td>
                                                <td class="text-center"><?= $value['new_patta_owner']; ?></td>
                                                <td class="text-center">
                                                    <?php
                                                    $patta_no = trim($value['patta_id']);
                                                    echo ($patta_no) ? $patta_no = App\Models\LandDetailsManagement\PattaModel::where(['id' => "$patta_no"])->value('patta_no') : '';
                                                    ?>
                                                </td>
                                                <td class="text-center">
                                                    <?php
                                                    $patta_no = trim($value['patta_id']);
                                                    echo ($patta_no) ? $patta_owner = App\Models\LandDetailsManagement\PattaModel::where(['id' => "$patta_no"])->value('patta_owner') : '';
                                                    ?>
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                    }
                                    ?>


                                    <?php
                                }
                            }
                            ?>

                        </tbody>


                    </table>
                </div>
            </div>
        <?php } else { ?>
            <div class="alert alert-warning"> No Result Found!! </div>
        <?php } ?>
        <!-- End .panel -->
    </div>
</div>


@endsection
