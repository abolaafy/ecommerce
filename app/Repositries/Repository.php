<?php

namespace App\Repositries;

use Illuminate\Database\Eloquent\Model;
use App\Http\Interfaces\repostitryInterface;

class Repository implements repostitryInterface
{
	protected $model;
		
		public function __construct (Model $model)
		{
			 $this -> model = $model;
		}
		public function index ()
		{
			return $this -> model -> get ();
		}
		public function create (array $data)
		{
			return $this -> model -> create ($data);
		}
		public function edit ( $id)
		{
			return $this -> model ->find($id);
		
		}
		public function update ($id , array $data)
		{
			$recoard = $this -> model -> find ($id);
			return $recoard -> update ( $data);
		}
		public function delete ($id)
		{
			$recoard = $this -> find ($id);
			return $recoard -> delete ();
		}	
			# Get Table In DataBase 
		public function getModel ()
		{
			return $this -> model ;
		}	
		   # set Table From DataBase
		public function setMedol ($model)
		{
			$this -> model = $model ;
			return $this ;
		} 
			# Get RelationShip between Tables
		public function getWith ($relations)
		{
			return $this -> model -> with ($relations) ;
			
		}
}