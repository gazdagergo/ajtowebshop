<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

<?php 

if (isset($css_files) AND !empty($css_files)) {
foreach($css_files as $file): ?>
	<link type="text/css" rel="stylesheet" href="<?php echo $file; ?>" />
	<link type="text/css" rel="stylesheet" href="/assets/css/admin.css" />
    <link href="/assets/css/simple-sidebar.css" rel="stylesheet">
    
    
<?php endforeach;}?>
    
<?php 
if (isset($css_files) AND !empty($js_files)) {
foreach($js_files as $file): ?>
	<script src="<?php echo $file; ?>"></script>
<?php endforeach;} ?>


    
</head>
<body>
    
    <div id="sidebar-black" class="sidebar-nav">
  <nav id="navbar-black" class="navbar navbar-default" role="navigation">
  
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-navbar-collapse">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <span class="visible-xs"><a class="navbar-brand" href="/">Ajtówebshop</a></span>
    </div>
    
    <div class="navbar-collapse collapse sidebar-navbar-collapse">
    
      <ul class="nav navbar-nav">
        <li class="hidden-xs"><a class="navbar-brand" href="/"><img src="/assets/images/ajtowebshoplogo-feher.svg" width="170" style="opacity:.8;" /></a></li>
        <li class="sidebar-form" style="opacity:0;">
          <form class="input-group" border="0" id="af" name="af" role="search" action="/admin">
              <input class="form-control" id="aa" name="aa" placeholder="Search" type="text">
            <span class="input-group-btn">  
              <button type="submit" class="btn btn-md" id="as" name="as" value="Go"><i class="glyphicon glyphicon-search"></i></button>
            </span>
          </form>
        </li>
      <li class="dropdown">
        <a href="/admin/products" class="dropdown-toggle" data-toggle="dropdown"><i class="glyphicon glyphicon-th-list"></i>&nbsp; Termék adminisztráció <b class="caret"></b></a>
          <ul class="dropdown-menu"> 
              <li><a href="/admin/products">Termékek</a></li>
              <li><a href="/admin/categories">Kategóriák</a></li>
              <li><a href="/admin/subcategories">Alkategóriák</a></li>
<!--                <li class="dropdown-header">Egyéb</li>-->
              <li><a href="/admin/product_groups">Termék-összevonások</a></li>
          </ul>
        </li>
               
        <li class="dropdown">
          <a href="/admin/orders" class="dropdown-toggle" data-toggle="dropdown"><i class="glyphicon glyphicon-shopping-cart"></i>&nbsp; Megrendelések <b class="caret"></b></a>
          <ul class="dropdown-menu"> 
              <li><a href="/admin/orders/current">Aktív</a></li>
              <li><a href="/admin/orders/past">Leszállított</a></li>
              <li><a href="/admin/orders/aborted">Ügyfél félbehagyta</a></li>
              <li><a href="/admin/orders/all">Összes</a></li>
          </ul>            
<!--          <ul class="dropdown-menu">
            <li><a href="/">Books</a></li>
            <li class="dropdown-header">Merchandise</li>
            <li><a href="/">Coffee Mugs</a></li>
          </ul>-->
        </li>
             

      
      </ul>
    </div><!--/.nav-collapse -->

    <ul class="nav navbar-nav">
        </li><li><a href="/admin/textpages"><i class="glyphicon glyphicon-text-background"></i>&nbsp; Szöveges oldalak</a></li>
        </li><li><a href="/admin/slider"><i class="glyphicon glyphicon-film"></i> &nbsp;Főoldali galéria</a></li>
      
      
      
      <hr/>
        </li><li><a href="/admin/logout"><i class="glyphicon glyphicon-log-out"></i> Kilépés</a></li>
      </ul>
      
  </nav><!--/.navbar -->
</div><!--/.sidebar-nav -->  

