<?php 
return array(
			"type" => "div",
			"attributes" => array(
				"class" => "col-md-12"
			),
			"childValues" => array(
				array(
					"type" => "form",
					"attributes" => array(
						"name" => "mapasform",
						"method" => "POST",
						"action" => Helper::$urlGeneration->route('puntosmapaPOST'),
						"enctype" => "application/x-www-form-urlencoded"
					),
					"childValues" => array(
						array(
							"type" => "input",
							"attributes" => array(
								"type" => "hidden",
								"name" => "temp_random",
								"value" => $_SESSION['tokencsrf']
							)
						),
						array(
							"type" => "input",
							"attributes" => array(
								"type" => "hidden",
								"name" => "current_map",
								"value" => "{var_id}"
							)
						),
						array(
							"type" => "input",
							"attributes" => array(
								"type" => "hidden",
								"name" => "img_id",
								"id" => "img_id",
								
							)
						),

						array(
							"type" => "div",
							"attributes" => array(
								"class" => "row mt-3 mb-4"
							),
							"childValues" => array(
								array(
									"type" => "div",
									"attributes" => array(
										"class" => "col-md-12"
									),
									"childValues" => array(
										array(
											"type" => "label",
											"attributes" => array(
												"class" => "labels"
											),
											"value" => "Descripción"
										),
										array(
											"type" => "textarea",
											"attributes" => array(
												"class" => "form-control",
												"rows" => "3",
												"name" => "informacion",
												"placeholder" => "Descripción",
												"innerText" => "",
												"required" => "required"
											)
										)
									)
								)
							)
						),
						array(
							"type" => "div",
							"attributes" => array(
								"class" => "row mt-3 mb-4"
							),
							"childValues" => array(
								array(
									"type" => "label",
									"attributes" => array(
										"class" => "labels"
									),
									"value" => "Coordenadas de inicio"
								),
								array(
									"type" => "div",
									"attributes" => array(
										"class" => "col-md-12"
									),
									"childValues" => array(
										array(
											"type" => "label",
											"attributes" => array(
												"class" => "labels col-sm-1 col-form-label",
											),
											"value" => "Latitud"
										),
										array(
											"type" => "input",
											"attributes" => array(
												"type" => "text",
												"name" => "latitud",
												"placeholder" => "Latitud",
												"value" => "",
												"required" => "required"
											)
										)
									)
								),
								array(
									"type" => "div",
									"attributes" => array(
										"class" => "col-md-12"
									),
									"childValues" => array(
										array(
											"type" => "label",
											"attributes" => array(
												"class" => "labels col-sm-1 col-form-label"
											),
											"value" => "Longitud"
										),
										array(
											"type" => "input",
											"attributes" => array(
												"type" => "text",
												"name" => "longitud",
												"placeholder" => "Longitud",
												"value" => "",
												"required" => "required"
											)
										)
									)
								)
							)
						),
						array(
							"type" => "div",
							"attributes" => array(
								"class" => "row mt-3 mb-4"
							),
							"childValues" => array(
								array(
									"type" => "label",
									"attributes" => array(
										"class" => "labels"
									),
									"value" => "Imagen de fondo, usa externa o interna y pulsa en subir"
								),
								array(
									"type" => "div",
									"attributes" => array(
										"class" => "col-md-12"
									),
									"childValues" => array(
										array(
											"type" => "label",
											"attributes" => array(
												"class" => "labels col-sm-1 col-form-label",
											),
											"value" => "Imagen externa"
										),
										array(
											"type" => "input",
											"attributes" => array(
												"type" => "text",
												"name" => "imgext",
												"id" => "imgext",
												"placeholder" => "Url imagen",
												"value" => "",
												"required" => "required"
											)
										)
									)
								),
								array(
									"type" => "div",
									"attributes" => array(
										"class" => "input-group mb-3"
									),
									"childValues" => array(
										array(
											"type" => "label",
											"attributes" => array(
												"class" => "labels col-sm-1 col-form-label"
											),
											"value" => "Imagen interna"
										),
										array(
											"type" => "input",
											"attributes" => array(
												"type" => "file",
												"name" => "imgint",
												"id" => "imgint",
												"required" => "required",
												"class" => 'form-control'
											),
										),
										array(
											"type" => "div",
											"attributes" => array(
												"class" => "form-text col-md-12"
											),
											"value" => "*Recomendación: que no supere 1MB"
										)
									)
											),
								array(
									"type" => "div",
									"attributes" => array(
										"class" => "col-md-12"
									),
									"childValues" => array(
										array(
											"type" => "button",
											"attributes" => array(
												"type" => "button",
												"name" => "imgbtn",
												"onclick" => "subirImagen(this)",
												"class" => "btn btn-outline-secondary"
											),
											"value" => "Subir Imagen",
										)
									)
								)
							)
						),
						
						array(
							"type" => "div",
							"attributes" => array(
								"class" => "text-end mt-4"
							),
							"childValues" => array(
								array(
									"type" => "button",
									"attributes" => array(
										"class" => "btn btn-outline-primary btn-lg px-5",
										"name" => "submit",
										"type" => "submit",
										"value" => "submit"
									),
									"value" => "Enviar"
								)
							)
						)
					)
				)
			)
		);