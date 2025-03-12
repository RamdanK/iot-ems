<x-filament-widgets::widget>
    <x-filament::section class="h-full w-full">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @foreach ($relays as $relay)
                <div class="p-4 bg-white rounded-lg shadow-md">
                    <div class="flex items-center gap-4">
                        <div>
                            @if ($relay['status'] == 'ON')
                                <x-heroicon-o-check-circle class="w-10 h-10 text-green-500" />
                            @else
                                <x-heroicon-o-x-circle class="w-10 h-10 text-red-500" />
                            @endif
                        </div>
                        <div class="flex justify-end w-full">
                            <div class="ml-4 text-right justify-end">
                                <p class="text-lg font-semibold text-gray-800">{{ $relay['name'] }}</p>
                                <p @class([
                                    'text-sm font-medium',
                                    'text-red-500' => $relay['status'] == 'OFF',
                                    'text-green-500' => $relay['status'] == 'ON',
                                ])>{{ $relay['status'] }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
