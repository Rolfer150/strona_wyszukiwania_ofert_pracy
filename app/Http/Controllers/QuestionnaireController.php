<?php

namespace App\Http\Controllers;

use App\Models\Offer;
use App\Models\Question;
use App\Models\Questionnaire;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class QuestionnaireController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $questionnaires = Questionnaire::query()
            ->where('user_id', '=', auth()->user()->id)
            ->orderBy('updated_at', 'desc')
            ->get();
        return view('questionnaire.index', compact('questionnaires'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $userOffers = Offer::query()
            ->where('user_id', '=', auth()->user()->id)
            ->where('active', '=', 1)
            ->orderBy('updated_at', 'desc')
            ->get();

        return view('questionnaire.create', compact('userOffers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //        dd($request->input('offers'));
        $name = $request->input('name');
        $questionnaire = new Questionnaire;
        $questionnaire->name = $name;
        $questionnaire->slug = Str::slug($name);
        $questionnaire->description = $request->input('description');
        //        $questionnaire->offer_id = $request->input('offers');
        $request->user()->questionnaires()->save($questionnaire);

        $offers = Offer::query()
            ->where('user_id', '=', auth()->user()->id)
            ->whereNull('questionnaire_id')
            ->orderBy('created_at', 'desc')
            ->first();

        foreach ($request->input('offers') as $key => $value) {
            if ($value == $offers->id) {
                $offers->questionnaire_id->fill($questionnaire->id);
            }
        }

        $questionnaire->questions()->createMany($request->questions);

        $question = new Question;
        $question->answers()->createMany($request->questions['answers']);

        return redirect(route('questionnaire.index'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Questionnaire $questionnaire)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Questionnaire $questionnaire)
    {
        return view('questionnaire.edit', compact('questionnaire'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Questionnaire $questionnaire)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Questionnaire $questionnaire)
    {
        //
    }
}
