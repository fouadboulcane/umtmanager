<?php
namespace App\Http\Controllers\Api;

use App\Models\Devi;
use App\Models\Article;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\DeviCollection;

class ArticleDevisController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Article $article
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Article $article)
    {
        $this->authorize('view', $article);

        $search = $request->get('search', '');

        $devis = $article
            ->devis()
            ->search($search)
            ->latest()
            ->paginate();

        return new DeviCollection($devis);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Article $article
     * @param \App\Models\Devi $devi
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Article $article, Devi $devi)
    {
        $this->authorize('update', $article);

        $article->devis()->syncWithoutDetaching([$devi->id]);

        return response()->noContent();
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Article $article
     * @param \App\Models\Devi $devi
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Article $article, Devi $devi)
    {
        $this->authorize('update', $article);

        $article->devis()->detach($devi);

        return response()->noContent();
    }
}
