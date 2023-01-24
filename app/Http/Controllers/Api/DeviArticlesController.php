<?php
namespace App\Http\Controllers\Api;

use App\Models\Devi;
use App\Models\Article;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ArticleCollection;

class DeviArticlesController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Devi $devi
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Devi $devi)
    {
        $this->authorize('view', $devi);

        $search = $request->get('search', '');

        $articles = $devi
            ->articles()
            ->search($search)
            ->latest()
            ->paginate();

        return new ArticleCollection($articles);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Devi $devi
     * @param \App\Models\Article $article
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Devi $devi, Article $article)
    {
        $this->authorize('update', $devi);

        $devi->articles()->syncWithoutDetaching([$article->id]);

        return response()->noContent();
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Devi $devi
     * @param \App\Models\Article $article
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Devi $devi, Article $article)
    {
        $this->authorize('update', $devi);

        $devi->articles()->detach($article);

        return response()->noContent();
    }
}
