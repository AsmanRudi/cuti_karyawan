import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.jsx',
    ],

    darkMode: 'class',

    theme: {
        extend: {
            colors: {
                "secondary-container": "#a6b1fd",
                "secondary": "#4e599e",
                "inverse-surface": "#303035",
                "tertiary-fixed-dim": "#ffb59d",
                "tertiary-container": "#3d0d00",
                "outline-variant": "#c7c5d2",
                "primary-fixed-dim": "#c0c1ff",
                "primary-container": "#121358",
                "tertiary": "#0e0100",
                "on-surface": "#1b1b20",
                "error-container": "#ffdad6",
                "secondary-fixed": "#dee0ff",
                "secondary-fixed-dim": "#bbc3ff",
                "surface-dim": "#dcd9df",
                "primary-fixed": "#e1e0ff",
                "inverse-primary": "#c0c1ff",
                "error": "#ba1a1a",
                "on-tertiary-fixed-variant": "#72351f",
                "on-tertiary-fixed": "#390c00",
                "surface": "#fcf8ff",
                "outline": "#777681",
                "on-secondary-container": "#364285",
                "surface-container-lowest": "#ffffff",
                "surface-container-low": "#f6f2f9",
                "on-primary": "#ffffff",
                "on-surface-variant": "#464650",
                "on-primary-fixed": "#0f1056",
                "on-primary-container": "#7d7fc7",
                "surface-container-high": "#eae7ed",
                "primary": "#010025",
                "on-tertiary": "#ffffff",
                "surface-container-highest": "#e4e1e8",
                "on-primary-fixed-variant": "#3d4083",
                "surface-tint": "#55589c",
                "surface-variant": "#e4e1e8",
                "tertiary-fixed": "#ffdbd0",
                "on-secondary": "#ffffff",
                "on-error-container": "#93000a",
                "on-tertiary-container": "#bf7158",
                "on-error": "#ffffff",
                "on-secondary-fixed": "#031158",
                "inverse-on-surface": "#f3eff6",
                "on-secondary-fixed-variant": "#354185",
                "background": "#fcf8ff",
                "surface-container": "#f0ecf3",
                "surface-bright": "#fcf8ff",
                "on-background": "#1b1b20",
                "royal-blue": "#232F72",
                "steel-blue": "#2F578A",
                "teal-accent": "#36ADA3"
            },
            borderRadius: {
                DEFAULT: "0.25rem",
                lg: "0.5rem",
                xl: "0.75rem",
                full: "9999px"
            },
            spacing: {
                unit: "4px",
                "margin-desktop": "40px",
                "margin-mobile": "16px",
                "gutter": "24px",
                "stack-md": "16px",
                "container-max-width": "1440px",
                "stack-sm": "8px",
                "stack-lg": "32px"
            },
            fontFamily: {
                "body-sm": ["Inter", ...defaultTheme.fontFamily.sans],
                "label-sm": ["Inter", ...defaultTheme.fontFamily.sans],
                "h1-mobile": ["Inter", ...defaultTheme.fontFamily.sans],
                "h1": ["Inter", ...defaultTheme.fontFamily.sans],
                "label-md": ["Inter", ...defaultTheme.fontFamily.sans],
                "h3": ["Inter", ...defaultTheme.fontFamily.sans],
                "body-md": ["Inter", ...defaultTheme.fontFamily.sans],
                "h2": ["Inter", ...defaultTheme.fontFamily.sans],
                "body-lg": ["Inter", ...defaultTheme.fontFamily.sans],
                sans: ["Inter", ...defaultTheme.fontFamily.sans],
            },
            fontSize: {
                "body-sm": ["14px", { lineHeight: "20px", fontWeight: "400" }],
                "label-sm": ["12px", { lineHeight: "16px", fontWeight: "500" }],
                "h1-mobile": ["28px", { lineHeight: "34px", letterSpacing: "-0.01em", fontWeight: "700" }],
                "h1": ["36px", { lineHeight: "44px", letterSpacing: "-0.02em", fontWeight: "700" }],
                "label-md": ["14px", { lineHeight: "20px", letterSpacing: "0.05em", fontWeight: "600" }],
                "h3": ["20px", { lineHeight: "28px", fontWeight: "600" }],
                "body-md": ["16px", { lineHeight: "24px", fontWeight: "400" }],
                "h2": ["24px", { lineHeight: "32px", letterSpacing: "-0.01em", fontWeight: "600" }],
                "body-lg": ["18px", { lineHeight: "28px", fontWeight: "400" }]
            }
        },
    },

    plugins: [forms],
};
