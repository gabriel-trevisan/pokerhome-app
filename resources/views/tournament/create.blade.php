<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-row justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Criação de torneio') }}
            </h2>
            <div class="action-menu">
                <div class="action-menu__add">
                    <a href="{{ route('tournaments.index') }}" class="no-underline hover:underline">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 15L3 9m0 0l6-6M3 9h12a6 6 0 010 12h-3" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>

    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <!-- Nome do Torneio -->
                        <div>
                            <x-input-label for="name" :value="'Nome do torneio'" />
                            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>
                        <!-- Data do Torneio -->
                        <div class="mt-4">
                            <x-input-label for="date" :value="'Data do Torneio'" />
                            <x-text-input id="date" class="block mt-1 w-full" type="date" name="date" required autocomplete="date" />
                            <x-input-error :messages="$errors->get('date')" class="mt-2" />
                        </div>
                        <fieldset class="mt-2">
                            <legend class="mb-4">Estrutura:</legend>
                            <!-- Buy-in -->
                            <x-input-label for="buyin" :value="'Valor Buy-in'" />
                            <x-text-input id="buyin" class="block mt-1 w-full" type="number" min="1" step="any" name="buyin" :value="old('buyin')" required autofocus autocomplete="buyin" />

                            <!-- Rebuy -->
                            <x-input-label for="rebuy" :value="'Valor Rebuy'" />
                            <x-text-input id="rebuy" class="block mt-1 w-full" type="number" min="1" step="any" name="rebuy" :value="old('rebuy')" required autofocus autocomplete="rebuy" />

                            <!-- Rebuy Duplo -->
                            <x-input-label for="doubleRebuy" :value="'Valor Rebuy Duplo'" />
                            <x-text-input id="doubleRebuy" class="block mt-1 w-full" type="number" min="1" step="any" name="doubleRebuy" :value="old('doubleRebuy')" required autofocus autocomplete="doubleRebuy" />

                            <!-- Addon -->
                            <x-input-label for="addon" :value="'Valor Addon'" />
                            <x-text-input id="addon" class="block mt-1 w-full" type="number" min="1" step="any" name="addon" :value="old('addon')" required autofocus autocomplete="addon" />
                        </fieldset>

                        <div class="flex items-center justify-end mt-4">
                            <x-primary-button class="ml-3">
                                Criar Torneio
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>