<?php

namespace MyBudget\Budget\Domain\Enum;

enum BudgetStatus:string
{
    case DRAFT = 'draft';
    case ACTIVE = 'active';

    case CLOSED = 'closed';
}
