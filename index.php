<?php header('content-type:text/html;charset=utf-8')?>
<form method='post'>
	<p><input type="radio" value='1' name='food_id'>酸菜盖饭</p>
 	<p> <input type="hidden" value='酸菜盖饭' name='food_name'> </p>
	<?php food_kinds(array(array('id'=>2,'name'=>"土豆丝"))) ?>
	
	<p><input type="submit" name='sub' value="提交"></p>
</form>

<?php
	// echo 1;
	print_r($_POST);
	const DATAFILEFOLD ='./data';

	if( isset($_POST['sub']))
	{
		// var_dump($_POST);
		$post = $_POST;
		unset($post['sub']);		
		save_orders($post);
		show_orders();
	}

	function food_kinds(array $foods)
	{
		foreach ($foods as $food) {
			echo '<p><input type="radio" value="'.$food['id'].'" name="food_id">'.$food['name'].'</p>';
			echo '<p> <input type="hidden" value="'.$food['name'].'" name="food_name"> </p>';
		}
	}

	function insert_food_kind($foodinfo)
	{
		write2file(DATAFILEFOLD.'/foods.txt',$foodinfo);
	}
	
	function read_foods()
	{
		$str = file_get_contents(DATAFILEFOLD.'/foods.txt');
		explode('\n', $str);
		
	}

	function save_orders($post)
	{
		$post['timestamp']=date('Y-m-d H-i-s');
		order2file(json_encode($post));
	}

	function show_orders()
	{
		$str = file_get_contents(DATAFILEFOLD.'/orders.txt');
		$json_orders = explode("\n",$str);
		//var_dump($json_orders);
		$table = '<table><caption>订单</caption>';
		foreach ($json_orders as &$value) {
			if(!empty($value) && ($data_arr = json_decode($value,1)))
			{	
				// echo '<p>'.$value."</p><br/>";
				// var_dump($data_arr);
				$table .= '<tr>';
				//print_r($data_arr);
				foreach ($data_arr as $field) {
					
					$table .= '<td>'.$field.'</td>'	;
				}

				$table .='</tr>';
			}
		}
		$table .= '</table>';
		echo $table;
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
		write2file(DATAFILEFOLD.'/orders.txt',$orderinfo);
	}

	function write2file($filename,$data)
	{
		// echo $filename;
		$handle = fopen($filename,'a+');
		fwrite($handle, $data.PHP_EOL);
		fclose($handle);
	}
