<?php

/* by artem at zabsoft dot co dot in (from php manual) */

 class Mycurl {
     protected $cookies_filename = 'cm_cookies';
     protected $_useragent = 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1';
     protected $_url;
     protected $_followlocation;
     protected $_timeout;
     protected $_maxRedirects;
     protected $_cookie;
     protected $_post;
     protected $_postFields;
     protected $_referer ="http://www.google.com";

     protected $_session;
     protected $_webpage;
     protected $_includeHeader;
     protected $_noBody;
     protected $_status;
     protected $_last_url;
     protected $_binaryTransfer;
     public    $authentication = 0;
     public    $auth_name      = '';
     public    $auth_pass      = '';
     protected $_file          = 0;
     protected $_file_handle      = 0;

     public function useAuth($use){
       $this->authentication = 0;
       if($use == true) $this->authentication = 1;
     }

     public function setName($name){
       $this->auth_name = $name;
     }
     public function setPass($pass){
       $this->auth_pass = $pass;
     }

     public function __construct($url,$followlocation = true,$timeOut = 50,$maxRedirecs = 10,$binaryTransfer = false,$includeHeader = false,$noBody = false, $load_cookies = FALSE)
     {
         $this->_url = $url;
         $this->_followlocation = $followlocation;
         $this->_timeout = $timeOut;
         $this->_maxRedirects = $maxRedirecs;
         $this->_noBody = $noBody;
         $this->_includeHeader = $includeHeader;
         $this->_binaryTransfer = $binaryTransfer;

         $this->_cookie = '';
         if ($load_cookies) {
             $cookie = file_get_contents($this->cookies_filename);
             if ($cookie) {
                 $this->_cookie = $cookie;
             }
         }
     }

    public function setCurlHeader($includeHeader = false) {
        $this->_includeHeader = $includeHeader;
    }


     public function setHeader($boolean) {
         if ($boolean) {
             $this->_includeHeader = TRUE;
         }
         else {
             $this->_includeHeader = FALSE;
         }
     }

     public function setReferer($referer){
       $this->_referer = $referer;
     }

     public function setCookie($cookie)
     {
         $this->_cookie = $cookie;
     }

     public function setPost ($postFields)
     {
        $this->_post = true;
        $this->_postFields = $postFields;
     }
     // Modified by juraseg
     public function unsetPost() 
     {
        $this->_post = false;
     }

     public function setFile($file_handle) {
        $this->_file = TRUE;
        $this->_file_handle = $file_handle;
     }
     public function unsetFile() {
        $this->_file = FALSE;
     }

     public function setUserAgent($userAgent)
     {
         $this->_useragent = $userAgent;
     }

     public function createCurl($url = 'nul')
     {
         if($url != 'nul'){
           $this->_url = $url;
         }
		
         $s = curl_init();
		 set_time_limit(0);
         curl_setopt($s,CURLOPT_URL,$this->_url);
         curl_setopt($s,CURLOPT_HTTPHEADER,array('Expect:'));
         curl_setopt($s,CURLOPT_TIMEOUT,$this->_timeout);
         curl_setopt($s,CURLOPT_MAXREDIRS,$this->_maxRedirects);
		 curl_setopt($s,CURLOPT_SSL_VERIFYPEER, false);
		 curl_setopt($s,CURLOPT_SSL_VERIFYHOST, false);
         curl_setopt($s,CURLOPT_RETURNTRANSFER,true);
		 curl_setopt($s, CURLOPT_SSLVERSION, 3);
         curl_setopt($s,CURLOPT_FOLLOWLOCATION,$this->_followlocation);
         curl_setopt($s,CURLOPT_COOKIE,$this->_cookie);

         if($this->authentication == 1){
           curl_setopt($s, CURLOPT_USERPWD, $this->auth_name.':'.$this->auth_pass);
         }
         if($this->_post)
         {
             curl_setopt($s,CURLOPT_POST,true);
             curl_setopt($s,CURLOPT_POSTFIELDS,$this->_postFields);
         }

         if ($this->_file) {
             curl_setopt($s,CURLOPT_FILE, $this->_file_handle);
         }

         if($this->_includeHeader)
         {
             curl_setopt($s,CURLOPT_HEADER,true);
         }

         if($this->_noBody)
         {
             curl_setopt($s,CURLOPT_NOBODY,true);
         }
		
		
         /*
         if($this->_binary)
         {
             curl_setopt($s,CURLOPT_BINARYTRANSFER,true);
         }
         */
         curl_setopt($s,CURLOPT_USERAGENT,$this->_useragent);
         curl_setopt($s,CURLOPT_REFERER,$this->_referer);

         $this->_webpage = curl_exec($s);
		 if(curl_errno($s))
		{
			echo 'error:' . curl_error($s)."\r\n";
			//exit;
		}
         $this->_status = curl_getinfo($s,CURLINFO_HTTP_CODE);
         $this->_last_url = curl_getinfo($s,CURLINFO_EFFECTIVE_URL);
         curl_close($s);

         // у нас есть результат обработки файла
         $temp_result = $this->_webpage;
         // вырезаем со страницы все куки которые пришли
         preg_match_all('~Set-Cookie: ([^\r\n]*)[\r\n]~i',$temp_result,$mass);
         // собираем их в строчку для CURL
         if (!empty($mass[1])) {
             $this->_cookie = implode(" ", $mass[1]);
         }
         file_put_contents($this->cookies_filename, $this->_cookie);

     }

   public function getLastEffectiveUrl()
   {
       return $this->_last_url;
   }

   public function getHttpStatus()
   {
       return $this->_status;
   }

   public function __tostring(){
      return $this->_webpage;
   }

   public function getCookie() {
       return $this->_cookie;
   }
}
