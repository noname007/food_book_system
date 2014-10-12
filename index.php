<?php
	
	require_once "./httpRequest.php";
	

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
	// preg_match_all('/^<li class(.|\n)*<\/li>$/', $res,$result);

	// var_dump($result);
	
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

			while(~$end)
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
						return -1;
					}
					else
					{
						return;
					}
				}
			}
			return -1;
		}
	}