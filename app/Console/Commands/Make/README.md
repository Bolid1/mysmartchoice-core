# Make domain classes module

## How to add model

First, we should create necessary classes with commands:

```bash
artisan make:model --all -- ModelName
artisan make:resource -- ModelNameResource
artisan make:policy --model=ModelName -- ModelNamePolicy
artisan make:request StoreModelNameRequest
artisan make:request UpdateModelNameRequest
```

From this point you have many classes, related to model:

* Migration
* Model itself
* Factory
* Seeder
* Controller
* Resource
* Policy
* Requests for store & update model

Let's modify this files, to make them work together!

### Migration

Fill all columns in `up()` method.

Run the migration

### Model

Setup relations, traits into the model, then run command:

```bash
artisan ide-helper:models --write
```

It is good point for setup casts.

### Factory & Seed

### Controller(s)

Move app/Http/Controllers/MyModelController.php into:

* app/Http/Controllers/Api/MyModel**s**Controller.php
* app/Http/Controllers/Web/MyModel**s**Controller.php

```php
# @source app/Http/Controllers/Api/MyModelsController.php
    public function __construct()
    {
        $this->authorizeResource(MyModel::class);
    }
```

```php
# @source routes/web.php

Route::resource('my_models', Web\MyModelsController::class)
    ->middleware(['auth', 'verified']);
```

```php
# @source routes/api.php

Route::apiResource('integrations', Api\MyModelsController::class)
     ->names([
         'index' => 'api.my_models.index',
         'show' => 'api.my_models.show',
         'store' => 'api.my_models.store',
         'update' => 'api.my_models.update',
         'destroy' => 'api.my_models.destroy',
     ])
     ->middleware('auth:api')
;
```

### Resource

### Policy

### Requests for store & update model

### Views

### Tests

`tests/Api/MyModelsControllerTest.php`


`tests/Web/MyModelsControllerTest.php`
