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
    {{ HTML::style('https://fonts.googleapis.com/css?family=Quattrocento+Sans:400,700') }}

    <!-- Css files -->
    <!-- Icons -->
    {{ HTML::style('assets/css/icons.css') }}
    <!-- Bootstrap stylesheets (included template modifications) -->
    {{-- HTML::style('assets/css/bootstrap.css') --}}
    <!-- Plugins stylesheets (all plugin custom css) -->
    {{ HTML::style('assets/css/plugins.css') }}
    <!-- Main stylesheets (template main css file) -->
    {{--HTML::style('assets/css/main.css')--}}
    <!-- Icons -->
    {{ HTML::style('assets/frontend/css/icons.css') }}
    <!-- Bootstrap stylesheets (included template modifications) -->
    {{ HTML::style('assets/frontend/css/bootstrap.css') }}
    <!-- Plugins stylesheets (all plugin custom css) -->
    {{ HTML::style('assets/frontend/css/plugins.css') }}
    <!-- Main stylesheets (template main css file) -->
    {{ HTML::style('assets/frontend/css/main.css') }}

    <!-- Custom stylesheets ( Put your own changes here ) -->
    {{ HTML::style('assets/frontend/css/custom.css') }}
	
	<!-- Flat icon --->
	{{ HTML::style('assets/frontend/css/flaticon/flaticon.css') }}
    {{ HTML::style('assets/frontend/css/flaticon2/flaticon.css') }}
    <!-- Fav and touch icons -->
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="{{URL::asset('assets/img/ico/apple-touch-icon-144-precomposed.png')}}">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="{{URL::asset('img/ico/apple-touch-icon-114-precomposed.png')}}">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="{{URL::asset('img/ico/apple-touch-icon-72-precomposed.png')}}">
    <link rel="apple-touch-icon-precomposed" href="{{URL::asset('img/ico/apple-touch-icon-57-precomposed.png')}}">
    <link rel="icon" href="{{URL::asset('assets/img/ico/fav.ico')}}" type="image/png">
    <!-- Windows8 touch icon ( http://www.buildmypinnedsite.com/ )-->




    @if (isset($data['cssArr']))
    @foreach ($data['cssArr'] as $jkey => $jvalue)
    @if (is_array($jvalue))

    @if ($jvalue['type'] == 'cdn')
    <link rel="stylesheet" href="{{$jvalue['src']}}" />
    @endif

    @else

    <link rel="stylesheet" href="{{ URL::asset($jvalue) }}" />

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