<?php

namespace Hamidrezaniazi\Pecs\Properties;

/** @link https://www.elastic.co/guide/en/ecs/current/ecs-threat.html#field-threat-enrichments-indicator-type */
enum ThreatIndicatorType: string
{
    case AUTONOMOUS_SYSTEM = 'autonomous-system';

    case ARTIFACT = 'artifact';

    case DIRECTORY = 'directory';

    case DOMAIN_NAME = 'domain-name';

    case EMAIL_ADDR = 'email-addr';

    case FILE = 'file';

    case IPV4_ADDR = 'ipv4-addr';

    case IPV6_ADDR = 'ipv6-addr';

    case MAC_ADDR = 'mac-addr';

    case MUTEX = 'mutex';

    case PORT = 'port';

    case PROCESS = 'process';

    case SOFTWARE = 'software';

    case URL = 'url';

    case USER_ACCOUNT = 'user-account';

    case WINDOWS_REGISTRY_KEY = 'windows-registry-key';

    case X509_CERTIFICATE = 'x509-certificate';
}
