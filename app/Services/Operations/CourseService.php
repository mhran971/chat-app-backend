<?php

namespace App\Services\Operations;

use App\Models\Country;
use App\Models\course;
use App\Models\Specialization;
use App\Models\User;
use App\Services\ImageService;

class CourseService{
    public function getallcourses($specializeid){

        $courses = [];

        Course::where('specialization_id', $specializeid)->chunk(10, function($chunk) use(&$courses){

            foreach($chunk as $course){
                $countryid =$course->country_id;
                $specializeid=$course->specialization_id;
                $autherid=$course->user_id;
                $country =Country::find($countryid);
                $specialize=Specialization::find($specializeid);
                $auther=User::find($autherid);
                $course['country_id']= $country->name;
                $course['specialization_id']= $specialize->name;
                $course['user_id']= $auther->name;

                $courses[] = $course;

            }
        });
        return $courses;
    }
    public function getcourse(int $id){
        return Course::find($id)->first();
    }

    public function createcourse($data){

        if (isset($data['image'])) {
            $destinationPath = public_path('images\\courses\\');
            $data['image'] = ImageService::saveImage($data['image'], $destinationPath);
        }
        $course =Course::create($data);
        return $course;
    }

    public function updatecourse($id,$data){
        $course = $this->getcourse($id);
        $course->update($data);
        $course->save();

        return $course;
    }

    public function deletecourse($id){
        $course=$this->getcourse($id);

        Course::where('id', $id)->delete();

        return 'the course is deleted successfully';
    }
}
