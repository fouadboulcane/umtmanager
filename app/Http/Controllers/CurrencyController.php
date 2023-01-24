<?php

namespace App\Http\Controllers;

use App\Models\Currency;
use Illuminate\Http\Request;
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
            ->paginate(5)
            ->withQueryString();

        return view('app.currencies.index', compact('currencies', 'search'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('create', Currency::class);

        return view('app.currencies.create');
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

        return redirect()
            ->route('currencies.edit', $currency)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Currency $currency
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Currency $currency)
    {
        $this->authorize('view', $currency);

        return view('app.currencies.show', compact('currency'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Currency $currency
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Currency $currency)
    {
        $this->authorize('update', $currency);

        return view('app.currencies.edit', compact('currency'));
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

        return redirect()
            ->route('currencies.edit', $currency)
            ->withSuccess(__('crud.common.saved'));
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

        return redirect()
            ->route('currencies.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
