<template>
    <div class="min-h-screen w-full flex flex-col items-center justify-center bg-slate-50">
        <span class="text-brand-500 bg-brand-50 p-6 rounded-2xl mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-24 w-24" viewBox="0 0 20 20" fill="currentColor">
             <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM7 9a1 1 0 100-2 1 1 0 000 2zm7-1a1 1 0 11-2 0 1 1 0 012 0zm-7.536 5.879a1 1 0 001.415 0 3 3 0 014.242 0 1 1 0 001.415-1.415 5 5 0 00-7.072 0 1 1 0 000 1.415z" clip-rule="evenodd" />
            </svg>
        </span>
        <h1 class="text-slate-700 text-2xl font-semibold tracking-tight">You're beyond the borders</h1>
        <p class="text-slate-500 text-sm mt-2 mb-6">This page doesn't exist or you don't have access.</p>
        <router-link class="btn-primary" :to="{name: 'dashboard'}">Back to dashboard</router-link>
    </div>
</template>
