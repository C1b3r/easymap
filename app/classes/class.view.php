<?php

class View {
	public $data = array();
	public $pagination = false;

	public function __construct() 
	{
		
	}
	private function loadView($name)
	{
		if (file_exists(VIEW_PATH . $name . '.php'))
		{
			require_once(VIEW_PATH . $name . '.php');
		}
		else throw new MyException('View file not found: '.$name,1);
		return $this;
	}
	private function clean($text)
	{
		return trim(strtolower(str_replace(' ' ,'-',$text)));
	}
	public function assign($field,$value)
	{
		//Creating property object dinamically
		$this->{$field} = $value;
		return $this;
	}
	public function makeLink($first,$option)
	{
		return WEB_PATH.implode('/',array($first,$this->clean($option))).'/';
	}
	public function display($name, $noInclude = false, $admin = false)
	{
		echo $this->render($name, $noInclude, $admin);
		return $this;
	}
	public function render($name, $noInclude = false, $admin = false)
	{
		ob_start();
		if ($noInclude)
		{
			$this->loadView($name);
		}
		else if($admin)
		{
			$this->loadView('admin/header-admin')->loadView('admin/'.$name)->loadView('admin/footer-admin');
		}
		else 
		{
			$this->loadView('header')->loadView($name)->loadView('footer');
		}
		$view = ob_get_contents();
		ob_end_clean();
		return $view;
	}

		/**
	 * @param links For limit number of pages, if is offset limit, it put ...
	 */
	public function createPaginationLink($data,$currentPage = '', $links = 7)
	{
			if ( $data->limit == 'all' ) {
				return '';
			}
		 
			$last       = ceil( $data->total / $data->limit );
		 
			$start      = ( ( $data->page - $links ) > 0 ) ? $data->page - $links : 1;
			$end        = ( ( $data->page + $links ) < $last ) ? $data->page + $links : $last;
		 
			$html       = '<ul class="pagination">';
		 
			$class      = ( $data->page == 1 ) ? "disabled" : "";
			$html       .= '<li class="page-item"><a class="page-link" href="'.COMPLETE_WEB_PATH_ADMIN.$currentPage.'/page/' . ( $data->page - 1 ) . '">&laquo;</a></li>';
		 
			if ( $start > 1 ) {
				$html   .= '<li class="page-item" ><a href="'.COMPLETE_WEB_PATH_ADMIN.$currentPage.'/page/1">1</a></li>';
				$html   .= '<li class="disabled"><span>...</span></li>';
			}
		 
			for ( $i = $start ; $i <= $end; $i++ ) {
				$class  = ( $data->page == $i ) ? "active" : "";
				$html   .= '<li class="page-item"><a class="page-link" href="'.COMPLETE_WEB_PATH_ADMIN.$currentPage.'/page/' . $i . '">' . $i . '</a></li>';
			}
		 
			if ( $end < $last ) {
				$html   .= '<li class="disabled"><span>...</span></li>';
				$html   .= '<li class="page-item"><a class="page-link" href="'.COMPLETE_WEB_PATH_ADMIN.$currentPage.'/page/' . $last . '">' . $last . '</a></li>';
			}
		 
			$class      = ( $data->page == $last ) ? "disabled" : "";
			$html       .= '<li class="page-item"><a class="page-link" href="'.COMPLETE_WEB_PATH_ADMIN.$currentPage.'/page/' . ( $data->page + 1 ) . '">&raquo;</a></li>';
		 
			$html       .= '</ul>';
		 
			return $html;
	}

}