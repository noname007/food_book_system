<?php
	header("Content-type:text/html;charset=utf-8");
	require_once "./CMenuList.php";

	Class Order
	{
		private $db;
		function __construct()
		{
			date_default_timezone_set('PRC');
			$this->db = new CMenuList('./data/order/'.date('Y-m-d').'.txt');
		}

		function run()
		{
			if(isset($_POST['food_id']) && $this->check_ip_limit())
			{
				$this->save_orders($_POST);
				$this->add_ip_2_limit_file();
				$this->show_orders();
			}
			else
			{
				echo '仅且只能选一道o(╯□╰)o！<a href="index.php"/> 重新选择</a>';
				$this->show_orders();
			}
		}

		/**
		 * [check_ip_limit IP]
		 * @return [type] [description]
		 */
		private function check_ip_limit()
		{
			// return 1;
			$ip = $this->read_ip();
			if(isset($ip[$_SERVER[REMOTE_ADDR]]))
			{
				return false;
			}
			else
			{
				return true;
			}
		}


		private function add_ip_2_limit_file()
		{
			$ip = $this->read_ip();
			$ip[$_SERVER[REMOTE_ADDR]] = 1;
			file_put_contents('./data/iplimit/'.date('Y-m-d').'.txt', json_encode($ip));
		}
		private function read_ip()
		{
			$ip_limit_file = './data/iplimit/'.date('Y-m-d').'.txt';
			// if(file_exists())
			$ip = file_get_contents($ip_limit_file);

			$ip = json_decode($ip,true);
			return $ip;
		}


		/**
		 * [save_orders order]
		 * @param  [type] $post [description]
		 * @return [type]       [description]
		 */
		private function save_orders($post)
		{
			$time_stamp = date('Y-m-d H:i:s');
			$orderid = mt_rand(0,10000).$time_stamp;

			$order = $this->db->select();
			$order[$orderid]['timestamp']=$time_stamp;
			// echo $post['food_id'];
			$tem = $this->read_food_info($post['food_id']);
			if(!$tem)
			{
				echo '无此菜!<a href="index.php"/> 重新选择</a>';
				exit;
			}
			// print_r($tem);
			$order[$orderid]['price'] = $tem['price'];
			$order[$orderid]['food_name'] = $tem['food_name'];
			$order[$orderid]['food_id'] = $tem['food_id'];
			$order[$orderid]['order_id'] = $orderid;
			$order[$orderid]['ip'] = $_SERVER[REMOTE_ADDR];
			$order[$orderid]['username']=$post['username']===''?'未填写。。。o(╯□╰)o':$post['username'];
			$this->db->insert($order);
		}

		private function read_food_info($food_id)
		{
			if($foods = $this->db->select('./data/menulist/'.date('Y-m-d').'.txt'))
			{
				return $foods[$food_id];
			}
			else
				return false;
		}
		
		//views
		public function show_orders()
		{
			$orders = $this->db->select();
			// var_dump($orders);
			$this->render($orders);
		}
		private	function render($orders)
		{
			$table = '<table border="1"><caption>订单</caption>';
			$sum = 0;

			// $keys = key(current($orders));
			$keys = array('时间','价格(RMB)','菜名','菜单id','订单号','ip','订饭人');
			// print_r($keys);
			$table .= '<tr>';
			foreach ($keys as &$key) 
			{
				$table .= '<td>'.$key.'</td>'	;
			}
			$food_num = array();
			$table .='</tr>';
			foreach ($orders as &$order) {

				$table .= '<tr>';
				$sum += $order['price'];
				foreach ($order as &$field) 
				{
					$table .= '<td>'.$field.'</td>'	;
				}
				
				if(isset($food_num[$order['food_id']]))
				{
					++$food_num[$order['food_id']]['num'];
				}
				else
				{
					$food_num[$order['food_id']]['num'] = 1;
					$food_num[$order['food_id']]['food_name'] = $order['food_name'];
				}

				$table .='</tr>';
			}

			$table .= '</table>';
			$table .= '<div>总钱数:<span style="color:red;font-weight:bold;">'.$sum.'RMB</span></div>';

			echo $table;

			foreach ($food_num as $food)
			{
				echo $food['food_name'].' : '.$food['num'].'份数<br/>';
			}
		}
	}
	// var_dump($_POST);
	$order = new Order;
	// echo '<pre>';
	$order->run();
	// echo '</pre>';
