<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ $title ?? config('app.name') }}</title>
        <link rel="icon" href="/favicon.ico" sizes="any">
        <link rel="icon" href="/favicon.svg" type="image/svg+xml">
        <link rel="apple-touch-icon" href="/apple-touch-icon.png">
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
        <script src="https://cdn.tailwindcss.com"></script>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <style>
            body {
                font-family: 'Hiragino Sans', 'Yu Gothic', 'Meiryo', 'Noto Sans JP', ui-sans-serif, system-ui, sans-serif;
                line-height: 1.6;
                margin: 0;
                padding: 0;
                background-color: #f9fafb;
            }
            .min-h-screen {
                min-height: 100vh;
            }
            .flex {
                display: flex;
            }
            .flex-col {
                flex-direction: column;
            }
            .items-center {
                align-items: center;
            }
            .justify-center {
                justify-content: center;
            }
            .w-full {
                width: 100%;
            }
            .max-w-sm {
                max-width: 24rem;
            }
            .max-w-md {
                max-width: 28rem;
            }
            .mt-6 {
                margin-top: 1.5rem;
            }
            .mb-6 {
                margin-bottom: 1.5rem;
            }
            .mb-4 {
                margin-bottom: 1rem;
            }
            .mb-2 {
                margin-bottom: 0.5rem;
            }
            .px-6 {
                padding-left: 1.5rem;
                padding-right: 1.5rem;
            }
            .py-8 {
                padding-top: 2rem;
                padding-bottom: 2rem;
            }
            .py-2 {
                padding-top: 0.5rem;
                padding-bottom: 0.5rem;
            }
            .px-4 {
                padding-left: 1rem;
                padding-right: 1rem;
            }
            .bg-white {
                background-color: #ffffff;
            }
            .bg-gray-50 {
                background-color: #f9fafb;
            }
            .shadow-md {
                box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            }
            .rounded-lg {
                border-radius: 0.5rem;
            }
            .text-2xl {
                font-size: 1.5rem;
                line-height: 2rem;
            }
            .text-sm {
                font-size: 0.875rem;
                line-height: 1.25rem;
            }
            .font-bold {
                font-weight: 700;
            }
            .font-medium {
                font-weight: 500;
            }
            .text-purple-600 {
                color: #9333ea;
            }
            .text-gray-900 {
                color: #111827;
            }
            .text-gray-600 {
                color: #4b5563;
            }
            .text-gray-500 {
                color: #6b7280;
            }
            .text-gray-700 {
                color: #374151;
            }
            .text-center {
                text-align: center;
            }
            .border {
                border-width: 1px;
            }
            .border-gray-300 {
                border-color: #d1d5db;
            }
            .rounded-md {
                border-radius: 0.375rem;
            }
            .shadow-sm {
                box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            }
            .hover\\:bg-gray-50:hover {
                background-color: #f9fafb;
            }
            .inline-flex {
                display: inline-flex;
            }
            .justify-center {
                justify-content: center;
            }
            .items-center {
                align-items: center;
            }
            .relative {
                position: relative;
            }
            .absolute {
                position: absolute;
            }
            .inset-0 {
                top: 0;
                right: 0;
                bottom: 0;
                left: 0;
            }
            .border-t {
                border-top-width: 1px;
            }
            .px-2 {
                padding-left: 0.5rem;
                padding-right: 0.5rem;
            }
            .bg-white {
                background-color: #ffffff;
            }
            .block {
                display: block;
            }
            .mt-1 {
                margin-top: 0.25rem;
            }
            .w-full {
                width: 100%;
            }
            .focus\\:border-indigo-500:focus {
                border-color: #6366f1;
            }
            .focus\\:ring-indigo-500:focus {
                --tw-ring-color: #6366f1;
            }
            .border-red-500 {
                border-color: #ef4444;
            }
            .text-red-600 {
                color: #dc2626;
            }
            .h-4 {
                height: 1rem;
            }
            .w-4 {
                width: 1rem;
            }
            .text-indigo-600 {
                color: #4f46e5;
            }
            .hover\\:text-indigo-500:hover {
                color: #6366f1;
            }
            .bg-indigo-600 {
                background-color: #4f46e5;
            }
            .hover\\:bg-indigo-700:hover {
                background-color: #4338ca;
            }
            .text-white {
                color: #ffffff;
            }
            .flex {
                display: flex;
            }
            .items-center {
                align-items: center;
            }
            .justify-between {
                justify-content: space-between;
            }
            .justify-end {
                justify-content: flex-end;
            }
            .ml-2 {
                margin-left: 0.5rem;
            }
            .space-x-1 > :not([hidden]) ~ :not([hidden]) {
                margin-left: 0.25rem;
            }
            svg {
                display: inline-block;
                vertical-align: middle;
                max-width: 100%;
                height: auto;
            }
            .w-5 {
                width: 1.25rem !important;
                height: 1.25rem !important;
            }
            .mr-2 {
                margin-right: 0.5rem;
            }
            @media (min-width: 640px) {
                .sm\\:justify-center {
                    justify-content: center;
                }
                .sm\\:pt-0 {
                    padding-top: 0;
                }
                .sm\\:max-w-md {
                    max-width: 28rem;
                }
                .sm\\:rounded-lg {
                    border-radius: 0.5rem;
                }
            }
        </style>
    </head>
    <body class="min-h-screen bg-gray-50 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
            <div class="w-full max-w-sm sm:max-w-md mt-6 px-6 py-8 bg-white shadow-md overflow-hidden sm:rounded-lg">
                <div class="flex justify-center mb-6">
                    <a href="{{ route('home') }}" class="text-2xl font-bold text-purple-600" wire:navigate>
                        FortuneCompass
                    </a>
                </div>
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
