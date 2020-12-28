package wcon.cmm.web;

import java.io.File;
import java.io.FileInputStream;
import java.io.IOException;
import java.net.URL;
import java.sql.SQLException;
import java.util.ArrayList;
import java.util.List;

import javax.annotation.Resource;
import javax.servlet.ServletOutputStream;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;

import org.apache.commons.io.IOUtils;
import org.slf4j.Logger;
import org.slf4j.LoggerFactory;

import org.springframework.stereotype.Controller;
import org.springframework.ui.ModelMap;
import org.springframework.web.bind.ServletRequestUtils;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.multipart.MultipartFile;
import org.springframework.web.multipart.MultipartHttpServletRequest;
import org.springframework.web.servlet.mvc.support.RedirectAttributes;

import egovframework.com.cmm.service.EgovProperties;
import egovframework.com.utl.fcc.service.EgovStringUtil;
import egovframework.com.utl.sim.service.EgovFileTool;
import egovframework.rte.psl.dataaccess.util.EgovMap;
import kr.ac.sau.web.model.service.AttachFileService;
import wcon.cmm.WcCmmUtil;
import wcon.cmm.WcFileMngUtil;
import wcon.cmm.WcSessionUtil;
import wcon.cmm.service.WcFileMngService;
import wcon.cmm.util.WcEgovUtil;
import wcon.cmm.util.WcStringUtil;
import wcon.cmm.vo.WcPgmFileVo;

@Controller
@RequestMapping(value = "/cmm/file")
public class WcFileController {

	@Resource(name = "wcFileMngService")
	private WcFileMngService wcFileMngService;
	
	@RequestMapping(value = "/downFile.do")
	public void downFileBoard(WcPgmFileVo fvo
			,HttpServletRequest request
			,HttpServletResponse response) throws NullPointerException, IOException, SQLException, Exception {
		//WcPgmFileVo fresult = wcFileMngService.selectFileInf(fvo);
		EgovMap map = wcFileMngService.selectFileInf(fvo);
		String path = EgovStringUtil.nullConvert(map.get("filePath"));
		String saveNm = EgovStringUtil.nullConvert(map.get("fileSaveNm"));
		String realNm = EgovStringUtil.nullConvert(map.get("fileRealNm"));
		/** 파일 다운로드 처리 */
		WcCmmUtil.downLoadProcess(response,request
				,path
				,saveNm
				,realNm);
	}
	
	@RequestMapping(value = "/downFileImg.do")
	public void downFileBoardImg(WcPgmFileVo fvo
			,HttpServletRequest request
			,HttpServletResponse response) throws NullPointerException, IOException, SQLException, Exception {
		//WcPgmFileVo fresult = wcFileMngService.selectFileInf(fvo);
		EgovMap map = wcFileMngService.selectFileInf(fvo);
		String path = EgovStringUtil.nullConvert(map.get("filePath"));
		String saveNm = EgovStringUtil.nullConvert(map.get("fileSaveNm"));
		String realNm = EgovStringUtil.nullConvert(map.get("fileRealNm"));
		/** 파일 다운로드 처리 */
		WcCmmUtil.downLoadProcessImg(response,request
				,path
				,saveNm
				,realNm);
	}	
	
	@RequestMapping(value = "/deleteFile.do")
	public String deleteFile(WcPgmFileVo fvo
						 , RedirectAttributes redirectAttr) throws NullPointerException, IOException, SQLException, Exception{
		
		//첨부파일 데이터삭제
		int result = wcFileMngService.deleteFileInf(fvo);
		String message = "실패되었습니다.";
		if(result>0){
			message = "삭제되었습니다.";
		}
		redirectAttr.addFlashAttribute("message", message);
		String returnUrl = fvo.getRtnPage().toString();
	    return "redirect:"+returnUrl;
		
	}
	
	@RequestMapping(value = "/showFile.do")
	public void showFileBoard(WcPgmFileVo fvo
			,HttpServletRequest request
			,HttpServletResponse response) throws NullPointerException, IOException, SQLException, Exception { 
		EgovMap map = wcFileMngService.selectFileInf(fvo);
		if(map != null){
			String path = EgovStringUtil.nullConvert(map.get("filePath"));
			String saveNm = EgovStringUtil.nullConvert(map.get("fileSaveNm"));
			String realNm = EgovStringUtil.nullConvert(map.get("fileRealNm"));
			String ext = EgovStringUtil.nullConvert(map.get("fileExt"));
			WcFileMngUtil.showFileProcess(response,request
					,path
					,saveNm
					,realNm
					,ext);
		}else{
			WcFileMngUtil.showFileProcess(response,request
					,"UxisHome/_Img/Board/"
					,"no-img01.jpg"
					,"no-img.jpg"
					,"jpg");
		}
	}
	
	/**
	 * 기업 관련 이미지 출력 처리 컨트롤 
	 * @param request
	 * @param response
	 * @throws NullPointerException
	 * @throws IOException
	 * @throws SQLException
	 * @throws Exception
	 */
	@RequestMapping(value = "/showCpImgFile.do")
	public void showCpImgFileBoard(HttpServletRequest request
			,HttpServletResponse response) throws NullPointerException, IOException, SQLException, Exception {
			 
		EgovMap fileInfo = null;
		String fileExt = null;
		String realName = null;
		String noImgType = ServletRequestUtils.getStringParameter(request, "nit", "0010");
		String siteImgSeq = ServletRequestUtils.getStringParameter(request, "siteImgSeq", "");
		String imgType = ServletRequestUtils.getStringParameter(request, "imgType", "");
		
		if(WcStringUtil.isEmpty(siteImgSeq, imgType) ){
			fileInfo = getNoImgData(noImgType);
			fileExt = "jpg";
			realName = getSaveName(fileInfo);
			WcFileMngUtil.pagePrintFile(response, request, getSaveDir(fileInfo), getSaveName(fileInfo), realName, fileExt);
		}else{
		
			EgovMap map = wcFileMngService.selectSiteImgData(siteImgSeq, imgType);
			
			if(map != null){
				fileExt = WcStringUtil.nullConvert(map.get("fileExt"));
				realName = WcStringUtil.nullConvert(map.get("fileRealNm"));
				
				fileInfo = getShowFileName(WcStringUtil.nullConvert(map.get("filePath")), 
						WcStringUtil.nullConvert(map.get("fileSaveNm")), 
						fileExt, 
						noImgType, 
						ServletRequestUtils.getBooleanParameter(request, "ssnf", false),
						ServletRequestUtils.getBooleanParameter(request, "csnf", false),
						ServletRequestUtils.getIntParameter(request, "sns", 275),
						ServletRequestUtils.getStringParameter(request, "snt", ""));
			}else{
				fileInfo = getNoImgData(noImgType);
				fileExt = "jpg";
				realName = getSaveName(fileInfo);
			}
			
			WcFileMngUtil.pagePrintFile(response, request, getSaveDir(fileInfo), getSaveName(fileInfo), realName, fileExt);
		}
			 
	}
	
	
	/**
	 * 썸네일 이미지를 보여주는 컨트롤
	 * 
	 * 이미지 파일에 대한 데이터가 있을 경우 이미지의 썸네일 이미지 존재여부를 확인, 있을 경우 썸네일 이미지를
	 * 없으면 이미지 파일 존재여부를 확인, 있을 경우 이미지 파일를
	 * 없으면 대체이미지를 보여줌
	 * [설정 모음]
	 * nit : 대체이미지 타입, fidx : 프로그램 파일 고유키, fseq : 프로그램 파일 순번
	 * ssnf : 썸네일 노출 여부, csnf : 썸네일 생성 여부, sns : 썸네일 생성시 썸네일 크기
	 * 
	 * @param request
	 * @param response
	 * @throws NullPointerException
	 * @throws IOException
	 * @throws SQLException
	 * @throws Exception
	 */
	@RequestMapping(value = "/showSumNailImg.do")
	public void showSumNailImg(HttpServletRequest request
			,HttpServletResponse response) throws NullPointerException, IOException, SQLException, Exception {
//System.out.println("\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n");
//System.out.println("----------------------------------------------------------------------------------------------------------------------------------------------------------------");
//System.out.println("----------------------------------------showSumNailImg.do-------------------------------------------------------------------------------------------------------");
//System.out.println("----------------------------------------------------------------------------------------------------------------------------------------------------------------");
//System.out.println("\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n");

		String noImgType = ServletRequestUtils.getStringParameter(request, "nit", "0010");				//대체이미지 타입(기본값 '0010')
		String fidx 	 = ServletRequestUtils.getStringParameter(request, "fidx","");					//프로그램 파일 고유키
		int fseq 		 = ServletRequestUtils.getIntParameter(request, "fseq", -1);					//프로그램 파일 순번
		
		String fileExt 	 = null;																		//이미지 파일 확장자를 담을 변수 선언
		String realName  = null;																		//이미지 파일 이름을 담을 변수 선언
		EgovMap fileInfo = null;																		//이미지 파일 정보를 담을 변수 선언
		
		//프로그램 파일 고유키 및 순번 값이 있을 경우 처리 
		if(!WcStringUtil.isEmpty(fidx) && fseq != -1){
			EgovMap fileMap = selectFileInf(fidx, fseq);												//프로그램 파일 정보를 조회하여 담는다.

//System.out.println("\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n");
//System.out.println("----------------------------------------------------------------------------------------------------------------------------------------------------------------");
//System.out.println("----------------------------------------selectFileInf-------------------------------------------------------------------------------------------------------");
//System.out.println("----------------------------------------fileMap\n"+fileMap+"-------------------------------------------------------------------------------------------------------");
//System.out.println("----------------------------------------csnf\n"+ServletRequestUtils.getBooleanParameter(request, "csnf", false)+"-------------------------------------------------------------------------------------------------------");
//System.out.println("----------------------------------------ssnf\n"+ServletRequestUtils.getBooleanParameter(request, "ssnf", true)+"-------------------------------------------------------------------------------------------------------");
//System.out.println("----------------------------------------------------------------------------------------------------------------------------------------------------------------");
//System.out.println("\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n");

			//프로그램 파일 정보가 있을 경우 처리
			if(fileMap != null){
				fileExt = WcStringUtil.nullConvert(fileMap.get("fileExt"));							//파일 확장자를 가져와서 담는다.
				realName = WcStringUtil.nullConvert(fileMap.get("fileRealNm"));						//파일 이름을 가져와서 담는다.
				/** 이미지 파일정보를 가져온다.  썸네일 있으면 썸네일 파일 정보를 없으면 이미지 파일 정보를, 이미지 파일이 없으면 대체 이미지 파일 정보를 가져온다. */
				fileInfo = getShowFileName2(request, WcStringUtil.nullConvert(fileMap.get("filePath")),		//파일 경로	 
						WcStringUtil.nullConvert(fileMap.get("fileSaveNm")), 						//파일 이름
						fileExt, 																		//파일 확장자
						noImgType, 																		//대체 이미지 타입
						ServletRequestUtils.getBooleanParameter(request, "ssnf", true),					//썸네일 노출 여부
						ServletRequestUtils.getBooleanParameter(request, "csnf", false),				//썸네일 생성 여부
						ServletRequestUtils.getIntParameter(request, "sns", 275),
						ServletRequestUtils.getStringParameter(request, "snt", ""));						//썸네일 생성시 width 사이즈
			}
//System.out.println("----------------------------------------fileInfo\n"+fileInfo+"-------------------------------------------------------------------------------------------------------");
			
		}
		
		//이미지 파일 정보가 없을 경우 대처이미지 파일 정보를 담는다.
		if(fileInfo == null){
			fileInfo = getNoImgData(noImgType);
			fileExt = "jpg";
			realName = getSaveName(fileInfo);
		}
		
		//이미지 파일을 출력 처리한다.
		WcFileMngUtil.pagePrintFile(response, request, getSaveDir(fileInfo), getSaveName(fileInfo), realName, fileExt);
	}
	
	/**
	 * ie 11 대응 이미지 파일 복사 컨트롤 
	 * @param request
	 * @param response
	 * @throws NullPointerException
	 * @throws IOException
	 * @throws SQLException
	 * @throws Exception
	 */
	@RequestMapping(value = "/setFile.do")
	public void setFile(WcPgmFileVo fvo
			,HttpServletRequest request
			,HttpServletResponse response) throws NullPointerException, IOException, SQLException, Exception {
		final Logger logger = LoggerFactory.getLogger(this.getClass());		 
		String fidx 	 = ServletRequestUtils.getStringParameter(request, "fidx","");					//프로그램 파일 고유키
		int fseq 		 = ServletRequestUtils.getIntParameter(request, "fseq", -1);					//프로그램 파일 순번
		
		
		//프로그램 파일 고유키 및 순번 값이 있을 경우 처리 
		if(!WcStringUtil.isEmpty(fidx) && fseq != -1){
			EgovMap fileMap = selectFileInf(fidx, fseq);												//프로그램 파일 정보를 조회하여 담는다.

			//프로그램 파일 정보가 있을 경우 처리
			//201124 박성아 첨부파일 이미지 미리보기 수정
			if(fileMap != null){
				String saveDir = WcStringUtil.nullConvert(fileMap.get("filePath"));
				String saveName = WcStringUtil.nullConvert(fileMap.get("fileSaveNm"));
				String fileExt = WcStringUtil.nullConvert(fileMap.get("fileExt"));
				
				String fileStorePath 	= EgovProperties.getProperty("Globals.fileStorePath");
				String fileUpLoadPath 		= EgovProperties.getProperty("Globals.fileUpLoadPath");
				
				saveDir = saveDir + saveName + "." + fileExt;
				
				response.setContentType("image/*");
				ServletOutputStream bout = response.getOutputStream();
				FileInputStream f = new FileInputStream(saveDir);
				int length;
				byte[] buffer = new byte[10];
				while((length=f.read(buffer)) != -1) {
					bout.write(buffer, 0 , length);
				}

				// 파일 없으면 생성
				if (!checkFileExstByExtnt(saveDir, "sample_" + saveName + "." + fileExt)) {
					WcFileMngUtil.copyFile(saveDir, saveName, "sample_" + saveName + "." + fileExt);
				}
			}
			
		}
	}
	
	/**
	 * 프로그램 파일 고유키 와 프로그램 파일 순번 값을 검색 조건으로 프로그램 파일 정보를 조회하는 메소드
	 * @param fidx		String 프로그램 파일 고유키
	 * @param fseq		int		프로그램 파일 순번
	 * @return
	 */
	private EgovMap selectFileInf(String fidx, int fseq){
		WcPgmFileVo fvo = new WcPgmFileVo();
		fvo.setPgmFileId(fidx);
		fvo.setPgmFileSeq(fseq);
		
		try{
			return wcFileMngService.selectFileInf(fvo);
		}catch(Exception e){
			e.printStackTrace();
			return null;
		}
	}
	
	/**
	 * 출력할 파일 정보를 되돌려주는 메소드
	 * 설정에 따라
	 * 썸네일이 있으면 썸네일을, 썸네일이 없고 이미지 파일이 있으면 이미지 파일을
	 * 썸네일도 없고 이미지 파일도 없을 경우 대체 이미지 정보를 되돌려준다.
	 * 
	 * @param saveDir					String 파일 저장 경로
	 * @param saveName					String 파일 이름
	 * @param ext						String 파일 확장자
	 * @param noImgType					String 대체 이미지 타입
	 * @param showSumNailFlag			String 썸네일 이미지 노출 여부
	 * @param createSumNailFlag			String 썸네일 파일 생성 여부
	 * @param sumNailSize				String 썸네일 생성시 width 크기
	 * @return							EgovMap 이미지 정보가 담긴 배열
	 */
	private EgovMap getShowFileName(String saveDir, String saveName, String ext,
			String noImgType,
			boolean showSumNailFlag, boolean createSumNailFlag, int sumNailSize, String sumNailType){
		String RelativePathPrefix = EgovProperties.getProperty("Globals.fileStorePath");
		saveDir = RelativePathPrefix + saveDir.substring(saveDir.lastIndexOf("/data/") + 1);

		//섬네일 타입이 2이고 섬네일2 파일이 존재할 경우 썸네일 파일 경로 및 파일명 값을 되돌려준다.
		if("2".equals(sumNailType) && checkFileExstByExtnt(saveDir, "sample2_" + saveName)){
			return setShowFileData(saveDir, "sample2_" + saveName);
		//섬네일 보여주기 여부가 true이고 섬네일 파일이 존재할 경우 썸네일 파일 경로 및 파일명 값을 되돌려준다.
		}else if(showSumNailFlag && checkFileExstByExtnt(saveDir, "sample_" + saveName)){
			return setShowFileData(saveDir, "sample_" + saveName);
		}
		//파일이 존재할 경우 처리 
		else if(checkFileExstByExtnt(saveDir, saveName)){
			//썸네일 생성 여부가 true이고 섬네일 생성에 성공 하였을 경우 섬네일 파일 경로 및 파일명 값을 되돌려준다.
			if(createSumNailFlag && WcFileMngUtil.sumNail(saveName, saveDir, ext, sumNailSize)){
				return setShowFileData(saveDir, "sample_" + saveName);
			}
			//아니거나 실패할 경우 실 파일 경로 및 파일명 값을 되돌려준다.
			else{
				return setShowFileData(saveDir, saveName);
			}
		}
		//섬네일이 없고 파일이 존재하지 않을 경우 no-img로 대처한다.
		else{
			return getNoImgData(noImgType);
		}
	}
	
	private EgovMap getShowFileName2(HttpServletRequest request, String saveDir, String saveName, String ext,
			String noImgType,
			boolean showSumNailFlag, boolean createSumNailFlag, int sumNailSize, String sumNailType){
				
		String browser = getBrowser(request);
		
		String RelativePathPrefix = EgovProperties.getProperty("Globals.fileStorePath");
		saveDir = RelativePathPrefix + saveDir.substring(saveDir.lastIndexOf("/data/") + 1);

//System.out.println("\n\n\n\n\n createSumNailFlag ["+createSumNailFlag);
//System.out.println("\n\n\n\n\n browser ["+browser);
		//썸네일 생성 여부가 true이고 섬네일 생성에 성공 하였을 경우 섬네일 파일 경로 및 파일명 값을 되돌려준다.
		if(createSumNailFlag){
			WcFileMngUtil.sumNail2(saveName, saveDir, ext, sumNailSize);
		}
		saveDir = saveDir.substring(saveDir.lastIndexOf("/data/"));
//System.out.println("\n\n\n\n\n saveDir ["+saveDir+"]");		
//System.out.println("		saveName ["+saveName+"]");		
//System.out.println("		ext ["+ext+"]");		
		if(showSumNailFlag && "Trident".equals(browser)){
//System.out.println("\n\n\n\n\n 브라우저 explorer ["+saveDir+"]");
			return setShowFileData(saveDir, saveName + "." + ext);
//			return setShowFileData(saveDir, saveName);
		}else if(showSumNailFlag && !"Trident".equals(browser)){
//System.out.println("\n\n\n\n\n 익스말고 다른거  ["+saveDir+"]");
			return setShowFileData(saveDir, saveName);
		}else{
//System.out.println("\n\n\n\n\n else ["+saveDir+"]");
			return setShowFileData(saveDir, saveName);
		}
	}
	
	private static String getBrowser(HttpServletRequest request) {
		String header = request.getHeader("User-Agent");
		if (header.indexOf("MSIE") > -1) {
			return "MSIE";
		} else if (header.indexOf("Trident") > -1) { // IE11 문자열 깨짐 방지
			return "Trident";
		} else if (header.indexOf("Chrome") > -1) {
			return "Chrome";
		} else if (header.indexOf("Opera") > -1) {
			return "Opera";
		} else if(header.indexOf("Safari") > -1){
			return "Safari";
		}
		return "Firefox";
	}
	
	/**
	 * EgovMap Type의 변수에 'dir'을 키로 파일 경로값을 'name'을 키로 파일 이름값을 담아서 되돌려주는 메소드 
	 * @param saveDir		String 파일 경로
	 * @param saveName		String 파일 이름
	 * @return				EgovMap 파일정보 Map
	 */
	private EgovMap setShowFileData(String saveDir, String saveName){
		EgovMap map = new EgovMap();
		map.put("dir", saveDir);
		map.put("name", saveName);
		return map;
	}
	
	/**
	 * 파일정보가 담긴 EgovMap에서 파일 경로 값을 가져온다.
	 * EgovMap에 'dir' 키로 된 값을 되돌려준다.
	 * @param map	EgovMap
	 * @return		String 파일 경로값
	 */
	private String getSaveDir(EgovMap map){
		return WcStringUtil.nullConvert(map.get("dir"));
	}
	
	/**
	 * 파일 정보가 담긴 EgovMap에 파일 이름 값을 가져온다.
	 * EgovMap에 'name' 키로 된 값을 되돌려준다.
	 * @param map	EgovMap
	 * @return		String	파일 이름 값
	 */
	private String getSaveName(EgovMap map){
		return WcStringUtil.nullConvert(map.get("name"));
	}
	
	/**
	 * 파일 존재여부를 확인하는 메소드 
	 * 확장자별로 디렉토리에 파일이 존재하는지 체크하는 기능(전자정부프레임워크 메소드)
	 * @param dir		String 파일 경로
	 * @param eventn	String 파일 이름
	 * @return			boolean 존재 여부
	 */
	private boolean checkFileExstByExtnt(String dir, String eventn){
		try{
			return EgovFileTool.checkFileExstByExtnt(dir, eventn);
		}catch(Exception e){
			e.printStackTrace();
			return false;
		}
	}
	
	/**
	 * 대체이미지 파일 정보값을 가져오는 메소드
	 * Type에 따라 대체이미지 파일 정보값을 되돌려줌 
	 * 0010 : 썸네일 대체이미지, 0020 : 보통 대체이미지
	 * @param type	String  대체이미지 타입값
	 * @return		EgovMap 이미지 정보가 담긴 배열
	 */
	private EgovMap getNoImgData(String type){
		String saveName = null;
		
		String RelativePathPrefix = EgovProperties.getProperty("Globals.fileStorePath");
		
		//썸네일 이미지 NO IMG Type 
		if("0010".equals(type)){
			RelativePathPrefix += "WEB-INF/jsp/wcon/chem/portal/share/img/default/"; 
			saveName = "noimage_thum.jpg";
		}
		//이미지 NO IMG Type
		else if("0020".equals(type)){
			RelativePathPrefix += "WEB-INF/jsp/wcon/chem/portal/share/img/default/"; 
			saveName = "noimage.jpg";
		}
		//기업 홈페이지 테플릿 1제품 이미지 NO IMG TYPE
		else if("0030".equals(type)){
			RelativePathPrefix += "WEB-INF/jsp/wcon/chem/tmplat/tmplat01/share/img/sub/"; 
			saveName = "tmp_pdt_noimg.jpg";
		}
		//기업 홈페이지 테플릿 2제품 이미지 NO IMG TYPE
		else if("0040".equals(type)){
			RelativePathPrefix += "WEB-INF/jsp/wcon/chem/tmplat/tmplat02/share/img/sub/"; 
			saveName = "tmp_pdt_noimg.jpg";
		}
		//PORTAL 메인페이지 미니 이미지 NO IMG TYPE
		else if("0050".equals(type)){
			RelativePathPrefix += "WEB-INF/jsp/wcon/chem/portal/share/img/main/";
			saveName = "noimg_main.jpg";
		}
		//PORTAL 기업로고 NO IMG TYPE
		else if("0060".equals(type)){
			RelativePathPrefix += "WEB-INF/jsp/wcon/chem/portal/share/img/main/";
			saveName = "noimg_main_2.jpg";
		}
		
		
		return setShowFileData(RelativePathPrefix, saveName);
	}
	
	
	
	//*********************네이버 에디터 유틸************************************************/
	
	@RequestMapping(value = "/editUpload.do")
	public String editPhotoView(ModelMap model, MultipartHttpServletRequest request
						 ) throws NullPointerException, IOException, SQLException, Exception{
		String filePath = EgovProperties.getProperty("Globals.fileStorePath");
		filePath += "share/cmm/nhn_se2_mstr/dist/data/";
		String siteId = "";
		if(!WcStringUtil.isEmpty(WcSessionUtil.getCmsSiteId())){
			siteId = WcSessionUtil.getCmsSiteId();
		}else if(!WcStringUtil.isEmpty(WcSessionUtil.getSysUserId())){
			siteId = "SITE000001";
		}else{
			return WcEgovUtil.setAlertPopClose(model, "세션이 존재하지 않습니다.");
		}
		filePath += siteId;
		File folder = new File(filePath);
		if(!folder.isFile()){
			folder.mkdir();
		}
		
		MultipartFile file = request.getFile("up_file");
		File saveFile = new File(filePath+"/", file.getOriginalFilename());
		
		if(WcStringUtil.isEmpty(file.getOriginalFilename())){
			return WcEgovUtil.setAlertPopClose(model, "첨부된 이미지가 없습니다.");
		}
		
		saveFile = fileReName(saveFile); //중복된 파일이름이 있을경우 이름변경
		
		file.transferTo(saveFile);
		
		
		filePath.replaceAll("\\\\", "/");
		filePath = filePath.substring(filePath.indexOf("/share"),filePath.length());
		return WcEgovUtil.setPopEditClose(model, filePath+"/"+saveFile.getName(),saveFile.getName());
		
	}
	
	@RequestMapping(value = "/editFileListPop.do")
	public String editFileListPop(ModelMap model
						 ) throws NullPointerException, IOException, SQLException, Exception{
		
		String filePath = EgovProperties.getProperty("Globals.fileStorePath");
		filePath += "share/cmm/nhn_se2_mstr/dist/data/";
		String siteId = "";
		if(!WcStringUtil.isEmpty(WcSessionUtil.getCmsSiteId())){
			siteId = WcSessionUtil.getCmsSiteId();
		}else if(!WcStringUtil.isEmpty(WcSessionUtil.getSysUserId())){
			siteId = "SITE000001";
		}else{
			return WcEgovUtil.setAlertPopClose(model, "세션이 존재하지 않습니다.");
		}
		filePath += siteId;
		File dirFile = new File(filePath);
		List<EgovMap> returnList = new ArrayList<EgovMap>();
		EgovMap map = new EgovMap();
		
		
		if (!dirFile.exists()) {
			dirFile.mkdirs();
		} else {
			File[] fileList = dirFile.listFiles();
			if(fileList != null){
				
				for (File tempFile : fileList) {
					
					if (tempFile.isFile()) {
						map = new EgovMap();
						map.put("path", tempFile.getParent().replaceAll("\\\\", "/"));
//						map.put("imgpath", tempFile.getParent().replaceAll("\\\\", "/").substring(tempFile.getParent().indexOf("\\share"), tempFile.getParent().length()));
						map.put("imgpath", "/" + tempFile.getParent().replaceAll("\\\\", "/").substring(tempFile.getParent().indexOf("share"), tempFile.getParent().length()));
						map.put("name", tempFile.getName());
						returnList.add(map);
					}
				}
				
			}
			
		}
		
		model.addAttribute("returnList", returnList);
		return "/nhn_se2_mstr/dist/popup/quick_photo/Photo_Folder_pop";
	}
	
	@RequestMapping(value = "/editFileDestory.do")
	public String editFileDestory(ModelMap model, HttpServletRequest request
			) throws NullPointerException, IOException, SQLException, Exception{
		String imgUrl = EgovStringUtil.nullConvert(request.getParameter("imgUrl"));
		
		File img = new File(imgUrl);
		if(img.isFile()){
			if(img.delete()){
				return WcEgovUtil.setAlterLoc(model, "삭제되었습니다.", "/cmm/file/editFileListPop.do");
			}else{
				return WcEgovUtil.setAlertHistory(model, "삭제에 실패하셨습니다.");
			}
		}else{
			return WcEgovUtil.setAlertHistory(model, "해당 이미지가 존재하지않습니다.");
		}
	}
	
	@RequestMapping(value = "/editPortalUpload.do")
	public String editPortalUpload(ModelMap model, MultipartHttpServletRequest request
			) throws NullPointerException, IOException, SQLException, Exception{
		
		String filePath = EgovProperties.getProperty("Globals.fileStorePath");
		filePath += "share/cmm/nhn_se2_mstr/dist/data/";
		String siteId = "";
		if(!WcStringUtil.isEmpty(WcSessionUtil.getPortalSiteId())){
			siteId = WcSessionUtil.getPortalSiteId();	//판매합니다, 구매문의 등록시 siteId 세션에 저장된 정보 가져오기
		}else{
			return WcEgovUtil.setAlertPopClose(model, "회사정보를 불러와주세요.");
		}
		filePath += siteId;
		File folder = new File(filePath);
		if(!folder.isFile()){
			folder.mkdir();
		}
		
		MultipartFile file = request.getFile("up_file");
		File saveFile = new File(filePath+"/", file.getOriginalFilename());
		
		if(WcStringUtil.isEmpty(file.getOriginalFilename())){
			return WcEgovUtil.setAlertPopClose(model, "첨부된 이미지가 없습니다.");
		} 
		
		saveFile = fileReName(saveFile); //중복된 파일이름이 있을경우 이름변경
		
		file.transferTo(saveFile);
		
		
		filePath.replaceAll("\\\\", "/");
		filePath = filePath.substring(filePath.indexOf("/share"),filePath.length());
		return WcEgovUtil.setPopEditClose(model, filePath+"/"+saveFile.getName(),saveFile.getName());
		
	}
	
	@RequestMapping(value = "/editFileListPortalPop.do")
	public String editFileListPortalPop(ModelMap model
			) throws NullPointerException, IOException, SQLException, Exception{
		
		String filePath = EgovProperties.getProperty("Globals.fileStorePath");
		filePath += "share/cmm/nhn_se2_mstr/dist/data/";
		String siteId = "";
		if(!WcStringUtil.isEmpty(WcSessionUtil.getPortalSiteId())){
			siteId = WcSessionUtil.getPortalSiteId();	//판매합니다, 구매문의 등록시 siteId 세션에 저장된 정보 가져오기
		}else{
			return WcEgovUtil.setAlertPopClose(model, "회사정보를 불러와주세요.");
		}
		filePath += siteId;
		File dirFile = new File(filePath);
		List<EgovMap> returnList = new ArrayList<EgovMap>();
		EgovMap map = new EgovMap();
		
		if (!dirFile.exists()) {
			dirFile.mkdirs();
		} else {
			File[] fileList = dirFile.listFiles();
			if(fileList != null){
				for (File tempFile : fileList) {
					if (tempFile.isFile()) {
						map = new EgovMap();
						map.put("path", tempFile.getParent().replaceAll("\\\\", "/"));
						map.put("imgpath", "/" + tempFile.getParent().replaceAll("\\\\", "/").substring(tempFile.getParent().indexOf("share"), tempFile.getParent().length()));
						map.put("name", tempFile.getName());
						returnList.add(map);
					}
				}
			}
		}
		model.addAttribute("returnList", returnList);
		return "/nhn_se2_mstr/dist/popup/quick_photo/Photo_Folder_Portal_pop";
	}
	
	@RequestMapping(value = "/editFilePortalDestory.do")
	public String editFilePortalDestory(ModelMap model, HttpServletRequest request
						 ) throws NullPointerException, IOException, SQLException, Exception{
		String imgUrl = EgovStringUtil.nullConvert(request.getParameter("imgUrl"));
		
		File img = new File(imgUrl);
		if(img.isFile()){
			if(img.delete()){
				return WcEgovUtil.setAlterLoc(model, "삭제되었습니다.", "/cmm/file/editFileListPortalPop.do");
			}else{
				return WcEgovUtil.setAlertHistory(model, "삭제에 실패하셨습니다.");
			}
		}else{
			return WcEgovUtil.setAlertHistory(model, "해당 이미지가 존재하지않습니다.");
		}
	}
	
	
	// 에디터 이미지 첨부시 파일명 같을경우 파일명 변경
	private File fileReName(File f){
		if (!FileChk(f)) return f;        //생성된 f가 중복되지 않으면 리턴
	     
	    String name = f.getName();
	    String body = null;
	    String ext = null;
	 
	    int dot = name.lastIndexOf(".");
	    if (dot != -1) {                              //확장자가 없을때
	      body = name.substring(0, dot);
	      ext = name.substring(dot);
	    } else {                                     //확장자가 있을때
	      body = name;
	      ext = "";
	    }
	 
	    int count = 0;
	    //중복된 파일이 있을때
	    //파일이름뒤에 a숫자.확장자 이렇게 들어가게 되는데 숫자는 9999까지 된다.
	    while (FileChk(f) && count < 9999) {  
	      count++;
	      String txt = "("+count+")";
	      String newName = body + txt + ext;
	      f = new File(f.getParent(), newName);
	    }
	    return f;
	}
	
	
	private boolean FileChk(File f) { 
	    boolean flag = false;
	    
	    String name = f.getName();
	    String body = null;
	    String ext = null;
	 
	    int dot = name.lastIndexOf(".");
	    if (dot != -1) {                              //확장자가 없을때
	      body = name.substring(0, dot);
	      ext = name.substring(dot);
	    } else {                                     //확장자가 있을때
	      body = name;
	      ext = "";
	    }
	    
	    String name1 = body.toUpperCase() +  ext.toUpperCase();
	    String name2 = body.toLowerCase() +  ext.toLowerCase();
	    String name3 = body.toLowerCase() +  ext.toUpperCase();
	    String name4 = body.toUpperCase() +  ext.toLowerCase();
	    
		try {
			//파일이 존재하면 true
			if(EgovFileTool.checkFileExstByName(f.getParent(),f.getName()) || 
					EgovFileTool.checkFileExstByName(f.getParent(),name1) ||
					EgovFileTool.checkFileExstByName(f.getParent(),name2) ||
					EgovFileTool.checkFileExstByName(f.getParent(),name3) ||
					EgovFileTool.checkFileExstByName(f.getParent(),name4) ){
				flag = true;
			}
			
			
	    }catch (Exception e) {
	    	e.printStackTrace();
	    }
	    
		return flag;
	  }
	
}