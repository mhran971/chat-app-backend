<?php

namespace App\Services;

use App\Models\Course;

use App\Models\Search;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class SearchService
{

    // Search for courses by name with pagination
    public function searchCourses(string $query)
    {
        return Course::where('name', 'LIKE', '%' . $query . '%')

            ->take(10)
            ->get();

    }
    /**
     * @throws \Exception
     */
    public function saveSearch(string $query): void
    {
        // Ensure the user is authenticated
        $userId = Auth::id();
        if (!$userId) {
            throw new \Exception("User is not authenticated.");
        }

        // Log the query to ensure it has the full word
        Log::info("Saving search for user ID: $userId, query: $query");

        // Save the query in cache
        $cacheKey = "searches:{$userId}";
        $cachedQueries = Cache::get($cacheKey, []);
        array_unshift($cachedQueries, $query);
        $cachedQueries = array_slice($cachedQueries, 0, 10);
        Cache::put($cacheKey, $cachedQueries);
    }


    // Get the last searches from the cache

    /**
     * @throws \Exception
     */


    public function getLastSearches()
    {
        // Ensure the user is authenticated
        $userId = Auth::id();
        if (!$userId) {
            throw new \Exception("User is not authenticated.");
        }

        // Retrieve all searches from the cache
        $cacheKey = "searches:{$userId}";
        $cachedQueries = Cache::get($cacheKey, []);

        // Get the last five searches
        $lastFiveSearches = array_slice($cachedQueries, 0, 5);

        return $lastFiveSearches;
    }

}
