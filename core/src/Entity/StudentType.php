<?php

namespace App\Entity;

enum StudentType: string
{
    case L3 = 'l3';
    case M1 = 'm1';
    case M2 = 'm2';
    case WORKER = 'wk';
    case OTHER = 'oth';
}