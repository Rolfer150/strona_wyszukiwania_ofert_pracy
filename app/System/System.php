<?php

namespace App\System;

use App\Models\Category;
use App\Models\Company;
use App\Models\Offer;
use App\Models\Skill;
use App\Models\User;
use App\Notifications\OfferRecommendedNotification;
use Illuminate\Support\Facades\Auth;
use \Illuminate\Contracts\View\View;
use Livewire\WithPagination;

class System
{
    use WithPagination;

    public string $skill = '';
    public int $user_skill_level;
    public int $required_skill_level;


    public function index(): View
    {
        //        dd($this->getHelpForUserToImproveSkills($this->getCurrentUser()->id, 41));
        //        $tips = $this->getHelpForUserToImproveSkills($this->getCurrentUser()->id, 41);
        //        dd($tips);
        $message = $this->displaySkillComparisonMessage(82, 41);
        dd($this->skillComparison(82, 41));
        $currentUser = $this->getCurrentUser();
        $offers = $this->getOfferSearch()->get();
        $this->getRecommendedOfferNotification();
        return view('system.index', compact('currentUser', 'offers', 'message'));
    }
    public function getCurrentUser()
    {
        return Auth::user();
    }
    public function getCurrentUserOffers()
    {
        return Offer::query()
            ->where('user_id', '=', $this->getCurrentUser()->id);
    }
    public function getRecommendedOfferNotification()
    {
        return $this->getCurrentUser()->notify(new OfferRecommendedNotification($this->getOfferSearch()->pluck('id')->all()));
    }
    public function getOfferSearch()
    {
        return Offer::query()
            ->join('category_user', 'category_user.category_id', '=', 'offers.category_id')
            ->where('category_user.user_id', '=', $this->getCurrentUser()->id)
            ->where('active', '=', 1);
    }
    public function getOfferBrands(): array
    {
        return Offer::query()
            ->where('user_id', '=', $this->getCurrentUser()->id)
            //            ->join('category_company', 'companies.id', '=', 'category_company.company_id')
            ->pluck('category_id')
            ->toArray();
    }

    public function getUserSkill($userID = null)
    {
        return User::query()
            ->join('skill_user', 'users.id', '=', 'skill_user.user_id')
            ->where('id', '=', $userID)
            ->select('skill_user.skill_id', 'skill_user.skill_level')
            ->get()
            ->toArray();
    }

    public function getOfferSkill($offerID = null)
    {
        return Offer::query()
            ->join('offer_skill', 'offers.id', '=', 'offer_skill.offer_id')
            ->where('id', '=', $offerID)
            ->select('offer_skill.skill_id', 'offer_skill.skill_level')
            ->get()
            ->toArray();
    }
    public function skillComparison($userID, $offerID)
    {
        $userSkills = $this->getUserSkill($userID);
        $offerSkills = $this->getOfferSkill($offerID);

        $skillComparison = [];

        // Loop through user skills
        foreach ($userSkills as $userSkill) {
            // Find matching skill in offer skills
            $matchingSkill = array_filter($offerSkills, function ($offerSkill) use ($userSkill) {
                return $offerSkill['skill'] === $userSkill['skill'];
            });

            if (!empty($matchingSkill)) {
                $matchingSkill = reset($matchingSkill); // Get the first matching skill
                $skillComparison[] = [
                    'skill' => $userSkill['skill'],
                    'user_skill_level' => $userSkill['skill_level'],
                    'required_skill_level' => $matchingSkill['skill_level'],
                    'is_matching' => $userSkill['skill_level'] >= $matchingSkill['skill_level'],
                ];
            } else {
                // Skill not found in the offer, set is_matching to false
                $skillComparison[] = [
                    'skill' => $userSkill['skill'],
                    'user_skill_level' => $userSkill['skill_level'],
                    'required_skill_level' => null,
                    'is_matching' => false,
                ];
            }
        }

        return $skillComparison;
    }
    public function displaySkillComparisonMessage($userID, $offerID)
    {
        $skillComparison = $this->skillComparison($userID, $offerID);
        //        dd($skillComparison);
        $messagesArray = [];

        foreach ($skillComparison as $comparison) {
            $message = "{$comparison['skill']}: ";

            if ($comparison['user_skill_level'] > $comparison['required_skill_level'] && $comparison['required_skill_level']) {
                $message .= "Twój poziom umiejętności ({$comparison['user_skill_level']}) jest wyższy niż podany w wymaganiach: ({$comparison['required_skill_level']})!";
                $messagesArray[$comparison['skill']] = $message;
            }
            if ($comparison['user_skill_level'] < $comparison['required_skill_level'] && $comparison['required_skill_level']) {
                $message .= "Twój poziom umiejętności ({$comparison['user_skill_level']}) jest niższy od wymaganego poziomu umiejętności: ({$comparison['required_skill_level']}). " . $this->helpForImprovingSkill($comparison['skill'], $comparison['user_skill_level']);
                $messagesArray[$comparison['skill']] = $message;
            }
            //            if ($comparison['is_matching']) {
            //                $message .= "You meet the required skill level ({$comparison['required_skill_level']}).";
            //                $messagesArray[$comparison['skill']] = $message;
            //            }
            //            else {
            //                if ($comparison['required_skill_level'] !== null) {
            //                    $message .= "Your skill level ({$comparison['user_skill_level']}) does not meet the required skill level ({$comparison['required_skill_level']}).";
            //                    $messagesArray[$comparison['skill']] = $message;
            //                } else {
            //                    $message .= "You do not possess the required skill.";
            //                    $messagesArray[$comparison['skill']] = $message;
            //                }
            //            }

            //            dd($messagesArray);
        }
        return $messagesArray;
    }

    public function categoryComparison($userID, $offerID)
    {
        $userCategories = User::find($userID)->categories()->pluck('category_id')->toArray();
        $categoriesNames = Category::whereIn('id', $userCategories)->pluck('name')->toArray();

        $offerCategory = trim(strtolower(Offer::find($offerID)->category->name));
        $userCategoriesLower = array_map('strtolower', $categoriesNames);

        $isMatching = in_array($offerCategory, $userCategoriesLower);

        $categoryComparison = [
            'user_categories' => $categoriesNames,
            'offer_category' => $offerCategory,
            'is_matching' => $isMatching,
        ];

        //        dd($categoryComparison);
        return $categoryComparison;
    }

    public function displayCategoryComparisonMessage($userID, $offerID)
    {
        $categoryComparison = $this->categoryComparison($userID, $offerID);
        $messagesArray = [];

        $message = "Twoje kategorie '" . implode(', ', $categoryComparison['user_categories']) . "': ";

        if (!$categoryComparison['is_matching']) {
            $message .= "umieszczone w profilu użytkownika nie pasują do kategorii branży firmy wystawiającej daną ofertę pracy. Zalecamy dodanie kategorii {$categoryComparison['offer_category']} w celu łatwiejszego wyszukania Twojego profilu przez rekrutera. Czy chciałbyś zmienić kategorię branży?";
            $messagesArray[] = $message;
        }

        return $messagesArray;
    }

    public function helpForImprovingSkill($skill = null, $skillLevel = null)
    {
        switch ($skill) {
            case 'Php':
                if ($skillLevel === 1) return 'Php: Proponowane porady o poziomie umiejętności ' . $skillLevel . ':';
                elseif ($skillLevel === 2) return 'Php: Proponowane porady o poziomie umiejętności ' . $skillLevel . ':';
                elseif ($skillLevel === 3) return 'Php: Proponowane porady o poziomie umiejętności ' . $skillLevel . ':';
                elseif ($skillLevel === 4) return 'Php: Proponowane porady o poziomie umiejętności ' . $skillLevel . ':';
                break;
            case 'Git':
                if ($skillLevel === 1) return 'Git: Proponowane porady o poziomie umiejętności ' . $skillLevel . ':';
                elseif ($skillLevel === 2) return 'Git: Proponowane porady o poziomie umiejętności ' . $skillLevel . ':';
                elseif ($skillLevel === 3) return 'Git: Proponowane porady o poziomie umiejętności ' . $skillLevel . ':';
                elseif ($skillLevel === 4) return 'Git: Proponowane porady o poziomie umiejętności ' . $skillLevel . ':';
                break;
        }
    }

    public function getHelpForUserToImproveSkills($userID, $offerID)
    {
        $skillComparison = $this->skillComparison($userID, $offerID);
        $messagesArray = [];

        foreach ($skillComparison as $comparison) {
            $message = $this->helpForImprovingSkill($comparison['skill'], $comparison['user_skill_level']);
            $messagesArray[] = $message;
        }

        return $messagesArray;
    }
}
