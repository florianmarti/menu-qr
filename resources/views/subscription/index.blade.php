<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Nuestros Planes de Suscripción 💳
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-4">
                @if (session('success'))
                    <div class="p-4 bg-green-100 border-l-4 border-green-500 text-green-700">{{ session('success') }}</div>
                @elseif (session('warning'))
                    <div class="p-4 bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700">{{ session('warning') }}</div>
                @elseif (session('error'))
                    <div class="p-4 bg-red-100 border-l-4 border-red-500 text-red-700">{{ session('error') }}</div>
                @endif
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach ($plans as $type => $plan)
                    @php
                        // Determinar si este es el plan actual del usuario
                        $isCurrent = $currentSubscription && $currentSubscription->type === $type && $currentSubscription->isActive();
                        $borderColor = $isCurrent ? 'border-indigo-600' : 'border-gray-200';
                        $buttonColor = $isCurrent ? 'bg-gray-400 cursor-not-allowed' : 'bg-indigo-600 hover:bg-indigo-700';
                        $buttonText = $isCurrent ? 'Plan Actual' : 'Suscribirse';
                    @endphp

                    <div class="bg-white overflow-hidden shadow-xl rounded-lg p-6 border-t-8 {{ $borderColor }}">

                        <h3 class="text-2xl font-bold mb-4 capitalize">{{ $type }}</h3>
                        <p class="text-4xl font-extrabold mb-6">${{ number_format($plan['price'], 0) }}<span class="text-base font-normal text-gray-500">/mes</span></p>

                        <ul class="space-y-3 text-gray-600 mb-8">
                            @foreach ($plan['features'] as $feature)
                                <li class="flex items-center">
                                    <svg class="h-5 w-5 text-green-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                    {{ $feature }}
                                </li>
                            @endforeach
                        </ul>

                        <form action="{{ route('subscription.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="plan" value="{{ $type }}">

                            <button type="submit" @if($isCurrent) disabled @endif
                                    class="w-full text-white font-bold py-2 rounded-lg {{ $buttonColor }}">
                                {{ $buttonText }}
                            </button>
                        </form>
                    </div>
                @endforeach
            </div>

            <div class="mt-8 text-center">
                <p class="text-gray-600">
                    ¿Ya tienes una suscripción?
                    <a href="{{ route('subscription.billingPortal') }}" class="text-indigo-600 hover:text-indigo-800 font-medium">
                        Administrar Facturación y Cambiar Plan (Portal de Stripe)
                    </a>
                </p>
            </div>
        </div>
    </div>
</x-app-layout>
