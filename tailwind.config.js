import defaultTheme from "tailwindcss/defaultTheme";
import forms from "@tailwindcss/forms";

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
    ],
    darkMode: 'class',

    theme: {
        extend: {
            fontFamily: {
                sans: ["Figtree", ...defaultTheme.fontFamily.sans],
            },
            colors: {
                primary: { DEFAULT: "#023CB6", foreground: "#F8FAFC" },
                secondary: { DEFAULT: "#F1F5F9", foreground: "#0F172A" },
                destructive: { DEFAULT: "#F72727", foreground: "#F8FAFC" },
            },
        },
    },
    

    plugins: [forms],
    
};
