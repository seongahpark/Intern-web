<script>alert("hello");</script>
<?
$sql = "DELETE FROM `board_event_comment` WHERE `idx_comment`='".$_POST['idx']."'";
$res = Mysql_query($sql);
?>
