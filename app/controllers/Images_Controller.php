<?php
namespace app\controllers;

use app\classes\Boot;
use app\classes\Controller;
use app\model\Imagen_Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Images_Controller extends Controller 
{
    protected $rules = [
    'imagen' => 'required|image|max:1024|mimes:jpeg,png,jpg' //1MB máximo
    ];
    public $errors,
           $rutaArchivo = ROOT_PATH.'/resources/images/uploads/';

    public function __construct() 
	{
		$this->model = new Imagen_Model();
	}

    public function subirImagen(Request $request)
    {
        $imagen = $request->input('imagen');
         
        // var_dump($request->getContent());

        if ($imagen === null) {
            // El campo 'imagen' se envió como un archivo físico
            $imagen = $request->file('imagen');
            if(!$this->validates(['imagen' => $imagen])){
              return array("Message" => $this->errors);  
            }
            $this->model->ext = 0;
              // Renombrar el archivo
            $this->model->name = Str::random(20) . time() . '.' . $imagen->getClientOriginalExtension();
            // Almacenamiento seguro
            // $rutaArchivo = $imagen->storeAs($this->rutaArchivo, $this->model->name);
            // Mover el archivo a la ruta deseada utilizando move_uploaded_file
            if (!move_uploaded_file($imagen->getPathname(), $this->rutaArchivo."/".$this->model->name)) {
                // Ocurrió un error al mover el archivo
                return ['message' => 'Error al subir la imagen'];
            }
            //   $this->model->name = $imagen->getClientOriginalName();
            // Es un archivo subido, puedes guardar el archivo y acceder a sus propiedades
            // $nombreArchivo = $imagenSubir->getClientOriginalName();
            // $rutaArchivo = $imagenSubir->store('ruta-de-almacenamiento');


 
        } else {
            // Es un string, puedes utilizarlo directamente
            // $nombreArchivo = $imagenSubir;

            // Realiza las operaciones necesarias con el nombre del archivo
            $this->model->name = $imagen;
            $this->model->ext = 1;
           
        }
        $this->model->save();
        return array('id' => $this->model->id_image);
    }
    public function validates($data)
    {
        $validator = Boot::$app->validator->make($data, $this->rules);

        if ($validator->fails()) {
            $this->errors = $validator->errors();
            return false;
        }
        return true;
    }
}