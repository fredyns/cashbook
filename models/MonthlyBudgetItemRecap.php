<?php

namespace app\models;

use yii\helpers\ArrayHelper;

/**
 * Description of MonthlyBudgetItemRecap
 *
 * @author Fredy Nurman Saleh <email@fredyns.net>
 */
class MonthlyBudgetItemRecap extends MonthlyBudgetItem
{
    /**
     * @var static[]
     */
    public static $budgetItems = [];

    /**
     * @param CashflowDetail[] $cashflowDetails
     */
    public static function parseMultiple($cashflowDetails)
    {
        // vars

        $budgetItemIds = static::getBudgetItemIds($cashflowDetails);
        $currentRecaps = static::getRecap($budgetItemIds);
        $prevRecaps = static::getRecap($budgetItemIds, "previous month");
        $prevDate = new \DateTime("previous month");

        // recap cashflow

        foreach ($cashflowDetails as $cashflowDetail) {
            $budgetItemId = $cashflowDetail->budgetItem_id;
            $nominal = $cashflowDetail->nominal;

            if (!isset($currentRecaps[$budgetItemId])) {
                $prevBalance = (int) ArrayHelper::getValue($prevRecaps, $budgetItemId.'.closingBalance', 0);
                $currentRecaps[$budgetItemId] = new static([
                    'year' => $prevDate->format('Y'),
                    'month' => $prevDate->format('m'),
                    'budgetItem_id' => $budgetItemId,
                    'recordStatus' => static::RECORDSTATUS_ACTIVE,
                    'openBalance' => $prevBalance,
                    'debit' => 0,
                    'credit' => 0,
                    'closingBalance' => $prevBalance,
                ]);

                $currentRecaps[$budgetItemId]->save(false);
            }

            // debit mengurangi saldo

            if ($cashflowDetail->flow = CashflowDetail::FLOW_CREDIT) {
                $nominal *= -1;
            }

            $currentRecaps[$budgetItemId]->{$cashflowDetail->flow} += $cashflowDetail->nominal;
            $currentRecaps[$budgetItemId]->closingBalance += $cashflowDetail->nominal;
            $cashflowDetail->monthlyBudgetItem_id = $currentRecaps[$budgetItemId]->id;

            $cashflowDetail->save(false);
        }

        // update last data

        foreach ($currentRecaps as $currentRecap) {
            $currentRecap->save(false);
        }
    }

    /**
     * @param CashflowDetail[] $cashflowDetails
     * @return integer[]
     */
    public static function getBudgetItemIds($cashflowDetails)
    {
        $budgetItemIds = [];

        foreach ($cashflowDetails as $cashflowDetail) {
            $budgetItemIds[] = $cashflowDetail->budgetItem_id;
        }

        return array_unique($budgetItemIds);
    }

    /**
     * @param integer[] $budgetItemIds
     * @param string $time
     * @return static[]
     */
    public static function getRecap($budgetItemIds, $time = "now")
    {
        $datetime = new \DateTime($time);

        return static::find()
                ->where([
                    'year' => $datetime->format('Y'),
                    'month' => $datetime->format('m'),
                    'budgetItem_id' => $budgetItemIds,
                    'recordStatus' => static::RECORDSTATUS_ACTIVE,
                ])
                ->indexBy('budgetItem_id')
                ->all();
    }
}