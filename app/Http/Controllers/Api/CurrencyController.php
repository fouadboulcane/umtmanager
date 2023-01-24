<?php

namespace App\Http\Controllers\Api;

use App\Models\Currency;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\CurrencyResource;
use App\Http\Resources\CurrencyCollection;
use App\Http\Requests\CurrencyStoreRequest;
use App\Http\Requests\CurrencyUpdateRequest;

class CurrencyController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', Currency::class);

        $search = $request->get('search', '');

        $currencies = Currency::search($search)
            ->latest()
            ->paginate();

        return new CurrencyCollection($currencies);
    }

    /**
     * @param \App\Http\Requests\CurrencyStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(CurrencyStoreRequest $request)
    {
        $this->authorize('create', Currency::class);

        $validated = $request->validated();

        $currency = Currency::create($validated);

        return new CurrencyResource($currency);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Currency $currency
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Currency $currency)
    {
        $this->authorize('view', $currency);

        return new CurrencyResource($currency);
    }

    /**
     * @param \App\Http\Requests\CurrencyUpdateRequest $request
     * @param \App\Models\Currency $currency
     * @return \Illuminate\Http\Response
     */
    public function update(CurrencyUpdateRequest $request, Currency $currency)
    {
        $this->authorize('update', $currency);

        $validated = $request->validated();

        $currency->update($validated);

        return new CurrencyResource($currency);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Currency $currency
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Currency $currency)
    {
        $this->authorize('delete', $currency);

        $currency->delete();

        return response()->noContent();
    }
}
