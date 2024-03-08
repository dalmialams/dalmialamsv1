<?php

/*
  |--------------------------------------------------------------------------
  | Application Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register all of the routes for an application.
  | It's a breeze. Simply tell Laravel the URIs it should respond to
  | and give it the controller to call when that URI is requested.
  |
 */
//use Auth;
//Route::get('/', function () {
//    return view('welcome');
//});
################### This is for admindashboard ######################
Route::any('landing', 'Dashboard\AdminController@landingPage')->middleware(['auth']);
Route::any('dashboard', 'Dashboard\AdminController@index')->middleware(['auth', 'dashboard_access', 'auth_dashboard_state_dist_block_vil']);
Route::get('dashboard/details', ['as' => 'details', 'uses' => 'Dashboard\AdminController@dashboardView'])->middleware(['auth', 'dashboard_access', 'auth_dashboard_state_dist_block_vil']);
Route::get('dashboard/classification', ['as' => '', 'uses' => 'Dashboard\AdminController@classification'])->middleware(['auth', 'dashboard_access', 'auth_dashboard_state_dist_block_vil']);
Route::get('dashboard/purpose', ['as' => '', 'uses' => 'Dashboard\AdminController@purpose'])->middleware(['auth','dashboard_access', 'auth_dashboard_state_dist_block_vil']);
Route::get('dashboard/purchaseType', ['as' => '', 'uses' => 'Dashboard\AdminController@purchaseType'])->middleware(['auth','dashboard_access', 'auth_dashboard_state_dist_block_vil']);
Route::get('dashboard/totaldetails', ['as' => 'totaldetails', 'uses' => 'Dashboard\AdminController@dashboardTotal'])->middleware(['auth', 'dashboard_access','auth_dashboard_state_dist_block_vil']);
Route::get('dashboard/district', ['as' => 'district', 'uses' => 'Dashboard\AdminController@dashboardDistrict'])->middleware(['auth', 'dashboard_access','auth_dashboard_state_dist_block_vil']);
Route::get('dashboard/block', ['as' => 'block', 'uses' => 'Dashboard\AdminController@dashboardBlock'])->middleware(['auth','dashboard_access', 'auth_dashboard_state_dist_block_vil']);
Route::get('dashboard/village', ['as' => 'village', 'uses' => 'Dashboard\AdminController@dashboardVillage'])->middleware(['auth', 'dashboard_access','auth_dashboard_state_dist_block_vil']);
Route::get('dashboard/legalentity', ['as' => 'legalentity', 'uses' => 'Dashboard\AdminController@dashboardLegalEntity'])->middleware(['auth','dashboard_access', 'auth_dashboard_state_dist_block_vil']);
Route::get('dashboard/get_state_json', ['as' => 'get_state_json', 'uses' => 'Dashboard\AdminController@get_state_json'])->middleware(['auth','dashboard_access', 'auth_dashboard_state_dist_block_vil']);
Route::get('dashboard/get_plant_json', ['as' => 'get_plant_json', 'uses' => 'Dashboard\AdminController@get_plant_json'])->middleware(['auth','dashboard_access', 'auth_dashboard_state_dist_block_vil']);
Route::get('dashboard/get_state_info/{id?}', ['as' => 'get_plant_json', 'uses' => 'Dashboard\AdminController@get_state_info'])->middleware(['auth','dashboard_access', 'auth_dashboard_state_dist_block_vil']);


Route::group(['prefix' => 'dashboard', 'middleware' => ['auth','dashboard_access', 'auth_dashboard_state_dist_block_vil'], 'namespace' => 'Dashboard\ContextualMenu'], function() {
    Route::get('mutation', ['as' => '', 'uses' => 'MutationController@mutationDetails']);
    Route::get('disputes', ['as' => '', 'uses' => 'DisputesController@disputes']);
    Route::get('mining', ['as' => '', 'uses' => 'MiningLeaseController@index']);
    Route::get('ceiling', ['as' => '', 'uses' => 'LandCeilingController@index']);
    Route::get('reservation', ['as' => '', 'uses' => 'LandReservationController@index']);
    Route::get('exchange', ['as' => '', 'uses' => 'LandExchangeController@index']);
    Route::get('holding', ['as' => '', 'uses' => 'LandHoldingController@index']);
    Route::get('inspection', ['as' => '', 'uses' => 'LandInspectionController@index']);
    Route::get('parent_company', ['as' => '', 'uses' => 'ConversionToParentCompController@index']);
});

Route::group(['prefix' => 'map', 'namespace' => 'Map'], function() {
    Route::get('view', ['as' => '', 'uses' => 'MapController@map']);
	Route::get('getDistrict', ['as' => '', 'uses' => 'MapController@getDistrict']);
	Route::get('getBlock', ['as' => '', 'uses' => 'MapController@getBlock']);
	Route::get('getVillage', ['as' => '', 'uses' => 'MapController@getVillage']);
	Route::get('getPlotInfo', ['as' => '', 'uses' => 'MapController@getPlotInfo']);
	Route::get('getStatePoint', ['as' => '', 'uses' => 'MapController@getStatePoint']);
	Route::get('getPlotGeoJson/{id}', ['as' => '', 'uses' => 'MapController@getPlotGeoJson']);
	Route::get('getPlotSearchGeoJson/{id}', ['as' => '', 'uses' => 'MapController@getPlotSearchGeoJson']);
	Route::get('getSurveyNo', ['as' => '', 'uses' => 'MapController@getSurveyNo']);
	Route::get('get-serveyno-json', ['as' => '', 'uses' => 'MapController@get_serveyno_json']);
	Route::get('get-classification-json/{id}', ['as' => '', 'uses' => 'MapController@get_classification_json']);
	Route::get('getClassification', ['as' => '', 'uses' => 'MapController@getClassification']);
	Route::get('exportShp', ['as' => '', 'uses' => 'MapController@exportShp']);
	Route::get('exportKml', ['as' => '', 'uses' => 'MapController@exportKml']);
	Route::get('getDistrictPoint', ['as' => '', 'uses' => 'MapController@getDistrictPoint']);
	Route::post('uploadKml', ['as' => '', 'uses' => 'MapController@uploadKml']);	
	Route::get('getZoomGeoJson/{id}', ['as' => '', 'uses' => 'MapController@getZoomGeoJson']);
	Route::get('zoomToPlayer/{id}', ['as' => '', 'uses' => 'MapController@getPlayerGeoJson']);
	Route::post('get-draw-serveyno-json', ['as' => '', 'uses' => 'MapController@get_draw_serveyno_json']);
	
});

////////////family///////////////////////////////////
Route::group(['prefix' => 'land-details-entry/registration', 'middleware' => ['auth', 'authRegNum', 'check_permission:registration_access'], 'namespace' => 'LandEntryManagement'], function() {
    //Route::get('update/{id}', ['as' => '', 'uses' => 'RegistrationController@edit']);
    Route::get('add', ['as' => '', 'uses' => 'RegistrationController@add'])->middleware(['check_permission:registration_add']);
    Route::get('edit', ['as' => '', 'uses' => 'RegistrationController@edit'])->middleware(['check_permission:registration_edit']);
    Route::any('list', ['as' => '', 'uses' => 'RegistrationController@regList'])->middleware(['auth_reg_search', 'check_permission:registration_search']);
    Route::post('submit-data', ['as' => '', 'uses' => 'RegistrationController@processData']);
    Route::any('view', ['as' => '', 'uses' => 'RegistrationController@regView'])->middleware(['check_permission:registration_view']);
	Route::get('audit-view-details', ['as' => '', 'uses' => 'RegistrationController@regauditView']);
    Route::get('transaction-details', ['as' => '', 'uses' => 'RegistrationController@transactionDetails']);
    Route::get('audit-details', ['as' => '', 'uses' => 'RegistrationController@auditDetails']);
    Route::get('converted-details', ['as' => '', 'uses' => 'RegistrationController@ConvertedRegistrationDetails']);
    Route::post('populate-transaction-details', ['as' => '', 'uses' => 'RegistrationController@populateTransactionDetails']);
    Route::post('populate-multiple-docs', ['as' => '', 'uses' => 'RegistrationController@populateMultipleDocs']);
});
Route::group(['prefix' => 'land-details-entry/document', 'middleware' => ['auth', 'authRegNum', 'check_permission:registration_access'], 'namespace' => 'LandEntryManagement'], function() {
    //Route::get('update/{id}', ['as' => '', 'uses' => 'DocumentUploadController@edit']);
    Route::get('add', ['as' => '', 'uses' => 'DocumentUploadController@add'])->middleware(['check_permission:document_upload_add']);
    Route::get('edit', ['as' => '', 'uses' => 'DocumentUploadController@edit'])->middleware(['check_permission:document_upload_edit']);
    Route::get('view', ['as' => '', 'uses' => 'DocumentUploadController@view'])->middleware(['check_permission:document_upload_view']);
    Route::post('submit-data', ['as' => '', 'uses' => 'DocumentUploadController@processData']);
    Route::get('delete', ['as' => '', 'uses' => 'DocumentUploadController@documentDelete'])->middleware(['check_permission:document_upload_delete']);
});
Route::group(['prefix' => 'land-details-entry/survey', 'middleware' => ['auth', 'authRegNum', 'check_permission:registration_access'], 'namespace' => 'LandEntryManagement'], function() {
    Route::get('add', ['as' => '', 'uses' => 'SurveyOnDetails@add'])->middleware(['check_permission:survey_no_details_add']);
    Route::get('edit', ['as' => '', 'uses' => 'SurveyOnDetails@edit'])->middleware(['check_permission:survey_no_details_edit']);
    Route::any('view', ['as' => '', 'uses' => 'SurveyOnDetails@view'])->middleware(['check_permission:survey_no_details_view']);
    Route::post('submit-data', ['as' => '', 'uses' => 'SurveyOnDetails@processData']);
    Route::get('delete', ['as' => '', 'uses' => 'SurveyOnDetails@surveyDelete'])->middleware(['check_permission:survey_no_details_delete']);
});
Route::group(['prefix' => 'land-details-entry/payment', 'middleware' => ['auth', 'authRegNum', 'check_permission:registration_access'], 'namespace' => 'LandEntryManagement'], function() {
    Route::get('add', ['as' => '', 'uses' => 'PaymentDetails@add'])->middleware(['check_permission:payment_details_add']);
    Route::get('edit', ['as' => '', 'uses' => 'PaymentDetails@edit'])->middleware(['check_permission:payment_details_edit']);
    Route::get('view', ['as' => '', 'uses' => 'PaymentDetails@view'])->middleware(['check_permission:payment_details_view']);
    Route::post('submit-data', ['as' => '', 'uses' => 'PaymentDetails@processData']);
    Route::get('delete', ['as' => '', 'uses' => 'PaymentDetails@paymentDelete'])->middleware(['check_permission:payment_details_delete']);
});
Route::group(['prefix' => 'land-details-entry/lease', 'middleware' => ['auth', 'authRegNum', 'check_permission:registration_access'], 'namespace' => 'LandEntryManagement'], function() {
    // Route::get('update/{id}', ['as' => '', 'uses' => 'PaymentDetails@edit']);
    Route::get('add/{id?}', ['as' => '', 'uses' => 'LeaseManagementController@add'])->middleware(['check_permission:lease_details_add']);
    Route::get('edit/{id?}', ['as' => '', 'uses' => 'LeaseManagementController@edit'])->middleware(['check_permission:lease_details_edit']);
    Route::get('view/{id?}', ['as' => '', 'uses' => 'LeaseManagementController@view'])->middleware(['check_permission:lease_details_view']);
    Route::post('submit-data', ['as' => '', 'uses' => 'LeaseManagementController@processData']);
    Route::get('delete', ['as' => '', 'uses' => 'LeaseManagementController@leaseDelete'])->middleware(['check_permission:lease_details_delete']);
});
Route::group(['prefix' => 'land-details-entry/survey-lat-long', 'middleware' => ['auth', 'authRegNum', 'check_permission:registration_access'], 'namespace' => 'LandEntryManagement'], function() {
    // Route::get('update/{id}', ['as' => '', 'uses' => 'PaymentDetails@edit']);
    Route::get('add/{id?}', ['as' => '', 'uses' => 'SurveyLatLongController@add'])->middleware(['check_permission:geo_tag_add']);
    Route::get('view/{id?}', ['as' => '', 'uses' => 'SurveyLatLongController@view'])->middleware(['check_permission:geo_tag_view']);
    Route::get('geo-view', ['as' => '', 'uses' => 'SurveyLatLongController@geoTagView'])->middleware(['check_permission:geo_tag_view']);
    Route::get('delete/{id?}', ['as' => '', 'uses' => 'SurveyLatLongController@surveyDelete'])->middleware(['check_permission:geo_tag_delete']);
    Route::any('getsuveyjson/{id?}', ['as' => '', 'uses' => 'SurveyLatLongController@getGeoJSONSurvey']);
    Route::any('getsuveyextent/{id?}', ['as' => '', 'uses' => 'SurveyLatLongController@getExtentSurvey']);
    Route::post('submit-data', ['as' => '', 'uses' => 'SurveyLatLongController@processData']);
    Route::get('jsonView/{id}', ['as' => '', 'uses' => 'SurveyLatLongController@serveyJsonView']);
    Route::get('plotGeom', ['as' => '', 'uses' => 'SurveyLatLongController@serveyPlotGeom']);
});


Route::group(['prefix' => 'land-details-entry/patta', 'middleware' => ['auth', 'auth_patta_num', 'check_permission:patta_access'], 'namespace' => 'PattaEntryManagement'], function() {
    //Route::get('update/{id}', ['as' => '', 'uses' => 'RegistrationController@edit']);
    Route::get('add', ['as' => '', 'uses' => 'PattaController@add'])->middleware(['check_permission:patta_add']);
    Route::get('edit/{id?}', ['as' => '', 'uses' => 'PattaController@edit'])->middleware(['check_permission:patta_edit']);
    Route::any('list', ['as' => '', 'uses' => 'PattaController@pattaList'])->middleware(['auth_patta_search', 'check_permission:patta_search']);
    Route::post('submit-data', ['as' => '', 'uses' => 'PattaController@processData']);
    Route::any('view', ['as' => '', 'uses' => 'PattaController@view'])->middleware(['check_permission:patta_view']);
    Route::get('delete', ['as' => '', 'uses' => 'PattaController@pattaDelete'])->middleware(['check_permission:patta_delete']);
    Route::get('mutation', ['as' => '', 'uses' => 'PattaController@pattaMutation'])->middleware(['check_permission:patta_mutation_access']);
    Route::post('populate-dropdown', ['as' => '', 'uses' => 'PattaController@dropDown']);
});

Route::group(['prefix' => 'land-details-entry/family-tree', 'middleware' => ['auth', 'authRegNum', 'check_permission:registration_access'], 'namespace' => 'LandEntryManagement'], function() {
    Route::get('add', ['as' => '', 'uses' => 'FamilyTree@add'])->middleware(['check_permission:family_tree_add']);
    Route::get('edit', ['as' => '', 'uses' => 'FamilyTree@edit'])->middleware(['check_permission:family_tree_edit']);
    Route::get('view', ['as' => '', 'uses' => 'FamilyTree@view'])->middleware(['check_permission:payment_details_view']);
    Route::post('submit-data', ['as' => '', 'uses' => 'FamilyTree@processData']);
    Route::get('delete', ['as' => '', 'uses' => 'FamilyTree@memberDelete']);
	Route::post('check-is-owner', ['as' => '', 'uses' => 'FamilyTree@checkIsOwner']);
	Route::post('check-exist-wife', ['as' => '', 'uses' => 'FamilyTree@checkExistWife']);

});


Route::get('download-file', ['as' => '', 'uses' => 'Controller@download']);

#######################  Master Data Management #######################################
#
#######################################################################################

Route::group(['prefix' => 'master/data', 'middleware' => ['auth', 'menu_item'], 'namespace' => 'MasterDataManagement'], function() {

    // t($user,1);
    Route::get('management', function () {
        session(['data' => '']);
        if (\Auth::check()) {
            $user = Auth::user()->toArray();
            // t($user,1);
            $this->data['current_user_id'] = $user['id'];
            $this->data['current_user_name'] = ucwords($user['user_name']);
            $this->user_type = $this->data['user_type'] = $user['user_type'];
        }
        $this->data['title'] = 'Dalmia-lams::Master Data Management';
        $this->data['pageHeading'] = 'Master Data <span class="text-danger" >Management</span>';
        return view('admin.MasterDataManagement.data', $this->data);
    });

    Route::post('submit-data', function(Illuminate\Http\Request $request) {
        $posted_data = $request->all();
//      t($posted_data);
        $posted_type_data = isset($posted_data['data']) ? $posted_data['data'] : '';
//         t($posted_type_data,1);
        if (\Auth::check()) {
            $user = Auth::user()->toArray();
        }
        $current_user_id = isset($user['id']) ? $user['id'] : '';
        switch ($posted_type_data['data']) {
            case 'CD00154': //State
                //   session(['data'=> $posted_type_data['data']]);
                Session::put('data', $posted_type_data['data']);
                return redirect('master/state/management');
                break;
            case 'CD00146': //district
                session(['data' => $posted_type_data['data']]);
                return redirect('master/district/management');
                break;
            case 'CD00153': //Tehsil
                session(['data' => $posted_type_data['data']]);
                return redirect('master/tehsil/management');
                break;
            case 'CD00155': //Village
                session(['data' => $posted_type_data['data']]);
                return redirect('master/village/management');
                break;
            case 'CD00281': // Sub Classification
                session(['data' => $posted_type_data['data']]);
                return redirect('master/sub_classification/management');
                break;
            case 'CD00282': //city
                session(['data' => $posted_type_data['data']]);
                return redirect('master/city/management');
                break;
            default:
                session(['data' => $posted_type_data['data']]);

                return redirect('master/code/management/null/' . $posted_type_data['data']);
        }
    });
});


Route::group(['prefix' => 'master/state', 'middleware' => ['auth', 'check_permission:master_state_access'], 'namespace' => 'MasterDataManagement'], function() {
    Route::get('management/edit/{id}', ['as' => '', 'uses' => 'StateController@edit']);
    Route::get('management/add', ['as' => '', 'uses' => 'StateController@add']);
    Route::get('management', ['as' => '', 'uses' => 'StateController@stateList']);
    Route::post('submit-data', ['as' => '', 'uses' => 'StateController@processData']);
});

Route::group(['prefix' => 'master/district', 'middleware' => ['auth', 'check_permission:master_district_access'], 'namespace' => 'MasterDataManagement'], function() {
    Route::get('management/edit/{id}', ['as' => '', 'uses' => 'DistrictController@edit']);
    Route::get('management/add', ['as' => '', 'uses' => 'DistrictController@add']);
    Route::get('management', ['as' => '', 'uses' => 'DistrictController@districtList']);
    Route::post('submit-data', ['as' => '', 'uses' => 'DistrictController@processData']);
});

Route::group(['prefix' => 'master/tehsil', 'middleware' => ['auth', 'check_permission:master_tehsil_access'], 'namespace' => 'MasterDataManagement'], function() {
    Route::get('management/edit/{id}', ['as' => '', 'uses' => 'BlockController@edit']);
    Route::get('management/add', ['as' => '', 'uses' => 'BlockController@add']);
    Route::get('management', ['as' => '', 'uses' => 'BlockController@blockList']);
    Route::post('submit-data', ['as' => '', 'uses' => 'BlockController@processData']);
});

Route::group(['prefix' => 'master/village', 'middleware' => ['auth', 'check_permission:master_village_access'], 'namespace' => 'MasterDataManagement'], function() {
    Route::get('management/edit/{id}', ['as' => '', 'uses' => 'VillageController@edit']);
    Route::get('management/add', ['as' => '', 'uses' => 'VillageController@add']);
    Route::get('management', ['as' => '', 'uses' => 'VillageController@villageList']);
    Route::post('submit-data', ['as' => '', 'uses' => 'VillageController@processData']);
});
Route::group(['prefix' => 'master/sub_classification', 'middleware' => ['auth', 'check_permission:master_sub_classification_access'], 'namespace' => 'MasterDataManagement'], function() {
    Route::get('management/edit/{id}', ['as' => '', 'uses' => 'SubClassificationController@edit']);
    Route::get('management/add', ['as' => '', 'uses' => 'SubClassificationController@add']);
    Route::get('management', ['as' => '', 'uses' => 'SubClassificationController@sub_classificationList']);
    Route::post('submit-data', ['as' => '', 'uses' => 'SubClassificationController@processData']);
});
Route::group(['prefix' => 'master/city', 'middleware' => ['auth', 'check_permission:master_city_access'], 'namespace' => 'MasterDataManagement'], function() {
    Route::get('management/edit/{id}', ['as' => '', 'uses' => 'CityController@edit']);
    Route::get('management/add', ['as' => '', 'uses' => 'CityController@add']);
    Route::get('management', ['as' => '', 'uses' => 'CityController@cityList']);
    Route::post('submit-data', ['as' => '', 'uses' => 'CityController@processData']);
});

Route::group(['prefix' => 'master/code', 'middleware' => ['auth'], 'namespace' => 'MasterDataManagement'], function() {
    Route::get('management/edit/{id}', ['as' => '', 'uses' => 'CodeController@edit']);
    Route::get('management/add/{codeType?}', ['as' => '', 'uses' => 'CodeController@add']);
    Route::get('management/{id?}/{codeType?}', ['as' => '', 'uses' => 'CodeController@codeList']);
    Route::post('submit-data', ['as' => '', 'uses' => 'CodeController@processData']);
});

Route::group(['prefix' => 'master/audit', 'middleware' => ['auth', 'check_permission:master_state_access'], 'namespace' => 'MasterDataManagement'], function() {
    Route::any('audit-log', ['as' => '', 'uses' => 'LogController@view_logs']);
	Route::post('logDistribution', ['as' => '', 'uses' => 'logController@logDistribution']);    
});
Route::group(['prefix' => 'master/search', 'middleware' => ['auth', 'check_permission:master_state_access'], 'namespace' => 'MasterDataManagement'], function() {
    Route::any('search-log', ['as' => '', 'uses' => 'LogController@search_logs']);
	Route::post('logDistribution', ['as' => '', 'uses' => 'logController@logDistribution']);    
});
#######################################################################################
##################################  Folder Scan #######################################
#
#######################################################################################

Route::group(['prefix' => 'folder', 'namespace' => 'FolderScan'], function() {
    Route::any('browser', ['as' => '', 'uses' => 'FolderScanController@browserDir']);
    Route::get('moveFile', ['as' => '', 'uses' => 'FolderScanController@moveFile']);
    Route::get('insert', ['as' => '', 'uses' => 'FolderScanController@insertFile']);

    Route::post('insertFile/{field?}/{filename?}', ['as' => '', 'uses' => 'CodeController@processData']);
});

Route::get('mediabrowser', ['as' => '', 'uses' => 'FolderScanController@insertFile']);


#######################################################################################
Route::post('populate-districts', ['as' => '', 'uses' => 'Controller@populateDistricts']);
Route::post('populate-dropdown', ['as' => '', 'uses' => 'Controller@dropDown']);
//Route::post('populate-survey-no', ['as' => '', 'uses' => 'Controller@dropDown']);



Route::group(['prefix' => '/', 'namespace' => 'MasterDataManagement'], function() {
    Route::get('/', function () {

        return view('admin.layouts.loginlayout');
    });
});


########################################Track Management#######################################

Route::group(['prefix' => 'approval-management/approval', 'namespace' => 'ApprovalManagement'], function() {
    Route::any('add/{id?}', ['as' => '', 'uses' => 'ApprovalManageController@add']);
    Route::any('list', ['as' => '', 'uses' => 'ApprovalManageController@userList']);
    Route::any('log', ['as' => '', 'uses' => 'ApprovalManageController@userLog']);
    Route::any('loginlog', ['as' => '', 'uses' => 'ApprovalManageController@loginLog']);
    Route::post('submit-data', ['as' => '', 'uses' => 'ApprovalManageController@processData']);
    Route::any('track/{id?}/{status?}', ['as' => '', 'uses' => 'ApprovalManageController@approval_track']);
    Route::any('track-history/{id?}', ['as' => '', 'uses' => 'ApprovalManageController@track_history']);
    Route::post('track-submit-data', ['as' => '', 'uses' => 'ApprovalManageController@reason_remarks_submit']);
    //Route::any('remarks-data-content', ['as' => '', 'uses' => 'ApprovalManageController@remarks_data_content']);
});

Route::group(['prefix' => 'document-management/document', 'namespace' => 'DocumentManagement'], function() {
   // Route::any('list', ['as' => '', 'uses' => 'DocumentManageController@documentList']);
     Route::any('list', ['as' => '', 'uses' => 'DocumentManageController@documentList']);
	 Route::any('shape-file-list', ['as' => '', 'uses' => 'DocumentManageController@shape_file_list']);
	 Route::any('mining-lease-boundary', ['as' => '', 'uses' => 'DocumentManageController@mining_lease_boundary']);
	 Route::any('colony-boundary', ['as' => '', 'uses' => 'DocumentManageController@colony_boundary']);
	 Route::any('plant-boundary', ['as' => '', 'uses' => 'DocumentManageController@plant_boundary']);
	 Route::any('truckyard', ['as' => '', 'uses' => 'DocumentManageController@truckyard']);
	 Route::any('railway-sliding-boundary', ['as' => '', 'uses' => 'DocumentManageController@railway_sliding_boundary']);
	 Route::any('approach-road', ['as' => '', 'uses' => 'DocumentManageController@approach_road']);
	 Route::any('conveyor-belt', ['as' => '', 'uses' => 'DocumentManageController@conveyor_belt']);
	 Route::any('railway-track', ['as' => '', 'uses' => 'DocumentManageController@railway_track']);
	 Route::any('crusher-location', ['as' => '', 'uses' => 'DocumentManageController@crusher_location']);
	 
	 Route::any('shape-file-remove/{id}/{id2}', ['as' => '', 'uses' => 'DocumentManageController@shape_file_remove']);
	 Route::any('shape-file-view/{id}/{id2}/{id3?}', ['as' => '', 'uses' => 'DocumentManageController@shape_file_view']);
	 Route::any('shape-map-view/{id}/{id2}', ['as' => '', 'uses' => 'DocumentManageController@shape_map_view']);
 	 Route::any('submit-data', ['as' => '', 'uses' => 'DocumentManageController@processData']); 
	 Route::get('shpDrop/{id}', ['as' => '', 'uses' => 'DocumentManageController@shpDrop']);
	 Route::get('importShp/{id1}/{id2}/{id3}', ['as' => '', 'uses' => 'DocumentManageController@importShp']);
	 Route::get('getShpJson', ['as' => '', 'uses' => 'DocumentManageController@getShpJson']);
	 Route::any('edit-shp-single/{id}/{id2}', ['as' => '', 'uses' => 'DocumentManageController@edit_shape_file']);
	 Route::any('shape-file-update', ['as' => '', 'uses' => 'DocumentManageController@update_shape_file']);
	 Route::any('data-export-shp/{id1}/{id2}/{id3}', ['as' => '', 'uses' => 'DocumentManageController@data_export_shp']);
	 Route::any('manage-village-map', ['as' => '', 'uses' => 'DocumentManageController@manage_village_map']);
	 Route::any('manage-village-export/{id1}', ['as' => '', 'uses' => 'DocumentManageController@manage_village_export']);
	 Route::any('manage-village-remove/{id1}', ['as' => '', 'uses' => 'DocumentManageController@manage_village_remove']);
	 Route::any('manage-shape-data/{id1}', ['as' => '', 'uses' => 'DocumentManageController@manage_shape_data']);
	 Route::any('manage-shape-remove/{id1}/{id2}', ['as' => '', 'uses' => 'DocumentManageController@manage_shape_remove']);
});

Route::group(['prefix' => 'user-management/user', 'namespace' => 'UserManagement'], function() {
    Route::any('add/{id?}', ['as' => '', 'uses' => 'UserManageController@add']);
    Route::any('list', ['as' => '', 'uses' => 'UserManageController@userList']);
    Route::any('log', ['as' => '', 'uses' => 'UserManageController@userLog']);
    Route::any('loginlog', ['as' => '', 'uses' => 'UserManageController@loginLog']);
    Route::post('submit-data', ['as' => '', 'uses' => 'UserManageController@processData']);
    Route::post('populate-user-dist-dropdown', ['as' => '', 'uses' => 'UserManageController@districtDropdown']);
});
Route::group(['prefix' => 'user-management/role', 'middleware' => 'check_if_admin', 'namespace' => 'UserManagement'], function() {
    Route::any('add/{id?}', ['as' => '', 'uses' => 'RoleManageController@add']);
    Route::post('submit-data', ['as' => '', 'uses' => 'RoleManageController@processData']);
    Route::get('delete/{id}', ['as' => '', 'uses' => 'RoleManageController@deleteRole']);
});
Route::group(['prefix' => 'user-management/form', 'middleware' => 'check_if_admin', 'namespace' => 'UserManagement'], function() {
    Route::any('add/{id?}', ['as' => '', 'uses' => 'FormManageController@add']);
    Route::post('submit-data', ['as' => '', 'uses' => 'FormManageController@processData']);
});
Route::group(['prefix' => 'user-management/permission', 'middleware' => 'check_if_admin', 'namespace' => 'UserManagement'], function() {
    Route::any('add/{id?}', ['as' => '', 'uses' => 'PermissionManageController@add']);
    Route::post('submit-data', ['as' => '', 'uses' => 'PermissionManageController@processData']);
});
Route::group(['prefix' => 'user-management/audit', 'middleware' => 'check_if_admin', 'namespace' => 'UserManagement'], function() {
    Route::any('add/{id?}', ['as' => '', 'uses' => 'AuditManageController@add']);
    Route::post('submit-data', ['as' => '', 'uses' => 'AuditManageController@processData']);
});

Route::any('contact', 'ContactManagement\ContactManageController@index');
Route::any('contact/submit-data', 'ContactManagement\ContactManageController@processData');

Route::get('check-valid-user', ['as' => 'check-valid-user', 'uses' => 'LoginController@checkValidUser']);
Route::post('validate-user-login', ['as' => 'validate-user-login', 'uses' => 'LoginController@authUserByCred']);
Route::get('logout', ['as' => 'logout', 'uses' => 'LoginController@logout']);

Route::group(['prefix' => 'lease-management', 'middleware' => ['auth'], 'namespace' => 'LeaseManagement'], function() {
    //Route::get('update/{id}', ['as' => '', 'uses' => 'DocumentUploadController@edit']);
    Route::get('add', ['as' => '', 'uses' => 'LeaseManagementController@add'])->middleware(['check_permission:lease_add']);
    Route::get('edit/{id?}', ['as' => '', 'uses' => 'LeaseManagementController@edit'])->middleware(['check_permission:lease_edit']);
//    Route::get('view/{id}', ['as' => '', 'uses' => 'LeaseManagementController@leaseView']);
//    Route::any('list', ['as' => '', 'uses' => 'LeaseManagementController@leaseList']);
    Route::post('submit-data', ['as' => '', 'uses' => 'LeaseManagementController@processData']);
    Route::post('populate-fields', ['as' => 'populate-fields', 'uses' => 'LeaseManagementController@populateFields']);
    Route::get('delete', ['as' => '', 'uses' => 'LeaseManagementController@leaseDelete'])->middleware(['check_permission:lease_delete']);
});
Route::group(['prefix' => 'payment', 'middleware' => ['auth'], 'namespace' => 'PaymentDetails'], function() {
    Route::get('add', ['as' => '', 'uses' => 'PaymentDetails@add'])->middleware(['check_permission:payment_add']);
    Route::get('edit/{id?}', ['as' => '', 'uses' => 'PaymentDetails@edit'])->middleware(['check_permission:payment_edit']);
    Route::post('submit-data', ['as' => '', 'uses' => 'PaymentDetails@processData']);
    Route::get('delete', ['as' => '', 'uses' => 'PaymentDetails@paymentDelete'])->middleware(['check_permission:payment_delete']);
});

Route::group(['prefix' => 'transaction/mutation', 'middleware' => ['auth'], 'namespace' => 'Transaction'], function() {
    Route::get('add', ['as' => '', 'uses' => 'MutationController@add'])->middleware(['check_permission:mutation_add']);
    Route::post('submit-data', ['as' => '', 'uses' => 'MutationController@processData']);
    Route::post('populate-fields', ['as' => 'populate-fields', 'uses' => 'MutationController@populateFields']);
    Route::post('populate-dropdown', ['as' => '', 'uses' => 'MutationController@dropDown']);
    Route::post('getPattaSurveyDetails', ['as' => '', 'uses' => 'MutationController@getPattaSurveyDetails']);
});
Route::group(['prefix' => 'transaction/inspection', 'middleware' => ['auth'], 'namespace' => 'Transaction'], function() {
    Route::get('add', ['as' => '', 'uses' => 'InspectionController@add'])->middleware(['check_permission:land_inspection_add']);
    ;
    Route::post('submit-data', ['as' => '', 'uses' => 'InspectionController@processData']);
    Route::post('populate-dropdown', ['as' => '', 'uses' => 'InspectionController@dropDown']);
});

Route::group(['prefix' => 'transaction/land-reservation', 'middleware' => ['auth'], 'namespace' => 'Transaction'], function() {
    Route::get('add', ['as' => '', 'uses' => 'LandReservationController@add'])->middleware(['check_permission:land_reservation_add']);
    Route::get('edit/{id?}', ['as' => '', 'uses' => 'LandReservationController@edit'])->middleware(['check_permission:land_reservation_edit']);
    Route::post('submit-data', ['as' => '', 'uses' => 'LandReservationController@processData']);
    Route::post('populate-dropdown', ['as' => '', 'uses' => 'LandReservationController@dropDown']);
    Route::get('delete/{survey_id}/{reservation_id}', ['as' => '', 'uses' => 'LandReservationController@deleteReservationSurvey'])->middleware(['check_permission:land_reservation_delete']);
});

Route::group(['prefix' => 'transaction/under-operation', 'middleware' => ['auth'], 'namespace' => 'Transaction'], function() {
    Route::get('add', ['as' => '', 'uses' => 'UnderOperationController@add'])->middleware(['check_permission:under_operation_add']);
    Route::post('submit-data', ['as' => '', 'uses' => 'UnderOperationController@processData']);
    Route::post('populate-dropdown', ['as' => '', 'uses' => 'UnderOperationController@dropDown']);
});

Route::group(['prefix' => 'transaction/disputes', 'middleware' => ['auth'], 'namespace' => 'Transaction'], function() {
    Route::get('add', ['as' => '', 'uses' => 'DisputesController@add'])->middleware(['check_permission:disputes_add']);
    Route::post('submit-data', ['as' => '', 'uses' => 'DisputesController@processData']);
    Route::post('populate-dropdown', ['as' => '', 'uses' => 'DisputesController@dropDown']);
});

Route::group(['prefix' => 'transaction/land-ceiling', 'middleware' => ['auth'], 'namespace' => 'Transaction'], function() {
    Route::get('add', ['as' => '', 'uses' => 'LandCeilingController@add'])->middleware(['check_permission:land_ceiling_add']);
    Route::get('edit/{id?}', ['as' => '', 'uses' => 'LandCeilingController@edit'])->middleware(['check_permission:land_ceiling_edit']);
    Route::post('submit-data', ['as' => '', 'uses' => 'LandCeilingController@processData']);
    Route::post('populate-dropdown', ['as' => '', 'uses' => 'LandCeilingController@dropDown']);
    Route::get('delete/{survey_id}/{ceiling_id}', ['as' => '', 'uses' => 'LandCeilingController@deleteCeilingSurvey'])->middleware(['check_permission:land_ceiling_delete']);
});

Route::group(['prefix' => 'transaction/mining-lease', 'middleware' => ['auth'], 'namespace' => 'Transaction'], function() {
    Route::get('add', ['as' => '', 'uses' => 'MiningLeaseController@add'])->middleware(['check_permission:mining_lease_add']);
    Route::get('edit/{id?}', ['as' => '', 'uses' => 'MiningLeaseController@edit'])->middleware(['check_permission:mining_lease_edit']);
    // Route::get('add/{id?}', ['as' => '', 'uses' => 'MiningLeaseController@add']);
    Route::post('submit-data', ['as' => '', 'uses' => 'MiningLeaseController@processData']);
    Route::post('populate-dropdown', ['as' => '', 'uses' => 'MiningLeaseController@dropDown']);
    Route::get('delete/{survey_id}/{mining_lease_id}', ['as' => '', 'uses' => 'MiningLeaseController@deleteMiningLeaseSurvey'])->middleware(['check_permission:mining_lease_delete']);
});

Route::group(['prefix' => 'transaction/land-conversion', 'middleware' => ['auth'], 'namespace' => 'Transaction'], function() {
    Route::get('add', ['as' => '', 'uses' => 'LandConversionController@add'])->middleware(['check_permission:land_conversion_add']);
    Route::get('edit/{id?}', ['as' => '', 'uses' => 'LandConversionController@edit'])->middleware(['check_permission:land_conversion_edit']);
    Route::post('submit-data', ['as' => '', 'uses' => 'LandConversionController@processData']);
    Route::post('populate-dropdown', ['as' => '', 'uses' => 'LandConversionController@dropDown']);
    Route::get('delete/{survey_id}/{conversion_id}', ['as' => '', 'uses' => 'LandConversionController@deleteConversionSurvey'])->middleware(['check_permission:land_conversion_delete']);
});

Route::group(['prefix' => 'transaction/land-exchange', 'middleware' => ['auth'], 'namespace' => 'Transaction'], function() {
    Route::get('add', ['as' => '', 'uses' => 'LandExchangeController@add'])->middleware(['check_permission:land_exchange_add']);
    Route::get('edit/{id?}', ['as' => '', 'uses' => 'LandExchangeController@edit'])->middleware(['check_permission:land_exchange_edit']);
    Route::post('submit-data', ['as' => '', 'uses' => 'LandExchangeController@processData']);
    Route::post('populate-dropdown', ['as' => '', 'uses' => 'LandExchangeController@dropDown']);
    Route::get('delete/{survey_id}/{reservation_id}', ['as' => '', 'uses' => 'LandExchangeController@deleteExchangeSurvey'])->middleware(['check_permission:land_exchange_delete']);
});

Route::group(['prefix' => 'transaction/audit', 'middleware' => ['auth'], 'namespace' => 'Transaction'], function() {
    Route::get('add', ['as' => '', 'uses' => 'AuditController@add'])->middleware(['check_permission:audit_status_add']);
    Route::get('edit', ['as' => '', 'uses' => 'AuditController@edit'])->middleware(['check_permission:audit_status_edit']);
    Route::post('submit-data', ['as' => '', 'uses' => 'AuditController@processData']);
    Route::post('checkExists', ['as' => '', 'uses' => 'AuditController@checkExists']);
    Route::post('populate-dropdown', ['as' => '', 'uses' => 'AuditController@dropDown']);
});

Route::group(['prefix' => 'transaction/conversion-parent-company', 'middleware' => ['auth'], 'namespace' => 'Transaction'], function() {
    Route::get('add', ['as' => '', 'uses' => 'ConversionParentCompanyController@add'])->middleware(['check_permission:conversion_to_parent_company_add']);
    Route::post('submit-data', ['as' => '', 'uses' => 'ConversionParentCompanyController@processData']);
    Route::post('populate-dropdown', ['as' => '', 'uses' => 'ConversionParentCompanyController@dropDown']);
});

Route::get('unauthorized-access', ['as' => '', 'uses' => 'UserManagement\UserManageController@unauthorized']);
Route::get('404', ['as' => '', 'uses' => 'UserManagement\UserManageController@notFound']);
Route::get('common-success', ['as' => '', 'uses' => 'UserManagement\UserManageController@commonSuccessView']);


//change pasword
Route::get('change-password', ['as' => '', 'uses' => 'UserManagement\ChangePasswordController@changePassword']);
Route::post('submit-change-password', ['as' => '', 'uses' => 'UserManagement\ChangePasswordController@processChangePasswordData']);

//forgot password
Route::get('forgot-password', ['as' => '', 'uses' => 'ForgotPasswordController@forgotPassword']);
Route::post('submit-forgot-password', ['as' => '', 'uses' => 'ForgotPasswordController@processData']);

//reset password
Route::get('reset-password', ['as' => '', 'uses' => 'ForgotPasswordController@resetPassword']);
Route::post('submit-reset-password', ['as' => '', 'uses' => 'ForgotPasswordController@processPasswordResetData']);

Route::group(['prefix' => 'master-user', 'middleware' => ['auth', 'check_if_admin'], 'namespace' => 'UserManagement'], function() {
    Route::get('add/{id?}', ['as' => '', 'uses' => 'MasterUserController@add']);
    Route::get('delete/{id}', ['as' => '', 'uses' => 'MasterUserController@deleteMasterUser']);
    Route::post('submit-data', ['as' => '', 'uses' => 'MasterUserController@processData']);
});

Route::post('costDistribution', ['as' => '', 'uses' => 'CostDistributionController@index']);

Route::group(['prefix' => 'transaction/hypothecation', 'middleware' => ['auth'], 'namespace' => 'Transaction'], function() {
    Route::get('add', ['as' => '', 'uses' => 'HypothecationController@add'])->middleware(['check_permission:hypothecation_add']);
    Route::get('edit/{id?}', ['as' => '', 'uses' => 'HypothecationController@edit'])->middleware(['check_permission:hypothecation_edit']);
    Route::post('submit-data', ['as' => '', 'uses' => 'HypothecationController@processData']);
    Route::post('checkExists', ['as' => '', 'uses' => 'HypothecationController@checkExists']);
    Route::post('populate-dropdown', ['as' => '', 'uses' => 'HypothecationController@dropDown']);
    Route::post('populate-registrationDetailsTable', ['as' => '', 'uses' => 'HypothecationController@registrationDetailsTable']);
    Route::post('populate-registrationDocumentDetailsTable', ['as' => '', 'uses' => 'HypothecationController@registrationDocumentDetailsTable']);
});

//MIS
Route::group(['prefix' => 'mis', 'middleware' => ['auth']], function() {
    Route::any('registration', ['as' => '', 'uses' => 'MisController@registration']);
    Route::any('transaction', ['as' => '', 'uses' => 'MisController@transaction']);
    Route::any('transaction1', ['as' => '', 'uses' => 'MisController1@transaction']);
    Route::any('transaction1/populate-box', ['as' => '', 'uses' => 'MisController1@common']);
    Route::any('transaction/populate-box', ['as' => '', 'uses' => 'MisController@common']);
   
    Route::post('submit-data', ['as' => '', 'uses' => 'MasterUserController@processData']);
});
//Clear Config cache:
Route::get('/clear-cache', function () {
	$exitCode = Artisan::call('cache:clear');
	return '<h1>Cache facade value cleared</h1>';
});
//Clear Config cache:
Route::get('/config-cache', function () {
	$exitCode = Artisan::call('config:cache');
	return '<h1>Clear Config cleared</h1>';
});


