<?php

namespace Hamidrezaniazi\Pecs\Properties;

/** @link https://www.elastic.co/guide/en/ecs/current/ecs-network.html#field-network-direction */
enum NetworkDirection: string
{
    case INGRESS = 'ingress';

    case EGRESS = 'egress';

    case INBOUND = 'inbound';

    case OUTBOUND = 'outbound';

    case INTERNAL = 'internal';

    case EXTERNAL = 'external';

    case UNKNOWN = 'unknown';
}
