<?php
namespace App\Models\ORM;

use Slim\App;
use App\Models\ORM\comida;

include_once __DIR__ . '/comida.php';

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Models\AutentificadorJWT;
use \Exception;

