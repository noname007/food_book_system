<?php


class httpRequest{
	public static  function http_request($url,$header=array(),$setop=array(),$reduction=1){
		//post 所有的配置需要$setop传过来
		//1
		$handle = curl_init($url);

		//2
		//设置options
		$options = array(
	        //请求相关设置			
			//数据流形式返回，不返还给标准输出stdout浏览器
			CURLOPT_RETURNTRANSFER=>1,

			//自定义头信息
			CURLOPT_HTTPHEADER=>$header,
			
			//重定向相关
			CURLOPT_FOLLOWLOCATION=>1,
			CURLOPT_AUTOREFERER=>1,
			CURLOPT_MAXREDIRS=>3,
			
			//等待时间
			CURLOPT_CONNECTTIMEOUT=>7,
			//响应相关的设置
			//c
			//CURLOPT_HTTPHEADER=>0,
		);

		foreach ($setop as $key => $value) {
			$options[$key] = $value;
		}
		//var_dump($options);
			curl_setopt_array($handle,$options);
		//3
		// do{
			$response_data_stream = curl_exec($handle);
			// --$reduction;
		// }while($response_data_stream ===false && $reduction);
		//4
		curl_close($handle);
		return $response_data_stream;
	}

	public static function get_method($url,$header=array()){
		return self::http_request($url,$header);
	}

	public static function post_method($url,$post_data,$header = array()){
		$setop = array(
			CURLOPT_POST=>1,
			CURLOPT_POSTFIELDS=>$post_data
		);
		return self::http_request($url,$header,$setop);
	}
	/**
	 * [get_method_reduction_4_get_right_result 防止curl_exec 执行失败,因为网络的原因，可以让其多执行几次，以能进行网络通信]
	 * @param  [type]  $url       [description]
	 * @param  integer $reduction [description]
	 * @return [type]             [description]
	 */
	// public static function get_method_reduction_4_get_right_result($url,$reduction=1){
	// 	return self::http_request($url,array(),array(),$reduction);
	// }

}

	