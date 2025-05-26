<?
die;
echo phpversion();
echo "<hr>";
phpinfo();
echo "<hr>";
$check = get_extension_funcs('gd');
var_dump($check);
echo "<hr>" ;
if (image_gd_check_settings())
  echo "GD installed";
else
  echo "GD not installed";
echo "<hr>";
?>
