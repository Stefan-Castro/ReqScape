<?php
class Levels extends AuthController
{
	public function __construct()
	{
		parent::__construct([
			SessionManager::ROLE_STUDENT,
			SessionManager::ROLE_TEACHER
		]);
	}

	public function levels()
	{
		$data = array();
		$data['page_tag'] = "Levels - " . name_project();
		$data['page_title'] = name_project();
		$data['page_name'] = "Levels";
		$data['page_functions_js'] = array(
			'jquery-3.7.1.min.js',
			'levels/levelsGameManager.js'
		);
		$data['page_css'] =  array(
			'game/game-focal.css',
			'levels/levels-focal.css'
		);
		$data['page_libraries_css'] =  array();
		$this->addNavInfo($data);
		$this->views->getView($this, "levels", $data);
	}

	//VISTA DEL NIVEL DE CLASIFICACION
	public function create_classification()
	{
		$data = array();
		$data['page_tag'] = "Create Game - " . name_project();
		$data['page_title'] = name_project();
		$data['page_name'] = "Create Game";
		$data['page_functions_js'] = array(
			'jquery-3.7.1.min.js',
			'plugins/datatables/dataTables.min.js',
			'plugins/datatables/dataTables.responsive.js',
			'plugins/datatables/responsive.dataTables.js',
			'plugins/papaparse.min.js',
			'levels/createClassificationGame.js'
		);
		$data['page_css'] =  array(
			'game/game-focal.css',
			'levels/levels-base.css',
			'levels/levels-focal.css',
			'levels/create-clasification.css'
		);
		$data['page_libraries_css'] =  array(
			'plugins/datatables/dataTables.dataTables.min.css',
			'plugins/datatables/responsive.dataTables.css'
		);
		$this->addNavInfo($data);
		$this->views->getView($this, "create_classification", $data);
	}

	public function get_requirements_clasification()
	{
		try {
			$idJugador = $this->getUserData('id'); // Por ahora usamos 1 como ejemplo
			$response = $this->model->getRequirementsClasification($idJugador);
		} catch (Error $e) {
			// Captura errores fatales como "Call to undefined method"
			$response = [
				'success' => false,
				'message' => 'Error al obtener los requisitos: ' . $e->getMessage()
			];
		} catch (Exception $e) {
			$response = [
				'success' => false,
				'message' => 'Error al obtener los requisitos: ' . $e->getMessage()
			];
		}
		$jsonResponse = json_encode($response, JSON_UNESCAPED_UNICODE);
		$encryptedResponse = encryptResponse($jsonResponse);
		echo json_encode([
			'data' => $encryptedResponse // Tu función de encriptación
		]);
		die();
	}

	public function create_requirement_clasification()
	{
		try {
			$idJugador = $this->getUserData('id'); // Por ahora usamos 1 como ejemplo
			$jsonData = file_get_contents('php://input');
			$postData = json_decode($jsonData, true);
			$response = $this->model->createRequirementClasification($postData, $idJugador);
		} catch (Error $e) {
			// Captura errores fatales como "Call to undefined method"
			$response = [
				'success' => false,
				'message' => 'Error al crear el requisito: ' . $e->getMessage()
			];
		} catch (Exception $e) {
			$response = [
				'success' => false,
				'message' => 'Error al crear el requisito: ' . $e->getMessage()
			];
		}
		//echo json_encode($response);
		$jsonResponse = json_encode($response, JSON_UNESCAPED_UNICODE);
		$encryptedResponse = encryptResponse($jsonResponse);
		echo json_encode([
			'data' => $encryptedResponse // Tu función de encriptación
		]);
		die();
	}

	public function import_requirements()
	{
		try {
			$jsonData = file_get_contents('php://input');
			$postData = json_decode($jsonData, true);
			$idJugador = $this->getUserData('id');

			if (!isset($postData['encryptedData'])) {
				throw new Exception('Datos no recibidos');
			}

			$decryptedData = decryptData($postData['encryptedData']);
			$data = json_decode($decryptedData, true);

			if (!$data || !isset($data['requirements'])) {
				throw new Exception('Formato de datos inválido');
			}

			$response = $this->model->importRequirementsClasification($data, $idJugador);

			$jsonResponse = json_encode($response, JSON_UNESCAPED_UNICODE);
			$encryptedResponse = encryptResponse($jsonResponse);

			echo json_encode([
				'data' => $encryptedResponse
			]);
		} catch (Exception $e) {
			$response = [
				'success' => false,
				'message' => 'Error: ' . $e->getMessage()
			];

			$jsonResponse = json_encode($response, JSON_UNESCAPED_UNICODE);
			$encryptedResponse = encryptResponse($jsonResponse);

			echo json_encode([
				'data' => $encryptedResponse
			]);
		}
		die();
	}

	public function create_game_clasification()
	{
		try {
			$idJugador = $this->getUserData('id'); // Por ahora usamos 1 como ejemplo
			$jsonData = file_get_contents('php://input');
			$postData = json_decode($jsonData, true);
			$response = $this->model->createGameClasification($postData, $idJugador);
		} catch (Error $e) {
			// Captura errores fatales como "Call to undefined method"
			$response = [
				'success' => false,
				'message' => 'Error al obtener los requisitos: ' . $e->getMessage()
			];
		} catch (Exception $e) {
			$response = [
				'success' => false,
				'message' => 'Error al obtener los requisitos: ' . $e->getMessage()
			];
		}
		$jsonResponse = json_encode($response, JSON_UNESCAPED_UNICODE);
		$encryptedResponse = encryptResponse($jsonResponse);
		echo json_encode([
			'data' => $encryptedResponse // Tu función de encriptación
		]);
		die();
	}

	//VISTA DEL NIVEL DE CONSTRUCCION
	public function create_construction()
	{
		$data = array();
		$data['page_tag'] = "Create Game - " . name_project();
		$data['page_title'] = name_project();
		$data['page_name'] = "Create Game";
		$data['page_functions_js'] = array(
			'jquery-3.7.1.min.js',
			'plugins/datatables/dataTables.min.js',
			'plugins/datatables/dataTables.responsive.js',
			'plugins/datatables/responsive.dataTables.js',
			'plugins/papaparse.min.js',
			'levels/createConstructionGame.js'
		);
		$data['page_css'] =  array(
			'game/game-focal.css',
			'levels/levels-base.css',
			'levels/levels-focal.css',
			'levels/create-clasification.css',
			'levels/create-construction.css',
			'levels/create-construction-form.css'
		);
		$data['page_libraries_css'] =  array(
			'plugins/datatables/dataTables.dataTables.min.css',
			'plugins/datatables/responsive.dataTables.css'
		);
		$this->addNavInfo($data);
		$this->views->getView($this, "create_construction", $data);
	}

	public function get_requirements_construction()
	{
		try {
			$idJugador = $this->getUserData('id'); // Por ahora usamos 1 como ejemplo
			$response = $this->model->getRequirementsConstruction($idJugador);
		} catch (Error $e) {
			// Captura errores fatales como "Call to undefined method"
			$response = [
				'success' => false,
				'message' => 'Error al obtener los requisitos: ' . $e->getMessage()
			];
		} catch (Exception $e) {
			$response = [
				'success' => false,
				'message' => 'Error al obtener los requisitos: ' . $e->getMessage()
			];
		}
		$jsonResponse = json_encode($response, JSON_UNESCAPED_UNICODE);
		$encryptedResponse = encryptResponse($jsonResponse);
		echo json_encode([
			'data' => $encryptedResponse // Tu función de encriptación
		]);
		die();
	}

	public function create_requirement_construction()
	{
		try {
			$idJugador = $this->getUserData('id'); // Por ahora usamos 1 como ejemplo
			$jsonData = file_get_contents('php://input');
			$postData = json_decode($jsonData, true);
			$response = $this->model->createRequirementConstruction($postData, $idJugador);
		} catch (Error $e) {
			// Captura errores fatales como "Call to undefined method"
			$response = [
				'success' => false,
				'message' => 'Error al crear el requisito: ' . $e->getMessage()
			];
		} catch (Exception $e) {
			$response = [
				'success' => false,
				'message' => 'Error al crear el requisito: ' . $e->getMessage()
			];
		}
		//echo json_encode($response);
		$jsonResponse = json_encode($response, JSON_UNESCAPED_UNICODE);
		$encryptedResponse = encryptResponse($jsonResponse);
		echo json_encode([
			'data' => $encryptedResponse // Tu función de encriptación
		]);
		die();
	}

	public function import_requirements_construction()
	{
		try {
			$jsonData = file_get_contents('php://input');
			$postData = json_decode($jsonData, true);
			$idJugador = $this->getUserData('id');

			if (!isset($postData['encryptedData'])) {
				throw new Exception('Datos no recibidos');
			}

			$decryptedData = decryptData($postData['encryptedData']);
			$data = json_decode($decryptedData, true);

			if (!$data || !isset($data['requirements'])) {
				throw new Exception('Formato de datos inválido');
			}

			$response = $this->model->importRequirementsConstruction($data, $idJugador);

			$jsonResponse = json_encode($response, JSON_UNESCAPED_UNICODE);
			$encryptedResponse = encryptResponse($jsonResponse);

			echo json_encode([
				'data' => $encryptedResponse
			]);
		} catch (Exception $e) {
			$response = [
				'success' => false,
				'message' => 'Error: ' . $e->getMessage()
			];

			$jsonResponse = json_encode($response, JSON_UNESCAPED_UNICODE);
			$encryptedResponse = encryptResponse($jsonResponse);

			echo json_encode([
				'data' => $encryptedResponse
			]);
		}
		die();
	}

	public function create_game_construction()
	{
		try {
			$idJugador = $this->getUserData('id'); // Por ahora usamos 1 como ejemplo
			$jsonData = file_get_contents('php://input');
			$postData = json_decode($jsonData, true);
			$response = $this->model->createGameConstruction($postData, $idJugador);
		} catch (Error $e) {
			// Captura errores fatales como "Call to undefined method"
			$response = [
				'success' => false,
				'message' => 'Error al obtener los requisitos: ' . $e->getMessage()
			];
		} catch (Exception $e) {
			$response = [
				'success' => false,
				'message' => 'Error al obtener los requisitos: ' . $e->getMessage()
			];
		}
		$jsonResponse = json_encode($response, JSON_UNESCAPED_UNICODE);
		$encryptedResponse = encryptResponse($jsonResponse);
		echo json_encode([
			'data' => $encryptedResponse // Tu función de encriptación
		]);
		die();
	}

}
