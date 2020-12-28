package wcon.cmm;

import java.io.BufferedInputStream;
import java.io.BufferedOutputStream;
import java.io.BufferedReader;
import java.io.File;
import java.io.FileFilter;
import java.io.FileInputStream;
import java.io.FileNotFoundException;
import java.io.FileOutputStream;
import java.io.IOException;
import java.io.InputStreamReader;
import java.io.OutputStream;
import java.io.PrintWriter;
import java.net.URLEncoder;
import java.nio.file.Files;
import java.nio.file.Path;
import java.nio.file.Paths;
import java.text.SimpleDateFormat;
import java.util.ArrayList;
import java.util.Calendar;
import java.util.Date;
import java.util.Iterator;
import java.util.List;
import java.util.Locale;
import java.util.Map;
import java.util.Properties;
import java.util.Set;
import java.util.zip.ZipEntry;
import java.util.zip.ZipOutputStream;

import javax.mail.Authenticator;
import javax.mail.Message;
import javax.mail.MessagingException;
import javax.mail.PasswordAuthentication;
import javax.mail.Session;
import javax.mail.Transport;
import javax.mail.internet.InternetAddress;
import javax.mail.internet.MimeMessage;
import javax.servlet.ServletOutputStream;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;

import org.apache.commons.compress.archivers.zip.ZipArchiveEntry;
import org.apache.commons.compress.archivers.zip.ZipArchiveOutputStream;
import org.apache.commons.io.FilenameUtils;
import org.json.simple.JSONObject;
import org.json.simple.parser.JSONParser;
import org.json.simple.parser.ParseException;
import org.slf4j.Logger;
import org.slf4j.LoggerFactory;
import org.springframework.ui.ModelMap;
import org.springframework.util.FileCopyUtils;
 

import egovframework.com.cmm.service.EgovProperties;
import egovframework.com.cmm.util.EgovBasicLogger;
import egovframework.com.cmm.util.EgovResourceCloseHelper;
import egovframework.com.utl.fcc.service.EgovStringUtil;
import egovframework.com.utl.sim.service.EgovFileTool;
import egovframework.rte.psl.dataaccess.util.EgovMap;
import egovframework.rte.ptl.mvc.tags.ui.pagination.PaginationInfo;
import wcon.cmm.util.WcStringUtil;
import wcon.cmm.vo.SearchVo;



public class WcCmmUtil {

	
	private static final Logger LOGGER = LoggerFactory.getLogger(WcCmmUtil.class);
	
	/** 날짜 관련 함수 모음 */
	
	/**
	 * 오늘 년도를 가져온다.
	 * @return
	 */
	public static int getYear(){
		Calendar cal = Calendar.getInstance();
		return cal.get(Calendar.YEAR);
	}
	
	/**
	 * 오늘 달를 가져온다.
	 * @return
	 */
	public static int getMonth(){
		Calendar cal = Calendar.getInstance();
		return cal.get(Calendar.MONTH) + 1;
	}
	
	/**
	 * 오늘 일자를 가져온다.
	 * @return
	 */
	public static int getDay(){
		Calendar cal = Calendar.getInstance();
		return cal.get(Calendar.DAY_OF_MONTH);
	}
	
	/**
	 * 현제 시간을 가져온다.
	 * @return
	 */
	public static int getTime(){
		Calendar cal = Calendar.getInstance();
		return cal.get(Calendar.HOUR_OF_DAY);
	}
	
	/**
	 * 오늘 달의 마지막 날짜를 가져온다.
	 * @return
	 */
	public static int getMaxDay(){
		return getMaxDay(getMonth());
	}
	
	/**
	 * 해당 달의 마지막 날짜를 가져온다.
	 * @param _month
	 * @return
	 */
	public static int getMaxDay(int _month){
		Calendar cal = Calendar.getInstance();
		cal.set(cal.YEAR, _month-1,1);
		
		return cal.getActualMaximum(cal.DATE);
	}
	
	/**
	 * php mktime 메소드 구현
	 * @param second
	 * @param minute
	 * @param hourOfDay
	 * @param date
	 * @param month
	 * @param year
	 * @return
	 */
	public static long mktime(int second, int minute, int hourOfDay, int date, int month, int year){
		Calendar cal = Calendar.getInstance();
		cal.set(year, month - 1, date, hourOfDay, minute , second);
		return cal.getTime().getTime() / 1000;
	}
	
	/**
	 * 오늘 날자를 UNIX TIME 값으로 넘겨준다.
	 * @return
	 */
	public static long todayMktime(){
		return mktime(0, 0, 0, getDay(), getMonth() , getYear());
	}
	
	/**
	 * php time() 메소드
	 * @return
	 */
	public static long time(){
		Calendar cal = Calendar.getInstance();
		return cal.getTime().getTime() / 1000;
	}
	
	public static int date(String type, long time){
		time *= 1000;
		if("w".equals(type))return dateWeek(time);
		else if("m".equals(type))return dateMonth(time);
		else if("d".equals(type))return dateDay(time);
		else if("Y".equals(type))return dateYear(time);
		return 0;
	}
	
	public static String weekStr(long time){
		time *= 1000;
		int weekInt = dateWeek(time);
		switch (weekInt) {
		case 1:
			return "일";
		case 2:
			return "월";
		case 3:
			return "화";
		case 4:
			return "수";
		case 5:
			return "목";
		case 6:
			return "금";
		case 7:
			return "토";

		default:
			return "";
		}
	}
	
	public static String weekEng(long time){
		time *= 1000;
		int weekInt = dateWeek(time);
		switch (weekInt) {
		case 1:
			return "Sunday";
		case 2:
			return "Monday";
		case 3:
			return "Tuesday";
		case 4:
			return "Wednesday";
		case 5:
			return "Thursday";
		case 6:
			return "Friday";
		case 7:
			return "Saturday";

		default:
			return "";
		}
	}
	
	public static int dateWeek(long time){
		Date nDate = new Date(time);
		
		Calendar cal = Calendar.getInstance();
		cal.setTime(nDate);
		return cal.get(Calendar.DAY_OF_WEEK);
	}
	
	private static int dateYear(long time){
		Date nDate = new Date(time);
		
		Calendar cal = Calendar.getInstance();
		cal.setTime(nDate);
		return cal.get(Calendar.YEAR);
	}
	
	public static int dateMonth(long time){
		Date nDate = new Date(time);
		
		Calendar cal = Calendar.getInstance();
		cal.setTime(nDate);
		return cal.get(Calendar.MONTH) + 1;
	}
	
	private static int dateDay(long time){
		Date nDate = new Date(time);
		
		Calendar cal = Calendar.getInstance();
		cal.setTime(nDate);
		return cal.get(Calendar.DAY_OF_MONTH);
	}
/** 날짜 함수 끝*/
	
	
	public static Map<String, List> changeMap(Map<String, List> map, String str, Object obj){
		if(map.get(str) == null){
			ArrayList aryList = new ArrayList();
			aryList.add(obj);
			map.put(str, aryList);
		}
		//해당 s_data가 키인 값이 존재하면 해당 값을 꺼내서 데이터를 대입한다.
		else{
			ArrayList aryList = (ArrayList) map.get(str);
			aryList.add(obj);
		}
		return map;
	}

	/**
	 * ModelMap과 alert()로 보여줄 메세지와 이동할 url값을 받아서 메시지 처리 및 페이지 이동 처리를 하는 페이지 주소를 리턴하는 함수
	 * @param model			ModelMap		값을 담은 ModelMap
	 * @param message		String			alert()에 띄울 메시지
	 * @param url				String			이동할 주소
	 * @return					String			처리할 페이지 주소
	 */
	public static String setAlterLoc(ModelMap model, String message, String url){
		
		model.addAttribute("altmsg", message);
		model.addAttribute("locurl", url);
		model.addAttribute("msg", "alterloc");
		
		return "common/message_process";
	}
	
	public static String setAlertPopClose(ModelMap model, String message){
		model.addAttribute("altmsg", message);
		model.addAttribute("msg", "alertpopclose");
		
		return "common/message_process";
	}
	
	public static String setAlertpopcloseReload(ModelMap model, String message){
		model.addAttribute("altmsg", message);
		model.addAttribute("msg", "alertpopcloseReload");
		
		return "common/message_process";
	}
	
	public static String setPageMove(ModelMap model, String url){
		model.addAttribute("locurl", url);
		model.addAttribute("msg", "gopage");
		
		return "common/message_process";
	}
	
	/**
	 * 메시지 출력 후 뒤로가기 처리를 하는 페이지 주소를 리턴하는 함수
	 * @param model
	 * @param message
	 * @return
	 */
	public static String setAlertBack(ModelMap model,String message){
		model.addAttribute("message",message);
		return "common/message_redirect";	
	}
	
	/**
	 * 해당 파라미터를 이용하요 PageCommonVO에 필요한 데이터를 입력, String type으로 html PageView 값을 리턴 하는 함수
	 * @param vo							PageCommonVO			
	 * @param request					HttpServletRequest
	 * @param totalCnt				int								총 게시물 수
	 * @param pageUnit				int								
	 * @param pageSize				int
	 * @return
	 */
	public static String getPageingView(SearchVo vo, HttpServletRequest request, int totalCnt, int pageUnit, int pageSize){
		
		return getPageingView(vo, request, totalCnt, pageUnit, pageSize,0);
	}
	
	/**
	 * 해당 파라미터를 이용하요 PageCommonVO에 필요한 데이터를 입력, String type으로 html PageView 값을 리턴 하는 함수
	 * @param vo							PageCommonVO			
	 * @param request					HttpServletRequest
	 * @param totalCnt				int								총 게시물 수
	 * @param pageUnit				int								
	 * @param pageSize				int
	 * @return
	 */
	public static String getPageingView(SearchVo vo, HttpServletRequest request, 
			int totalCnt, int pageUnit, int pageSize, int pagingType){
		/** EgovPropertyService.sample */
		vo.setPageUnit(pageUnit);
		vo.setPageSize(pageSize);
		
		/** pageing */
		PaginationInfo paginationInfo = new PaginationInfo();
		paginationInfo.setCurrentPageNo(vo.getPageIndex());
		paginationInfo.setRecordCountPerPage(vo.getPageUnit());
		paginationInfo.setPageSize(vo.getPageSize());

		vo.setFirstIndex(paginationInfo.getFirstRecordIndex());
		vo.setLastIndex(paginationInfo.getLastRecordIndex());
		vo.setRecordCountPerPage(paginationInfo.getRecordCountPerPage());
		
		vo.setTotalSize(totalCnt);
		paginationInfo.setTotalRecordCount(totalCnt);
		
		vo.setTotalPageCount(paginationInfo.getTotalPageCount());
		
		WcPaging paging = new WcPaging(pagingType);
		
		return paging.getPaging(paginationInfo, request);
	}
	
	
	
	public static boolean nullObjectBoolean(Object obj, boolean flag){
		if(obj!= null){
			try{
				return (Boolean) obj;
			}catch(ClassCastException e){
				LOGGER.error("nullObjectBoolean ClassCastException {}", e.getMessage());
				return flag;
			}
		}else{
			return flag;
		}
	}
	
	public static boolean nullObjectBoolean(Object obj){
		return nullObjectBoolean(obj, false);
	}
	
	public static int nullObjectInt(Object obj, int defalut){
		if(obj!= null){
			try{
				return Integer.parseInt(obj.toString());
			}catch(ClassCastException e){
				LOGGER.error("nullObjectInt ClassCastException {}", e.getMessage());
				return defalut;
			}
		}else{
			return defalut;
		}
	}
	
	public static int nullObjectInt(Object obj){
		return nullObjectInt(obj, 0);
	}
	
	
	/**
	 * 년,월,주 값을 받아서 해당 주의 날짜 데이터 (cal)및 쿼리문 조건에 필요한 요일 값이 담긴 Map(sqlData) 값을 담은 Map타입을 리턴  
	 * @param _year
	 * @param _month
	 * @param _week
	 * @return
	 */
	@SuppressWarnings("unused")
	public static List getCalendar(int _year, int _month, int _week){
		Calendar calNow = Calendar.getInstance();
	    Calendar calBefore = Calendar.getInstance();
	    Calendar calNext = Calendar.getInstance();
	    
	    int iNowYear = _year;
		int iNowMonth = _month - 1;
		int iNowDate = 0;
		int iNowWeek = _week - 1;
		
		calNow.set(iNowYear, iNowMonth, 1);
		calBefore.set(iNowYear, iNowMonth, 1);
		calNext.set(iNowYear, iNowMonth, 1);

		calBefore.add(Calendar.MONTH, -1);
		calNext.add(Calendar.MONTH, +1);
		
		int startDay = calNow.getMinimum(Calendar.DATE);
		int endDay = calNow.getActualMaximum(Calendar.DAY_OF_MONTH);
		int startWeek = calNow.get(Calendar.DAY_OF_WEEK);
		
		ArrayList listWeekGrop = new ArrayList();
		ArrayList listWeekDate = new ArrayList();
		
		String sUseDate = "";
		
		calBefore.add(Calendar.DATE , calBefore.getActualMaximum(Calendar.DAY_OF_MONTH) - (startWeek-1));
		for(int i = 1; i < startWeek ; i++ )
		{
			sUseDate = Integer.toString(calBefore.get(Calendar.YEAR));
			sUseDate += dateTypeIntForString(calBefore.get(Calendar.MONTH)+1);
			sUseDate += dateTypeIntForString(calBefore.get(Calendar.DATE));
			
			listWeekDate.add(sUseDate);
			calBefore.add(Calendar.DATE, +1);
		}
		
		int iBetweenCount = startWeek;
		
	// 주별로 자른다. BETWEEN 구하기
		for(int i=1; i <= endDay; i++)
		{
			sUseDate = Integer.toString(iNowYear);
			//sUseDate += Integer.toString(iNowMonth).length() == 1 ? "0" + Integer.toString(iNowMonth+1) : Integer.toString(iNowMonth+1);
			// (2011.09.02 수정사항) 10월의 주별 날짜가 이상하게 나와서 LeaderSchedule 보고 수정함. 위의 코드가 원래 코드
			sUseDate += Integer.toString(iNowMonth+1).length() == 1 ? "0" + Integer.toString(iNowMonth+1) : Integer.toString(iNowMonth+1);
			sUseDate += Integer.toString(i).length() == 1 ? "0" + Integer.toString(i) : Integer.toString(i);

			listWeekDate.add(sUseDate);

			if( iBetweenCount % 7 == 0){
				listWeekGrop.add(listWeekDate);
				listWeekDate = new ArrayList();

				if(i < iNowDate){
					iNowWeek++;

				}
			}

			//미지막 7일 자동계산
			if(i == endDay){

				for(int j=listWeekDate.size(); j < 7;j++){
					String sUseNextDate = Integer.toString(calNext.get(Calendar.YEAR));
					sUseNextDate += dateTypeIntForString(calNext.get(Calendar.MONTH)+1);
					sUseNextDate += dateTypeIntForString(calNext.get(Calendar.DATE));
					listWeekDate.add(sUseNextDate);
					calNext.add(Calendar.DATE, +1);
				}

				listWeekGrop.add(listWeekDate);
			}

			iBetweenCount++;
		}
		
		List listWeek = (List)listWeekGrop.get(iNowWeek);
		
		return listWeek;
	}
	
	/**
	 * 0을 붙여 반환
	 * @return  String
	 * @throws
	 */
    public static String dateTypeIntForString(int iInput){
			String sOutput = "";
			if(Integer.toString(iInput).length() == 1){
				sOutput = "0" + Integer.toString(iInput);
			}else{
				sOutput = Integer.toString(iInput);
			}

      return sOutput;
    }
    
    
    public static String changWeekStr(int weekInt){
		switch (weekInt) {
		case 0:
			return "일";
		case 1:
			return "월";
		case 2:
			return "화";
		case 3:
			return "수";
		case 4:
			return "목";
		case 5:
			return "금";
		case 6:
			return "토";

		default:
			return "";
		}
	}
    
    public static void putRequestData(EgovMap map, Map requestMap){
		Set key = requestMap.keySet();
		for(Iterator iterator = key.iterator(); iterator.hasNext();){
			String keyName = (String)iterator.next();
			String[] valueName = (String[])requestMap.get(keyName);
			
			if(valueName.length > 1)
				map.put(keyName, valueName);
			else
				map.put(keyName, valueName[0]);
		}
	}
    
    public static String changSize(long a) {
		long cd = a;
		String gubn[] = { "Byte", "KB", "MB", "GB", "TB" };
		int gubnkey = 0;
		long changeSize = 1;
		for (int x = 0; (a / (double) 1024) > 0; x++, a /= (double) 1024) {
			gubnkey = x;
			changeSize = changeSize * 1024;
		}
		changeSize = changeSize / 1024;
		return (Math.round((cd / ((double) changeSize)) * 100) / 100.0)
				+ gubn[gubnkey];
	}

	public static String changSize(long a, int _gubn) {
		long cd = a;
		String gubn[] = { "Byte", "KB", "MB", "GB", "TB" };
		int gubnkey = 0;
		long changeSize = 1;
		for (int x = 0; (a / (double) 1024) > 0; x++, a /= (double) 1024) {
			gubnkey = x;
			changeSize = changeSize * 1024;
			if (x == _gubn)
				break;
		}
		changeSize = changeSize / 1024;
		return (Math.round((cd / ((double) changeSize)) * 100) / 100.0)
				+ gubn[gubnkey];
	}
	
	/**
	 * 해당 경로의 파일을 읽어서 String 타입으로 리턴하는 함수
	 * @param _filename				String 	파일 리얼 경로
	 * @return								String
	
	public static String fileReading(String _filename){
		StringBuffer strBuffer = new StringBuffer();
		String filename = _filename;
		String thisLine = "";
		try{
			FileInputStream fin = new FileInputStream(filename);
			BufferedReader myInput = new BufferedReader(new InputStreamReader(fin));
			while((thisLine = myInput.readLine()) != null)
			{
				strBuffer.append(thisLine);
			}
		}catch(FileNotFoundException e){
			LOGGER.error("FileNotFoundException error {}", e.getMessage());
		}catch(IOException e){
			LOGGER.error("IOException error {}", e.getMessage());
		} 
		
		return strBuffer.toString();
	}
	 */
	
	/** 파일 다운로드 처리 */
	public static void downLoadProcess(HttpServletResponse response
				,HttpServletRequest request
				,String saveDir
				,String saveName
				,String realName) throws Exception{
		
		/**
		 * 2019-11-21 김주수 수정 (첨부파일 데이터 저장 경로 변경)
		 * 첨부 파일 데이터 저장시 파일 경로를 전체 경로 -> 프로퍼티의 프로젝트 경로 + 업로드 경로 제외한 경로로 변경
		 */
		String fileStorePath = EgovProperties.getProperty("Globals.fileStorePath");
		String fileUpLoadPath = EgovProperties.getProperty("Globals.fileUpLoadPath");
		
		saveDir = fileStorePath + fileUpLoadPath + "/" + saveDir;
		
		File uFile = new File(saveDir, FilenameUtils.getName(saveName));
		int fSize = (int) uFile.length();
		
		if (fSize > 0) {
			String mimetype = "application/x-msdownload";
			//String mimetype = "doesn/matter; charset=utf-8";
			//response.flushBuffer();
			//response.getWriter();
			response.setBufferSize(fSize);	// OutOfMemeory 발생
			response.setContentType(mimetype);
			//response.setHeader("Content-Disposition", "attachment; filename=\"" + URLEncoder.encode(fvo.getOrignlFileNm(), "utf-8") + "\"");
			setDisposition(realName, request, response);
			response.setContentLength(fSize);
	
			/*
			 * FileCopyUtils.copy(in, response.getOutputStream());
			 * in.close();
			 * response.getOutputStream().flush();
			 * response.getOutputStream().close();
			 */
			BufferedInputStream in = null;
			BufferedOutputStream out = null;
			
			try {
				
							
				in = new BufferedInputStream(new FileInputStream(uFile));
				out = new BufferedOutputStream(response.getOutputStream());
				
				FileCopyUtils.copy(in, out);
				out.flush();
				//jw.clear();	
			} catch (IOException ex) {
				// 다음 Exception 무시 처리
				// Connection reset by peer: socket write error
				EgovBasicLogger.ignore("IO Exception", ex);
			} finally {
				EgovResourceCloseHelper.close(in, out);
			}
	
		} else {
			response.setContentType("text/html");
	
			PrintWriter printwriter = response.getWriter();
			
			printwriter.println("<html>");
			//printwriter.println("<h2>Could not get file name:<br>" + realName + "</h2>");
			printwriter.println("<h2>Could not get file name</h2>");
			printwriter.println("<center><h3><a href='javascript: history.go(-1)'>Back</a></h3></center>");
			printwriter.println("<br>&copy; webAccess");
			printwriter.println("</html>");
			
			printwriter.flush();
			printwriter.close();
		}
	}
	
	/** 201125 박성아 팝업창/존 이미지 파일 다운로드 처리 */
	public static void downLoadProcessImg(HttpServletResponse response
			,HttpServletRequest request
			,String saveDir
			,String saveName
			,String realName) throws Exception{

	String fileStorePath = EgovProperties.getProperty("Globals.fileStorePath");
	String fileUpLoadPath = EgovProperties.getProperty("Globals.fileUpLoadPath");
	
	//saveDir = fileStorePath + fileUpLoadPath + "/" + saveDir;
	
	File uFile = new File(saveDir, FilenameUtils.getName(saveName));
	int fSize = (int) uFile.length();
	
	if (fSize > 0) {
		String mimetype = "application/x-msdownload";
		//String mimetype = "doesn/matter; charset=utf-8";
		//response.flushBuffer();
		//response.getWriter();
		response.setBufferSize(fSize);	// OutOfMemeory 발생
		response.setContentType(mimetype);
		//response.setHeader("Content-Disposition", "attachment; filename=\"" + URLEncoder.encode(fvo.getOrignlFileNm(), "utf-8") + "\"");
		setDisposition(realName, request, response);
		response.setContentLength(fSize);

		/*
		 * FileCopyUtils.copy(in, response.getOutputStream());
		 * in.close();
		 * response.getOutputStream().flush();
		 * response.getOutputStream().close();
		 */
		BufferedInputStream in = null;
		BufferedOutputStream out = null;
		
		try {
			
						
			in = new BufferedInputStream(new FileInputStream(uFile));
			out = new BufferedOutputStream(response.getOutputStream());
			
			FileCopyUtils.copy(in, out);
			out.flush();
			//jw.clear();	
		} catch (IOException ex) {
			// 다음 Exception 무시 처리
			// Connection reset by peer: socket write error
			EgovBasicLogger.ignore("IO Exception", ex);
		} finally {
			EgovResourceCloseHelper.close(in, out);
		}

	} else {
		response.setContentType("text/html");

		PrintWriter printwriter = response.getWriter();
		
		printwriter.println("<html>");
		//printwriter.println("<h2>Could not get file name:<br>" + realName + "</h2>");
		printwriter.println("<h2>Could not get file name</h2>");
		printwriter.println("<center><h3><a href='javascript: history.go(-1)'>Back</a></h3></center>");
		printwriter.println("<br>&copy; webAccess");
		printwriter.println("</html>");
		
		printwriter.flush();
		printwriter.close();
	}
}	
	/** 파일 다운로드 처리 */
	public static void downLoadProcess2(HttpServletResponse response
				,HttpServletRequest request
				,String saveName
				,String realName) throws Exception{
		
		File uFile = new File(saveName);
		
		int fSize = (int) uFile.length();
		
		 
		if (fSize > 0) {
			String mimetype = "application/x-msdownload";
			//String mimetype = "doesn/matter; charset=utf-8";
			//response.flushBuffer();
			//response.getWriter();
			response.setBufferSize(fSize);	// OutOfMemeory 발생
			response.setContentType(mimetype);
			//response.setHeader("Content-Disposition", "attachment; filename=\"" + URLEncoder.encode(fvo.getOrignlFileNm(), "utf-8") + "\"");
			setDisposition(realName, request, response);
			response.setContentLength(fSize);
	
			/*
			 * FileCopyUtils.copy(in, response.getOutputStream());
			 * in.close();
			 * response.getOutputStream().flush();
			 * response.getOutputStream().close();
			 */
			BufferedInputStream in = null;
			BufferedOutputStream out = null;
	
			try {
				
							
				in = new BufferedInputStream(new FileInputStream(uFile));
				out = new BufferedOutputStream(response.getOutputStream());
				
				FileCopyUtils.copy(in, out);
				out.flush();
				//jw.clear();	
			} catch (IOException ex) {
				// 다음 Exception 무시 처리
				// Connection reset by peer: socket write error
				EgovBasicLogger.ignore("IO Exception", ex);
			} finally {
				EgovResourceCloseHelper.close(in, out);
			}
	
		} else {
			response.setContentType("text/html");
	
			PrintWriter printwriter = response.getWriter();
			
			printwriter.println("<html>");
			//printwriter.println("<h2>Could not get file name:<br>" + realName + "</h2>");
			printwriter.println("<h2>Could not get file name</h2>");
			printwriter.println("<center><h3><a href='javascript: history.go(-1)'>Back</a></h3></center>");
			printwriter.println("<br>&copy; webAccess");
			printwriter.println("</html>");
			
			printwriter.flush();
			printwriter.close();
		}
	}
	
	/** 파일 다운로드 처리 
	 * @throws Exception */
	public static void downLoadProcessZip(HttpServletResponse response
				,HttpServletRequest request
				,List<EgovMap> fileList
				,String zipName) throws Exception{
		String fileStorePath = EgovProperties.getProperty("Globals.fileStorePath");
		String fileUpLoadPath = EgovProperties.getProperty("Globals.fileUpLoadPath");
		
		int bufferSize = 1024 * 2;
		            
		ZipOutputStream zos = null;
		            
		try {
		         
			String mimetype = "application/x-msdownload";
			response.setContentType(mimetype);
			setDisposition(zipName, request, response);
		                
		    OutputStream os = response.getOutputStream();
		    zos = new ZipOutputStream(os); // ZipOutputStream
		    zos.setLevel(8); // 압축 레벨 - 최대 압축률은 9, 디폴트 8
		    BufferedInputStream bis = null;
		                
		    int    i = 0;
		    for(EgovMap fileMap : fileList){
				String fileSaveName = WcStringUtil.nullConvert(fileMap.get("fileSaveNm"));
				String fileRealName = WcStringUtil.nullConvert(fileMap.get("fileRealNm"));
				String filePath = WcStringUtil.nullConvert(fileMap.get("filePath"));
				
		        File sourceFile = new File(fileStorePath + fileUpLoadPath + filePath, FilenameUtils.getName(fileSaveName));
		                        
		        bis = new BufferedInputStream(new FileInputStream(sourceFile));
		        ZipEntry zentry = new ZipEntry(fileRealName);
		        zentry.setTime(sourceFile.lastModified());
		        zos.putNextEntry(zentry);
		        
		        byte[] buffer = new byte[bufferSize];
		        int cnt = 0;
		        while ((cnt = bis.read(buffer, 0, bufferSize)) != -1) {
		            zos.write(buffer, 0, cnt);
		        }
		        zos.closeEntry();
		 
		        i++;
		    }
		               
		    zos.close();
		    bis.close();
		                
		} catch(FileNotFoundException e){  
			LOGGER.error("FileNotFoundException {}", e.getMessage());
		} catch(IOException e){
			LOGGER.error("IOException {}", e.getMessage());
		}
		
	}
	
	/** 파일리스트를 압축파일로 다운로드 */
	public static void zipFileDownLoadProcess(HttpServletResponse response
				,HttpServletRequest request
				,String zipFileName
				,List<EgovMap> resultList) throws Exception{			
		
		String fileStorePath = EgovProperties.getProperty("Globals.fileStorePath");
		String fileUpLoadPath = EgovProperties.getProperty("Globals.fileUpLoadPath");
		
		int listSize = resultList.size();
		String resultFilePath = "";		
		for(int i =0 ; i < listSize ; i++){
			resultFilePath = WcStringUtil.nullConvert(resultList.get(i).get("filePath"));
			if(!"".equals(resultFilePath)){
				break;
			}
		}
		
		//첨부파일 경로
		String path = resultFilePath;		
		String saveDirPath = fileStorePath + fileUpLoadPath + path;
		
		//임시 디렉토리 경로
		String tempDirPath = fileStorePath + fileUpLoadPath + path + "temp" + File.separator;		
		File tempDir = new File(tempDirPath);
		
		if(!tempDir.exists()){
			tempDir.mkdir();
		}
		
        //압축파일 명
        String outZipFileNm = tempDirPath + zipFileName;
        
        int size = 1024;
        byte[] buf = new byte[size];
        
        FileInputStream fis = null;
        ZipArchiveOutputStream zos = null;
        BufferedInputStream bis = null;
        ServletOutputStream so = null;
        BufferedOutputStream bos = null;
        
		String saveNm = "";
		String realNm = "";
		String tempNum = "";
		int listNum = 0;
		String reqNm = "";
		String pgmFileId = "";
		
		String orginalFilePath = "";
		String tempFilePath = "";		
		Path orginalPath = null;
		Path tempPath = null;
		
		try {
            // Zip 파일생성
            zos = new ZipArchiveOutputStream(new BufferedOutputStream(new FileOutputStream(outZipFileNm))); 
            
            for(EgovMap map : resultList){
            	
            	pgmFileId = EgovStringUtil.nullConvert(map.get("pgmFileId"));
            	
            	if("".equals(pgmFileId)){
            		continue;
            	}
            	
    			saveNm  = EgovStringUtil.nullConvert(map.get("fileSaveNm"));
    			realNm  = EgovStringUtil.nullConvert(map.get("fileRealNm"));
    			listNum = Integer.parseInt(map.get("listNum").toString());
    			reqNm   = EgovStringUtil.nullConvert(map.get("reqNm"));
    			
    			if(realNm.length() > 100){
    				realNm = realNm.substring(0, 100);
    			}
    			
    			//원본 파일명 변경
    			tempNum = String.format("%03d", listNum);
    			realNm  = tempNum + "_" + reqNm + "_" + realNm;
    			
    			orginalFilePath = saveDirPath + saveNm;    			
    			tempFilePath = tempDirPath + realNm;
    			//파일명 같을 경우 _숫자 붙이기
    			tempFilePath = appendSuffixName(tempFilePath ,1);
    			
    			orginalPath = Paths.get(orginalFilePath);
    			tempPath = Paths.get(tempFilePath);
    			//파일 임시 디렉토리로 복사
    			Files.copy(orginalPath, tempPath);
    			    			
    			//encoding 설정
                zos.setEncoding("UTF-8");
                 
                //buffer에 해당파일의 stream을 입력한다.
                fis = new FileInputStream(tempFilePath);
                bis = new BufferedInputStream(fis,size);
                //경로제외하고 파일만 설정 
                tempFilePath = tempFilePath.substring(tempDirPath.length() , tempFilePath.length());
                //zip에 넣을 다음 entry 를 가져온다.
                zos.putArchiveEntry(new ZipArchiveEntry(tempFilePath));
                
                //준비된 버퍼에서 집출력스트림으로 write 한다.
                int len;
                while((len = bis.read(buf,0,size)) != -1){
                    zos.write(buf,0,len);
                }
                 
                bis.close();
                fis.close();
                zos.closeArchiveEntry();
            }
           
            zos.close();
            
            String mimetype = "application/zip";    	
    		response.setContentType(mimetype);    		
    		setDisposition(zipFileName, request, response);    	
    		
            File outZipFile = new File(outZipFileNm);
            int fSize = 0;
            if(outZipFile.exists()){
            	fSize = (int) outZipFile.length(); 
            	response.setBufferSize(fSize);				
    			response.setContentLength(fSize);
            }      
            
            fis = new FileInputStream(outZipFileNm);
            bis = new BufferedInputStream(fis);
            so  = response.getOutputStream();
            bos = new BufferedOutputStream(so);
            
            buf = new byte[2048];
            int input = 0;

            while((input=bis.read(buf))!=-1){
                bos.write(buf,0,input);
                bos.flush();
            }            
 
        } catch (FileNotFoundException e) {
            LOGGER.error("FileNotFoundException {}", e.getMessage());
            downLoadError(response);
        } catch (IOException e){
			LOGGER.error("IOException error {}", e.getMessage());
			downLoadError(response);
        }finally{
        	if( bos != null ) bos.close();
        	if( so  != null )  so.close();
        	if( bis != null ) bis.close();
        	if( fis != null ) fis.close(); 
            if( zos != null ) zos.close();
        }		
	}
	
	private static void downLoadError(HttpServletResponse response)throws Exception{
		response.setContentType("text/html;charset=utf-8");
		
		PrintWriter printwriter = response.getWriter();		
		printwriter.println("<html>");
		printwriter.println("<script type='text/javascript'>");
		printwriter.println("alert('파일 다운로드에 실패하였습니다.');");
		printwriter.println("history.go(-1);");
		printwriter.println("</script>");
		printwriter.println("</html>");			
		printwriter.flush();
		printwriter.close();
	}
	
	/** 엑셀 파일 다운로드 처리(다운로드 후 삭제) */
	public static void excelDownLoadProcess(HttpServletResponse response
				,HttpServletRequest request
				,String saveDir
				,String saveName
				,String realName) throws Exception{
		
		File uFile = new File(saveDir, FilenameUtils.getName(saveName));
		int fSize = (int) uFile.length();
		
		 
		if (fSize > 0) {
			String mimetype = "application/x-msdownload";
			//String mimetype = "doesn/matter; charset=utf-8";
			//response.flushBuffer();
			//response.getWriter();
			response.setBufferSize(fSize);	// OutOfMemeory 발생
			response.setContentType(mimetype);
			//response.setHeader("Content-Disposition", "attachment; filename=\"" + URLEncoder.encode(fvo.getOrignlFileNm(), "utf-8") + "\"");
			setDisposition(realName, request, response);
			response.setContentLength(fSize);
	
			/*
			 * FileCopyUtils.copy(in, response.getOutputStream());
			 * in.close();
			 * response.getOutputStream().flush();
			 * response.getOutputStream().close();
			 */
			BufferedInputStream in = null;
			BufferedOutputStream out = null;
	
			try {
				
							
				in = new BufferedInputStream(new FileInputStream(uFile));
				out = new BufferedOutputStream(response.getOutputStream());
				
				FileCopyUtils.copy(in, out);
				out.flush();
				//jw.clear();	
			} catch (IOException ex) {
				// 다음 Exception 무시 처리
				// Connection reset by peer: socket write error
				EgovBasicLogger.ignore("IO Exception", ex);
			} finally {
				EgovResourceCloseHelper.close(in, out);
				if(EgovFileTool.checkFileExstByName(saveDir, saveName)){
					String resultPath = EgovFileTool.deleteFile(saveDir + saveName);					//삭제 처리
				}
			}
	
		} else {
			response.setContentType("application/x-msdownload");
	
			PrintWriter printwriter = response.getWriter();
			
			printwriter.println("<html>");
			//printwriter.println("<h2>Could not get file name:<br>" + realName + "</h2>");
			printwriter.println("<h2>Could not get file name</h2>");
			printwriter.println("<center><h3><a href='javascript: history.go(-1)'>Back</a></h3></center>");
			printwriter.println("<br>&copy; webAccess");
			printwriter.println("</html>");
			
			printwriter.flush();
			printwriter.close();
		}
	}
	
	public static void setDisposition(String filename, HttpServletRequest request, HttpServletResponse response) throws Exception {
		String browser = getBrowser(request);

		String dispositionPrefix = "attachment; filename=";
		String encodedFilename = null;

		if ("MSIE".equals(browser)) {
			encodedFilename = URLEncoder.encode(filename, "UTF-8").replaceAll("\\+", "%20");
		} else if ("Trident".equals(browser)) { // IE11 문자열 깨짐 방지
			encodedFilename = URLEncoder.encode(filename, "UTF-8").replaceAll("\\+", "%20");
		} else if ("Firefox".equals(browser)) {
			encodedFilename = "\"" + new String(filename.getBytes("UTF-8"), "8859_1") + "\"";
		} else if ("Opera".equals(browser)) {
			encodedFilename = "\"" + new String(filename.getBytes("UTF-8"), "8859_1") + "\"";
		} else if ("Chrome".equals(browser)) {
			StringBuffer sb = new StringBuffer();
			for (int i = 0; i < filename.length(); i++) {
				char c = filename.charAt(i);
				if (c > '~') {
					sb.append(URLEncoder.encode("" + c, "UTF-8"));
				} else {
					sb.append(c);
				}
			}
			encodedFilename = sb.toString();
		}else if("Safari".equals(browser)){
			 
			encodedFilename = URLEncoder.encode(filename, "UTF-8")+";";
			//dispositionPrefix = "filename=";
			//response.setHeader("Content-Type", "application/octet-stream; charset=utf-8");
			//response.setHeader("Content-Type", "doesn/matter; charset=utf-8");
			//response.setContentType("application/octet-stream;charset=UTF-8");
			//response.setHeader("Content-Type", "doesn/matter; charset=utf-8");
		}else {
		
			throw new IOException("Not supported browser");
		}
//System.out.println("\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n");
//System.out.println("----------------------------------------------------------------------------------------------------------------------------------------------------------------");
//System.out.println("----------------------------------------browser : "+browser+"-------------------------------------------------------------------------------------------------------");
//System.out.println("----------------------------------------encodedFilename : "+encodedFilename+"-------------------------------------------------------------------------------------------------------");
//System.out.println("----------------------------------------------------------------------------------------------------------------------------------------------------------------");
//System.out.println("\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n");

		encodedFilename = encodedFilename.replaceAll("\\,", "");
		/*
		String fileType = "";
		
		if (fileType.equals("hwp")){
		  response.setContentType("application/x-hwp");
		} else if (fileType.equals("pdf")){
		  response.setContentType("application/pdf");
		} else if (fileType.equals("ppt") || fileType.equals("pptx")){
		  response.setContentType("application/vnd.ms-powerpoint");
		} else if (fileType.equals("doc") || fileType.equals("docx")){
		  response.setContentType("application/msword");
		} else if (fileType.equals("xls") || fileType.equals("xlsx")){
		  response.setContentType("application/vnd.ms-excel");
		} else {
		  response.setContentType("application/octet-stream");
		}*/
		response.setContentType("application/octet-stream");
		response.setHeader("Content-Description", "JSP Generated Data");
		response.setHeader("Content-Disposition", dispositionPrefix + encodedFilename);
		response.setHeader("Content-Transfer-Encoding", "binary");
		response.setHeader("Pragma", "no-cache;");
		response.setHeader("Expires", "-1;");
		if ("Opera".equals(browser)) {
			response.setContentType("application/octet-stream;charset=UTF-8");
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
	 * 구글 메일을 통해서 메일 발송 함수 
	 * 주의사항) 해당 구글 메일 보안 수준이 앱의 액세스가 허용됨이 되어있어야 함
	 * @param recipients					String[] 	받은 사람 메일 주소 목록 
	 * @param subject							String 	 	메일 제목
	 * @param message							String 		보낼 메세지
	 * @param from								String		보내는 사람 메일 주소
	 * @param googleId						String		구글 메일 ID
	 * @param googlePassword			String		구글 메일 password
	 * @throws MessagingException
	 */
	public static boolean postGoolgleMail(String recipients, String recipientsName, String subject, String message, String from, String name, String googleId, String googlePassword) throws MessagingException {
    boolean debug = false;
    java.security.Security.addProvider(new com.sun.net.ssl.internal.ssl.Provider());
    boolean flag = false;
    String SMTP_HOST_NAME = "gmail-smtp.l.google.com";
    //String SMTP_HOST_NAME = "mail.pknu.ac.kr";
    try{
	    // Properties 설정
	    Properties props = new Properties();
	    props.put("mail.transport.protocol", "smtp");
	    props.put("mail.smtp.starttls.enable","true");
	    props.put("mail.smtp.host", SMTP_HOST_NAME);
	    props.put("mail.smtp.auth", "true");
	
	    Authenticator auth = new SMTPAuthenticator(googleId,googlePassword);
	    Session session = Session.getInstance(props, auth);
	
	    session.setDebug(debug);
	
	    // create a message
	    MimeMessage msg = new MimeMessage(session);
	
	    // set the from and to address
	    InternetAddress addressFrom = new InternetAddress();
	    addressFrom.setAddress(from);
	    addressFrom.setPersonal(name);
	    msg.setFrom(addressFrom);
	
	    InternetAddress[] addressTo = new InternetAddress[1];
	    addressTo[0] = new InternetAddress();
	    addressTo[0].setAddress(recipients);
	    addressTo[0].setPersonal(recipientsName);
	    msg.setRecipients(Message.RecipientType.TO, addressTo);

	    // Setting the Subject and Content Type
	    msg.setSubject(subject);
	    msg.setText(message, "UTF-8");
	    msg.setHeader("content-Type", "text/html");
	    Transport.send(msg);
	    flag = true;
    }//메일 오류 관련 처리
		catch(MessagingException mex)
		{
			LOGGER.error("MessagingException {}", mex.getMessage());
			flag = false;
		}
		//예외 처리
		//catch(Exception e)			//할상 첨부된 파일들은 삭제
		//{
		//	e.printStackTrace();
		//	flag = false;
		//}
    	finally
		{
			return flag;
		}
}

	/**
	 * 구글 사용자 메일 계정 아이디/패스 정보
	 */
	public static class SMTPAuthenticator extends javax.mail.Authenticator {
		private String userName;
		private String password;
		public SMTPAuthenticator(String _userName, String _password) {
			// TODO Auto-generated constructor stub
			userName = _userName;
			password = _password;
		}
	    public PasswordAuthentication getPasswordAuthentication() {
	        return new PasswordAuthentication(userName, password);
	    }
    
	}
	
	 public static ArrayList<?> getDirList(String path) throws Exception{
			
		ArrayList<Object> arr = new ArrayList<Object>();
		FileFilter fileFilter = new FileFilter() {
			   public boolean accept(File file) {
				   return file.isDirectory();
			   }
		};  
			 
		 File file = new File(path);
		 File[] files = file.listFiles(fileFilter);
		 if (files == null){
			   return arr;
		 }else{
			  for(int i = 0;i < files.length;i++) {   
			   if(files[i].isDirectory()) {
				   arr.add(files[i].getName());
			   } 
			  }
		 }
		 return arr;
	}
	 
	 /**
     * <pre>
     * Json 타입 처리 프로세스
     * </pre>
     * 
     * @param response
     * @param jsonData
     */
	 public static void jsonProcess(HttpServletResponse response, String jsonData) {
        if (WcStringUtil.isEmpty(jsonData))
            jsonData = errorJsonStr();
        response.setContentType("text/html");
        response.setHeader("Cache-Control", "no-cache");
        response.setCharacterEncoding("UTF-8");
        PrintWriter writer = null;
        try {
            writer = response.getWriter();
            writer.write(jsonData);
        } catch (IOException e) {
            LOGGER.error("jsonProcess IOException {}", e.getMessage());
        }
        if (writer != null)
            writer.close();
    }
	 
	 /**
	  * <pre>
	  * Json 타입 처리 프로세스
	  * </pre>
	  * 
	  * @param response
	  * @param jsonData
	  */
	 public static void jsonProcess(HttpServletResponse response, String jsonData, String callback) {
		 if (WcStringUtil.isEmpty(jsonData))
			 jsonData = errorJsonStr();
		 response.setContentType("text/html");
		 response.setHeader("Cache-Control", "no-cache");
		 response.setCharacterEncoding("UTF-8");
		 PrintWriter writer = null;
		 try {
			 writer = response.getWriter();
			 writer.write(callback + "(" + jsonData + ")");
		 } catch (IOException e) {
	            LOGGER.error("jsonProcess IOException {}", e.getMessage());
		 }
		 if (writer != null)
			 writer.close();
	 }
    
	public static String errorJsonStr() {
        JSONObject jsonObj = new JSONObject();
        jsonObj.put("message", "오류");
        jsonObj.put("result", "N");

        return jsonObj.toJSONString();
    }
	 
	public static String jsonMessage(int cnt){
		String message = "";
		String resultStr = "";
		if(cnt > 0){
			message = "처리되었습니다.";
			resultStr = "Y";
		}else{
			message = "처리에 실패하였습니다.";
			resultStr = "N";
		}
		
		return jsonMessage(message, resultStr);
	}
	
	public static String jsonMessage(String message, String resultStr){
		
		JSONObject jsonObj = new JSONObject();
		jsonObj.put("message", message);
		jsonObj.put("result", resultStr);
		
		return jsonObj.toJSONString();
	}
	
	public static String getJsonData(String jsonData, String col) throws ParseException{
		JSONParser jsonParser = new JSONParser();
        JSONObject jsonObj = (JSONObject) jsonParser.parse(jsonData);
        
		return WcStringUtil.nullConvert(jsonObj.get(col));
	}
	

	/**
     * <p>XXX - XX - XXXXX 형식의 사업자번호 앞,중간, 뒤 문자열 3개 입력 받아 유효한 사업자번호인지 검사.</p>
     *
     *
     * @param   3자리 사업자앞번호 문자열 , 2자리 사업자중간번호 문자열, 5자리 사업자뒷번호 문자열
     * @return  유효한 사업자번호인지 여부 (True/False)
     */
	public static boolean checkCompNumber(String comp1, String comp2, String comp3) {

		String compNumber = comp1 + comp2 + comp3;

		int hap = 0;
		int temp = 0;
		int check[] = {1,3,7,1,3,7,1,3,5};  //사업자번호 유효성 체크 필요한 수

		if(compNumber.length() != 10)    //사업자번호의 길이가 맞는지를 확인한다.
			return false;

		for(int i=0; i < 9; i++){
			if(compNumber.charAt(i) < '0' || compNumber.charAt(i) > '9')  //숫자가 아닌 값이 들어왔는지를 확인한다.
				return false;

			hap = hap + (Character.getNumericValue(compNumber.charAt(i)) * check[temp]); //검증식 적용
			temp++;
		}

		hap += (Character.getNumericValue(compNumber.charAt(8))*5)/10;

		if ((10 - (hap%10))%10 == Character.getNumericValue(compNumber.charAt(9))) //마지막 유효숫자와 검증식을 통한 값의 비교
			return true;
		else
			return false;
 	}
	
	/**
     * <p>XXX - XXX- XXXX 형식의 전화번호 앞, 중간, 뒤 문자열 3개 입력 받아 유요한 전화번호형식인지 검사.</p>
     * 
     * 
     * @param   전화번호 문자열( 3개 )
     * @return  유효한 전화번호 형식인지 여부 (True/False)
     */
    public static boolean checkFormatTell(String tell1, String tell2, String tell3) {
		 
	 String[] check = {"02", "031", "032", "033", "041", "042", "043", "051", "052", "053", "054", "055", "061", 
				 "062", "063", "070", "080", "0505"};	//존재하는 국번 데이터
	 String temp = tell1 + tell2 + tell3;
		 
	 for(int i=0; i < temp.length(); i++){
    		if (temp.charAt(i) < '0' || temp.charAt(i) > '9')	
    			return false;    		
	 }	//숫자가 아닌 값이 들어왔는지를 확인
 		 
	 for(int i = 0; i < check.length; i++){
		 if(tell1.equals(check[i])) break;			 
		 if(i == check.length - 1) return false;
	 }	//국번입력이 제대로 되었는지를 확인
		 
	 if(tell2.charAt(0) == '0') return false; 
		
	 if("02".equals(tell1)){
		 if(tell2.length() != 3 && tell2.length() !=4) return false;
		 if(tell3.length() != 4) return false;	//서울지역(02)국번 입력때의 전화 번호 형식유효성 체크			 
	 }else{
		 if(tell2.length() != 3) return false;
		 if(tell3.length() != 4) return false;
	 }	//서울을 제외한 지역(국번 입력때의 전화 번호 형식유효성 체크	 
	 
	 return true;
    }
    
    /**
     * <p>XXX - XXX- XXXX 형식의 전화번호 하나를 입력 받아 유요한 전화번호형식인지 검사.</p>
     * 
     * 
     * @param   전화번호 문자열 (1개)
     * @return  유효한 전화번호 형식인지 여부 (True/False)
     */
    public static boolean checkFormatTell(String tellNumber) {
	 
	 String temp1;
	 String temp2;
	 String temp3;
	 String tell = tellNumber;
	 
	 tell = tell.replace("-", "");	
	 
	 if(tell.length() < 9 || tell.length() > 11  || tell.charAt(0) != '0') return false;	//전화번호 길이에 대한 체크
		 
	 if(tell.charAt(1) =='2'){	//서울지역 (02)국번의 경우일때
		 temp1 = tell.substring(0,2);
		 if(tell.length() == 9){
			 temp2 = tell.substring(2,5);
			 temp3 = tell.substring(5,9);
		 }else if(tell.length() == 10){
			 temp2 = tell.substring(2,6);
			 temp3 = tell.substring(6,10);
		 }else
			 return false;	
	 } else if(tell.substring(0,4).equals("0505")){ //평생번호(0505)국번의 경우일때
		 if(tell.length() != 11) return false;
		 temp1 = tell.substring(0,4);
		 temp2 = tell.substring(4,7);
		 temp3 = tell.substring(7,11);
	 } else {	// 서울지역 및 "0505" 를 제외한 일반적인 경우일때
		 if(tell.length() != 10) return false;
		 temp1 = tell.substring(0,3);
		 temp2 = tell.substring(3,6);
		 temp3 = tell.substring(6,10); 
	 }
		 		 
	 return checkFormatTell(temp1, temp2, temp3);
    }
    
    /**
     * <p>XXX - XXX- XXXX 형식의 휴대폰번호 앞, 중간, 뒤 문자열 3개 입력 받아 유요한 휴대폰번호형식인지 검사.</p>
     * 
     * 
     * @param   휴대폰번호 문자열,(3개)
     * @return  유효한 휴대폰번호 형식인지 여부 (True/False)
     */
    public static boolean checkFormatCell(String cell1, String cell2, String cell3) {
	 String[] check = {"010", "011", "016", "017", "018", "019"}; //유효한 휴대폰 첫자리 번호 데이터
	 String temp = cell1 + cell2 + cell3;
	 
	 for(int i=0; i < temp.length(); i++){
    		if (temp.charAt(i) < '0' || temp.charAt(i) > '9') 
    			return false;    		
         }	//숫자가 아닌 값이 들어왔는지를 확인
	 		 
	 for(int i = 0; i < check.length; i++){
	     if(cell1.equals(check[i])) break;			 
	     if(i == check.length - 1) return false;
	 }	// 휴대폰 첫자리 번호입력의 유효성 체크
		 
	 if(cell2.charAt(0) == '0') return false;
		
	 if(cell2.length() != 3 && cell2.length() !=4) return false;
	 if(cell3.length() != 4) return false;
				 
	 return true;
    }
	 
    /**
     * <p>XXXXXXXXXX 형식의 휴대폰번호 문자열 3개 입력 받아 유요한 휴대폰번호형식인지 검사.</p>
     * 
     * 
     * @param   휴대폰번호 문자열(1개)
     * @return  유효한 휴대폰번호 형식인지 여부 (True/False)
     */
    public static boolean checkFormatCell(String cellNumber) {
		 
	 String temp1;
	 String temp2;
	 String temp3;
	
	 String cell = cellNumber;
	 cell = cell.replace("-", "");		
	 
	 if(cell.length() < 10 || cell.length() > 11  || cell.charAt(0) != '0') return false;
	 
	 if(cell.length() == 10){	//전체 10자리 휴대폰 번호일 경우
		 temp1 = cell.substring(0,3);
		 temp2 = cell.substring(3,6);
		 temp3 = cell.substring(6,10);
	 }else{		//전체 11자리 휴대폰 번호일 경우
		 temp1 = cell.substring(0,3);
		 temp2 = cell.substring(3,7);
		 temp3 = cell.substring(7,11);
	 }
		 
	 return checkFormatCell(temp1, temp2, temp3);
    }
    
    /**
     * <p> 이메일의  앞, 뒤 문자열 2개 입력 받아 유요한 이메일형식인지 검사.</p>
     * 
     * 
     * @param   이메일 문자열 (2개)
     * @return  유효한 이메일 형식인지 여부 (True/False)
     */
    public static boolean checkFormatMail(String mail1, String mail2) {
		 
	 int count = 0;
		 
	 for(int i = 0; i < mail1.length(); i++){
		 if(mail1.charAt(i) <= 'z' && mail1.charAt(i) >= 'a') continue;		
		 else if(mail1.charAt(i) <= 'Z' && mail1.charAt(i) >= 'A') continue;	
		 else if(mail1.charAt(i) <= '9' && mail1.charAt(i) >= '0') continue;	
		 else if(mail1.charAt(i) == '-' && mail1.charAt(i) == '_') continue;	
		 else return false;
	 }	// 유효한 문자, 숫자인지 체크
		 		 		 
	 for(int i = 0; i < mail2.length(); i++){	
		 if(mail2.charAt(i) <= 'z' && mail2.charAt(i) >= 'a') continue;
		 else if(mail2.charAt(i) == '.'){ count++;  continue;}
		 else return false;
	 }	// 메일 주소의 형식 체크(XXX.XXX 형태)		
		 
	 if(count == 1) return true;
	 else  return false;	 
		 
    }
	
    /**
     * <p> 이메일의 전체문자열 1개 입력 받아 유요한 이메일형식인지 검사.</p>
     * 
     * 
     * @param   이메일 문자열 (1개)
     * @return  유효한 이메일 형식인지 여부 (True/False)
     */
    public static boolean checkFormatMail(String mail) {
		 
	 String[] temp = mail.split("@");	// '@' 를 기점으로 앞, 뒤 문자열 구분
	 
	 if(temp.length == 2) return checkFormatMail(temp[0], temp[1]);
	 else return false;
    }
	
	/**
	 * XSS 공격 방지 메소드
	 * @param value
	 * @return
	 */
	public static String cleanXSS(String value)
	{
		if(value == null)return null;
		//You'll need to remove the spaces from the html entities below         
		
		  value = value.replaceAll("<", "&lt;").replaceAll(">", "&gt;");         
		  
		  value = value.replaceAll("\\(", "&#40;").replaceAll("\\)", "&#41;");         
		  
		  value = value.replaceAll("'", "&#39;");        
		  
		  value = value.replaceAll("eval\\((.*)\\)", "");         
		  
		  value = value.replaceAll("[\\\"\\\'][\\s]*javascript:(.*)[\\\"\\\']", "\"\"");         
		  
		  value = value.replaceAll("script", "");       
		  
		  return value;    
	}

	/**
	 * 현재(한국기준) 날짜정보를 얻는다.                     <BR>
	 * 표기법은 yyyy-mm-dd                                  <BR>
	 * @return  String      yyyymmdd형태의 현재 한국시간.   <BR>
	 */
	public static String getCurrentDate(String dateType) {
		Calendar aCalendar = Calendar.getInstance();

		int year = aCalendar.get(Calendar.YEAR);
		int month = aCalendar.get(Calendar.MONTH) + 1;
		int date = aCalendar.get(Calendar.DATE);
		String strDate = Integer.toString(year) 
				+ ((month < 10) ? "0" + Integer.toString(month) : Integer.toString(month))
				+ ((date < 10) ? "0" + Integer.toString(date) : Integer.toString(date));
		 
		if (!"".equals(dateType)) {
		
			strDate = convertDate(strDate, "0000", dateType);
		}
		return strDate;
	}

	/**
	 * 날짜형태의 String의 날짜 포맷만을 변경해 주는 메서드
	 * @param sDate 날짜
	 * @param sTime 시간
	 * @param sFormatStr 포멧 스트링 문자열
	 * @return 지정한 날짜/시간을 지정한 포맷으로 출력
	 * @See Letter  Date or Time Component  Presentation  Examples
	           G  Era designator  Text  AD
	           y  Year  Year  1996; 96
	           M  Month in year  Month  July; Jul; 07
	           w  Week in year  Number  27
	           W  Week in month  Number  2
	           D  Day in year  Number  189
	           d  Day in month  Number  10
	           F  Day of week in month  Number  2
	           E  Day in week  Text  Tuesday; Tue
	           a  Am/pm marker  Text  PM
	           H  Hour in day (0-23)  Number  0
	           k  Hour in day (1-24)  Number  24
	           K  Hour in am/pm (0-11)  Number  0
	           h  Hour in am/pm (1-12)  Number  12
	           m  Minute in hour  Number  30
	           s  Second in minute  Number  55
	           S  Millisecond  Number  978
	           z  Time zone  General time zone  Pacific Standard Time; PST; GMT-08:00
	           Z  Time zone  RFC 822 time zone  -0800

	           Date and Time Pattern  Result
	           "yyyy.MM.dd G 'at' HH:mm:ss z"  2001.07.04 AD at 12:08:56 PDT
	           "EEE, MMM d, ''yy"  Wed, Jul 4, '01
	           "h:mm a"  12:08 PM
	           "hh 'o''clock' a, zzzz"  12 o'clock PM, Pacific Daylight Time
	           "K:mm a, z"  0:08 PM, PDT
	           "yyyyy.MMMMM.dd GGG hh:mm aaa"  02001.July.04 AD 12:08 PM
	           "EEE, d MMM yyyy HH:mm:ss Z"  Wed, 4 Jul 2001 12:08:56 -0700
	           "yyMMddHHmmssZ"  010704120856-0700

	 */
	public static String convertDate(String sDate, String sTime, String sFormatStr) {
		String dateStr = validChkDate(sDate);
		String timeStr = validChkTime(sTime);

		Calendar cal = null;
		cal = Calendar.getInstance();

		cal.set(Calendar.YEAR, Integer.parseInt(dateStr.substring(0, 4)));
		cal.set(Calendar.MONTH, Integer.parseInt(dateStr.substring(4, 6)) - 1);
		cal.set(Calendar.DAY_OF_MONTH, Integer.parseInt(dateStr.substring(6, 8)));
		cal.set(Calendar.HOUR_OF_DAY, Integer.parseInt(timeStr.substring(0, 2)));
		cal.set(Calendar.MINUTE, Integer.parseInt(timeStr.substring(2, 4)));

		SimpleDateFormat sdf = new SimpleDateFormat(sFormatStr, Locale.ENGLISH);

		return sdf.format(cal.getTime());
	}

	/**
	 * 입력된 일자 문자열을 확인하고 8자리로 리턴
	 * @param sDate
	 * @return
	 */
	public static String validChkDate(String dateStr) {
		if (dateStr == null || !(dateStr.trim().length() == 8 || dateStr.trim().length() == 10)) {
			throw new IllegalArgumentException("Invalid date format: " + dateStr);
		}
				
		if (dateStr.length() == 10) {
			return EgovStringUtil.removeMinusChar(dateStr);
		}
		
		return dateStr;
	}

	/**
	 * 입력된 일자 문자열을 확인하고 8자리로 리턴
	 * @param sDate
	 * @return
	 */
	public static String validChkTime(String timeStr) {
		if (timeStr == null || !(timeStr.trim().length() == 4)) {
			throw new IllegalArgumentException("Invalid time format: " + timeStr);
		}
		
		if (timeStr.length() == 5) {
			timeStr = EgovStringUtil.remove(timeStr, ':');
		}

		return timeStr;
	}
	
	/**
    * 동일한 파일명의 파일이 존재하는지 확인하여 존재한다면 파일명 뒤에 "_숫자" 를 
    * 붙이고 "_숫자"가 존재한다면 "_숫자" +1 을 더한값을 재귀적으로 카운트
    * */
	public static String appendSuffixName(String orgFileName, int seq) {
        String retFileName = "";
        // 파일이 존재하는지 확인한다.
        if (new File(orgFileName).exists()) {
            int plusSeq = 1;
 
            String seqStr = "_" + seq;
            String firstFileName = orgFileName.substring(0,
                    orgFileName.lastIndexOf("."));
            String extName = orgFileName
                    .substring(orgFileName.lastIndexOf("."));
 
            // 만약 파일명에 _숫자가 들어간경우라면..
            if (orgFileName.lastIndexOf("_") != -1
                    && !firstFileName.endsWith("_")) {
            	
                String numStr = orgFileName.substring(
                        orgFileName.lastIndexOf("_") + 1,
                        orgFileName.lastIndexOf(extName));
                try {
                    plusSeq = Integer.parseInt(numStr);
                    plusSeq = plusSeq + 1;
                    
                    retFileName = firstFileName.substring(0,
                            firstFileName.lastIndexOf("_"))
                            + "_" + plusSeq + extName;
                } catch (NumberFormatException e) {
                    retFileName = firstFileName + seqStr + extName;
                    return appendSuffixName(retFileName, ++plusSeq);
                }
                
            } else {
                retFileName = firstFileName + seqStr + extName;
            }
            // 재귀
            return appendSuffixName(retFileName, ++plusSeq);
        } else {
            return orgFileName;
        }
    }
	
	public static boolean  chkDt(String checkDate){

		try{
	         SimpleDateFormat  dateFormat = new  SimpleDateFormat("yyyy-MM-dd");

	         dateFormat.setLenient(false);
	         dateFormat.parse(checkDate);
	         return  true;

	    }catch (java.text.ParseException  e){
	         return  false;
	    }

	}

}
