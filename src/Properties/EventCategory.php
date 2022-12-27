<?php

namespace Hamidrezaniazi\Pecs\Properties;

/** @link https://www.elastic.co/guide/en/ecs/current/ecs-allowed-values-event-category.html */
//TODO add type validation based on category with the logic in the link above
enum EventCategory: string
{
    case AUTHENTICATION = 'authentication';

    case CONFIGURATION = 'configuration';

    case DATABASE = 'database';

    case DRIVER = 'driver';

    case EMAIL = 'email';

    case FILE = 'file';

    case HOST = 'host';

    case IAM = 'iam';

    case INTRUSION_DETECTION = 'intrusion_detection';

    case MALWARE = 'malware';

    case NETWORK = 'network';

    case PACKAGE = 'package';

    case PROCESS = 'process';

    case REGISTRY = 'registry';

    case SESSION = 'session';

    case THREAT = 'threat';

    case WEB = 'web';
}
