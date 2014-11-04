<?php

namespace Terravision\QRCode\Exception;

use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class BadRequestImageSizeNotValid extends BadRequestHttpException implements ExceptionInterface {}