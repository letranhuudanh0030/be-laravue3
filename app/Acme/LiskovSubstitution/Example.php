<?php

interface LessonRepositoryInterface {
    /**
     * Fetch all records
     *
     * @return array
     */
    public function getAll();
}

class FileLessonRepository implements LessonRepositoryInterface{
    public function getAll()
    {
        # return through filesystem
        return [];
    }
}

class DbLessonRepository implements LessonRepositoryInterface{
    public function getAll()
    {
        return Lesson::all()->toArray(); // violates the LSP
    }
}

function foo(LessonRepositoryInterface $lesson)
{
    $lessons = $lesson->getAll();
}


// class VideoPlayer {
//     public function play($file)
//     {
//         // play the video
//     }

// }

// class AviVideoPlayer extends VideoPlayer {
//     public function play($file)
//     {
//         if(pathinfo($file, PATHINFO_EXTENSION) !== 'avi'){
//             throw new Exception; // violates the LSP
//         }
//     }
// }

// class A {
//     public function fire()
//     {
//         # code...
//     }
// }

// class B extends A {
//     public function fire()
//     {
//         # code...
//     }
// }

// function doSomething(A $obj)
// {
//     # code...
// }
