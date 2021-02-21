![Little Auditor - The littlest Laravel auditor](little-auditor-banner.png)

# Little Auditor

[![Latest Version on Packagist](https://img.shields.io/packagist/v/rrvwmrrr/little-auditor.svg?style=flat-square)](https://packagist.org/packages/rrvwmrrr/little-auditor)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/rrvwmrrr/little-auditor/run-tests?label=tests)](https://github.com/rrvwmrrr/little-auditor/actions?query=workflow%3ATests+branch%3Amaster)
[![GitHub Code Style Action Status](https://img.shields.io/github/workflow/status/rrvwmrrr/little-auditor/Check%20&%20fix%20styling?label=code%20style)](https://github.com/rrvwmrrr/little-auditor/actions?query=workflow%3A"Check+%26+fix+styling"+branch%3Amaster)
[![Total Downloads](https://img.shields.io/packagist/dt/rrvwmrrr/little-auditor.svg?style=flat-square)](https://packagist.org/packages/rrvwmrrr/little-auditor)

Little auditor contains a pair of traits you can apply to your [Eloquent](https://laravel.com/docs/8.x/eloquent) models to allow you to hook in to their events and store the attached data.

## Should I use this package?

No. It's not ready yet.

## Who should consider this package?

There are no extra functionalities here, we're just keeping track of a model, changes that have
been made to it and the user that made them.

If you need fully fledged auditing functionality, I'd recommend [Laravel Auditing](https://github.com/owen-it/laravel-auditing).

## Auditing

If you've turned off package discovery, you'll need to register the Audit service provider 
in your app config.

```php

    'providers' => [
        ...
        Rrvwmrrr\Auditor\AuditServiceProvider::class,
        ...

    ]

```

### Setting up an auditor

The auditor will always attempt to grab the logged in user id and attach that to an audit. 
The default auditor is mapped to `App\Models\User` but can be changed via a service 
provivider if you're authenticating with a different model.

```php

// app/Providers/AppServiceProvider.php

use Rrvwmrrr\Auditor\Auditor;

public function boot()
{
    Auditor::$auditorModel = Some\Other\Class::class;
}

```

Now that we've configured the model for our Auditor, let's set up the trait on that model.

```php

// app/Models/User.php

use Rrvwmrrr\Auditor\Traits\IsAuditor;

class User extends Authenticatable
{
    use IsAuditor;

```

### Setting up auditable models

Finally, we need to apply the auditing trait for the models we want to track changes on.

```php

// app/Models/Order.php

use Rrvwmrrr\Auditor\Traits\IsAudited;

class Order
{
    use IsAudited;
}

```

### Defaults

By default, the IsAudited trait will try to listen for all model events.
This can be customized via each model using the audit property

```php

// app/Models/Order.php

use Rrvwmrrr\Auditor\Traits\IsAudited;

class Order
{
    use IsAudited;

    /**
     * The model events to listen for
     *
     * @var array
     */
    protected $audit = [
        'saved',
    ];
}

```

This set up would only save audit information when the saved event is fired for the model.

### Audit relationships

Audits can now be queried on both the user model (retreiving everything they've audited)
and any auditable model.

```php

    $user = User::find(1);
    $user->audits;   //  Collection of audits made by the user

    $order = Order::find(1);
    $order->audits; //  Collection of audits made on the order

```

## Testing

```bash
composer test
```

## Contributors

- [James Sessford](https://github.com/jamessessford)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](license.md) for more information.