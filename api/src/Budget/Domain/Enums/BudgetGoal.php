<?php

namespace MyBudget\Budget\Domain\Enums;

enum BudgetGoal
{
    case HOME_BUDGET;
    case COMPANY_BUDGET;
    case SAVINGS;
    case INVESTMENTS;
    case OTHER;
}
