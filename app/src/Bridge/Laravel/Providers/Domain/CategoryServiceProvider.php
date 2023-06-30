<?php

declare(strict_types=1);

namespace Laravel\Providers\Domain;

use Cycle\ORM\ORMInterface;
use Cycle\ORM\Select;
use Domain\Category\Category;
use Domain\Category\CategoryRepository;
use Domain\Category\Contracts\CategoryIdGenerator;
use Domain\Category\Exceptions\CategoryNotFoundException;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Infrastructure\Persistence\Cycle\ORMCategoryRepository;

final class CategoryServiceProvider extends ServiceProvider
{
    /**
     * @throws BindingResolutionException
     */
    public function boot(): void
    {
        $this->bindCategoryEntity();
    }

    public function register(): void
    {
        $this->app->bind(
            CategoryRepository::class,
            ORMCategoryRepository::class
        );

        $this->app->when(ORMCategoryRepository::class)
            ->needs(Select::class)
            ->give(function (): Select {
                return new Select($this->app->make(ORMInterface::class), 'category');
            });

        $this->app->bind(CategoryIdGenerator::class, CategoryRepository::class);
    }

    /**
     * @throws BindingResolutionException
     */
    private function bindCategoryEntity(): void
    {
        $repository = $this->app->make(CategoryRepository::class);

        Route::bind('category', static function ($value) use ($repository) {
            /** @var Category|null $category */
            $category = $repository->findById($value);

            if (null === $category) {
                throw new CategoryNotFoundException();
            }

            return $category;
        });
    }
}
