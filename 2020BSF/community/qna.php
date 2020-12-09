<? include '../inc/inc_header.php' ?>
<div class="m-container sub barba-container">
   <div class="s-container">
      <div class="inner">
         <div class="bread">
            <ul>
               <li class="home"><a href="../main/index.php">홈</a></li>
               <li class="depth_01"><a href="#">소통마당</a></li>
               <li class="depth_02"><a href="qna.php?bid=qna&&start=0">Q&A</a></li>
            </ul>
         </div>
         <div class="common_top">
            <div class="title">Q&A</div>
            <div class="exp">제19회 부산과학축제에 궁금한점을 남겨주세요</div>
         </div>
         <!-- 리스트 -->
         <? include '../board/board-list.php' ?>
         <!-- 뷰 -->
         <? //include '../board/board-view.php' ?>
         <!-- 작성,수정-->
         <? //include '../board/board-write.php' ?>
         <!-- 비밀번호 페이지 -->
         <? //include '../board/board-pass.php' ?>
      </div>
   </div>
</div>
<? include '../inc/inc_footer.php' ?>