<?php

namespace Hamidrezaniazi\Pecs\Properties;

/** @link https://www.elastic.co/guide/en/ecs/current/ecs-dns.html#field-dns-header-flags */
enum DnsHeaderFlag: string
{
    case AA = 'AA';

    case TC = 'TC';

    case RD = 'RD';

    case RA = 'RA';

    case AD = 'AD';

    case CD = 'CD';

    case DO = 'DO';
}
