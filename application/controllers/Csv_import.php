<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Csv_import extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('csv_import_model');
		$this->load->library('csvimport');
	}

	function index()
	{
		$this->load->view('csv_import');
	}

	function load_data()
	{
		$result = $this->csv_import_model->select();
		$output = '
		 <h3 align="center">Imported User Details from CSV File</h3>
        <div class="table-responsive">
        	<table class="table table-bordered table-striped">
        		<tr>
        			<th>id</th>
        			<th>Nome</th>
        			<th>Dt.Matric</th>
        			<th>Dt.Nasc</th>
        			<th>Situação</th>
        			<th>Matrícula</th>
        			<th>idMEC</th>
        			<th>Observação</th>
        		</tr>
		';
		$count = 0;
		if($result->num_rows() > 0)
		{
			foreach($result->result() as $row)
			{
				
				$output .= '
				<tr>
					
					<td>'.$row->id.'</td>
					<td>'.$row->nome.'</td>
					<td>'.$row->dtMatric.'</td>
					<td>'.$row->dtNasc.'</td>
					<td>'.$row->situacao.'</td>
					<td>'.$row->matricula.'</td>
					<td>'.$row->idMec.'</td>
					<td>'.$row->obs.'</td>
				</tr>
				';
			}
		}
		else
		{
			$output .= '
			<tr>
	    		<td colspan="5" align="center">Data not Available</td>
	    	</tr>
			';
		}
		$output .= '</table></div>';
		echo $output;
	}

	function import()
	{
		$file_data = $this->csvimport->get_array($_FILES["csv_file"]["tmp_name"]);
		foreach($file_data as $row)
		{
			$data[] = array(
                        'id'                    =>      $row["id"], 
                        'nome'                  =>	$row["nome"],
        		'dtMatric'		=>	$row["dtMatric"],
        		'dtNasc'                =>	$row["dtNasc"],
        		'situacao'		=>	$row["situacao"],
        		'matricula'		=>	$row["matricula"],
        		'idMec'                 =>	$row["idMec"],
        		'obs'                   =>	$row["obs"]
			);
		}
		$this->csv_import_model->insert($data);
	}
	
		
}
