<?php

namespace Hamidrezaniazi\Pecs\Properties;

/** @link https://www.elastic.co/guide/en/ecs/current/ecs-allowed-values-event-type.html */
enum EventType: string
{
    case ACCESS = 'access';

    case ADMIN = 'admin';

    case ALLOWED = 'allowed';

    case CHANGE = 'change';

    case CONNECTION = 'connection';

    case CREATION = 'creation';

    case DELETION = 'deletion';

    case DENIED = 'denied';

    case END = 'end';

    case ERROR = 'error';

    case GROUP = 'group';

    case INDICATOR = 'indicator';

    case INFO = 'info';

    case INSTALLATION = 'installation';

    case PROTOCOL = 'protocol';

    case START = 'start';

    case USER = 'user';
}
