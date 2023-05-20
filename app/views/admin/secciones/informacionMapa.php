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
						"action" => COMPLETE_WEB_PATH_ADMIN."login",
						"enctype" => "application/x-www-form-urlencoded"
					),
					"childValues" => array(
						array(
							"type" => "input",
							"attributes" => array(
								"type" => "hidden",
								"name" => "temp_random",
								"value" => "{{random}}"
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
												"value" => ""
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
											"type" => "textarea",
											"attributes" => array(
												"class" => "form-control",
												"rows" => "3",
												"placeholder" => "Descripción"
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
											"value" => "Latitud"
										),
										array(
											"type" => "input",
											"attributes" => array(
												"type" => "text",
												"name" => "latitud",
												"placeholder" => "Latitud"
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
												"class" => "labels"
											),
											"value" => "Longitud"
										),
										array(
											"type" => "input",
											"attributes" => array(
												"type" => "text",
												"name" => "longitud",
												"placeholder" => "Longitud"
											)
										)
									)
								)
							)
						),
						array(
							"type" => "iframe",
							"attributes" => array(
								"style" => "width:100%; height:300px;",
								"src" => "https://developers-dot-devsite-v2-prod.appspot.com/maps/documentation/utils/geocoder/embed"
							)
						),
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
		);