<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title>Ajtó webshop</title>

    <!-- Bootstrap core CSS -->
    <link href="/assets/css/bootstrap.min.css" rel="stylesheet">

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="/assets/css/ie10-viewport-bug-workaround.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="signin.css" rel="stylesheet">

  </head>

  <body>

    <div class="container" style="max-width: 400px;
margin: 20px auto;">

      <form class="form-signin" method="post" style="margin-top:55px;">
        <div style="text-align:center;"><img src="/assets/images/ajtowebshoplogo2.svg" style="width:200px;margin-left:-33px;margin-bottom:12px;" /></div>
        <label for="inputEmail" class="sr-only">Email address</label>
        <input type="text" name="username" id="inputEmail" class="form-control" placeholder="Email address" style="margin-bottom:8px;" required autofocus>
        <label for="inputPassword" class="sr-only">Password</label>
        <input type="password" id="inputPassword" name="password" class="form-control" placeholder="Password"  style="margin-bottom:8px;" required>

        <button class="btn btn-lg btn-primary btn-block" type="submit">Belépés</button>
      </form>

    </div> <!-- /container -->



  </body>
</html>