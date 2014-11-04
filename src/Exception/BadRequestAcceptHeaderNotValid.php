<?php

namespace Terravision\QRCode\Exception;

use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class BadRequestAcceptHeaderNotValid extends BadRequestHttpException implements ExceptionInterface {}