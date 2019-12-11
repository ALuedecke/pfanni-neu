<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="utf-8">
	<meta http-equiv="refresh" content="5">
    <meta name="author" content="A. Kapella" />
    <meta name="description" content="Show data received from A9G pudding" />
    <meta name="keywords" content="A9G, A9G pudding, Data" />
    <meta name="robots" content="index, follow" />
    <meta name="viewport" content="width=device-width,initial-scale=0.5,minimum-scale=0.4,maximum-scale=1.0" />
	<style>
	  body {
		background-color:#2080A0;
	  }
	  div {
		font-family:Courier;
	  }
	  table {
		border-collapse:collapse;
		border-color:#202020;
		border-style:solid;
		border-width:1px;
	  }
	  td.data {
		background-color:#FFFFFF;
		border-color:#202020;
		border-style:solid;
		border-width:1px;
		text-align: right;
		width:150px;
	  }
	  td.head {
		background-color:#C0C0C0;
		border-color:#202020;
		border-style:solid;
		border-width:1px;
		font-weight:bold;
		width:110px;
	  }
	</style>
    <title>A9G Data</title>
</head>

<body>
  <div>
    <?php
      include("a9g_data.php");
  
      $a9g_file = 'a9g_data.json';
  
      if (!file_exists($a9g_file)) {
        $a9g_file = 'a9g_data.json';
        if (!file_exists($a9g_file)) {
          die("ERROR: File $a9g_file is not present!");
        }
      }

      $data = new A9GData();
  
      echo $data->get_html($data->get_json($a9g_file));
    ?>
  </div>
</body>

</html>
