<?php

namespace App\Util;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Id\AbstractIdGenerator;

class TmpRootIdGenerator extends AbstractIdGenerator
{
    private const NB_CHAR = 6;
    private const BEGIN_ID = 't';

    public function generateId(EntityManagerInterface $em, ?object $entity): string
    {
        return TmpRootIdGenerator::generateTmpRootId();
    }

    public static function generateTmpRootId(): string
    {
        $generatedID = self::BEGIN_ID;

        for ($i = 0; $i < self::NB_CHAR; $i++) {
            $generatedID .= TmpRootIdGenerator::generateChar();
        }

        return $generatedID;
    }

    private static function generateChar(): string
    {
        return (string) random_int(0, 9);
    }

}