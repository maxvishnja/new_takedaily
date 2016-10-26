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
		$alreadyDoneCustomers = array_flatten($mailFlow->customers()->select('customer_id')->get()->toArray());

		foreach ( $customers as $customer )
		{
			if( in_array($customer->id, $alreadyDoneCustomers))
			{
				continue;
			}

			$isAMatch = true;

			foreach ( $mailFlow->conditions as $condition )
			{
				$compareTo = $this->getCompareableValue($condition->key, $customer);

				if(!$this->compareCondition($compareTo, $condition->type, $condition->value))
				{
					$isAMatch = false;
					break;
				}
			}

			if ( $isAMatch )
			{
				// todo send

				$mailFlow->customers()->create(['customer_id' => $customer->id]);
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
				return in_array(date('m'), $summerMonths) ? 1 : 0;
				break;

			case 'is-winter':
				$winterMonths = [1,2,3,10,11,12];
				return in_array(date('m'), $winterMonths) ? 1 : 0;
				break;

			case 'customer':
				$subKey = explode('.', $key)[1];
				return $customer->{$subKey};
				break;

			case 'plan':
				$subKey = explode('.', $key)[1];
				return $customer->getPlan()->{$subKey};
				break;

			case 'customer_attribute':
				$subKey = explode('.', $key)[1];
				return $customer->getCustomerAttribute($subKey, null);
				break;

			case 'user_data':
				$subKey = explode('.', $key)[1];
				return $customer->getCustomerAttribute("user_data.$subKey", null);
				break;

			default:
				return $keyIdentifier;
				break;
		}
	}
}