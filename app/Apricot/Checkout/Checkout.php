<?php

namespace App\Apricot\Checkout;


use App\Apricot\Interfaces\PaymentInterface;
use App\Apricot\Libraries\MoneyLibrary;
use App\Apricot\Libraries\PaymentDelegator;
use App\Apricot\Libraries\PaymentHandler;
use App\Apricot\Libraries\TaxLibrary;
use App\Apricot\Repositories\CouponRepository;
use App\Coupon;
use App\Giftcard;
use App\Product;

class Checkout
{
	private $total;
	private $subscriptionPrice;
	private $paymentMethod;
	private $paymentHandler;
	private $product;
	private $paymentCustomer;
	private $taxLibrary;
	/** @var Giftcard */
	private $giftcard;
	/** @var Coupon */
	private $coupon;

	public function appendCoupon($couponCode)
	{
		$couponRepository = new CouponRepository();
		$coupon           = $couponRepository->findByCoupon($couponCode);

		if ( $coupon )
		{
			$this->coupon = $coupon;

			if ( $coupon->discount_type == 'percentage' )
			{
				$this->deductTotal($coupon->discount / 100);
			}
			elseif ( $coupon->discount_type == 'amount' )
			{
				$this->deductTotal(MoneyLibrary::toMoneyFormat($coupon->discount));
			}

			if ( $coupon->applies_to == 'plan' )
			{
				$this->setSubscriptionPrice($this->getTotal());
			}
		}

		return $this;
	}

	public function setProduct(Product $product, $updatePrices = true)
	{
		$this->product = $product;

		if ( $updatePrices )
		{
			$this->setTotal(MoneyLibrary::toMoneyFormat($this->getProduct()->price));
			$this->setSubscriptionPrice($this->getProduct()->is_subscription == 1 ? MoneyLibrary::toMoneyFormat($this->getProduct()->price) : 0);
		}

		return $this;
	}

	public function createCustomer($name, $email)
	{
		$this->paymentCustomer = $this->getPaymentHandler()->createCustomer($name, $email);

		return $this;
	}

	public function getCustomer()
	{
		return $this->paymentCustomer;
	}

	public function setProductByName($name = 'subscription')
	{
		$product = Product::where('name', $name)->first();

		if ( !$product )
		{
			return false;
		}

		return $this->setProduct($product);
	}

	/**
	 * @return Product
	 */
	public function getProduct()
	{
		return $this->product;
	}

	public function deductTotal($byAmount)
	{
		$this->setTotal($this->getTotal() - $byAmount);

		return $this;
	}

	public function getTotal()
	{
		return $this->total;
	}

	public function setTotal($newTotal)
	{
		$this->total = $newTotal;

		return $this;
	}

	/**
	 * @return PaymentHandler
	 */
	public function getPaymentHandler()
	{
		return $this->paymentHandler;
	}

	public function setPaymentHandler()
	{
		$this->paymentHandler = new PaymentHandler($this->getPaymentMethod());

		return $this;
	}

	/**
	 * @return PaymentInterface
	 */
	public function getPaymentMethod()
	{
		return $this->paymentMethod;
	}

	public function setPaymentMethod($method, $setHandler = true)
	{
		$this->paymentMethod = PaymentDelegator::getMethod($method);

		if ( $setHandler )
		{
			$this->setPaymentHandler();
		}

		return $this;
	}

	public function appendGiftcard($id, $token)
	{
		$giftcard = null;

		if ( $this->getProduct()->name == 'subscription' )
		{
			$giftcard = Giftcard::where('id', $id)
			                    ->where('token', $token)
			                    ->where('is_used', 0)
			                    ->first();
		}

		if ( $giftcard )
		{
			$this->giftcard = $giftcard;
		}

		return $this;
	}

	public function getSubscriptionPrice()
	{
		return $this->total;
	}

	public function setSubscriptionPrice($newPrice)
	{
		$this->subscriptionPrice = $newPrice;

		return $this;
	}

	public function addToTotal($byAmount)
	{
		$this->setTotal($this->getTotal() + $byAmount);

		return $this;
	}

	public function makeInitialPayment()
	{
		return $this->getPaymentHandler()
		            ->makeInitialPayment(MoneyLibrary::toCents($this->getTotal()), $this->getCustomer());
	}

	public function getCoupon()
	{
		return $this->coupon;
	}

	public function getGiftcard()
	{
		return $this->giftcard;
	}

	public function setTaxLibrary($country)
	{
		$this->taxLibrary = new TaxLibrary($country);

		return $this;
	}

	/**
	 * @return TaxLibrary
	 */
	public function getTaxLibrary()
	{
		return $this->taxLibrary;
	}

	public function getSubTotal()
	{
		return $this->getTotal() * $this->getTaxLibrary()->reversedRate();
	}

	public function getTaxTotal()
	{
		return $this->getTotal() * $this->getTaxLibrary()->rate();
	}
}