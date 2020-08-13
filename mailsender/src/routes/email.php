<?php

  use \Psr\Http\Message\ServerRequestInterface as Request;
  use \Psr\Http\Message\ResponseInterface as Response;

  use PHPMailer\PHPMailer\PHPMailer;
  use PHPMailer\PHPMailer\Exception;

  use Monolog\Logger;
  use Monolog\Handler\StreamHandler;

  $container = $app->getContainer();

  $container['logger'] = function ($c) {
      // create a log channel
      $log = new Logger('api');
      $log->pushHandler(new StreamHandler(__DIR__ . '/../logs/app.log', Logger::INFO));

      return $log;
  };

  // change * for the vinetsite.com 
  $app->add(function (Request $request, Response $response, $next) {
	$response = $next($request, $response);
	$response = $response->withHeader('Access-Control-Allow-Origin', '*')
		->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
		->withHeader('Access-Control-Allow-Methods', 'GET, POST');
	return $response;
  }); 

  $app->group('/email', function () use ($app) {
    $app->post('/send', function (Request $request, Response $response){
        $mail = new PHPMailer(true);
        try {

            // request values 
            $nameFrom = $request ->getParam("name"); 
            $emailFrom = $request->getParam("email");
            $message = $request ->getParam("message");


            // SMPT Settings 
            $mail->IsSMTP();
            $mail->SMTPDebug = 2;
            $mail->CharSet="UTF-8";
            $mail->Host = "smtp.gmail.com";  // smpt server 
            $mail->SMTPAuth = true; 
            $mail->SMTPSecure = 'tls';    
            $mail->Username = "lesstalkmorelistening@gmail.com"; // change this 
            $mail->Password = "Voices2020."; // change this
            $mail->Port = 587;  

            // Email header 
            $mail->From = "contacto@gmail.com"; // Desde donde enviamos (Para mostrar)
            $mail->FromName = "Carlos Woching site"; 
            $mail->AddAddress("carloswo15@hotmail.com"); // correo al cual queremos que lleguen los submit del sitio

            // Email Body 
            $mail->IsHTML(true); // El correo se envía como HTML
            $mail->Subject = 'Nuevo Mensaje sitio web'; // A su gusto
            $body = "
            <div>
                <h2>Desean contactarte<h2>
            </div>
            <div> 
            <p><strong>Nombre: </strong> $nameFrom</p> 
            <p><strong>Email: </strong> $emailFrom </p> 
            <p><strong>Mensaje: </strong>$message</p>
            </div>
            ";
           
            $mail->Body = $body; // Mensaje a enviar

            // Email sended 
            $exito = $mail->Send(); // Envía el correo.
            // headers
            $response = $response->withJson($exito);
            $response = $response->withHeader("Content-Type", "application/json");
			$response = $response->withStatus(201, "Sended");
            return $response;
        } catch (Exception $e) {
            echo 'Mailer Error: ' . $mail->ErrorInfo;
        }
    }); 
  });

?>
