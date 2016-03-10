# Tweaky

[![Build Status](https://travis-ci.org/beequeue/tweaky.svg?branch=master)](https://travis-ci.org/beequeue/tweaky) [![Coverage Status](https://coveralls.io/repos/github/beequeue/tweaky/badge.svg?branch=master)](https://coveralls.io/github/beequeue/tweaky?branch=master)

Tweaky is a library and domain-specific language in JSON notation allowing for the custom transformation of JSON payloads.  It is more concerned with altering values than altering form.  Primary use-case is for specifying modifications to API responses in a mocking proxy.

## Usage

Include via composer:

    composer require beequeue/tweaky

Example usage:

```php
use Beequeue\Tweaky\Spec;
use Beequeue\Tweaky\Tweaky;

$inputJson =<<< END
{
  "a": 1,
  "b": "original",
  "c": [
    {"key": "first"},
    {"key": "second"},
    {"key": "last"}
  ],
  "d": "leave alone"
}
END;

$specJson =<<< END
{
  "transforms": [{
    "a": "{+10}",
    "b": "new value",
    "c": {
      "{[1]}": {
        "key": "middle"
      }
    }
  }]
}
END;

$spec = new Spec($specJson);
$tweaky = new Tweaky($spec);
$output = $tweaky->process($inputJson);

echo json_encode($output, JSON_PRETTY_PRINT);
```

will output:

```
{
    "a": 11,
    "b": "new value",
    "c": [
        {
            "key": "first"
        },
        {
            "key": "middle"
        },
        {
            "key": "last"
        }
    ],
    "d": "leave alone"
}
```

