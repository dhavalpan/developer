<?php

namespace Drupal\Punk_api\Controller;

use Drupal\Core\Controller\ControllerBase;

class Punk_apiController extends ControllerBase {

	public function display() {
		$data = file_get_contents('https://api.punkapi.com/v2/beers?page=17&per_page=20'); //https://api.punkapi.com/v2/beers/1 https://api.punkapi.com/v2/beers?page=1&per_page=80
		$cat_facts = json_decode($data, TRUE);
		// /*foreach ($cat_facts as $cat_fact) {
		// 	echo "<pre>";
		// 	print_r($cat_fact); 	
		// }*/

		foreach ($cat_facts as $item) {
			$query = db_insert('api_data1');
			$id = $item['id'];
			$first_brewed = $item['first_brewed'];
			
			//$ingredients = $item['ingredients'];
			$name = $item['name'];
			$description = $item['description'];
			$food_pairing = $item['food_pairing'];
			//\Drupal::database()->insert('api_data')
			$query->fields([
				'id',
			    'first_brewed',
			    'name',
			    'description',
			    'food_pairing',
			]);	
			$query->values([
				// 1,
				// 'asdasdsdasd',
				// 'asdasdasdsadasdas',
				// 'dsaddsda',
				(int)$id,
				(string)$first_brewed,
				(string)$name,
				(string)$description,
				implode($food_pairing),
			]);	
			$query->execute();
		}
		exit;
	}
}





		// $query = db_select('api_data1');
		// $query->fields('api_data1', [
		// 	'id',
		// 	'first_brewed',
		//     'name',
		//     'description',
		//     'food_pairing'
		//   ]);
		// $query->range(0, 3);
		// $results = $query->execute()->fetchAll();
		
		// echo "<pre>";
		// print_r($results);
		// foreach ($results as $result) {
		//   // Create node object.
		//   $node = Node::create([
		//   	'type' => 'punk_api',
		//     'title' => 'api_data',
		//   ]);
		//   $node->save();
		//   // print_r($result);
		// }