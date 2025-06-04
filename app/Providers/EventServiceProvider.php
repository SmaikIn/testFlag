<?php

namespace App\Providers;

use App\Domains\User\Observers\UserObserver;
use App\Events\OrderCashEvent;
use App\Listeners\OrderCashListener;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderPaymentType;
use App\Models\OrderStatus;
use App\Models\Product;
use App\Models\User;
use App\Observers\CartItemObserver;
use App\Observers\OrderObserver;
use App\Observers\OrderPaymentTypeObserver;
use App\Observers\OrderStatusObserver;
use App\Observers\ProductObserver;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        OrderCashEvent::class => [
            OrderCashListener::class,
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        User::observe(UserObserver::class);
        Product::observe(ProductObserver::class);
        CartItem::observe(CartItemObserver::class);
        OrderPaymentType::observe(OrderPaymentTypeObserver::class);
        OrderStatus::observe(OrderStatusObserver::class);
        Order::observe(OrderObserver::class);
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
