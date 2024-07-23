<?php

namespace App\Services\Homewedget;

use App\Models\Content;
use App\Models\Course;
use App\Models\User;


    // Service of last 10 objects in Home widget (The results Change depending on the user ):
class GetFromContentService
{
    public function Getvideos()
    {
        $user = User::find(auth('sanctum')->id());

        if ($user) {
            $userSpecializations = $user->specializations;
            $specializationIds = $userSpecializations->pluck('id');
            $relatedvideos = [];

            $relatedcourses = Course::whereIn('specialization_id', $specializationIds)->get();

            foreach ($relatedcourses as $course) {
                $relatedvideos[] = $course->content->filter(function($content) {
                    return $content->type == 'video';
                });
            }

            return collect($relatedvideos)->flatten();
        }

        return null;
    }
    public function Getdocuments()
    {
        $user = User::find(auth('sanctum')->id());

        if ($user) {
            $userSpecializations = $user->specializations;
            $specializationIds = $userSpecializations->pluck('id');
            $relatedvideos = [];

            $relatedcourses = Course::whereIn('specialization_id', $specializationIds)->get();

            foreach ($relatedcourses as $course) {
                $relateddocuments[] = $course->content->filter(function($content) {
                    return $content->type == 'document';
                });;
            }

            return collect($relateddocuments)->flatten();
        }

        return null;
    }

}
