<x-filament::page>
    <div class="grid grid-cols-10">
        <div class="col-span-1"></div>
        <div class="col-span-8">
            {{-- @include('filament.resources.invoice-resource.pages.invoice', $record) --}}
            <x-filament::card>
                <div class="grid grid-cols-5 px-2 py-3">
                    <div class="col-span-3">
                        <img src="{{ asset('/images/invoice-logo-3.png') }}" alt="Logo" class="">
                    </div>
                    <div class="col-span-2 flex flex-col">
                        <div class="flex justify-end w-full">
                            <div class="bg-primary-600 px-1 text-lg text-white font-bold w-fit">FA- 0213</div>
                        </div>
                        <div class="flex flex-col text-sm text-right font-light">
                            <span>Date de facturation: {{ $record->billing_date->format('d/m/Y') }}</span>
                            <span>Date d'échéance: {{ $record->due_date->format('d/m/Y') }}</span>
                        </div>
                    </div>
                    <div class="mt-2 col-span-3 flex flex-col space-y-3 text-sm">
                        <div class="flex flex-col font-light">
                            <span class="font-semibold">Sarl Ultimate Market Technology</span>
                            <span>Cyberparc de SIDI ABDELLAH RAHMANIA-ALGER</span>
                            <span>RC : 17B 1012208-16/00</span>
                            <span>NIF : 001716101220804</span>
                            <span>Art : 16480102027</span>
                        </div>
                        <div class="flex flex-col">
                            <span class="font-light">Téléphone: 0661485783/0559336237</span>
                        </div>
                        <div>
                            <span class="font-light">Site: https://ultimatemarkettechnology.dz/</span>
                        </div>
                    </div>
                    <div class="mt-2 col-span-2">
                        <div class="flex flex-col text-sm  w-full font-light">
                            <span class="font-semibold">Client</span>
                            <span class="font-semibold">{{ $record->client->name }}</span>
                            <span>{{ $record->client->address }}</span>
                            <span>{{ $record->client->city }}</span>
                            <span>{{ $record->client->state }}</span>
                            <span>{{ $record->client->zipcode }}</span>
                            <span>Algérie</span>
                            <span>RC: 18B 1012976 16/00</span>
                        </div>
                    </div>
                    <div class="col-span-5 mt-4">
                        <table class="table-auto border-collapse border border-slate-400 w-full text-sm">
                            <thead>
                                <tr>
                                <th class="w-1/2 font-semibold border border-slate-100 text-left p-2">Article</th>
                                <th class="border font-semibold border-slate-100">Quantity</th>
                                <th class="border font-semibold border-slate-100">Price</th>
                                <th class="border font-semibold border-slate-100">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                            @if(!empty($record->articles))

                                @foreach($record->articles as $article)
                                <tr>
                                <td class="border border-slate-100 p-2">
                                    <div class="font-semibold">{{ $article->title }}</div>
                                    <div class="font-light">{{ $article->description }}</div>
                                </td>
                                <td class="border border-slate-100 p-2 text-center">{{ $article->pivot->quantity }}</td>
                                <td class="border border-slate-100 p-2 text-center">{{ $article->price }}</td>
                                <td class="border border-slate-100 p-2 text-center">{{ $article->pivot->quantity * $article->price }}</td>
                                </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </x-filament::card>
        </div>
    </div>



    @php
    $relationManagers = $this->getRelationManagers();
  @endphp
  
  {{-- @if ((! $this->hasCombinedRelationManagerTabsWithForm()) || (! count($relationManagers)))
    {{ $this->form }}
  @endif --}}
  
  @if (count($relationManagers))
    @if (! $this->hasCombinedRelationManagerTabsWithForm())
        <x-filament::hr />
    @endif
  
    <x-filament::resources.relation-managers
        :active-manager="$activeRelationManager"
        :form-tab-label="$this->getFormTabLabel()"
        :managers="$relationManagers"
        :owner-record="$record"
        :page-class="static::class"
    >
        @if ($this->hasCombinedRelationManagerTabsWithForm())
            <x-slot name="form">
                {{ $this->form }}
            </x-slot>
        @endif
    </x-filament::resources.relation-managers>
  
  @endif
  
    
</x-filament::page>