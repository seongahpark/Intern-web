<?	require_once ($_SERVER["DOCUMENT_ROOT"].'/Mngt/conn/conn.php'); 
	session_start();
	//error_reporting(E_ALL);
	//ini_set("display_errors", 1);

	if($_SESSION['userid'] == "" || !$_SESSION || $_SESSION['name'] == ""){ ?>
		<script>
		alert("로그인 후 이용가능합니다.");
		history.go(-1);		
		</script>
	<? }else{
	$idx = $_GET['idx'];
?>

<div class="board">
    <div class="board_write_frame">
		<form name="add_form" action="qna_insert.php?idx=<?=$idx?>" method="post">
        <div class="row">
            <div class="item">
                <div class="label">작성자</div>
                <div class="input_box"><input type="text" name = "writer" placeholder="이름을 입력해주세요" readonly="readonly" value="<?=$_SESSION['name']?>"></div>
            </div>  
			
			<!--
            <div class="item">
                <div class="label">비밀번호</div>
                <div class="input_box"><input type="password" name = "password" placeholder="비밀번호를 입력해주세요"></div>
            </div>
			-->
        </div>
        <div class="row">
            <div class="item">
				<div class="secret_wrapper">
					<label>
						<input type="checkbox" name="secret" value="1">
						비밀글로 작성하기
					</label>
				</div>
                <div class="label">제목</div>
                <div class="input_box"><input type="text" name = "title" placeholder="제목을 입력해주세요"></div>
            </div>  
        </div>
        <div class="row">
            <div class="item">
                <div class="label">내용</div>
                <div class="input_box"><textarea name = "edit_contents" id="edit_contents" cols="30" rows="10"></textarea></div>
					<!--내용 에디터 관련-->
				  <script type="text/javascript" src="/Seditor/js/HuskyEZCreator.js" charset="utf-8"></script>
				  <script>
						var oEditors = [];

						nhn.husky.EZCreator.createInIFrame({
							oAppRef: oEditors,
							elPlaceHolder: "edit_contents",
							sSkinURI: "/Seditor/SmartEditor3Skin.html",
							fCreator: "createSEditor2"
						});
				  </script>
            </div>  
        </div>
		<!--
		<?  if($_SERVER['REMOTE_ADDR'] == "61.32.164.99"){ ?>

        <div class="row">
            <div class="item">
                <div class="label">첨부파일</div>
                <div class="file_box"><input type="file" id="egovComFileUploader"><label for="egovComFileUploader" class="board_btn">파일선택</label></div>
            </div>             
        </div>
         <!--파일첨부 생성되도록 해주세요, 안보이고 있다가-->
		 <!--
        <div class="row">
            <div class="item">
                <div class="label">첨부목록</div>
                <div class="file_box_list">
                    <div id="egovComFileList" class="list">
                        
                    </div>
                </div>
            </div>
        </div>
		<? } ?>
		-->
		</form>
        <div class="btn_wrapper write">
            <button class="board_btn write" onclick="javascript:add_form_check();">작성</button>
            <button class="board_btn cancel" onclick="javascript:goBack();">취소</button>
        </div>
    </div>
	<!-- 글 작성 시, 빈 칸 확인여부 -->
	<script type="text/javascript" src="../Mngt/cmmJs/formCheck.js"></script>
	<script type="text/javascript">
		function add_form_check(){
			var form = document.add_form;
			
			if(!Val_Chk(form.writer,'아이디'))	return false;
			//if(!Val_Chk(form.password,'비밀번호')) return false;
			if(!Val_Chk(form.title,'제목')) return false;
			oEditors.getById["edit_contents"].exec("UPDATE_CONTENTS_FIELD", []);
			
			if(!Val_Chk(form.edit_contents,'내용')) return false;

			form.submit();
		}
		//이전 페이지로 돌아가기
		function goBack() {
			window.history.back();
		}
	</script>

    <script>
        // 첨부파일 스크립트
        function MultiSelector( list_target, max ){

            // Where to write the list
            this.list_target = list_target;
            // How many elements?
            this.count = 0;
            // How many elements?
            this.id = 0;
            // Is there a maximum?
            if( max ){
                this.max = max;
            } else {
                this.max = -1;
            };
            
            /**
             * Add a new file input element
             */
            this.addElement = function( element ){

                // Make sure it's a file input element
                if( element.tagName == 'INPUT' && element.type == 'file' ){

                    // Element name -- what number am I?
                    element.name = 'up_file[' + (this.id++) + ']';

                    // Add reference to this object
                    element.multi_selector = this;

                    // What to do when a file is selected
                    element.onchange = function(){

                        // New file input
                        var new_element = document.createElement( 'input' );
                        new_element.type = 'file';
                        new_element.id = "egovComFileUploader"; 
                        // Add new element
                        this.parentNode.insertBefore( new_element, this );

                        // Apply 'update' to element
                        this.multi_selector.addElement( new_element );

                        // Update list
                        this.multi_selector.addListRow( this );
                        
                        // Hide this: we can't use display:none because Safari doesn't like it
                        this.style.position = 'absolute';
                        this.style.left = '-1000px';
                        this.style.top = '-1000px';
                        this.style.display = 'none';
                        this.style.visibility = 'hidden';
                        this.style.width = '0';
                        this.style.height = '0';
                        this.style.overflow = 'hidden';

                        new_element.onkeypress = function(){
                            return false;
                        };

                    };
                    // If we've reached maximum number, disable input element
                    if( this.max != -1 && this.count >= this.max ){
                        element.disabled = true;
                    };

                    // File element counter
                    this.count++;
                    // Most recent element
                    this.current_element = element;
                    
                } else {
                    // This can only be applied to file input elements!
                    alert( 'Error: not a file input element' );
                };

            };

            /**
             * Add a new row to the list of files
             */
            this.addListRow = function( element ){

                // Row div
                var new_row = document.createElement( 'div' );
                new_row.className = "list_item";
                var title_span = document.createElement('span');
                new_row.appendChild(title_span);
                // Delete button
                var new_row_button = document.createElement( 'input' );
                new_row_button.type = 'button';
                new_row_button.className = 'board_btn';
                new_row_button.value = '파일취소';

                // References
                new_row.element = element;

                // Delete function
                new_row_button.onclick= function(){

                    // Remove element from form
                    this.parentNode.element.parentNode.removeChild( this.parentNode.element );

                    // Remove this row from the list
                    this.parentNode.parentNode.removeChild( this.parentNode );

                    // Decrement counter
                    this.parentNode.element.multi_selector.count--;

                    // Re-enable input element (if it's disabled)
                    this.parentNode.element.multi_selector.current_element.disabled = false;

                    //    which nixes your already queued uploads
                    return false;
                };

                // Set row value
                new_row.querySelector('span').innerHTML = element.value;

                // Add button
                new_row.appendChild( new_row_button );

                // Add it to the list
                this.list_target.appendChild( new_row );
            };

        };
        
        var maxFileNum = 5;
        if(maxFileNum==null || maxFileNum==""){
            maxFileNum = 1;
        }
        var multi_selector = new MultiSelector( document.getElementById( 'egovComFileList' ), maxFileNum );
        multi_selector.addElement( document.getElementById( 'egovComFileUploader' ) );

    </script>    
</div>

<? } ?>