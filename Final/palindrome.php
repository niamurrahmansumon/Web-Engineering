<?php
function isPalindrome(string $str): bool {
    // strrev() is a built-in PHP function to reverse a string
    return strtolower($str) === strrev(strtolower($str));
}

// Example
echo 'madam: ' . (isPalindrome('madam') ? 'Yes' : 'No'); // Output: Yes
echo "\n";
echo 'hello: ' . (isPalindrome('hello') ? 'Yes' : 'No');  // Output: No
?>