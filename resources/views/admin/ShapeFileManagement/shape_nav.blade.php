<style>.cb-st{margin-top:3px;}</style>
<div class="row " id="noprint">
    <div class="panel panel-primary  toggle panelMove panelClose panelRefresh">
        <!-- Start .panel -->     
        <div class="panel-body">         
			<a href="<?= url('document-management/document/shape-file-list') ?>" class="btn <?= isset($section) && ($section == 'survey_plot') ? "btn-primary" : "btn-default" ?>">Survey Plot</a>

			<a href="<?= url('document-management/document/mining-lease-boundary') ?>" class="btn <?= isset($section) && ($section == 'mining_lease_boundary') ? "btn-primary" : "btn-default" ?>">Mining Lease Boundary</a>

			<a href="<?= url('document-management/document/plant-boundary') ?>" class="btn <?= isset($section) && ($section == 'plant_boundary') ? "btn-primary" : "btn-default" ?>">Plant Boundary</a>
			
			<a href="<?= url('document-management/document/colony-boundary') ?>" class="btn <?= isset($section) && ($section == 'colony_boundary') ? "btn-primary" : "btn-default" ?>">Colony Boundary</a>

			<a href="<?= url('document-management/document/truckyard') ?>" class="btn <?= isset($section) && ($section == 'truckyard') ? "btn-primary" : "btn-default" ?>">Truckyard</a>

			<a href="<?= url('document-management/document/railway-sliding-boundary') ?>" class="btn <?= isset($section) && ($section == 'railway_sliding_boundary') ? "btn-primary" : "btn-default" ?>">Railway Sliding Boundary</a>

			<a href="<?= url('document-management/document/approach-road') ?>" class="btn <?= isset($section) && ($section == 'approach_road') ? "btn-primary" : "btn-default" ?>">Approach Road</a>

			<a href="<?= url('document-management/document/conveyor-belt') ?>" class="btn <?= isset($section) && ($section == 'conveyor_belt') ? "btn-primary" : "btn-default" ?>">Conveyor Belt</a>

			<a href="<?= url('document-management/document/railway-track') ?>" class="btn <?= isset($section) && ($section == 'railway_track') ? "btn-primary" : "btn-default" ?>">Railway Track</a>

			<a href="<?= url('document-management/document/crusher-location') ?>" class="btn cb-st <?= isset($section) && ($section == 'crusher_location') ? "btn-primary" : "btn-default" ?>  ">Crusher Location</a>
        </div>
    </div>
</div>