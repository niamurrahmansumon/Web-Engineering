<?php
function factorial(int $n): int {
    // Base case: factorial of 0 or 1 is 1
    if ($n <= 1) {
        return 1;
    }
    // Recursive call
    return $n * factorial($n - 1);
}

// Example
echo 'Factorial of 5 is: ' . factorial(5); // Output: 120
echo "\n";
echo 'Factorial of 0 is: ' . factorial(0); // Output: 1
?>