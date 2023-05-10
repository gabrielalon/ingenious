<?php

declare(strict_types=1);

namespace App\Infrastructure\Providers;

use App\Modules\Invoices\Infrastructure\Subscribers\InvoiceSubscriber;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use ReflectionClass;
use Support\Attributes\ListensTo;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The subscribers to resolve.
     *
     * @var array<class-string>
     */
    private array $subscribers = [
        InvoiceSubscriber::class,
    ];

    /**
     * Determine if events and listeners should be automatically discovered.
     *
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }

    /**
     * @throws \ReflectionException
     */
    public function register(): void
    {
        parent::register();

        foreach ($this->subscribers as $subscriber) {
            foreach ($this->resolveListeners($subscriber) as [$event, $listener]) {
                app('events')->listen($event, $listener);
            }
        }
    }

    /**
     * @throws \ReflectionException
     */
    private function resolveListeners(string $subscriberClass): array
    {
        $reflectionClass = new ReflectionClass($subscriberClass);

        $listeners = [];

        foreach ($reflectionClass->getMethods() as $method) {
            $attributes = $method->getAttributes(ListensTo::class);

            foreach ($attributes as $attribute) {
                /** @var ListensTo $listener */
                $listener = $attribute->newInstance();

                $listeners[] = [$listener->eventClass, [$subscriberClass, $method->getName()]];
            }
        }

        return $listeners;
    }
}
