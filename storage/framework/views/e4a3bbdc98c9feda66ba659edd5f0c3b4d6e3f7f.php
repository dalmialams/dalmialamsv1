<!-- no cache headers -->
<meta http-equiv='cache-control' content='no-cache'>
<meta http-equiv='expires' content='<?= time() ?>'>
<meta http-equiv='pragma' content='no-cache'>
<!-- end no cache headers -->
<head>
    <meta charset="utf-8">
    <title><?= isset($title) ? $title : '' ?></title>

    <!-- Mobile specific metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1 user-scalable=no">
    <!-- Force IE9 to render in normal mode -->
    <!--[if IE]><meta http-equiv="x-ua-compatible" content="IE=9" /><![endif]-->
    <meta name="author" content="" />
    <meta name="description" content="" />
    <meta name="keywords" content="" />
    <meta name="application-name" content="" />
	<link rel="icon" href="<?php echo url('favicon.ico');?>" type="image/ico" />
	<!--<link rel="shortcut icon" href="<?php echo url('assets/img/fav_icon.png');?>"> -->
<link rel="icon" href="<?php echo url('assets/img/fav_icon.png');?>">
    <!-- Import google fonts - Heading first/ text second -->
    <?php echo e(HTML::style('https://fonts.googleapis.com/css?family=Quattrocento+Sans:400,700')); ?>


    <!-- Css files -->
    <!-- Icons -->
    <?php echo e(HTML::style('assets/css/icons.css')); ?>

    <!-- Bootstrap stylesheets (included template modifications) -->
    <?php /* HTML::style('assets/css/bootstrap.css') */ ?>
    <!-- Plugins stylesheets (all plugin custom css) -->
    <?php echo e(HTML::style('assets/css/plugins.css')); ?>

    <!-- Main stylesheets (template main css file) -->
    <?php /*HTML::style('assets/css/main.css')*/ ?>
    <!-- Icons -->
    <?php echo e(HTML::style('assets/frontend/css/icons.css')); ?>

    <!-- Bootstrap stylesheets (included template modifications) -->
    <?php echo e(HTML::style('assets/frontend/css/bootstrap.css')); ?>

    <!-- Plugins stylesheets (all plugin custom css) -->
    <?php echo e(HTML::style('assets/frontend/css/plugins.css')); ?>

    <!-- Main stylesheets (template main css file) -->
    <?php echo e(HTML::style('assets/frontend/css/main.css')); ?>


    <!-- Custom stylesheets ( Put your own changes here ) -->
    <?php echo e(HTML::style('assets/frontend/css/custom.css')); ?>

	
	<!-- Flat icon --->
	<?php echo e(HTML::style('assets/frontend/css/flaticon/flaticon.css')); ?>

    <?php echo e(HTML::style('assets/frontend/css/flaticon2/flaticon.css')); ?>

    <!-- Fav and touch icons -->
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php echo e(URL::asset('assets/img/ico/apple-touch-icon-144-precomposed.png')); ?>">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php echo e(URL::asset('img/ico/apple-touch-icon-114-precomposed.png')); ?>">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo e(URL::asset('img/ico/apple-touch-icon-72-precomposed.png')); ?>">
    <link rel="apple-touch-icon-precomposed" href="<?php echo e(URL::asset('img/ico/apple-touch-icon-57-precomposed.png')); ?>">
    <link rel="icon" href="<?php echo e(URL::asset('assets/img/ico/fav.ico')); ?>" type="image/png">
    <!-- Windows8 touch icon ( http://www.buildmypinnedsite.com/ )-->




    <?php if(isset($data['cssArr'])): ?>
    <?php foreach($data['cssArr'] as $jkey => $jvalue): ?>
    <?php if(is_array($jvalue)): ?>

    <?php if($jvalue['type'] == 'cdn'): ?>
    <link rel="stylesheet" href="<?php echo e($jvalue['src']); ?>" />
    <?php endif; ?>

    <?php else: ?>

    <link rel="stylesheet" href="<?php echo e(URL::asset($jvalue)); ?>" />

    <?php endif; ?>
    <?php endforeach; ?>
    <?php endif; ?>
    <meta name="msapplication-TileColor" content="#3399cc" />
</head>
<style>
    .select2-hidden-accessible{
        display: none!important;
    }
</style>