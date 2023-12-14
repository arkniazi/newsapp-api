<?php

namespace App\Scopes;

use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class UserPreferenceScope implements Scope
{
  public function apply(Builder $builder, Model $model)
  {
    $user = Auth::user();

    if ($user) {
      $preferences = $user->user_preferences;

      $builder->when($preferences->favorite_categories, function ($query) use ($preferences) {
        $query->whereIn('category_id', $preferences->favorite_categories);
      });

      $builder->when($preferences->favorite_sources, function ($query) use ($preferences) {
        $query->whereIn('news_source_id', $preferences->favorite_sources);
      });

      $builder->when($preferences->favorite_authors, function ($query) use ($preferences) {
        $query->whereIn('news_source_id', $preferences->favorite_authors);
      });
    }
  }
}
