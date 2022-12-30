<?php

namespace Hamidrezaniazi\Pecs\Properties;

enum HttpMethod: string
{
    case GET = 'GET';

    case HEAD = 'HEAD';

    case POST = 'POST';

    case PUT = 'PUT';

    case DELETE = 'DELETE';

    case CONNECT = 'CONNECT';

    case OPTIONS = 'OPTIONS';

    case TRACE = 'TRACE';

    case PATCH = 'PATCH';
}
