import { Router } from '@inertiajs/inertia/types/router'

// @see vendor/laravel/framework/src/Illuminate/Foundation/helpers.php route
declare function $route(name: string, params?: object, absolute?: boolean): string;
declare function $route(): Router | {
    current(name: string, params?: object): boolean;
    current(): string | undefined;
};

declare global {
    interface Window {
        route: typeof $route;
    }
}

