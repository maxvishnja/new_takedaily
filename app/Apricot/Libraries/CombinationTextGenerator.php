<?php namespace App\Apricot\Libraries;


use Illuminate\Support\Str;

class CombinationTextGenerator
{
	/**
	 * @param $key
	 *
	 * @return array
	 */
	private function getReasons( $key )
	{
		if ( trans( "flow-reasons.{$key}.reasons" ) === "flow-reasons.{$key}.reasons" )
		{
			return [];
		}

		return (array) is_array( trans( "flow-reasons.{$key}.reasons" ) ) ? trans( "flow-reasons.{$key}.reasons" ) : [];
	}

	/**
	 * @param $key
	 *
	 * @return string
	 */
	private function getMain( $key )
	{
		return (string) trans( "flow-reasons.{$key}.main" ) ?: '';
	}

	public function generate( $key, array $matchedReasons = [], $lines = false )
	{
		$key = strtolower( $key );

		$main    = $this->getMain( $key );
		$reasons = collect( $this->getReasons( $key ) )->reject( function ( $value, $key ) use ( $matchedReasons )
		{
			return ! in_array( $key, $matchedReasons, false );
		} )->toArray();

		$text = "$main ";

		if ( count( $reasons ) > 0 )
		{
			$seperator = $lines ? trans( 'flow-reasons.generic.lines' ) : trans( 'flow-reasons.generic.and' );

			if ( $lines && $main !== '' )
			{
				$text .= $seperator;
			}

			$text .= implode( $seperator, $reasons );

			if(!Str::endsWith($text, '.'))
			{
				$text .= '.';
			}
		}

		return $text;
	}
}