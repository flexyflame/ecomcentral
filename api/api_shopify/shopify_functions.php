<?php

	function api_shopify_file_get_contents($uri) {
		$ret = file_get_contents($uri);

		$header_array = $http_response_header;

		foreach ($header_array AS $key => $val) {
			$limit = strstr($val, "HTTP_X_SHOPIFY_SHOP_API_CALL_LIMIT: ");
			if ($limit != false) {
				$limit = substr($limit, 36);
				$limit_von = strstr($limit, "/", true);
				$limit_bis = strstr($limit, "/");
				if ($limit_bis != false) $limit_bis = substr($limit_bis, 1);
				$limit_von_int = intval($limit_von);
				$limit_bis_int = intval($limit_bis);
				$prozent_genutzt = ($limit_von_int / $limit_bis_int) * 100;
				//echo ($limit_von . " - " . $limit_bis . " " .$prozent_genutzt . "%");

				if ($prozent_genutzt > 95) {
					sleep(60);
				} else if ($prozent_genutzt > 90) {
					sleep(30);
				} else if ($prozent_genutzt > 80) {
					sleep(15);
				} else if ($prozent_genutzt > 70) {
					sleep(8);
				} else if ($prozent_genutzt > 50) {
					sleep(3);
				} else if ($prozent_genutzt > 30) {
					sleep(1);
				} else {
					usleep(580 * 1000);
				}
			}
		}

		// file_put_contents("http.log", var_export($header_array, true), FILE_APPEND);
		// file_put_contents("http.log", "\r\n\r\n", FILE_APPEND);

		return $ret;
	}

	function shopify_rest_api($token, $shop, $api_endpoint, $query = array(), $method = 'GET', $request_headers = array()) {
		$url = "https://" . $shop . $api_endpoint;
		
		if (!is_null($query) && in_array($method, array('GET', 'DELETE'))) $url = $url . "?" . http_build_query($query);
		//echo $url . '<br><br>';

		$curl = curl_init($url);
		curl_setopt($curl, CURLOPT_HEADER, 1);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_FOLLOWLOCATION, TRUE);
		curl_setopt($curl, CURLOPT_MAXREDIRS, 3);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 30);
		curl_setopt($curl, CURLOPT_TIMEOUT, 30);
		curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);

		$request_headers[] = "";

		$headers[] = "Content-Type: application/json";

		if (!is_null($token)) $request_headers[] = "X-Shopify-Access-Token: " . $token;
		curl_setopt($curl, CURLOPT_HTTPHEADER, $request_headers);

		if ($method != 'GET' && in_array($method, array('POST', 'PUT'))) {
			if (is_array($query)) $query = json_encode($query);

			curl_setopt ($curl, CURLOPT_POSTFIELDS, $query);
		}

		$response = curl_exec($curl);
		$error_number = curl_errno($curl);
		$error_message = curl_error($curl);

		$code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
		//$info = curl_getinfo($curl);
		// print_r($code);
		//print_r($error_message);

		curl_close($curl);
		//echo $response;

		if ($error_number) {
			return $error_message;
		} else {
			$response = preg_split("/\r\n\r\n|\n\n|\r\r/", $response, 2);
			$headers = array();
			$header_data = explode("\n",$response[0]);
			$headers['status'] = $header_data[0];
			$headers['http_code'] = $code;
			$headers['http_body_json'] = $query;
			$headers['url'] = $url;
			$headers['method'] = $method;
			array_shift($header_data);
			foreach($header_data as $part) {
				$h = explode(":", $part, 2);
				$headers[trim($h[0])] = trim($h[1]);
			}
			return array('headers' => $headers, 'data' => $response[1]);
		}
	}

	function shopify_gql_rest_api($token, $shop, $query = array(), $rel = "") {
		$url = "https://" . $shop . "/admin/api/2023-01/graphql.json";

		if (!empty($rel)) sleep(15);

		$curl = curl_init($url);
		curl_setopt($curl, CURLOPT_HEADER, 1);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_FOLLOWLOCATION, TRUE);
		curl_setopt($curl, CURLOPT_MAXREDIRS, 3);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 30);
		curl_setopt($curl, CURLOPT_TIMEOUT, 30);
		
		$request_headers[] = "";
		$request_headers[] = "Content-Type: application/json";
		if (!is_null($token)) $request_headers[] = "X-Shopify-Access-Token: " . $token;
		curl_setopt($curl, CURLOPT_HTTPHEADER, $request_headers);
		curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($query));
		curl_setopt($curl, CURLOPT_POST, TRUE);

		$response = curl_exec($curl);
		$error_number = curl_errno($curl);
		$error_message = curl_error($curl);

		$code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
		//$info = curl_getinfo($curl);
		//print_r($code);
		//print_r($error_message);

		curl_close($curl);
		//echo $response;

		if ($error_number) {
			return $error_message;
		} else {
			$response = preg_split("/\r\n\r\n|\n\n|\r\r/", $response, 2);
			$headers = array();
			$header_data = explode("\n",$response[0]);
			$headers['status'] = $header_data[0];
			$headers['http_code'] = $code;
			$headers['http_body_json'] = $query;
			$headers['url'] = $url;
			array_shift($header_data);
			foreach($header_data as $part) {
				$h = explode(":", $part, 2);
				$headers[trim($h[0])] = trim($h[1]);
			}

			//print_r(array( $response[1]));
			$data_json = json_decode($response[1], true);
			// print_r(json_encode($data_json['extensions']));
		
			if (!empty($data_json['errors'])) {
				print_r(json_encode($data_json['errors']));
				return array('headers' => $headers, 'data' => $response[1], 'errors' => $data_json['errors']);
				die('===AAAAAA');
			} 
			
			return array('headers' => $headers, 'data' => $response[1]);
		}
	}

	function str_btwn($string, $start, $end){
		$string = ' ' . $string;
		$ini = strpos($string, $start);
		if ($ini == 0) return '';
		$ini += strlen($start);
		$len = strpos($string, $end, $ini) - $ini;
		return substr($string, $ini, $len);
	}

?>