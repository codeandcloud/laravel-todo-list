# Laravel Todo List Project

## Introduction

This is a hobby project to learn the MVC implementation of PHP using the Laravel Framework in a *Windows 11 machine*. This project use both sqlite3 and MySQL as database(and adminer to manage the database table data). Things to install before starting with the project

1. PHP
2. Composer
3. Laravel
4. SQLite
5. Docker Desktop (I have installed MySQL using Docker Desktop in this project)

Please ensure that these extensions are enabled in the *php.ini* file in your machine

- `extension=curl`
- `extension=fileinfo`
- `extension=mbstring`
- `extension=mysqli`
- `extension=openssl`
- `extension=pdo_mysql`
- `extension=pdo_sqlite`
- `extension=sqlite3`

## Steps to create a project

Please follow these steps to create the project and run

1. `composer create-project laravel/laravel laravel-todo-list`
2. `php artisan serve`
3. `docker compose up` *(to run the docker-compose.yml in the root)*

[What is Artisan Console?](https://laravel.com/docs/11.x/artisan)

## Steps to run this project

Please follow these steps to run the project after pulling this project from GitHub

1. Rename .env.example file to .env inside your project root and fill the database information for the MySQL database.
2. Open the console and cd your project root directory
3. Run `composer install`
4. Run `php artisan key:generate`
5. Run `php artisan migrate`
6. Run `php artisan db:seed to run seeders`.
7. Run `php artisan serve`

## Important Commands

Some of the commands that I have come across while working with the project

### Creating a Project

We generally use this command,`composer create-project laravel/laravel example app`

or in install laravel installer and then creating the app

```shell
composer global require laravel/installer
laravel new example app
```

To install with minimal setup use

```shell
composer create-project laravel/laravel example app
```

### General

- `php artisan serve` *(runs the project)*
- `php artisan tinker` *(tinker with the functions in shell. Stuff like db query)*

### Routing

- `php artisan route:list` *(List all routes)*

### Database

#### Migration and Seeding

- `php artisan migrate` *(Migrate DB changes to database)*
- `php artisan migrate:refresh --seed` *(Reset data and starts seeding afresh. Shouldn't use in production)*
- `php artisan db:seed` *(To seed database with dummy data)*

#### Models and Factory

- `php artisan make:model Task -m` *(Creates a model)*
- `php artisan make:factory TaskFactory --model=Task` *(Creates a factory class for seeding)*

### Validation

- `php artisan make:request TaskRequest` *(To validate request)*

## Eloquent ORM

### Relationship

```php
// Models/Book
class Book extends Model
{
    use HasFactory;

     protected $fillable = ['review', 'rating'];

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}
```

```php
// Models/Review
class Review extends Model
{
    use HasFactory;

    public function book()
    {
        return $this->belongsTo(Book::class);
    }
}
```

### Migration Schema

```php
// factories/BookFactory.php
Schema::create('reviews', function (Blueprint $table) {
        $table->id();

        $table->text('review');
        $table->unsignedTinyInteger('rating');

        $table->timestamps();

        // $table->unsignedBigInteger('book_id');
        // $table->foreign('book_id')->references('id')->on('books')
        //     ->onDelete('cascade');

        $table->foreignId('book_id')->constrained()
            ->cascadeOnDelete();
    });
}
```

### Custom Seeding

```php
namespace Database\Factories;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(3),
            'author' => fake()->name,
            'created_at' => fake()->dateTimeBetween('-2 years'),
            //updated >= created seeding            
            'updated_at' => function (array $attributes) {
                return fake()->dateTimeBetween($attributes['created_at'], 'now');
            },
        ];
    }
}
```

Manipulating the seeding to get an average distribution of books with *good, average and bad* reviews.

```php
namespace Database\Factories;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReviewFactory extends Factory
{
    public function definition(): array
    {
        return [
            'book_id' => null,
            'review' => fake()->paragraph,
            'rating' => fake()->numberBetween(1, 5),
            'created_at' => fake()->dateTimeBetween('-2 years'),
            //updated >= created seeding            
            'updated_at' => function (array $attributes) {
                return fake()->dateTimeBetween($attributes['created_at'], 'now');
            },
        ];
    }

    public function good()
    {
        return $this->state(function (array $attributes) {
            return [
                'rating' => fake()->numberBetween(4, 5)
            ];
        });
    }

    public function average()
    {
        return $this->state(function (array $attributes) {
            return [
                'rating' => fake()->numberBetween(2, 5)
            ];
        });
    }

    public function bad()
    {
        return $this->state(function (array $attributes) {
            return [
                'rating' => fake()->numberBetween(1, 3)
            ];
        });
    }
}
```

### Local Query Scope

```php
use Illuminate\Database\Eloquent\Builder;

class Book extends Model
{
    //always prefix with scope and use camelCase
    public function scopeTitle(Builder $query, string $title): Builder
    {
        return $query->where('title', 'LIKE', '%' . $title . '%');
    }
}
```

use it like,

```shell
php artisan tinker
> \App\Models\Books::title('qui')->get();

```

### Aggregations on Relations

```php
// Book.model
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\Builder as QueryBuilder;

class Book extends Model
{
    //...

    public function scopePopular(Builder $query, $from = null, $to = null): Builder|QueryBuilder
    {
        // using a custom function
        return $query->withCount([
            'reviews' => fn(Builder $q) => $this->dateRangeFilter($q, $from, $to)
        ])
            ->orderBy('reviews_count', 'desc');
    }

    public function scopeHighestRated(Builder $query, $from = null, $to = null): Builder|QueryBuilder
    {
        return $query->withAvg([
            'reviews' => fn(Builder $q) => $this->dateRangeFilter($q, $from, $to)
        ], 'rating')
            ->orderBy('reviews_avg_rating', 'desc');
    }

    public function scopeMinReviews(Builder $query, int $minReviews): Builder|QueryBuilder
    {
        // should use "having" instead of "where" for aggregate functions
        return $query->having('reviews_count', '>=', $minReviews);
    }

    private function dateRangeFilter(Builder $query, $from = null, $to = null)
    {
        if ($from && !$to) {
            $query->where('created_at', '>=', $from);
        } elseif (!$from && $to) {
            $query->where('created_at', '<=', $to);
        } elseif ($from && $to) {
            $query->whereBetween('created_at', [$from, $to]);
        }
    }
}
```

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
