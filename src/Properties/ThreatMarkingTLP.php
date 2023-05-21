<?php

namespace Hamidrezaniazi\Pecs\Properties;

/** @link https://www.elastic.co/guide/en/ecs/current/ecs-threat.html#field-threat-enrichments-indicator-marking-tlp */
enum ThreatMarkingTLP: string
{
    case WHITE = 'WHITE';

    case CLEAR = 'CLEAR';

    case GREEN = 'GREEN';

    case AMBER = 'AMBER';

    case AMBER_STRICT = 'AMBER+STRICT';

    case RED = 'RED';
}
