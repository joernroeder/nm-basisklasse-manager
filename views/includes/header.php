<!doctype html>
<html class="no-js" lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Basisklasse @ Neue Medien</title>
    <link rel="stylesheet" href="assets/css/foundation.min.css" />
    <style>
      body {
        background: #D3D3D3;
      }

      .row {
        max-width: 100%;
      }

      .logo {
        max-height: 128px;
        margin: 10px 0 20px;
        display: inline-block; 
      }

      button {
        color: #D9DF20;
        background-color: #262626;
      }

      button:hover {
        color: #fff;
        background-color: #000;
      }

      table {
        background-color: #E6E6E6;
      }

      table tr:hover td {
        background-color: #D9DF20;
      }

      .switch label {
        background-color: #D3D3D3;
      }

      #logout-btn {
        position: absolute;
        top: 0.9375rem;
        right: 0.9375rem;
        z-index: 100;
      }
    </style>
  </head>
  <body>

  <?php if ($login->isUserLoggedIn()) : ?>
  <a href="index.php?logout" id="logout-btn" class="button radius tiny secondary">Logout</a>
  <?php endif; ?>

    
	<div class="row">
		<div class="small-12 text-center columns">
			<img src="assets/img/logo_intern_256_wide.png" class="logo" />
		</div>
	</div>