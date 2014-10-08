<?php header('content-type:text/html;charset=utf-8');?>

<form action="">
	<p><span>菜名</span><input type="text" name = "food_name"></p>
	<p><span>价格</span><input type="text" name="pirce"></p>
	<input type="submit" value='sub' name='sub'>
</form>

<?php
	const DATAFILEFOLD ='./data';
	const PREFIX_FOODID = 'food_id';
	if(isset($_REQUEST['sub']))
	{
		$_REQUEST['food_id'] = time();
		unset($_REQUEST['sub']);
		insert_food_kind($_REQUEST);
	}
	show_table(read_foods(),'foods');
// const DATAFILEFOLD ='./data';
	function insert_food_kind($post_data)
	{
		// var_dump($post_data);
		$food[$post_data['food_id']] = $post_data;
		write2file(DATAFILEFOLD.'/foods.txt',json_encode($food));
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
				// echo $value.'<br/>';
				$temp = json_decode($value,1);
				// list($order) = $temp;
				// $order = each(json_decode($value,1));
				// var_dump($temp);
				// var_dump($order);
				// exit();
				$temp = each(json_decode($value,1));
				$order = $temp['value'];
				$res[$order['food_id']] = $order;
				// var_dump($res);
				// break;
				// $res[$temp[0]]= $temp[0];
				// array_push($res,json_decode($value,1));
		}
		// var_dump($res);
		
		if(empty($id)){
			return $res;
		}
		else if(isset($res['id']))
		{

			return $res[$id];
		}
		else
		{
			return false;
		}
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