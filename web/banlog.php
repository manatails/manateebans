<html>
<head>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<link rel="stylesheet" type="text/css" href="manatee.css">
</head>
<title>매너티밴 차단 목록</title>

<?php

include 'config.php';

// Connecting, selecting database
$link = mysql_connect($mana_host, $mana_user, $mana_pass)
    or die('Could not connect: ' . mysql_error());
mysql_select_db($mana_table) or die('Could not select database');

// Performing SQL query

mysql_query("SET NAMES latin1");

$query = 'SELECT * FROM manateebans_log ORDER BY time DESC LIMIT 20';
$result = mysql_query($query) or die('Query failed: ' . mysql_error());

// Printing results in HTML
  
echo "<div class=\"datagrid\"><table>\n";
echo "  <thead><tr><th>차단 목록</th></tr></thead>
        <tr><td>고유번호</td>
		<td>아이피</td>
		<td>닉네임</td>
		<td>시간</td>
		<td>서버</td></tr>";
while ($line = mysql_fetch_array($result, MYSQL_ASSOC)) {
    echo "\t<tr>\n";
    foreach ($line as $k => $col_value) {
	
	    if ($k == 'time')
	        $col_value = gmdate("Y-m-d H:i:s", $col_value);
				
        echo "\t\t<td>$col_value</td>\n";
    
	}
    echo "\t</tr>\n";
}
echo "</table></div>\n";

// Free resultset
mysql_free_result($result);

// Closing connection
mysql_close($link);
?>
    <br>
    <div align="right"><a href="index.php">메인 메뉴</a></div>
</html>
