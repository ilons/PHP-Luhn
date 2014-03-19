<?php
	/*
	* Check if a given number is a valid Luhn number, and if the control digit is correct
	* 
	* Asumes the input to be digits only, and last one to be the control digit.
	* Only zeros are considered valid, and should be taken care or outside of this function.
	*
	* @see http://en.wikipedia.org/wiki/Luhn_algorithm
	*/
	public function isLuhnNumber($digits = NULL) {
		if (is_numeric($digits)) {

			// Calculate the digits with start from the last (which is the check digit)
			$digits = strrev($digits);

			$checksum = 0;
			$multiplier = 1;

			// for each other digit, multiply with 1 and 2
			// If the sum is greater than 9, substract 9
			// Add sum to the total checksum
			for ($index = 0; $index < strlen($digits); $index++) {
				$sum = $digits[$index] * $multiplier;

				if ($sum > 9) {
					$checksum += $sum - 9;
				} else {
					$checksum += $sum;
				}

				if ($multiplier == 1) {
					$multiplier = 2;
				} else {
					$multiplier = 1;
				}
			}

			// If the checksum modulus 10 is 0, the checksum is correct
			if (($checksum % 10) === 0) {
				// Next check that the supplied control digit is correct

				// The last digit is the control digit, substract its value from the checksum
				// Since the number is reversed, this is the first digit
				$controldigit = $digits[0];
				$checksum -= $controldigit;

				// Get next even 10-multiplier
				$next10multiplier = ceil($checksum / 10) * 10;

				// Verify that the given check digit is in fact correct
				// Substract the checksum (without value for control digit) from the next even 10 multiplier
				if (($next10multiplier - $checksum) == $controldigit) {
					return true;
				}
			}
		}
		return false;
	}
?>
