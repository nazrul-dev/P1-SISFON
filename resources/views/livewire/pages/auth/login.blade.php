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

<div>
    <!-- Session Status -->
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

    <div class=" mt-5 border-t">
        <div class="mb-5 mt-5 ">
            <div class="font-semibold">Akun Demo</div>
            <p>silahkan pilih satu akun demo </p>
        </div>
        <div class="flex flex-wrap gap-2">
            <x-button type="button" label="Superadmin" onclick="demoLogin(1)" positive />
            <x-button type="button" label="Admin KUA" onclick="demoLogin(2)" warning />
            <x-button type="button" label="Operator KUA" onclick="demoLogin(3)" primary />
            <x-button type="button" label="Admin Desa" onclick="demoLogin(4)" teal />
            <x-button type="button" label="Operator Desa" onclick="demoLogin(5)" negative />
        </div>

    </div>
</div>

<script>


    function demoLogin(type) {

        document.getElementById("password").value = 'password'

        if(type == 1){
            document.getElementById("email").value = 'superadmin@demo.com'
        }
        if(type == 2){
            document.getElementById("email").value = 'admin-kua@demo.com'
        }
        if(type == 3){
            document.getElementById("email").value = 'operator-kua@demo.com'
        }
        if(type == 4){
            document.getElementById("email").value = 'admin-desa@demo.com'
        }
        if(type == 5){
            document.getElementById("email").value = 'nazrul.dev@gmail.com'
        }
        document.getElementById('sbm').click();

    }
</script>
