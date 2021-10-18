<?php

namespace Drupal\Punk_api\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Database\Database;

class DbController extends ControllerBase {

	public function display() {

	  	$form = array();	
	  	// Fields to show in table with sorting criteria
		$header = array(
		    array('data' => t('id'), 'field' => 'id', 'sort' => 'asc'),
		    array('data' => t('name'), 'field' => 'name'),

		    //array('data' => t('Address'), 'colspan' => 3),
		    array('data' => $this->t('first_brewed')),
		    array('data' => $this->t('description')),
		    array('data' => $this->t('food_pairing')),
		);
			    // $years = array(
			    // 	'0' => t('All'),
			    // );
		// Fetching required fields to show in table
		$query = db_select('api_data1', 'b');
		$query->fields('b', array('id','name','first_brewed','description','food_pairing'));  // select your required fields here
		$table_sort = $query->extend('Drupal\Core\Database\Query\TableSortExtender') // Add table sort extender.
		->orderByHeader($header); // Add order by headers.
		// For showing 12 entries per page
	  	$pager = $table_sort->extend('Drupal\Core\Database\Query\PagerSelectExtender')->limit(12);  // here you can limit the number of data per page.
	  	$result = $pager->execute();
	  	// 
	  	$rows = array();

	  	foreach($result as $row) {
	  		$rows[] = array('data' => array(
	  			'id' => $row->id,
	  			'name' => $row->name,
	  			'first_brewed' => $row->first_brewed,
	  			'description' => $row->description,
	  			'food_pairing' => $row->food_pairing,   	
	        ));
	  	}	
	  	// Filter criteria for Name field  
		$rest = db_query('SELECT id, name, first_brewed FROM {api_data1}');
		$options1 = array();
		$options = array();
		foreach ($rest as $r) {
		  $options[] = $r->name;
		  $options1[] = $r->first_brewed;
		}	

	    $form['form'] = [
	        '#type'  => 'form',
	    ];	  	

	    $form['form']['description'] = [
	        '#title'         => 'description',
	        '#type'          => 'search'
	    ];	

	    // Values to select from Name field
	    $form['form']['filters']['name'] = [
	        '#title'         => 'name',
	        '#type'          => 'select',
	        '#empty_option'  => '- Select -',
	        '#options'       => $options,
	    ];

		// Values to select from first_brewed field
	    $form['form']['filters']['first_brewed'] = [
	        '#title'         => 'first_brewed',
	        '#type'          => 'select',
	        '#empty_option'  => '- Select -',
	        '#options'       => $options1,
	    ];

	    $form['form']['actions'] = [
	        '#type'       => 'actions'
	    ];

	    $form['form']['actions']['submit'] = [
	        '#type'  => 'submit',
	        '#value' => t('submit')
	    ];

	    $form['config_table'] = array(
	      '#type' => 'table',
	      '#header' => $header,
	      '#rows' => $rows,
	    );

	    // Finally add the pager.    
	    $form['pager'] = array(
	      '#type' => 'pager'
	    );

	    return $form;
	}
}