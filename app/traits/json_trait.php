<?php
namespace app\traits;

trait Json_Trait
{
	/**  Función para realizar el reemplazo en el JSON
	 */
	public function reemplazarMarcadores(string $json, array $data) {
		foreach ($data as $key => $value) {
		$json = str_replace("{{$key}}", $value, $json);
		}
		return $json;
 	 }

	public function loadJSONView(string $path,string $name)
	{
		if (file_exists(VIEW_PATH.$path.$name.'.php'))
		{
			return require_once VIEW_PATH.$path.$name.'.php';
		}else{
			return null;
		}
	}
	public function checkAndReturnJson(string $json)
	{
		$result = json_decode($json);

		if (json_last_error() === JSON_ERROR_NONE) {
			return $result;
		}
		return false;
	}
}