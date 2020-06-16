<?php
// +----------------------------------------------------------------------
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://jizhihuwai.com All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: @zhiwei
// +----------------------------------------------------------------------
namespace Org\Util;
class QQConnect {

    private function get_access_token($appkey, $appsecretkey, $code, $callback, $state) {
        if($state == $_SESSION['state']) {
            $url = "https://graph.qq.com/oauth2.0/token";
            $param = array(
                "grant_type"    =>    "authorization_code",
                "client_id"     =>    $appkey,
                "client_secret" =>    $appsecretkey,
                "code"          =>    $code,
                "state"         =>    $state,
                "redirect_uri"  =>    $callback
            );

            $response = $this->get($url, $param);
            if($response == false) {
                return false;
            }
            $params = array();
            parse_str($response, $params);
            return $params["access_token"];
        } else {
            exit("The state does not match. You may be a victim of CSRF.");
        }
    }

    private function get_openid($access_token) {
        $url = "https://graph.qq.com/oauth2.0/me"; 
        $param = array(
            "access_token"    => $access_token
        );

        $response  = $this->get($url, $param);
        if($response == false) {
            return false;
        }
        if (strpos($response, "callback") !== false) {
            $lpos = strpos($response, "(");
            $rpos = strrpos($response, ")");
            $response  = substr($response, $lpos + 1, $rpos - $lpos -1);
        }

        $user = json_decode($response);
        if (isset($user->error) || $user->openid == "") {
            return false;
        }
        return $user->openid;
    }

    public function get_user_info($token, $openid, $appkey, $format = "json") {
        $url = "https://graph.qq.com/user/get_user_info";
        $param = array(
            "access_token"      =>    $token,
            "oauth_consumer_key"=>    $appkey,
            "openid"            =>    $openid,
            "format"            =>    $format
        );

        $response = $this->get($url, $param);
        if($response == false) {
            return false;
        }

        $user = json_decode($response, true);
        return $user;
    }

    public function login($appkey, $callback, $scope='') {
        $_SESSION['state'] = md5(uniqid(rand(), TRUE)); //CSRF protection
        $login_url = "https://graph.qq.com/oauth2.0/authorize?response_type=code&client_id=" 
            . $appkey . "&redirect_uri=" . urlencode($callback)
            . "&state=" . $_SESSION['state']
            . "&scope=".$scope;
        redirect($login_url);
    }

    public function callback($appkey, $appsecretkey, $callback) {
        $code = $_GET['code'];
        $state = $_SESSION['state'];

        $token = $this->get_access_token($appkey, $appsecretkey, $code, $callback, $state);
        $openid = $this->get_openid($token);
        if(!$token || !$openid) {
            exit('get token or openid error!');
        }

        return array('openid' => $openid, 'token' => $token);
    }
    
    /*
     * HTTP GET Request
    */
    private function get($url, $param = null) {
    	if($param != null) {
    		$query = http_build_query($param);
    		$url = $url . '?' . $query;
    	}
    	$ch = curl_init();
    	if(stripos($url, "https://") !== false){
    		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    	}
    
    	curl_setopt($ch, CURLOPT_URL, $url);
    	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1 );
    	$content = curl_exec($ch);
    	$status = curl_getinfo($ch);
    	curl_close($ch);
    	if(intval($status["http_code"]) == 200) {
    		return $content;
    	}else{
    		echo $status["http_code"];
    		return false;
    	}
    }
    
    /*
     * HTTP POST Request
    */
    private function post($url, $params) {
    	$ch = curl_init();
    	if(stripos($url, "https://") !== false) {
    		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    	}
    
    	curl_setopt($ch, CURLOPT_URL, $url);
    	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1 );
    	curl_setopt($ch, CURLOPT_POST, true);
    	curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
    	$content = curl_exec($ch);
    	$status = curl_getinfo($ch);
    	curl_close($ch);
    	if(intval($status["http_code"]) == 200) {
    		return $content;
    	} else {
    		echo $status["http_code"];
    		return false;
    	}
    }
    
    private function http_build_query_multi($params, $boundary) {
    	if (!$params) return '';
    
    	uksort($params, 'strcmp');
    
    	$MPboundary = '--'.$boundary;
    	$endMPboundary = $MPboundary. '--';
    	$multipartbody = '';
    
    	foreach ($params as $parameter => $value) {
    
    		if( in_array($parameter, array('pic', 'image')) ) {
    			$content = file_get_contents( $value );
    			$filename = 'upload.jpg';
    
    			$multipartbody .= $MPboundary . "\r\n";
    			$multipartbody .= 'Content-Disposition: form-data; name="' . $parameter . '"; filename="' . $filename . '"'. "\r\n";
    			$multipartbody .= "Content-Type: image/unknown\r\n\r\n";
    			$multipartbody .= $content. "\r\n";
    		} else {
    			$multipartbody .= $MPboundary . "\r\n";
    			$multipartbody .= 'content-disposition: form-data; name="' . $parameter . "\"\r\n\r\n";
    			$multipartbody .= $value."\r\n";
    		}
    
    	}
    
    	$multipartbody .= $endMPboundary;
    	return $multipartbody;
    }

}
