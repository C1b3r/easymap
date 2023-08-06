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
						"action" => Helper::$urlGeneration->route('informacionPOST'),
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
							"type" => "div",
							"attributes" => array(
								"class" => "row mt-2"
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
											"value" => "Titulo"
										),
										array(
											"type" => "input",
											"attributes" => array(
												"type" => "text",
												"class" => "form-control",
												"placeholder" => "Titulo",
												"value" => "{var_title}",
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
												"placeholder" => "Descripción",
												"innerText" => "{var_descripcion}",
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
												"value" => "{var_latitud}",
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
												"value" => "{var_longitud}",
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
									"value" => "Zoom y provedor url"
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
											"value" => "Zoom"
										),
										array(
											"type" => "input",
											"attributes" => array(
												"type" => "number",
												"name" => "Zoom",
												"placeholder" => "Zoom",
												"value" => "{var_zoom}",
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
											"value" => "Proveedor"
										),
										array(
											"type" => "input",
											"attributes" => array(
												"class" => "col-sm-10",
												"type" => "text",
												"name" => "Proveedor",
												"placeholder" => "Proveedor",
												"value" => "{var_proveedor}",
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
								"class" => "text-center mt-4",
								"id" => "iframe-container"
							),
							"childValues" => array(
								array(
									"type" => "button",
									"attributes" => array(
										"class" => "iframe-content btn btn-secondary",
										"data-src" => "https://developers.google.com/maps/documentation/utils/geocoder?hl=es-419",
										"innerText" => "Haz click aquí para desplegar mapa para escoger unas coordenadas",
										"type" => "button"
									)
								)
								/*array(
									"type" => "iframe",
									"attributes" => array(
										"style" => "width:100%; height:300px;",
										"src" => "https://developers-dot-devsite-v2-prod.appspot.com/maps/documentation/utils/geocoder/embed"
									)
								)*/
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
									"value" => "Editar"
								)
							)
						)
					)
				)
			)
		);