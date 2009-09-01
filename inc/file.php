<?php
if(!defined('WEBSITE')){die();}
/*=====================================
  HERA v.2.0 Beta                      
  File: inc/file.php                   
  fetch the contents of a page         
=====================================*/

class File {

var $host =	"www.sidar.nsn"; // host name
var $port = 80; // port
var $error = ""; // error messages
var $response_code = ""; // response code returned from server
var $status = 0; // http request status
var $_redirectaddr = false; // will be set if page fetched is a redirect
var $lastredirectaddr = ""; // contains address of last redirected address
var $passcookies = true; // pass set cookies back through redirects
var $cookies = array(); // array of cookies to pass
var $_httpmethod = "GET"; // default http request method
var $_httpversion = "HTTP/1.0"; // default http request version
var $rawheaders = array(); // array of raw headers to send
var $accept = "text/html, application/xml, application/xhtml+xml";
var $referer = ""; // referer info to pass
var $_mime_boundary = ""; // MIME boundary for multipart/form-data submit type
var $headers = array(); // headers returned from server
var $results = ""; // content
var $uri_real = ""; // corrected URI
var $meta_redirect = ""; // redirect meta tag found

	function File($url_tmp, $ser = "Hera 2.0") {
		global $lang;
		
		// Alteração VVB - 22/10/2008
		//echo $url_tmp;
		SESSION_START();
		$url_metric = $url_tmp;
		$_SESSION['url_metric']=$url_metric;
		// ----------------------------------------- end VVB
		
		if (($url_tmp == "") || ($url_tmp == "http://")) {
			$this->error = $lang['falta_url'];
			return false;
		} else {
			$parse = parse_url($url_tmp);
			if ($parse['scheme']) {
				if (strtolower($parse['scheme']) != 'http') {
					$this->error = sprintf($lang['scheme_no'], $parse['scheme']);
					return;
				} else {
					$this->uri_real = $url_tmp;
				}
			} else if (!$parse['scheme']) {
				$this->uri_real = 'http://'.$url_tmp;
			}
			if (strtolower($parse['host']) == 'localhost') {
				$this->error = 'Sólo se admiten páginas remotas';
				return false;
			}
		}
		$this->agent = $ser;
		if (!defined(SOFT)) {
			define ('SOFT', $this->agent);
		}
	} // Fin constructor clase


/*============================================
	Function: fetch the contents of a page     
============================================*/

	function fetch($URI, $BASE, $OPT){

		$URI_PARTS = parse_url($URI);
		if (empty($URI_PARTS["query"])) {
			$URI_PARTS["query"] = '';
		}
		$this->host = $URI_PARTS["host"];
		if (!empty($URI_PARTS["port"])) {
			$this->port = $URI_PARTS["port"];
		}
		if ($this->_connect($fp)) {
			$path = $URI_PARTS["path"].($URI_PARTS["query"] ? "?".$URI_PARTS["query"] : "");
			$this->_httprequest($path, $fp, $URI, $this->_httpmethod);
			fclose($fp);

			if ($this->_redirectaddr) {
				/* follow the redirect */
				$this->lastredirectaddr=$this->_redirectaddr;
				$this->fetch($this->_redirectaddr);
			}
		} else {
			return false;
		}
		if ($BASE == 'base') {
			// Definir URI y obtener la URI de base
			if ($this->lastredirectaddr != '') {
				//$this->uri_real = $this->lastredirectaddr;
				define ('URL', $this->lastredirectaddr);
			} else {
				//$this->uri_real = $URI;
				define ('URL', $URI);
			}
			$this->Parse_URI(URL);
		}
		if ($OPT == 'arry') {
			$this->File_array();
		}
		return true;
	}


/*=====================================
	Function: make a socket connection   =====================================*/

	function _connect(&$fp) {
		$this->status = 0;
		if ($fp = @fsockopen($this->host, $this->port, $errno, $errstr, 30)) {
			// socket connection OK
			return true;
		} else {
			// socket connection FAIL
			$this->status = $errno;
			return false;
		}
	}

/*===============================================
	Function: get the http data from the server   
===============================================*/

	function _httprequest($url, $fp, $URI, $http_method, $content_type="", $body="") {
		$cookie_headers = '';
		if($this->passcookies && $this->_redirectaddr) {
			for($x=0; $x<count($this->headers); $x++) {
				if (preg_match('/^set-cookie:[\s]+([^=]+)=([^;]+)/i', $this->headers[$x],$match)) {
					$this->cookies[$match[1]] = urldecode($match[2]);
				}
			}
		}

		$URI_PARTS = parse_url($URI);
		if(empty($url)) {
			$url = "/";
		}
		$headers = $http_method." ".$url." ".$this->_httpversion."\r\n";
		if(!empty($this->agent)) {
			$headers .= "User-Agent: ".$this->agent."\r\n";
		}
		if(!empty($this->host) && !isset($this->rawheaders['Host'])) {
			$headers .= "Host: ".$this->host."\r\n";
		}
		if(!empty($this->accept)) {
			$headers .= "Accept: ".$this->accept."\r\n";
		}
		if(!empty($this->referer)) {
			$headers .= "Referer: ".$this->referer."\r\n";
		}
		if(!empty($this->cookies)) {
			if(!is_array($this->cookies)) {
				$this->cookies = (array)$this->cookies;
			}
			reset($this->cookies);
			if ( count($this->cookies) > 0 ) {
				$cookie_headers .= 'Cookie: ';
				foreach ( $this->cookies as $cookieKey => $cookieVal ) {
					$cookie_headers .= $cookieKey."=".urlencode($cookieVal)."; ";
				}
				$headers .= substr($cookie_headers,0,-2) . "\r\n";
			} 
		}
		if(!empty($this->rawheaders)) {
			if(!is_array($this->rawheaders)) {
				$this->rawheaders = (array)$this->rawheaders;
			}
			while(list($headerKey,$headerVal) = each($this->rawheaders)) {
				$headers .= $headerKey.": ".$headerVal."\r\n";
			}
		}
		if(!empty($content_type)) {
			$headers .= "Content-type: $content_type";
			if ($content_type == "multipart/form-data") {
				$headers .= "; boundary=".$this->_mime_boundary;
			}
			$headers .= "\r\n";
		}
		if(!empty($body))	{
			$headers .= "Content-length: ".strlen($body)."\r\n";
		}

		$headers .= "\r\n";

		fwrite($fp,$headers.$body,strlen($headers.$body));
		
		$this->_redirectaddr = false;
		unset($this->headers);

		while ($currentHeader = fgets($fp,4096)) {
			if($currentHeader == "\r\n") {
				break;
			}
			if (preg_match("/^Content-Type:\s*(.*)$/im",$currentHeader,$tmp)) {
				if (!stristr($tmp[1],'html') && !stristr($tmp[1],'xml')) {
					return false;
				}
			}
			// if a header begins with Location: or URI:, set the redirect
			if (preg_match("/^(Location:|URI:)/i",$currentHeader)) {
				// get URL portion of the redirect
				preg_match("/^(Location:|URI:)[ ]+(.*)/i", chop($currentHeader), $matches);
				// look for :// in the Location header to see if hostname is included
				if (!preg_match("|\:\/\/|",$matches[2])) {
					// no host in the path, so prepend
					$this->_redirectaddr = $URI_PARTS["scheme"]."://".$this->host.":".$this->port;
					// eliminate double slash
					if (!preg_match("|^/|",$matches[2])) {
							$this->_redirectaddr .= "/".$matches[2];
					} else {
							$this->_redirectaddr .= $matches[2];
					}
				} else {
					$this->_redirectaddr = $matches[2];
				}
			}
		
			if (preg_match("|^HTTP/|",$currentHeader)) {
				if (preg_match("|^HTTP/[^\s]*\s(.*?)\s|",$currentHeader, $status)) {
					$this->status= $status[1];
				}
				$this->response_code = $currentHeader;
			}
			$this->headers[] = $currentHeader;
		}

		$results = '';
		do {
    		$_data = fread($fp, 500000);
    		if (strlen($_data) == 0) {
        		break;
    		}
    		$results .= $_data;
		} while(true);

		// check if there is a a redirect meta tag
		if (preg_match("'<meta[\s]*http-equiv[\s]*=[\s]*[\"\']?refresh'i", $results)) {
			preg_match("'content[\s]*=[\s]*[\"\']?(\d+);[\s]*URL[\s]*=[\s]*([^\"\']*?)[\"\']?>'i", $results, $match);
			if ($match[1] == 0) {
				$this->meta_redirect = $URI;
				if (!preg_match("|\:\/\/|",$match[2])) {
					// no host in the path, so prepend
					$this->_redirectaddr = $URI_PARTS["scheme"]."://".$this->host.":".$this->port;
					// eliminate double slash
					if (!preg_match("|^/|",$match[2])) {
						$this->_redirectaddr .= "/".$match[2];
					} else {
						$this->_redirectaddr .= $match[2];
					}
				} else {
					$this->_redirectaddr = $match[2];
				}
			}
		}

		$this->results = $results;
		return true;
	}

/*=======================================
	Función: Analiza una URI y devuelve   
	$url y $url_base                      
=======================================*/

	function Parse_URI($uri) {

		$parse = parse_url($uri);
		$url_b = strtolower($parse['scheme'])."://";
		$url_b .= $parse['host'] ? $parse['host'] : '';
		$url_b .= $parse['port'] ? ':'.$parse['port'] : '';

		if (isset($parse['path'])) {
			if((ereg("\.",$parse['path'])) || ($parse['query']) || ($parse['fragment']) || (substr($uri,-1) != "/")) {
				$separa = explode("/",$parse['path']);
				$sacar = array_pop($separa);
				$parse['path'] = rtrim($parse['path'],$sacar);
				$url_b .= $parse['path'];
			} else {
				$url_b .= $parse['path'];
			}
		}
		if(substr($url_b,-1) != "/") {
			$url_b .= "/";
		}
		define ('URL_BASE', $url_b);
	} // Fin función Parse_URI


	function File_array() {
		global $tags, $contents;

		$search = array (
		"@(<script[^>]*>)(.*)(</script>)@ismUe",
		"@(<style[^>]*>)(.*)(</style>)@ismUe",
		"@<!--[\s\S]*-->@mU" );
		$replace = array (
		"stripslashes('\\1').stripslashes(htmlspecialchars('\\2')).'\\3'",
		"stripslashes('\\1').stripslashes(htmlspecialchars('\\2')).'\\3'",
		"" );
		
		$fp = preg_replace($search,$replace,$this->results);
		preg_match_all("@(<[^>]+>)([^<]*)@m", $fp, $out, PREG_PATTERN_ORDER);

		$s_tag = array ("@\n+@", "@\s\s+@", "@\s*=\s*@");
		$r_tag = array (" ", " ", "=");
		for ($i=0; $i < count($out[0]); $i++) {
			$tag_tmp = preg_replace($s_tag, $r_tag, $out[1][$i]);
			$tags[$i] = $tag_tmp;
			$cont_tmp = trim($out[2][$i]);
			if (!preg_match("@<(style|script)@", $tag_tmp)) {
				$cont_tmp = preg_replace("@\n+@", "\n", $cont_tmp);
			}
			$contents[$i] = trim($cont_tmp);
		}
}

}
?>