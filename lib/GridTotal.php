<?php

namespace common\lib;


class GridTotal {
	public static function getTotal( $provider, $fieldName ) {
		$total = 0;
		foreach ( $provider as $item ) {
			$total += $item[ $fieldName ];
		}

		return $total;
	}
}