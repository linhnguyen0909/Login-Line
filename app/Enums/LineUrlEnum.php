<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class LineUrlEnum extends Enum
{
    const LINE_AUTHORIZE_URL =   'https://access.line.me/oauth2/v2.1/authorize';

    const LINE_TOKEN_URL = 'https://api.line.me/oauth2/v2.1/token';

    const LINE_PROFILE_URL = 'https://api.line.me/v2/profile';
}
