<?php

namespace Hamidrezaniazi\Pecs\Properties;

/** @link https://www.elastic.co/guide/en/ecs/current/ecs-os.html#field-os-type */
enum OsType: string
{
    case LINUX = 'linux';

    case MACOS = 'macos';

    case UNIX = 'unix';

    case WINDOWS = 'windows';

    case IOS = 'ios';

    case ANDROID = 'android';
}
