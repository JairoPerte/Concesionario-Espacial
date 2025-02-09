<?php

namespace Jairo\ConcesionarioEspacial\Controllers;

use Jairo\ConcesionarioEspacial\Core\BaseController;
use Jairo\ConcesionarioEspacial\Models\UserModel;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class RegistroController extends BaseController
{
    public static function comprobarSesion($protected)
    {
        session_start();

        // Comprobamos que la sesión esté activa
        if (!isset($_SESSION['user_id']) || !isset($_SESSION['session_hash']) || !isset($_SESSION['session_start']) || !isset($_SESSION['user_nickname']) || !isset($_SESSION['user_validated'])) {
            return false;
        }

        // Si no está iniciado sesión pues:
        if (!$_SESSION['user_validated']) {
            return false;
        }

        // Comprobar si la sesión ha expirado
        $tiempoActual = time();
        // 5*60=300seg time() devuelve el tiempo en segundos desde una fecha como js
        if (($tiempoActual - $_SESSION['session_start']) > 300) {
            // Si se le ha pasado la sesión pues se la quitamos
            if ($_SESSION['session_start'] != 0) {
                session_unset();
                session_destroy();
            }
            return false;
        }

        // Comprobar las cookies/hash de sesión (solo si la página está protegida) y también que esté confirmado el email
        if ($protected) {
            $userM = new UserModel();
            if (!$userM->comprobarCookie($_SESSION['user_id'], $_SESSION['session_hash'])) {
                return false;
            }
            if (!$userM->validacionEmail($_SESSION['user_id'])) {
                return false;
            }
        }

        // Si la sesión es válida, renueva la entrada de tiempo
        $_SESSION['session_start'] = $tiempoActual;
        return true;
    }

    public function login()
    {
        if ($this::comprobarSesion(false)) {
            header('Location: /');
        } else {
            $this->view('login');
        }
    }

    public function verificarLogin()
    {
        $userM = new UserModel();
        $email = $_POST["email"];
        $password = $_POST["password"];
        $usuario = $userM->comprobarUsuario($email, $password);
        if ($usuario) {
            session_start();
            session_regenerate_id(true);

            // Inserta el hash en bd y luego lo devuelve
            $hash = $userM->insertarSesion($usuario["id"]);

            // Guardar la sesión
            $_SESSION['user_id'] = $usuario["id"];
            $_SESSION['user_nickname'] = $usuario["nickname"];
            $_SESSION['user_validated'] = $usuario["validated"] == 1 ? true : false;
            $_SESSION['session_hash'] = $hash;
            // Tiene 0 de tiempo hasta que se valide como usuario (la sesión se mantendrá hasta que se valide pero no podrá acceder a ningún sitio por no estarlo)
            if ($_SESSION['user_validated']) {
                $_SESSION['session_start'] = time();
            } else {
                $_SESSION['session_start'] = 0;
            }

            // Ya ha iniciado sesión
            header('Location: /');
        } else {
            // Se ha equivocado con el login
            $this->view('login');
        }
    }

    public function registro()
    {
        if ($this::comprobarSesion(false)) {
            header('Location: /');
        } else {
            $this->view('registro');
        }
    }


    public function registrarUsuario()
    {
        // Definimos los códigos de error y sus mensajes
        $error_messages = [
            "NICKNAME_BAD_FORMATED" => "El nombre de usuario debe tener entre 4 y 20 caracteres.",
            "PASSWORD_BAD_FORMATED" => "La contraseña debe ser de tener 8 a 64 caracteres e incluir mínimo uno de cada: número, mayúscula, minúscula y carácter especial.",
            "EMAIL_BAD_FORMATED" => "El formato del correo electrónico no es válido.",
            "EMAIL_EXISTENTE" => "El correo electrónico ya está registrado.",
            "NICKNAME_EXISTENTE" => "El nombre de usuario ya está en uso."
        ];

        $errores = [];

        // Comprobación del formato de los datos
        $nickname = $_POST["nickname"];
        if (strlen($nickname) < 4 || strlen($nickname) > 20) {
            $errores["NICKNAME_BAD_FORMATED"] = $error_messages["NICKNAME_BAD_FORMATED"];
        }
        $password = $_POST["password"];
        if (!$this::validarContrasena($password)) {
            $errores["PASSWORD_BAD_FORMATED"] = $error_messages["PASSWORD_BAD_FORMATED"];
        }
        $email = $_POST["email"];
        if (!$this::validarEmail($email)) {
            $errores["EMAIL_BAD_FORMATED"] = $error_messages["EMAIL_BAD_FORMATED"];
        }

        if (empty($errores)) {

            $userM = new UserModel();
            if ($userM->existeEmail($email)) {
                $errores["EMAIL_EXISTENTE"] = $error_messages["EMAIL_EXISTENTE"];
            }
            if ($userM->existeNickname($nickname)) {
                $errores["NICKNAME_EXISTENTE"] = $error_messages["NICKNAME_EXISTENTE"];
            }

            // Si ha pasado todos los filtros de errores pues finalmente lo que haremos será generar un código para que confirme el correo
            if (empty($errores)) {
                // Creamos el hash de la contraseña y el código de verificación del email
                $hash = password_hash($password, PASSWORD_ARGON2ID);
                $codigo = $userM::generarCodigoVerificacion();
                $usuario = ["nickname" => $nickname, "email" => $email, "password" => $hash, "validated_code" => $codigo];
                $id = $userM->insertar($usuario);

                session_start();
                session_regenerate_id(true);

                // Guardar la sesión sin la validación del usuario por tanto es como si no ha iniciado sesión hasta que se valide el correo
                $_SESSION['user_id'] = $id;
                $_SESSION['user_nickname'] = $usuario["nickname"];
                $_SESSION['user_validated'] = false;
                $_SESSION['session_hash'] = $userM->insertarSesion($id);
                // Tiene 0 de tiempo hasta que se valide como usuario (la sesión se mantendrá hasta que se valide pero no podrá acceder a ningún sitio)
                $_SESSION['session_start'] = 0;

                $this::enviarEmailValidacion($email, $codigo);

                // Pues tiene que validar el email
                header('Location: /email-verify');
                exit;
            }
        }

        // Cuando hay algún error pues mostramos otra vez el registro pero con los fallos mostrados
        $this->view('registro', $errores);
    }

    public function verificacionEmail()
    {
        if ($this::comprobarSesion(false)) {
            header('Location: /');
        } else {
            if (!empty($_SESSION)) {
                $this->view("verificacionEmail", $_SESSION);
            } else {
                var_dump($_SESSION);
                // header('Location: /login');
            }
        }
    }

    public function validarCodigoEmail()
    {
        // Si tiene sesión pues prosegimos sino pues al login
        session_start();
        if (!empty($_SESSION) && !$_SESSION['user_validated']) {
            $userM = new UserModel();
            $id = $_SESSION['user_id'];

            // Comprobamos que nuestro código sea válido
            if ($userM->verificarCodigoEmail($id, $_POST['verification_code'])) {
                // Empezamos a contar el tiempo a partir de ahora que está validado
                $_SESSION['session_start'] = time();
                $_SESSION['user_validated'] = true;
                $userM->validarEmail($id);
                header('Location: /');
                exit;
            }

            // Sino le decimos que se ha equivocado el bobo que aprenda ha escribir 5 numeritos
            $this->view("verificacionEmail", $_SESSION);
        } else {
            header('Location: /login');
        }
    }

    private static function enviarEmailValidacion($email, $verificationCode)
    {
        // Creamos el email para luego enviarlo
        $mail = new PHPMailer(true);

        try {
            // Configuraciones para la API de Mailjet
            $mail->isSMTP();
            $mail->Host = 'smtp.mailjet.com ';
            $mail->SMTPAuth = true;
            $mail->Username = $_ENV['SMTP_API_KEY'];
            $mail->Password = $_ENV['SMTP_SECRET_KEY'];
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            // Configurar codificación UTF-8
            $mail->CharSet = 'UTF-8';
            $mail->Encoding = 'base64';
            $mail->setLanguage('es');

            // Añadimos los datos de la cabezera
            $mail->setFrom('infinity.beyond.concesionario@gmail.com', 'Infinity&Beyond');
            $mail->addAddress($email);

            // Contenido del cuerpo
            $mail->isHTML(true);
            $mail->Subject = 'Código de verificación';
            $htmlContent = "
                <html lang=\"es\">
                <head>
                    <meta http-equiv=\"Content-Language\" content=\"es\">
                    <style>
                        body {
                            font-family: Arial, sans-serif;
                            background-color: #f4f4f4;
                            margin: 0;
                            padding: 0;
                        }
                        .container {
                            max-width: 600px;
                            margin: 20px auto;
                            background: #ffffff;
                            padding: 20px;
                            border-radius: 10px;
                            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
                            text-align: center;
                        }
                        .logo {
                            width: 150px;
                        }
                        .code {
                            font-size: 24px;
                            font-weight: bold;
                            color: #2c3e50;
                        }
                        .footer {
                            font-size: 12px;
                            color: #7f8c8d;
                            margin-top: 20px;
                        }
                    </style>
                </head>
                <body>
                    <div class='container'>
                        <h2>¡Gracias por registrarte en Infinity&Beyond!</h2>
                        <p>Para completar tu registro, introduce el siguiente código de verificación en la página correspondiente:</p>
                        <p class='code'>$verificationCode</p>
                        <p>Si no has solicitado este código, puedes ignorar este correo.</p>
                        <div class='footer'>
                            &copy; 2025 Infinity&Beyond. Todos los derechos reservados.
                        </div>
                    </div>
                </body>
                </html>
            ";

            $mail->Body = $htmlContent;


            $mail->send();
            return true;
        } catch (Exception $e) {
            // Por si al final quiero hacer los errores con el modo DOTENV
            echo "Algo ha fallado en el envio de correo";
            return false;
        }
    }

    private static function validarContrasena($password)
    {
        // Verificar longitud de la contraseña
        if (strlen($password) < 8 || strlen($password) > 64) {
            return false;
        }

        // Verificar al menos un número
        if (!preg_match('/\d/', $password)) {
            return false;
        }

        // Verificar al menos una letra mayúscula
        if (!preg_match('/[A-Z]/', $password)) {
            return false;
        }

        // Verificar al menos una letra minúscula
        if (!preg_match('/[a-z]/', $password)) {
            return false;
        }

        // Verificar al menos un carácter especial
        if (!preg_match('/[\W_]/', $password)) {
            return false;
        }

        // Si todas las condiciones se cumplen
        return true;
    }

    private static function validarEmail($email)
    {
        // Verificar longitud del email
        if (strlen($email) < 8 || strlen($email) > 254) {
            return false;
        }

        // Verificar formato del email (utilizamos directamente el filtrador de email que he encontrado en internet que es más facil)
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return false;
        }

        // Si todas las condiciones se cumplen
        return true;
    }

    public function logout()
    {
        session_start();
        session_unset();
        session_destroy();

        header('Location: /login');
        exit;
    }
}
