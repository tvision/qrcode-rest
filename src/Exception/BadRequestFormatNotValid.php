<?php

namespace Terravision\QRCode\Exception;

use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class BadRequestFormatNotValid extends BadRequestHttpException implements ExceptionInterface {}