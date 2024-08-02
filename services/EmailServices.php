<?php
namespace Services;
use PHPMailer\PHPMailer\PHPMailer;

 class EmailServices{
        protected $nombre;
        protected $email;
        protected $token;

        public  function SendEmailToUser($options = [],$type = true){
            
            foreach ($options as $key => $value) {
                 $this->$key = $value;
            }
            if($type){
                
                $this->enviarConfirmacion();
            }else{
                $this->enviarInstrucciones();
            }
        }
            //TODO: quitars las variablews de enotrno o instalar DOTenv          }   

    public function enviarConfirmacion(){
        try {
            $email = new PHPMailer();
            $email->isSMTP();
            $email->Host = 'sandbox.smtp.mailtrap.io';
            $email->SMTPAuth = true;
            $email->Port = 2525;
            $email->Username = '441f3f81afab7e';
            $email->Password = '6ed65e192434b8';
                
            // Configuración del protocolo de seguridad
            if ($_ENV['EMAIL_PORT'] == 465) {
                $email->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            } else {
                $email->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            }
    
            // Configuración del correo
            $email->setFrom('antoniotraderxd@gmail.com', 'Antonio AS');
            $email->addAddress($this->email, $this->nombre);
            $email->Subject = 'Confirma tu cuenta';
            
            $email->isHTML(true);
            $email->CharSet = 'UTF-8';
    
            $contenido = '<html>';
            $contenido .= "<p>Hola: " . htmlspecialchars($this->nombre) . "</p>";
            $contenido .= "<p>Has creado una cuenta en nuestra página. Confirma presionando el siguiente enlace:</p>";
            $contenido .= "<p>Presiona aquí: <a href='" . 'http://localhost:8080' . "/confirmar?token=" . urlencode($this->token) . "'>Confirmar Cuenta</a></p>";
            $contenido .= "<p>Si tú no solicitaste este registro, solo ignóralo.</p>";
            $contenido .= '</html>';
            
            $email->Body = $contenido;
    
            // Habilita la depuración
            $email->SMTPDebug = 2;
    
            // Envía el correo
            if (!$email->send()) {
                debuguear('El mensaje no pudo ser enviado. Error: ' . $email->ErrorInfo) ;
            } 
        } catch ( \Throwable $th) {
            debuguear ('Error: ' . $th->getMessage());
        }
    }
    public function enviarInstrucciones(){

        try{
            $email = new PHPMailer();
            $email->isSMTP();
            $email->Host = 'sandbox.smtp.mailtrap.io';
            $email->SMTPAuth = true;
            $email->Port = 2525;
            $email->Username = '441f3f81afab7e';
            $email->Password = '6ed65e192434b8';
                
            
            // Configuración del protocolo de seguridad
            if ($_ENV['EMAIL_PORT'] == 465) {
                $email->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            } else {
                $email->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            }
            
            $email->setFrom('appsalon@gmail.com');
            $email->addAddress($this->email);
            $email->Subject = 'restablece tu password';
    
            $email->isHTML(true);
            $email->CharSet = 'UTF-8';
    
            $contenido = '<html> ';
            $contenido.= "<p>Hola: ". $this->nombre ." has solicitado restablecer tu password</p>";
            $contenido.= "<p>Presiona aqui: <a href = '".'http://localhost:8080'."/recuperar?token=".$this->token."'>Restablece tu password</a></p>";
            $contenido.= "<p>Si tu no solistaste este registro solo ignoralo</p>";
            $contenido .= '</html>';
    
            $email->Body = $contenido;
            if (!$email->send()) {
                debuguear('El mensaje no pudo ser enviado. Error: ' . $email->ErrorInfo) ;
            } 
         
        }catch ( \Throwable $th) {
            debuguear ('Error: ' . $th->getMessage());
        }




    }


}
