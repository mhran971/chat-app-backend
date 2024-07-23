<?php

namespace App\Services\Operations;

use App\Models\content;
use App\Models\Course;

class ContentService{
    public function getallcontents($courseid){

        $contents = [];

        Content::where('course_id',$courseid)->chunk(10, function($chunk) use(&$contents){

            foreach($chunk as $content){
                $contents[] = $content;
            }
        });
        return $contents;
    }

    public function getcontent(int $id){
        return Content::find($id)->first();
    }

    public function createcontent($data){

        $content =Content::create($data);
        return $content;
    }

    public function updatecontent($id,$data){
        $content = $this->getcontent($id);
        $content->update($data);
        $content->save();

        return $content;
    }

    public function deletecontent($id){
        $content=$this->getcontent($id);
        Content::where('id', $id)->delete();

        return $content;

    }
}
