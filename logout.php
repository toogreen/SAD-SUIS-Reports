<?php 
include ("login.php");
session_unregister($uid);
session_unregister($pwd);
session_unregister($lastlogin);
session_destroy();

?>


<html>
<head>
<title>SmSh Site administration ... logout</title>
<meta http-equiv ="Refresh" content = "5 ; url=index.php">
</head>

<body bgcolor="#FFFFFF">
<?PHP
message("All cookies removed from your machine","index.php", "5");
exit();
?>
</body>
</html>
