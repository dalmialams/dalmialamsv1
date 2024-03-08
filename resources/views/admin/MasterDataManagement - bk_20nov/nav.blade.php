<div class="row">
    <div class=" panel-primary ">
        <!-- Start .panel -->     
        <div class="panel-body">
            {!! Form::open(['url' => url('master/data/submit-data'),'class' => 'form-horizontal reg-form','method' => 'POST','id'=>'my-form', 'enctype' => 'multipart/form-data','role' => 'form']) !!}
            <div class="col-lg-12">
                <div class="row ">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 form-group">
                        <label class="col-lg-2 col-md-3 control-label">Data Management</label>
                        <div class="col-lg-10 col-md-9">
                            <?php
                            $user_type = isset($user_type) ? $user_type : '';
                            $current_user_id = isset($current_user_id) ? $current_user_id : '';
                            if (Session::has('data'))
                                $data = Session::get('data');
                            $masterType = App\Models\Common\CodeModel::where(['cd_type' => "masterdata_type", 'cd_fl_archive' => 'N'])->where('id', '<>', 'CD00156')->orderBy('cd_desc')->lists('cd_desc', 'id')->toArray();

                            $cdList = App\Models\Common\CodeModel::where('cd_type', '<>', 'masterdata_type')->groupBy('cd_type')->orderBy('cd_type', 'asc')->lists('cd_type', 'cd_type')->toArray();

                            $cdList = array_map("array_value_replace", $cdList);

                            function array_value_replace($value) {

                                return ucwords(str_replace('_', ' ', $value));
                            }

                            $masterType = array_merge($masterType, $cdList);
                            asort($masterType);
                            $masterType = array_merge(['' => 'Select'], $masterType);
                            //t($masterType, 1);
                            $filtrered_master_type = [];
                            if ($user_type == 'admin') {
                                $filtrered_master_type = $masterType;
                            } else {
                                if ($masterType) {
                                    foreach ($masterType as $key => $value) {
                                        switch ($key) {
                                            case 'area_unit':
                                                if ((\App\Models\UtilityModel::ifHasPermission('master_data_area_unit_access', $current_user_id))) {
                                                    $filtrered_master_type[$key] = $value;
                                                }
                                                break;
                                            case 'CD00282': //city
                                                if ((\App\Models\UtilityModel::ifHasPermission('master_city_access', $current_user_id))) {
                                                    $filtrered_master_type[$key] = $value;
                                                }
                                                break;
                                            case 'CD00146': //district
                                                if ((\App\Models\UtilityModel::ifHasPermission('master_district_access', $current_user_id))) {
                                                    $filtrered_master_type[$key] = $value;
                                                }
                                                break;

                                            case 'document_type':
                                                if ((\App\Models\UtilityModel::ifHasPermission('master_data_document_type_access', $current_user_id))) {
                                                    $filtrered_master_type[$key] = $value;
                                                }
                                                break;
                                            case 'encroachment_type':
                                                if ((\App\Models\UtilityModel::ifHasPermission('master_data_encroachment_type_access', $current_user_id))) {
                                                    $filtrered_master_type[$key] = $value;
                                                }
                                                break;
                                            case 'land_usage':
                                                if ((\App\Models\UtilityModel::ifHasPermission('master_data_land_usage_access', $current_user_id))) {
                                                    $filtrered_master_type[$key] = $value;
                                                }
                                                break;
                                            case 'land_usage':
                                                if ((\App\Models\UtilityModel::ifHasPermission('master_data_land_usage_access', $current_user_id))) {
                                                    $filtrered_master_type[$key] = $value;
                                                }
                                                break;
                                            case 'legal_entity':
                                                if ((\App\Models\UtilityModel::ifHasPermission('master_data_legal_entity_access', $current_user_id))) {
                                                    $filtrered_master_type[$key] = $value;
                                                }
                                                break;
                                            case 'litigation_type':
                                                if ((\App\Models\UtilityModel::ifHasPermission('master_data_litigation_type_access', $current_user_id))) {
                                                    $filtrered_master_type[$key] = $value;
                                                }
                                                break;
                                            case 'operation':
                                                if ((\App\Models\UtilityModel::ifHasPermission('master_data_operation_access', $current_user_id))) {
                                                    $filtrered_master_type[$key] = $value;
                                                }
                                                break;
                                            case 'payment_mode':
                                                if ((\App\Models\UtilityModel::ifHasPermission('master_data_payment_mode_access', $current_user_id))) {
                                                    $filtrered_master_type[$key] = $value;
                                                }
                                                break;
                                            case 'payment_type':
                                                if ((\App\Models\UtilityModel::ifHasPermission('master_data_payment_type_access', $current_user_id))) {
                                                    $filtrered_master_type[$key] = $value;
                                                }
                                                break;
                                            case 'plot_classification':
                                                if ((\App\Models\UtilityModel::ifHasPermission('master_data_plot_classification_access', $current_user_id))) {
                                                    $filtrered_master_type[$key] = $value;
                                                }
                                                break;
                                            case 'plot_type':
                                                if ((\App\Models\UtilityModel::ifHasPermission('master_data_plot_type_access', $current_user_id))) {
                                                    $filtrered_master_type[$key] = $value;
                                                }
                                                break;
                                            case 'purchase_type':
                                                if ((\App\Models\UtilityModel::ifHasPermission('master_data_purchase_type_access', $current_user_id))) {
                                                    $filtrered_master_type[$key] = $value;
                                                }
                                                break;
                                            case 'purchaser_name':
                                                if ((\App\Models\UtilityModel::ifHasPermission('master_data_purchaser_name_access', $current_user_id))) {
                                                    $filtrered_master_type[$key] = $value;
                                                }
                                                break;
                                            case 'purchasing_team':
                                                if ((\App\Models\UtilityModel::ifHasPermission('master_data_purchasing_team_access', $current_user_id))) {
                                                    $filtrered_master_type[$key] = $value;
                                                }
                                                break;
                                            case 'CD00154': //State
                                                if ((\App\Models\UtilityModel::ifHasPermission('master_state_access', $current_user_id))) {
                                                    $filtrered_master_type[$key] = $value;
                                                }
                                                break;
                                            case 'CD00281': // Sub Classification
                                                if ((\App\Models\UtilityModel::ifHasPermission('master_sub_classification_access', $current_user_id))) {
                                                    $filtrered_master_type[$key] = $value;
                                                }
                                                break;
                                            case 'sub_registrar_office':
                                                if ((\App\Models\UtilityModel::ifHasPermission('master_data_sub_registrar_office_access', $current_user_id))) {
                                                    $filtrered_master_type[$key] = $value;
                                                }
                                                break;
                                            case 'CD00153': //Tehsil
                                                if ((\App\Models\UtilityModel::ifHasPermission('master_tehsil_access', $current_user_id))) {
                                                    $filtrered_master_type[$key] = $value;
                                                }
                                                break;
                                            case 'CD00155': //Village
                                                if ((\App\Models\UtilityModel::ifHasPermission('master_village_access', $current_user_id))) {
                                                    $filtrered_master_type[$key] = $value;
                                                }
                                                break;
                                            default:
                                        }
                                    }

                                    $filtrered_master_type = array_merge(['' => 'Select'], $filtrered_master_type);
                                }
                            }


//                              $masterType= App\Models\Common\CodeModel::where(['cd_fl_archive'=>'N'])->select('cd_type','cd_desc','id')->groupBy('cd_type','cd_desc','id')->orderBy('cd_desc')->lists('cd_desc', 'id')->toArray();
                            ?>
                            {{ Form::select('data[data]',$filtrered_master_type , isset($data) ? $data : '', ['class'=>'form-control select2 select2-minimum required','onChange'=>'form.submit();']) }}
                        </div>
                    </div>
                </div>
            </div>
           
        </div>
    </div>
</div>