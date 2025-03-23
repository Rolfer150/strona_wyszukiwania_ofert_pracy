<?php

namespace App\Http\Controllers;

use App\Enums\Contract;
use App\Enums\Employment;
use App\Enums\PaymentType;
use App\Enums\ProgrammingSkills;
use App\Enums\SkillLevel;
use App\Enums\WorkMode;
use App\Http\Requests\CreateOfferRequest;
use App\Models\Category;
use App\Models\Offer;
use App\Models\Skill;
use App\Notifications\OfferCreatedNotification;
use App\System\System;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Str;

class OfferController extends Controller
{
    public function mainPage(): View
    {
        $offers = Offer::query()
            ->where('active', '=', 1)
            ->orderBy('created_at', 'desc')
            ->limit(3)
            ->get();

        return view('home', compact('offers'));
    }

    //    public function showOffers(): View
    //    {
    //        $employments = Employment::employmentFilter();
    //        $contracts = Contract::contractFilter();
    //        $workmodes = WorkMode::workmodeFilter();
    //
    //        $new_offers = Offer::query()
    //            ->where('active', '=', 1)
    //            ->orderBy('created_at', 'desc')
    //            ->paginate(8);
    //
    //        return view('sidewidgets.offer', compact('new_offers'));
    //    }

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $myOffers = Offer::query()
            ->where('user_id', '=', auth()->user()->id)
            ->where('active', '=', true)
            ->orderBy('created_at', 'desc')
            ->get();
        return view('offer.myoffers', compact('myOffers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $payments = PaymentType::cases();
        $employments = Employment::cases();
        $contracts = Contract::cases();
        $workModes = WorkMode::cases();
        $categories = Category::query()
            ->select('id', 'name')
            ->get();
        $skills = Skill::query()
            ->select('id', 'name')
            ->get();
        $skillLevel = SkillLevel::cases();
        return view('offer.create', compact(
            'categories',
            'payments',
            'employments',
            'contracts',
            'workModes',
            'skills',
            'skillLevel'
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateOfferRequest $request): RedirectResponse
    {
        // dd($request->all());
        $offer = new Offer($request->validated());
        $offer->slug = Str::slug($request->name);
        $offer->active = true;
        $offer->employment = $request->employment;
        $offer->contract = $request->contract;
        $offer->work_mode = $request->work_mode;
        $offer->created_at = Carbon::now();

        if ($request->hasFile('image_path')) {
            $file = $request->file('image_path');
            $fileName = $file->getClientOriginalName();
            $filePath = 'offer/' . $fileName;
            $file->storeAs('public/offer', $fileName);
            $offer->image_path = $filePath;
        }
        $request->user()->offers()->save($offer);
        auth()->user()->notify(new OfferCreatedNotification($offer));

        return redirect(route('home'));
    }

    /**
     * Display the specified resource.
     * @param Offer $offer
     * @return View
     */
    public function show(Offer $offer): View
    {
        $user = auth()->user();

        try {
            $offer::where('id', '=', $offer->id)
                //                ->where('active', '=', 1)
                ->when($user->id != $offer->user_id, function ($q) {
                    $q->where('active', '=', 1);
                })
                ->firstOrFail();
        } catch (\Exception $exception) {
            return view('errors.offerNotActive');
        }

        $canNotApply = '';

        if ($user) {
            $system = new System;
            $messagesSkillComparison = $system->displaySkillComparisonMessage($user->id, $offer->id);
            $messagesCategoryComparison = $system->displayCategoryComparisonMessage($user->id, $offer->id);

            if ($offer->isUsersOffer()) {
                $messagesSkillComparison = null;
                $messagesCategoryComparison = null;
                $canNotApply = 'userMadeThisOffer';
            }
            if ($offer->userHasApplied()) $canNotApply = 'userHasApplied';
        }

        $category_offers = Offer::query()
            ->where('active', '=', 1)
            ->where('category_id', '=', $offer->category_id)
            ->where('id', '!=', $offer->id)
            ->orderBy('created_at', 'desc')
            ->limit(6)
            ->get();

        $skills = Offer::query()
            ->join('offer_skill', 'offers.id', '=', 'offer_skill.offer_id')
            ->where('offer_id', '=', $offer->id)
            ->get();

        //        dd($messages);
        return view("offer.show", compact('offer', 'category_offers', 'canNotApply', 'skills', 'messagesSkillComparison', 'messagesCategoryComparison'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Offer $offer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CreateOfferRequest $request, Offer $offer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Offer $offer)
    {
        //
    }

    //    public function search(Request $request)
    //    {
    //        $q = $request->get('q');
    //
    //        $employments = Employment::employmentFilter();
    //        $contracts = Contract::contractFilter();
    //        $workmodes = WorkMode::workmodeFilter();
    //
    //        $searched_offers = Offer::query()
    //            ->where('active', '=', 1)
    //            ->whereDate('published_at', '<', Carbon::now())
    //            ->orderBy('published_at', 'desc')
    //            ->where(function ($query) use($q)
    //            {
    //                $query->where('name', 'like', "%$q%")
    //                    ->orWhere('description', 'like', "%$q%");
    //            })
    //            ->paginate(8);
    //
    //        return view('sidewidgets.search', compact('searched_offers', 'q'));
    //    }
}
