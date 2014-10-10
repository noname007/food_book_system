<?php

	// const DATAFILEFOLD ='';
	// const PREFIX_FOODID = 'food_id';
	class CMenuList
	{
		private $menulistFile ='';

		function __construct($menulistFile='')
		{
			date_default_timezone_set('PRC');
			$this->menulistFile = $menulistFile;
		}

		function select($file='')
		{	
			if(empty($file))
			{
				$file = $this->menulist_file();
			}

			if(file_exists($file))
			{
				return json_decode( file_get_contents($file),true);
			}
			else
			{
				return false;
			}
		}
		
		function insert($menulist,$mode = 'w')
		{
			// echo $this->menulist_file();
			if(count($menulist))
				$this->write2file($this->menulist_file(),json_encode($menulist), $mode);
		}
		
		private function write2file($filename,$data,$mode)
		{
			$handle = fopen($filename,$mode);
			fwrite($handle, $data.PHP_EOL);
			fclose($handle);
		}
		private function menulist_file()
		{
			if(empty($this->menulistFile))
				return './data/menulist/'.date('Y-m-d').'.txt';
			else
				return $this->menulistFile;
		}
	}


	