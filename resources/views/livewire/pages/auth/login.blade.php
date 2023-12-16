<?php

use App\Livewire\Forms\LoginForm;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component {
    public LoginForm $form;

    /**
     * Handle an incoming authentication request.
     */
    public function login(): void
    {
        $this->validate();

        $this->form->authenticate();

        Session::regenerate();

        $this->redirect(session('url.intended', RouteServiceProvider::HOME), navigate: true);
    }
}; ?>

<div class="flex  gap-5">
    <!-- Session Status -->
   <x-card>
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form wire:submit="login" id="loginForm">
        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input wire:model="form.email" id="email" class="block mt-1 w-full" type="email" name="email"
                required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input wire:model="form.password" id="password" class="block mt-1 w-full" type="password"
                name="password" required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember" class="inline-flex items-center">
                <input wire:model="form.remember" id="remember" type="checkbox"
                    class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                    href="{{ route('password.request') }}" wire:navigate>
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <x-primary-button class="ms-3" id="sbm" >
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>
   </x-card>

    <x-card title="Akun Demo">
        <div >
            <div class="mb-5 ">

                <p>silahkan pilih satu akun demo, <br> semua akun passwordnya  : <strong class="border p-1">password</strong> </p>
            </div>
            <div class="flex flex-col gap-2">

                <div class="p-2 border rounded-lg ">
                    email : superadmin@demo.com <br>
                    role : Superadmin
                </div>
                <div class="p-2 border rounded-lg ">
                    email : admin-kua@demo.com <br>
                    role : Admin KUA
                </div>
                <div class="p-2 border rounded-lg ">
                    email : operator-kua@demo.com <br>
                    role : Operator KUA
                </div>
                <div class="p-2 border rounded-lg ">
                    email : admin-desa@demo.com <br>
                    role : Admin Desa
                </div>
                <div class="p-2 border rounded-lg ">
                    email : operator-desa@demo.com <br>
                    role : Operator Desa
                </div>
            </div>

        </div>
    </x-card>
</div>

