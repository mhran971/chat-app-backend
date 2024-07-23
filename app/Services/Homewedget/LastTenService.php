<?php

namespace App\Services\Homewedget;

use App\Models\Content;
use App\Models\Country;
use App\Models\Course;
use App\Models\Specialization;
use App\Models\User;


    // Service of last 10 objects in Home widget (The results Change depending on the user ):
class LastTenService
{
    //function for show last 10 updated courses which have same  Specializations of user
    public function UpdatedCourses()
    {
        $user = User::find(auth('sanctum')->id());

        if ($user) {
            $userSpecializations = $user->specializations;
            $specializationIds = $userSpecializations->pluck('id');

            $relatedCourses = Course::whereIn('specialization_id', $specializationIds)
                ->latest('updated_at')
                ->take(10)
                ->get();

            $updatedCourses = [];

            foreach ($relatedCourses as $course) {
                $country = Country::find($course->country_id);
                $specialization = Specialization::find($course->specialization_id);
                $author = User::find($course->user_id);

                $courseData = $course->toArray();
                $courseData['country_id'] = $country->name;
                $courseData['specialization_id'] = $specialization->name;
                $courseData['user_id'] = $author->name;

                $updatedCourses[] = $courseData;
            }

            return $updatedCourses;
        }

        return null;
    }
    /*function for show last 10 updated courses which have same

    Specializations of user in the same his country */
    public function TrendCoursesInHisCountry()
    {
        $user = User::find(auth('sanctum')->id());

        if($user)
        {
            $userCountry = $user->country;

            if($userCountry) {

                $userSpecializations = $user->specializations;
                $specializationIds = $userSpecializations->pluck('id')->toArray();

                $relatedCourses = Course::whereIn('specialization_id', $specializationIds)
                    ->where('country_id', $userCountry->id)
                    ->latest('updated_at')
                    ->take(10)
                    ->get();

                $updatedCourses = [];

                foreach ($relatedCourses as $course) {
                    $country = Country::find($course->country_id);
                    $specialization = Specialization::find($course->specialization_id);
                    $author = User::find($course->user_id);

                    $courseData = $course->toArray();
                    $courseData['country_id'] = $country->name;
                    $courseData['specialization_id'] = $specialization->name;
                    $courseData['user_id'] = $author->name;

                    $updatedCourses[] = $courseData;
                }

                return $updatedCourses;
            }
        }

        return null;
    }
    //function for show 10 courses randomly which have same  Specializations of user
    public function randCourses()
    {
        $user = User::find(auth('sanctum')->id());

        if($user)
        {
            $userSpecializations = $user->specializations;
            $specializationIds = [];

            foreach ($userSpecializations as $specialization) {
                $specializationIds[] = $specialization->id;
            }
            $relatedCourses = Course::whereIn('specialization_id', $specializationIds)
                ->inRandomOrder()
                ->take(10)
                ->get();

            $updatedCourses = [];

            foreach ($relatedCourses as $course) {
                $country = Country::find($course->country_id);
                $specialization = Specialization::find($course->specialization_id);
                $author = User::find($course->user_id);

                $courseData = $course->toArray();
                $courseData['country_id'] = $country->name;
                $courseData['specialization_id'] = $specialization->name;
                $courseData['user_id'] = $author->name;

                $updatedCourses[] = $courseData;
            }

            return $updatedCourses;

        }
        return null;
    }


}
