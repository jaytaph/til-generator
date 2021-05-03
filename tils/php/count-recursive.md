# Recursive count

PHP allows you to count recursively:

```php

$a = [
    'foo' => [ 1, 2, 3], 
    'bar' => [4, 5, 6]
    ];

print count($a);
// 2

print count($a, COUNT_RECURSIVE);
// 8
```    

So a 2-dimensional array can be easily counted like:

```php

$a = [
    'foo' => [ 1, 2, 3], 
    'bar' => [4, 5, 6]
    ];

print count($a, COUNT_RECURSIVE) - count($a);
// 6
```   
