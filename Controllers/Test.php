<?php
class Test extends Controllers
{
	public function __construct()
	{
		parent::__construct();
	}

	public function test()
	{
		$data['page_id'] = 2;
		$data['page_tag'] = "Test - Tienda Virtual";
		$data['page_title'] = "Test - Tienda Virtual";
		$data['page_name'] = "Test";
		$data['page_functions_js'] = "test/functions_test.js";
        $data['page_libraries_css'] =  array(
			'plugins/datatables/dataTables.dataTables.min.css'
		);
		$data['page_css'] =  array(
			'test/test.css'
		);
		$this->views->getView($this, "test", $data);
	}

	public function test2()
	{
		$data['page_id'] = 2;
		$data['page_tag'] = "Test - Tienda Virtual";
		$data['page_title'] = "Test - Tienda Virtual";
		$data['page_name'] = "Test";
		$data['page_functions_js'] = array();
		$data['page_css'] =  array(
			'report/variables.css',
			'report/report.css',
			'report/progress.css',
			'report/table.css'
		);
		$this->views->getView($this, "test2", $data);
	}
}
