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
?>

<?php
	header('content-type:text/html;charset=utf-8'); 
	const DATAFILEFOLD ='./data';
	const PREFIX_FOODID = 'food_id';
	const PREFIX_ORDERID='orderid';
?>
<form method='post'>
	<!-- <p><input type="radio" value='1' name='food_id'>酸菜盖饭</p> -->
 	<!-- <p> <input type="hidden" value='酸菜盖饭' name='food_name'> </p> -->
	<?php food_kinds(read_foods()) ?>
	<p>姓名<input type="text" name="username" value=""></p>
	<p><input type="submit" name='sub' value="提交"></p>
</form>

<?php
	//存储传递用json ，程序操作用数组
	// echo 1;
	// print_r($_POST);
	if(isset($_REQUEST['food_id']))
	{
		// var_dump($_POST);
		$post = $_REQUEST;
		unset($post['sub']);		
		save_orders($post);
		show_orders();
		echo total_money()." RMB";
	}
	else if(isset($_REQUEST['sub']))
	{
		echo '怎么也得选一个菜吧。。。。！';
	}

	function food_kinds(array $foods)
	{
		foreach ($foods as $food) {
			echo '<p><input type="radio" value="'.$food['food_id'].'" name="food_id"> | '.$food['food_name'].' | '.$food['pirce'].' RMB</p>';
		}
	}

	function read_foods($id='')
	{
	
		$str = file_get_contents(DATAFILEFOLD.'/foods.txt');			
		// echo $str;
		$food_arr = explode("\n", $str);
		$res = array();
		foreach ($food_arr as  $value) 
		{
				if(empty($value))
				{
					continue;
				}
				$temp = json_decode($value,1);

				$temp = each(json_decode($value,1));
				$order = $temp['value'];
				$res[$order['food_id']] = $order;

		}
		// var_dump($res);
		
		if(empty($id)){
			return $res;
		}
		else if(isset($res[$id]))
		{

			return $res[$id];
		}
		else
		{
			return false;
		}
	}

	function read_orders()
	{
		$str = file_get_contents(DATAFILEFOLD.'/orders'.date('Y-m-d').'.txt');
		$json_format_orders = explode("\n",$str);

		foreach ($json_format_orders as $order_json_format) {		
			if($order_json_format)
				$data_arr[] = json_decode($order_json_format,1);
		}

		return $data_arr;
		// show_table($data_arr);
	}

	function save_orders($post)
	{
		date_default_timezone_set('PRC');
		$post['timestamp']=date('Y-m-d H:i:s');
		$orderid = mt_rand(0,10000).time($post['timestamp']);
		// echo $post['food_id'];
		$tem = (read_foods($post['food_id']));
		// echo $tem['pirce'];
		$post['pirce'] = $tem['pirce'];
		$post['food_name'] = $tem['food_name'];
		$post['order_id'] = PREFIX_ORDERID.$orderid;
		// $post['ip']=$_SERVER['IP']
		order2file(json_encode($post));
	}

	function show_orders()
	{
		$orders = read_orders();
		// var_dump($orders);
		foreach ($orders as &$order) {
			if(empty($order['username']))
			{
				$order['username'] = '无名氏';
			}
			unset($order['food_id']);
			unset($order['order_id']);
		}
		// var_dump()
		show_table($orders,'订单');
	
		//var_dump($json_orders);
		// $table = '<table><caption>订单</caption>';
		// foreach ($json_orders as &$value) {
		// 	if(!empty($value) && ($data_arr = json_decode($value,1)))
		// 	{	
		// 		// echo '<p>'.$value."</p><br/>";
		// 		// var_dump($data_arr);
		// 		$table .= '<tr>';
		// 		//print_r($data_arr);
		// 		foreach ($data_arr as $field) {
					
		// 			$table .= '<td>'.$field.'</td>'	;
		// 		}

		// 		$table .='</tr>';
		// 	}
		// }
		// $table .= '</table>';
		// echo $table;
	}
	function total_money()
	{
		$sum = 0;
		$orders = read_orders();
		foreach ($orders as & $value) {
			$sum += $value['pirce'];
		}
		return $sum;
	}
	// function insert_food_kind(array $food)
	// {

	// }

	

	// function ()
	// {
	// 	// fopen($file,'a+');
	// 	// , length)
		
	// }
	// 
	//json格式存储数据
	

	function order2file($orderinfo)
	{
		write2file(DATAFILEFOLD.'/orders'.date('Y-m-d').'.txt',$orderinfo);
	}

	function write2file($filename,$data)
	{
		// echo $filename;
		$handle = fopen($filename,'a+');
		fwrite($handle, $data.PHP_EOL);
		fclose($handle);
	}

	function show_table($data,$name,$field_name='')
	{
		// var_dump($data);
		$table = '<hr/><table><caption>订单</caption>';
		
		if(is_array($field_name))
		{
			foreach($field_name as $value)
			{
				$table .= '<td>'.$value.'</td>';
			}
		}

		
		foreach ($data as $value) {
	
			$table .= '<tr>';

			foreach ($value as $field) {
				$table .= '<td>'.$field.'</td>'	;
			}

			$table .='</tr>';
		}

		$table .= '</table>';
		
		echo $table;
	}
	
