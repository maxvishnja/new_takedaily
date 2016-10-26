<?php


namespace App\Apricot\Libraries;


use App\Customer;
use App\MailFlow;

class MailFlowMatchmaker
{
	/**
	 * @param MailFlow   $mailFlow
	 * @param Customer[] $customers
	 */
	public function make( MailFlow $mailFlow, $customers )
	{
		foreach ( $customers as $customer )
		{
			$isAMatch = true;

			foreach ( $mailFlow->conditions as $condition )
			{
				$compareTo = $this->getCompareableValue($condition->key, $customer);

				$this->compareCondition($compareTo, $condition->type, $condition->value);
			}

			if ( $isAMatch )
			{
				// todo send

				$mailFlow->customers()->attach($customer->id);
			}
		}
	}

	private function compareCondition( $value, $method = '=', $compareWith )
	{
		switch ( $method )
		{
			case '=':
				return $value == $compareWith;
				break;
			case '!=':
				return $value != $compareWith;
				break;
			case '>':
				return $value > $compareWith;
				break;
			case '<':
				return $value < $compareWith;
				break;
			case '>=':
				return $value >= $compareWith;
				break;
			case '<=':
				return $value <= $compareWith;
				break;
		}
	}

	private function getCompareableValue($key, Customer $customer)
	{
		$keyIdentifier = explode('.', $key)[0];

		switch($keyIdentifier)
		{
			case 'year':
				return date('Y');
				break;

			case 'month':
				return date('m');
				break;

			case 'is-summer':
				$summerMonths = [4,5,6,7,8,9];
				return in_array(date('m'), $summerMonths);
				break;

			case 'is-winter':
				$winterMonths = [1,2,3,10,11,12];
				return in_array(date('m'), $winterMonths);
				break;

			case 'customer':
				$subKey = explode('.', $key)[1];
				return $customer->{$subKey};
				break;

			case 'plan':
				$subKey = explode('.', $key)[1];
				return $customer->getPlan()->{$subKey};
				break;

			default:
				return $keyIdentifier;
				break;
		}
	}
}