<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use App\Repositories\PostRepository;

class PostsController extends Controller
{
    private $repository;

    public function __construct(PostRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index()
    {
//        $reports = Reporting::all();
//        $data= array('reports' => $reports);
//        foreach ($reports as $key => $val) {
//            echo "$key => $val <br>";
//        }
        return response()->json($this->repository->index());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
//        $request->validate([
//            'longitude'=>'required',
//            'latitude'=>'required',
//            'type'=>'required',
//            'urlToImage'=>'required',
//            'time'=>'required',
//        ]);

//            $post_data = $request->all();
//            $report = new Reporting();
//             $report->longitude = $post_data['longitude'];
// $report->latitude = $post_data['latitude'];
// $report->type = $post_data['type'];
// $report->urlToImage = $post_data['urlToImage'];
// $report->time = $post_data['time'];
// $report->save();

//            $post_data = $request->all();
//$report = Reporting::create($post_data);
        $post_data = $request->all();
        // echo "avant modification = " . $post_data["urlToImage"];
        $toStore = base64_decode( $post_data["urlToImage"]);
        $name = date('YmdHis');
        // echo "aprés modification = " . $post_data["urlToImage"];
        file_put_contents("images/$name.jpg",$toStore);
        $post_data["urlToImage"] = "public/images/$name.jpg" ;
        $report = Post::create($post_data);

        $report->save();


//       [
//            'longitude' => $request->get('longitude'),
//            'latitude' => $request->get('latitude'),
//            'type' => $request->get('type'),
//            'urlToImage' => $request->get('urlToImage'),
//            'time' => $request->get('time'),
//        ]);
//        $report->save();
//        return redirect('/result')->with('success', 'report saved!');
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function show2()
    {

        // $posts = Post::all();
        $posts=DB::table("posts")->where('type' , 'like' , '%'.'%')->paginate(10);
        $data = array('posts' => $posts);
        //return view('posts', $data);
        return response()->json($data);
    }

    public function edit2(Request $request) {
        $id = $request['id'];
        $etat= $request['affichage'];
        if($etat=='true') {$affichage = 0;}
        else{$affichage=1;}
        DB::update('update posts set affichage = ? where id = ?',[$affichage,$id]);
    }

    public function search(Request $request)
    {
        $search = $request['search'];
        $posts=DB::table("posts")->where([
            ['description' , 'like' , '%'.$search.'%'],
            ['affichage','=','1'],
            ]
        )->paginate(10);
        //return view('index',['posts' => $posts]) ;
        $data = array('posts' => $posts);
        return response()->json($data);
    }

}
