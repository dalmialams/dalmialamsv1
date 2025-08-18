
@extends('admin.layouts.adminlayout')
@section('content')
<!-- .page-content -->
<form method="POST" action="<?= url('land-details-entry/registration/data') ?>">
    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
    <div class="col-lg-12">
        <div class="row ">
            <!-- Start .row -->
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group">
                <label class="col-lg-5 col-md-3 control-label">SAP Asset Code</label>
                    <input type="text" name="sap_code" value="">
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group">
                <label class="col-lg-5 col-md-3 control-label">SAP Company Code</label>
                <input type="text" name="company_code" value="">
            </div>
        </div>
    </div>
     <div class="col-lg-12">
        <input type="submit" value="Send to SAP">
    </div>
</form>
@endsection
