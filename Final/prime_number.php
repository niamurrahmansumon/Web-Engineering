<?php
function isPrime(int $num): bool {
    // Numbers less than 2 are not prime
    if ($num < 2) {
        return false;
    }
    // Check for divisors from 2 up to the square root of the number
    for ($i = 2; $i <= sqrt($num); $i++) {
        if ($num % $i === 0) {
            return false; // Found a divisor, so it's not prime
        }
    }
    return true; // No divisors found, it's prime
}

// Example
echo '13 is prime? ' . (isPrime(13) ? 'Yes' : 'No'); // Output: Yes
echo "\n";
echo '12 is prime? ' . (isPrime(12) ? 'Yes' : 'No');  // Output: No
?>