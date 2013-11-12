<html>
<head>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<link rel="stylesheet" type="text/css" href="../manatee.css">
</head>
<title>매너티밴 어드민</title>

<?php

session_start();
 
if(!isset($_SESSION['username'])){
  header("location:login.php");
}

echo '

<div align="center">
  <h2>어드민 메뉴</h2>
</div>


<p align="center"><a href="search_steamid.php">밴 검색/언밴</a></p>
<p align="center"><a href="search_ip.php">IP밴 검색/언밴</a></p>
<p align="center"><a href="addban.php">밴 추가</a></p>
';

if ($_SESSION['status'] == "superadmin")
echo '
<p align="center"><a href="addadmin.php">어드민 추가</a></p>
<p align="center"><a href="modadmin.php">어드민 수정</a></p>
<p align="center"><a href="admin_list.php">어드민 목록</a></p>
';
?>
<p align="center"><a href="change_password.php">비밀번호 변경</a></p>
<p align="center"><a href="logout.php">로그아웃</a></p>


</html>