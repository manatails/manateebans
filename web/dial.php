<?php
/* ManateeBans Ban Lookup Service Over Phone
 * intended for use with asterisk or other IVR systems
 */
 
include 'config.php';

//get info
$steamid = $_GET["steamid"];
if (!$steamid){
echo('스팀 아이디를 잘못 입력하셨습니다.');
return;
}

$steamid = mysql_real_escape_string($steamid);

if (strlen($steamid) <= 2){
echo('스팀 아이디를 잘못 입력하셨습니다.');
return;
}

if (strlen($steamid) >= 9)
$steamid = substr($steamid, 0, 1) . ':' . substr($steamid, 1, 1) . ':' . substr($steamid, 2);

// Connecting, selecting database
$link = mysql_connect($mana_host, $mana_user, $mana_pass)
    or die('오류: ' . mysql_error());
mysql_select_db($mana_table) or die('테이블 선택에 실패했습니다');

// Performing SQL query

mysql_query("SET NAMES latin1");


$query = 'SELECT * FROM manateebans WHERE (length = 0 OR ends > UNIX_TIMESTAMP()) AND removetype IS NULL AND steamid like \'%' . $steamid . '%\' LIMIT 1';

//echo $query;

$result = mysql_query($query) or die('Query failed: ' . mysql_error());

//Print Results
if(mysql_num_rows($result) == 0)
echo('활성화된 밴이 없습니다.');

while ($line = mysql_fetch_array($result, MYSQL_ASSOC)) {
if ($line["length"] == 0)
{
$length = '영구';
}
else
{
$length = $line["length"] . '분';
}
$baninfo = '스팀아이디 ' . $line["steamid"] . ' 님은 ' .$line["servername"]. '에서 ' . $line["adminnick"] . '님께 '. $length . ' 밴 당하셨습니다. 이유는 ' . $line["reason"] . '입니다.';

$baninfo = str_replace("ㅋ", "큭", $baninfo);

$baninfo = str_replace("ㅉ", "쯧", $baninfo);

echo $baninfo;
 }


// Free resultset
mysql_free_result($result);

// Closing connection
mysql_close($link);


//add logs
$callerid = $_GET["callerid"];
$v_date = date("l d F H:i:s");

$fp = fopen("logs/dial_log.txt", "a");
fputs($fp, "$callerid - DATE: $v_date - QUERY: $steamid $baninfo\n");
fclose($fp)



?>
