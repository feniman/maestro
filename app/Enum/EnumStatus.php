<?php

namespace App\Enum;

class EnumStatus
{
    const INACTIVE = 0;
    const ACTIVE = 1;
    const DRAFT = 2;
    const TRASH = 3;

    const NAME = [
        self::INACTIVE => 'Inativo',
        self::ACTIVE => 'Ativo',
        self::DRAFT => 'Rascunho',
        self::TRASH => 'Excluido',
    ];
}
