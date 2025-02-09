<?php

namespace Jairo\ConcesionarioEspacial\Core;

class SubidaArchivos
{
    public static function subirImagenPerfil($imagen, $id)
    {
        //Obtenemos los datos de la imagen
        $fileName = $imagen['name'];
        $fileTmpPath = $imagen['tmp_name'];

        $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        // Verifica si es una imagen
        $allowedExts = ['jpg', 'jpeg', 'png'];
        if (!in_array($fileExt, $allowedExts)) {
            echo 'Solo se permiten imágenes (JPG, JPEG, PNG).';
            return false;
        }

        // A donde lo vamos a enviar
        $directory = realpath(__DIR__ . '\..\..\public\img\profile_user');
        $destination = $directory . "\user_$id.webp";

        // Creamos la imagen temporal
        if ($fileExt == 'png') {
            $newImage = imagecreatefrompng($fileTmpPath);
        } elseif ($fileExt == 'jpg' || $fileExt == 'jpeg') {
            $newImage = imagecreatefromjpeg($fileTmpPath);
        } else {
            return false;
        }

        // Corregir la orientación EXIF si es necesario
        if ($fileExt == 'jpg' || $fileExt == 'jpeg') {
            $exif = exif_read_data($fileTmpPath);
            if (isset($exif['Orientation'])) {
                switch ($exif['Orientation']) {
                    case 3:
                        $newImage = imagerotate($newImage, 180, 0); // Gira 180 grados
                        break;
                    case 6:
                        $newImage = imagerotate($newImage, -90, 0); // Gira 90 grados en sentido antihorario
                        break;
                    case 8:
                        $newImage = imagerotate($newImage, 90, 0); // Gira 90 grados en sentido horario
                        break;
                }
            }
        }

        // Redimensionamos a 510x510
        $newImage = SubidaArchivos::redimensionarImagenPerfil($newImage);

        // Guarda la nueva imagen (y borramos la antigua)
        if (file_exists($destination)) {
            echo "Ruta de destino: " . $destination;
            unlink($destination);
        }
        if (imagewebp($newImage, $destination, 70)) {
            // Libera la memoria
            imagedestroy($newImage);
            return "/img/profile_user/user_$id.webp";
        } else {
            return false;
        }
    }

    private static function redimensionarImagenPerfil($imagen)
    {
        return imagescale($imagen, 510, 510);
    }
}
