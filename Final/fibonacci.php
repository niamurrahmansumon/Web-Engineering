<?php
function fibonacci(int $n): int {
    // Base cases for the recursion
    if ($n <= 1) {
        return $n;
    }
    // Recursive call
    return fibonacci($n - 1) + fibonacci($n - 2);
}

// Example: Print the first 10 Fibonacci numbers
echo "First 10 Fibonacci numbers: ";
for ($i = 0; $i < 10; $i++) {
    echo fibonacci($i) . ' ';
}
// Output: 0 1 1 2 3 5 8 13 21 34
?>