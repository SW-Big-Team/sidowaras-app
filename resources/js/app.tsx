import "../css/app.css"
import "./bootstrap"
import React from 'react'
import { createInertiaApp } from '@inertiajs/react'
import { createRoot } from 'react-dom/client'
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { HeroUIProvider } from "@heroui/react";

const appName = import.meta.env.VITE_APP_NAME || 'Sidowaras';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) =>
        resolvePageComponent(
            `./Pages/${name}.tsx`,
            import.meta.glob('./Pages/**/*.tsx'),
        ),
        setup({ el, App, props }) {
            const root = createRoot(el);
    
            root.render(
                // <React.StrictMode>
                    <HeroUIProvider>
                        <App {...props} />
                    </HeroUIProvider>
                // </React.StrictMode>
            );
        },
})