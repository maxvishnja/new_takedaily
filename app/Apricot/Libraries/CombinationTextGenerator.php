<?php namespace App\Apricot\Libraries;


class CombinationTextGenerator
{
	/**
	 * @param $key
	 *
	 * @return array
	 */
	private function getReasons($key)
	{
		return (array) trans("flow-reasons.{$key}.reasons") ?: [];
	}

	/**
	 * @param $key
	 *
	 * @return string
	 */
	private function getMain($key)
	{
		return (string) trans("flow-reasons.{$key}.main") ?: '';
	}

	public function generate($key, array $matchedReasons = [], $lines = false)
	{
		$key = strtolower($key);

		$main = $this->getMain($key);
		$reasons = collect($this->getReasons($key))->reject(function($value, $key) use($matchedReasons)
		{
			return !in_array($key, $matchedReasons, false);
		})->toArray();

		$text = $main;

		$seperator = $lines ? trans('flow-reasons.generic.lines') : trans('flow-reasons.generic.and');

		$text .= implode($seperator, $reasons);

		$text .= '.';

		return $text;
	}
}