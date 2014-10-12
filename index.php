 <?php
	header("Content-type:text/html;charset=utf-8");
	require_once "./httpRequest.php";
	require_once "./CMenuList.php";

	class MenuData
	{
		private $url;
		private $db;

		function __construct($url = "http://waimai.baidu.com/waimai/shop/18062509820316987430",$menulistfile='')
		{
			$this->url = $url;
			//model
			$this->db = new CMenuList($menulistfile);
		}
			
		//controller
		public function run()
		{
			// echo '<pre>';
			if(empty($this->url))
			{
				echo 'url 为空！<a href ="./admin.php"/> 重 填 </a>';
				exit;
			}

			$data = $this->getBaiduWaimaiMenuList();
			$this->db->insert($data);
			$this->render($data);
			// echo '</pre>';

			// echo 1;
		}
		public function  get_menulist()
		{
			return $this->db->select();
		}
		//model
		//food_id,food_name,pirce,img
		private function getBaiduWaimaiMenuList()
		{
			$res =  httpRequest::get_method($this->url);

<<<<<<< HEAD
			while(~$end)
=======
			if($res==false)
>>>>>>> 3a8d3ed5cb4b2231a1ed17394317b38c99189793
			{
				return array();
			}

			$imgs = array();
			while($data_pos =strpos($res,'<li class="list-item" data="'))
			{
				//data
				$data_pos +=strlen('<li class="list-item" data="');
			    $res = substr($res, $data_pos);
			    $id_pos = strpos($res,'" id');
			    $menu_data= substr($res, 0, $id_pos);
			    //img
			    $data_src_pos = strpos($res,'data-src="')+ strlen('data-src="');
			    $src_pos = strpos($res,'" src');
			    $imgs[$menu_data] =  substr($res, $data_src_pos, $src_pos - $data_src_pos);
			}

			// print_r($imgs);
			$menu = array();
			foreach ($imgs as $data => $img) 
			{
				$info = explode('$', $data);
				// print_r($info);
				$menu[$info[0]]['food_id']=$info[0];
				$menu[$info[0]]['food_name']=$info[1];
				$menu[$info[0]]['price']=$info[2];
				$menu[$info[0]]['img']=$img;
			}
			return $menu;
		}

		//views
		public function render($menulist)
		{
			$form = '<form method="post" action="Order.php">
			<p>姓名<input type="text" name="username" value=""></p>
			<p><input type="submit" name="sub" value="提交"></p>';
			$form .= $this->add_menu_radio($menulist); 
			$form.='</form>';
			echo  $form;
			return ;
		}
		private function add_menu_radio($menulist)
		{
			$res = '';
			foreach ($menulist as $food)
			{
<<<<<<< HEAD
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
=======
				$res .= '<p><input type="radio" value="'.$food['food_id'].'" name="food_id"> | '.$food['food_name'].' | '.$food['price'].' RMB |<img src ="'.$food['img'].'</p>"/>';
			}
			return $res;
>>>>>>> 3a8d3ed5cb4b2231a1ed17394317b38c99189793
		}
		//confg
	}

	$menu = new MenuData($_POST['url']);
	if($_POST['sub'] === 'king')
		$menu->run();
	else
	{
		$menu->render($menu->get_menulist());
	}