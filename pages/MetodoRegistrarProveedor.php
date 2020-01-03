<?php

	function validarNombre($data)
	{
		if (empty($data))
			$data = "Este campo esta vacio";

		return $data;
	}

	echo "Hola, soy el script que subira tus datos.";

	if ($_SERVER['REQUEST_METHOD'] == "POST")
	{
		echo "Fui post.";

		$_POST['tipo'] = validarNombre($_POST['tipo']);
		echo "El dato que recibi " . $_POST['tipo'] . "<br>";
	}
	else
		echo "No fue post.";
?>