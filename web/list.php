<html>
<head>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<link rel="stylesheet" type="text/css" href="manatee.css">
</head>
<title>매너티밴 목록</title>

<?php

include 'config.php';

// Connecting, selecting database
$link = mysql_connect($mana_host, $mana_user, $mana_pass)
    or die('Could not connect: ' . mysql_error());
mysql_select_db($mana_table) or die('Could not select database');

// Performing SQL query

mysql_query("SET NAMES latin1");

$query = 'SELECT steamid, ip, nick, starts, ends, length, reason, servername, adminnick, removetype, removenick, removeon, removereason, flag FROM manateebans ORDER BY starts DESC LIMIT 20';
$result = mysql_query($query) or die('Query failed: ' . mysql_error());

// Printing results in HTML
  
echo "<div class=\"datagrid\"><table>\n";
echo "  <thead><tr><th>모든 데이터베이스 기록</th></tr></thead>
        <tr><td>고유번호</td>
		<td>아이피</td>
		<td>닉네임</td>
		<td>밴 시작 시간</td>
		<td>밴 종료 시간</td>
		<td>밴 기간 (분)</td>
		<td>이유</td>
		<td>서버</td>
		<td>어드민</td>
		<td>언밴</td>
		<td>언밴 어드민</td>
		<td>언밴 시간</td>
		<td>언밴 이유</td>
		<td>적용 서버</td></tr>";
while ($line = mysql_fetch_array($result, MYSQL_ASSOC)) {
    echo "\t<tr>\n";
	$i = 0;
    foreach ($line as $col_value) {
	if ($i == 3)
	    $col_value = gmdate("Y-m-d H:i:s", $col_value);
	if ($i == 4)
	    $col_value = gmdate("Y-m-d H:i:s", $col_value);
	if (($i == 5) & $col_value == "0")
	    $col_value = '영구';
	if ($i == 11 & $col_value != "")
	    $col_value = gmdate("Y-m-d H:i:s", $col_value);		
		
        echo "\t\t<td>$col_value</td>\n";
		$i++;
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