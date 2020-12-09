<? $d1n=5; $d2n=7; $d3n=0; $d4n=0; ?>
<? include "$_SERVER[DOCUMENT_ROOT]/kor/share/ui/header.php"; ?>

<?php
if($_GET['jj_ori'])
{
?>
<table class="basic">
	<colgroup>
		<col width="10%" />
		<col width="50%" />
		<col width="10%" />
		<col width="20%" />
		<col width="5%" />
	</colgroup>
	<thead>
		<tr>
			<th>번호</th>
			<th>제목</th>
			<th>작성자</th>
			<th>작성일</th>
			<th>조회</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td><span class="re_a bold">이벤트</span></td>
			<td class="list_tit bold">이벤트입니다.</td>
			<td>AMUSE</td>
			<td>2014-03-02</td>
			<td>75</td>
		</tr>
		<tr>
			<td>1</td>
			<td class="list_tit">공지사항입니다. </td>
			<td>AMUSE</td>
			<td>2014-03-02</td>
			<td>75</td>
		</tr>
		<tr>
			<td>1</td>
			<td class="list_tit">공지사항입니다. 공지사항입니다.</td>
			<td>AMUSE</td>
			<td>2014-03-02</td>
			<td>75</td>
		</tr>
		<tr>
			<td>1</td>
			<td class="list_tit">공지사항입니다. </td>
			<td>AMUSE</td>
			<td>2014-03-02</td>
			<td>75</td>
		</tr>
		<tr>
			<td>1</td>
			<td class="list_tit">공지사항입니다. </td>
			<td>AMUSE</td>
			<td>2014-03-02</td>
			<td>75</td>
		</tr>
		<tr>
			<td>1</td>
			<td class="list_tit">공지사항입니다. </td>
			<td>AMUSE</td>
			<td>2014-03-02</td>
			<td>75</td>
		</tr>
		<tr>
			<td>1</td>
			<td class="list_tit">공지사항입니다. </td>
			<td>AMUSE</td>
			<td>2014-03-02</td>
			<td>75</td>
		</tr>
	</tbody>
</table>

<div class="clear_div"></div>

<div id="page">
	<span>
		<a href="#" class="first"></a>
		<a href="#" class="prev"></a>
		<a href="#">1</a>
		<a href="#">2</a>
		<a href="#">3</a>
		<a href="#">4</a>
		<a href="#" class="on">5</a>
		<a href="#">6</a>
		<a href="#">7</a>
		<a href="#">8</a>
		<a href="#">9</a>
		<a href="#">10</a>
		<a href="#" class="next"></a>
		<a href="#" class="last"></a>
	</span>
</div>

<div id="search">
  <select name="select" id="select"  class="input02 h30">
		<option>제목</option>
		<option>작성자</option>
	</select>
  <input type="text" name="textfield" id="textfield" class="input">
</div>


<br /><br /><br /><br /><br /><br />


<table class="view">
	<thead>
		<tr>
			<th>제목</th>
		</tr>
	</thead>
	<tr>
		<td>
			<dl class="view_con">
				<dt>작성자 :</dt>
				<dd class="name">홍길동</dd>
				<dt>작성일 :</dt>
				<dd class="date">2014-03-03 오후 5:00:00</dd>
				<dt>조회 :</dt>
				<dd>23</dd>
			</dl>
		</td>
	</tr>
	<tr>
		<td class="substance">게시판 내용입니다. 게시판 내용입니다. 게시판 내용입니다. 게시판 내용입니다. 게시판 내용입니다. 게시판 내용입니다. 게시판 내용입니다. 게시판 내용입니다. 게시판 내용입니다. 게시판 내용입니다. 게시판 내용입니다. 게시판 내용입니다. 게시판 내용입니다. 게시판 내용입니다. 게시판 내용입니다. 게시판 내용입니다. 게시판 내용입니다. 게시판 내용입니다. </td>
	</tr>
</table>

<div class="right pt_20">
	<a href="#" class="btn_on" title="목록">목록</a>
</div>

<div class="clear_div"></div>

<?php
}
else
{
	$tn		= 'board_event';
	$menu	= '039_'.$tn;
	include_once $_SERVER['DOCUMENT_ROOT'].'/web-cs/'.$menu.'/c.php';
}
?>
<? include "$_SERVER[DOCUMENT_ROOT]/kor/share/ui/footer.php"; ?>