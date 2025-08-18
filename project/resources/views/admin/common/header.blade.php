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
    <link href="https://fonts.googleapis.com/css?family=Quattrocento+Sans:400,700" rel="stylesheet">
    
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Css files -->
    <!-- Icons -->
    <link href="<?php echo url('assets/css/icons.css');?>" rel="stylesheet">
    <link href="<?php echo url('assets/css/bootstrap.css');?>" rel="stylesheet">
    <link href="<?php echo url('assets/css/plugins.css');?>" rel="stylesheet">
    <link href="<?php echo url('assets/css/main.css');?>" rel="stylesheet">
    <link href="<?php echo url('assets/frontend/css/icons.css');?>" rel="stylesheet">
    <link href="<?php echo url('assets/frontend/css/bootstrap.css');?>" rel="stylesheet">
    <link href="<?php echo url('assets/frontend/css/plugins.css');?>" rel="stylesheet">
    <link href="<?php echo url('assets/frontend/css/main.css');?>" rel="stylesheet">
    <link href="<?php echo url('assets/frontend/css/custom.css');?>" rel="stylesheet">

    <link href="<?php echo url('assets/frontend/css/flaticon/flaticon.css');?>" rel="stylesheet">
    <link href="<?php echo url('assets/frontend/css/flaticon2/flaticon.css');?>" rel="stylesheet">

    
    <!-- Fav and touch icons -->
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="{{url('assets/img/ico/apple-touch-icon-144-precomposed.png')}}">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="{{url('img/ico/apple-touch-icon-114-precomposed.png')}}">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="{{url('img/ico/apple-touch-icon-72-precomposed.png')}}">
    <link rel="apple-touch-icon-precomposed" href="{{url('img/ico/apple-touch-icon-57-precomposed.png')}}">
    <link rel="icon" href="{{url('assets/img/ico/fav.ico')}}" type="image/png">
    <!-- Windows8 touch icon ( http://www.buildmypinnedsite.com/ )-->



   
    @if (isset($data['cssArr']))
    @foreach ($data['cssArr'] as $jkey => $jvalue)
    @if (is_array($jvalue))

    @if ($jvalue['type'] == 'cdn')
    
    <link rel="stylesheet" href="{{$jvalue['src']}}" />
    @endif

    @else
   
    <link rel="stylesheet" href="{{ url($jvalue) }}" />

    @endif
    @endforeach
    @endif
   
    <meta name="msapplication-TileColor" content="#3399cc" />
</head>

<style>
    .select2-hidden-accessible{
        display: none!important;
    }
</style>