<?php
	// header('Content-type:text/html;charset=utf8');
	header("Content-type:text/json;charset=utf-8");
	require_once "./httpRequest.php";
	$test_url = "http://waimai.baidu.com/waimai/shop/18062509820316987430";

	$res =  httpRequest::get_method($test_url);
	// file_put_contents('1', $res);
	// $dom = new DOMDocument;
	// if($dom->loadHTML($res))
	// {
	// 	var_dump($dom);
	// }
	// else
	// {
	// 	echo 'fail 2 load html';
	// }
	// preg_match('`<li class="list-item"[\s\S]*\s</li>`', $res,$result);
	// // preg_match_all('/(.|[u4e00-u9fa5]])*/', $res,$result);
	// file_put_contents('2', json_encode($result));
	// echo htmlspecialchars(json_encode(($result)));
	// // print_r($result);
	// $po = strpos('li class="list-item"', $res);
	// strpos('id', substr($res,$po))
	// echo substr($res,strpos('data=',substr($res,$po)),);
	

	// $res = substr($res,strpos('<section class="menu-list">',$res));
	// echo $res;

	while($data_pos =strpos($res,'<li class="list-item" data="'))
	{
		$data_pos +=strlen('<li class="list-item" data="');
		// echo $data_pos;
		// var_dump($data_pos);
	    $res = substr($res, $data_pos);
	    // echo $res."\n";
	    // substr(string, start)
	    // var_dump($res);
	    // exit ;
	    $id_pos = strpos($res,'" id');
	    // echo $id_pos;
	    // $start = ;
	    // $start = 0;
	    // echo $start,' ',$id_pos;
	    // $res =  substr($res, $start);
	    $key= substr($res, 0, $id_pos);
	    $data_src_pos = strpos($res,'data-src="')+ strlen('data-src="');
	    $src_pos = strpos($res,'" src');
	    $imgs[$key] =  substr($res, $data_src_pos, $src_pos - $data_src_pos);
	}
	foreach ($imgs as $data => $img) {
		$res= explode('$',$data);
		//var_dump($res);
	}



	// var_dump($img);
	// var_dump($data);
	// $data_title_pos = 'data-title=';
	// $data_src_pos = 'data-src=';

	class Order
	{

		private $test_url = "http://waimai.baidu.com/waimai/shop/18062509820316987430";
		
		function getData($test_url = 'http://waimai.baidu.com/waimai/shop/18062509820316987430')
		{
			$res =  httpRequest::get_method($test_url);
			return $res;
		}

		private function get_menu($res)
		{
			$result = array();
			$li_len = 0;
			$end = 0;	

			// while($)
			{
				$res = substr($res,$end + $li_len);
				$li_len = strlen('</li>');
				$begin = str_match($res,'<li class');
				if($begin!==false)
				{
					$end = str_match($res,'</li>');
					if($end!== false)
					{
						$result[] = substr($res,$begin,$end+ $li_len - $begin);
					}
					// return $end;
				}	
			}
			
		}

		private function str_match(&$res, $pattern1)
		{
			$res_len = strlen($res);
			// $pattern1 = '<li class';
			// $pattern2 = '</li>';
			$p_1 = strlen($pattern1);
			// $p_2 = strlen($pattern2);

			for($i = 0;$i < $res_len; ++$i)
			{
				for( $j = 0; $j < $p_1; ++$j)
				{
					$k = $i;
					if($res[$k]!=$p[$j])
					{
						break;	
					}
					else if($j != $p_1 -1)
					{
						$k ++;
					}
					else if($k < $res_len)
					{
						return $i;
					}
					else
					{
						return false;
					}
				}
			}
			return $i;
		}
	}