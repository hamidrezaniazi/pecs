<?php

namespace Hamidrezaniazi\Pecs\Properties;

/** @link https://www.elastic.co/guide/en/ecs/current/ecs-file.html#field-file-attributes */
enum FileAttribute: string
{
    case ARCHIVE = 'archive';

    case COMPRESSED = 'compressed';

    case DIRECTORY = 'directory';

    case ENCRYPTED = 'encrypted';

    case EXECUTE = 'execute';

    case HIDDEN = 'hidden';

    case READ = 'read';

    case READONLY = 'readonly';

    case SYSTEM = 'system';

    case WRITE = 'write';
}
