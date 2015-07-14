<?php
abstract class API
{
	/**
	 * Property: method
	 * The HTTP method this request was made in, either GET, POST, PUT or DELETE
	 */
	protected $method = '';
	/**
	 * Property: endpoint
	 * The Model requested in the URI. eg: /files
	 */
	protected $endpoint = '';
	/**
	 * Property: verb
	 * An optional additional descriptor about the endpoint, used for things that can
	 * not be handled by the basic methods. eg: /files/process
	 */
	protected $verb = '';
	/**
	 * Property: args
	 * Any additional URI components after the endpoint and verb have been removed, in our
	 * case, an integer ID for the resource. eg: /<endpoint>/<verb>/<arg0>/<arg1>
	 * or /<endpoint>/<arg0>
	 */
	protected $args = Array();
	/**
	 * Property: file
	 * Stores the input of the PUT request
	*/
	protected $file = Null;
	/**
	 * Property: request body
	 * Stores the json oject of body of request
	 */
	protected $request_body = '';
	/**
	 * Constructor: __construct
	 * Allow for CORS, assemble and pre-process the data
	 */
	public function __construct($request) {
		header("Access-Control-Allow-Orgin: *");
		header("Access-Control-Allow-Methods: *");
		header("Content-Type: application/json");

		$this->args = explode('/', rtrim($request, '/'));
		$this->endpoint = array_shift($this->args);
		if (array_key_exists(0, $this->args) && !is_numeric($this->args[0])) {
			$this->verb = array_shift($this->args);
		}

		$this->method = $_SERVER['REQUEST_METHOD'];
		if ($this->method == 'POST' && array_key_exists('HTTP_X_HTTP_METHOD', $_SERVER)) {
			if ($_SERVER['HTTP_X_HTTP_METHOD'] == 'DELETE') {
				$this->method = 'DELETE';
			} else if ($_SERVER['HTTP_X_HTTP_METHOD'] == 'PUT') {
				$this->method = 'PUT';
			} else {
				throw new Exception("Unexpected Header");
			}
		}
		
		$this->request_body=file_get_contents("php://input");
		$this->request_body=json_decode($this->request_body);
		switch($this->method) {
			case 'POST':
			case 'GET':
				//this prints json results for client
				$this->processAPI();
				break;
			default:
				$res['error']='Invalid Method';
				$this->_response($res, 405);
				break;
		}
	}
	public function processAPI() {
		if (method_exists($this, $this->endpoint)) {
			return $this->{$this->endpoint}($this->method,$this->verb,$this->args,$this->request_body);
		}
		$data['error']="No Endpoint: $this->endpoint";
		return $this->_response($data, 404);
	}

	protected function _response($data, $status = 200) {
		header("HTTP/1.1 " . $status . " " . $this->_requestStatus($status));
		echo json_encode($data);
	}

	private function _cleanInputs($data) {
		$clean_input = Array();
		if (is_array($data)) {
			foreach ($data as $k => $v) {
				$clean_input[$k] = $this->_cleanInputs($v);
			}
		} else {
			$clean_input = trim(strip_tags($data));
		}
		return $clean_input;
	}

	private function _requestStatus($code) {
		$status = array(
				200 => 'OK',
				400 => 'Bad Request',
				401 => 'Unauthorized',
				404 => 'Not Found',
				405 => 'Method Not Allowed',
				500 => 'Internal Server Error',
		);
		return ($status[$code])?$status[$code]:$status[500];
	}
}
